<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // die('FortifyServiceProvider Booting');
        
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::authenticateUsing(function (Request $request) {
            \Illuminate\Support\Facades\Log::info('Fortify Attempting Custom Login');
            $ihriService = app(\App\Services\IHRIService::class);
            $response = $ihriService->login(
                $request->email,
                $request->password
            );

            // Debugging: Log the response to see what's happening
            \Illuminate\Support\Facades\Log::info('iHRI Live Login Attempt:', [
                'email' => $request->email,
                'response_is_null' => is_null($response),
                'status' => $response['status'] ?? 'N/A'
            ]);

            // Check if login was successful
            $isSuccess = $response && (
                isset($response['access_token']) || 
                isset($response['token']) ||
                (isset($response['status']) && strtolower($response['status']) === 'success') ||
                (isset($response['success']) && $response['success'] === true)
            );

            if ($isSuccess) {
                // Extract user data
                $userData = $response['user'] ?? $response['data']['user'] ?? $response['data'] ?? null;
                
                // Fallback if userData is still null but response has user info at root
                if (!$userData && (isset($response['email']) || isset($response['id']))) {
                    $userData = $response;
                }

                $email = $userData['email'] ?? $request->email;
                
                // Get name from various possibilities
                $name = $userData['name'] ?? null;
                if (!$name) {
                    $firstName = $userData['first_name'] ?? '';
                    $lastName = $userData['last_name'] ?? '';
                    $name = trim("$firstName $lastName");
                }
                if (!$name) {
                    $name = explode('@', $email)[0];
                }

                $ihriUuid = $userData['uuid'] ?? $userData['id'] ?? null;

                $user = \App\Models\User::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => $name,
                        'password' => \Illuminate\Support\Facades\Hash::make($request->password),
                        'ihri_uuid' => $ihriUuid,
                    ]
                );

                if ($user->roles->isEmpty()) {
                    $user->assignRole('user');
                }

                $token = $response['token'] ?? $response['access_token'] ?? $response['data']['token'] ?? $response['data']['access_token'] ?? null;
                if ($token) {
                    session(['ihri_token' => $token]);
                    // Trigger async sync using a Queue Job
                    \App\Jobs\SyncIHRIJob::dispatch($token);
                }

                return $user;
            }

            // 2. If iHRI fails, try Local Database Fallback
            $user = \App\Models\User::where('email', $request->email)->first();

            if ($user && \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
                return $user;
            }

            return null;
        });
    }
}
