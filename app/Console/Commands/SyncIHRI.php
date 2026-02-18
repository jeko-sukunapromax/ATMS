<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\IHRIService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SyncIHRI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ihri:sync {--token= : The authentication token for iHRI API}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and sync all users and employees from the iHRI system';

    /**
     * Execute the console command.
     */
    public function handle(IHRIService $ihriService)
    {
        $token = $this->option('token');

        if (!$token) {
            $this->error('Argument/Option --token is required. Example: php artisan ihri:sync --token=203|...');
            return 1;
        }

        Log::info('SyncIHRI: Fetching offices...');
        $offices = $ihriService->getOffices();

        if (empty($offices)) {
            Log::warning('SyncIHRI: No offices found or API error.');
            $this->error('Failed to retrieve offices or no offices found.');
            return 1;
        }

        Log::info('SyncIHRI: Found ' . count($offices) . ' offices.');
        $this->info('Found ' . count($offices) . ' offices. Syncing employees per office...');

        $bar = $this->output->createProgressBar(count($offices));
        $bar->start();

        $syncCount = 0;

        foreach ($offices as $office) {
            $this->info("Syncing office: {$office['name']}...");
            
            $response = $ihriService->getEmployeesByOffice($office['uuid'], $token);
            
            if (!$response) {
                $this->warn("No response for office: {$office['name']}");
                continue;
            }

            $employees = null;
            if (isset($response['data'])) {
                $employees = $response['data'];
            } elseif (isset($response['employees'])) {
                $employees = $response['employees'];
            } elseif (is_array($response) && count($response) > 0) {
                $employees = $response;
            }

            if (is_array($employees)) {
                $officeSyncCount = 0;
                foreach ($employees as $emp) {
                    if ($this->syncUserData($emp, $office['name'] ?? null)) {
                        $officeSyncCount++;
                        $syncCount++;
                    }
                }
                $this->info("Synced $officeSyncCount users.");
            } else {
                $this->warn("Unexpected response format for office {$office['name']}");
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();

        $this->info('Fetching permanent users from /api/users...');
        $response = $ihriService->getUsers($token);
        
        if ($response) {
            $permanentUsers = null;
            if (isset($response['data'])) {
                $permanentUsers = $response['data'];
            } elseif (isset($response['users'])) {
                $permanentUsers = $response['users'];
            } elseif (is_array($response) && count($response) > 0 && isset($response[0]['email'])) {
                $permanentUsers = $response;
            }

            if (is_array($permanentUsers)) {
                $this->info("Found " . count($permanentUsers) . " permanent users.");
                foreach ($permanentUsers as $pUser) {
                    if ($this->syncUserData($pUser)) {
                        $syncCount++;
                    }
                }
            }
        }

        $this->info("Sync finished! Total users synced/updated: {$syncCount}");
        return 0;
    }

    /**
     * Sync single user data to local database
     */
    protected function syncUserData($data, $officeName = null)
    {
        $email = $data['email'] ?? null;
        $ihriUuid = $data['uuid'] ?? $data['id'] ?? null;
        $username = $data['username'] ?? null;

        // If email is missing (common for OJTs/Employees in some endpoints)
        if (!$email) {
            if ($username) {
                $email = $username . '@ihri.local';
            } elseif ($ihriUuid) {
                $email = substr($ihriUuid, 0, 8) . '@ihri.local';
            } else {
                return false; // Truly no identifier
            }
        }

        // Try to get name from various possible keys
        $name = $data['name'] ?? null;
        if (!$name) {
            $firstName = $data['first_name'] ?? '';
            $lastName = $data['last_name'] ?? '';
            $name = trim("$firstName $lastName");
        }
        
        if (!$name) {
            $name = $username ?? explode('@', $email)[0] ?? 'Unknown User';
        }

        $position = $data['position_name'] ?? $data['position'] ?? $data['plantilla']['name'] ?? 'EMPLOYEE';

        // Check if user already exists
        $existingUser = User::where('email', $email)->orWhere('ihri_uuid', $ihriUuid)->first();

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => $existingUser ? $existingUser->password : Hash::make('password123'),
                'position' => $position,
                'office' => $officeName ?? $data['office']['name'] ?? null,
                'ihri_uuid' => $ihriUuid,
            ]
        );

        // Assign default role if none
        if ($user->roles->isEmpty()) {
            $user->assignRole('user');
        }

        return true;
    }
}
