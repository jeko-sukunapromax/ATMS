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
        $offices = $ihriService->getOffices($token);

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
            if ($syncCount === 0) {
                Log::info("Sample response format for office: " . json_encode($response));
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
            $empNumber = $data['employee_number'] ?? null;
            if ($username) {
                $email = $username . '@ihri.local';
            } elseif ($empNumber) {
                $email = $empNumber . '@ihri.local';
            } elseif ($ihriUuid) {
                $email = substr($ihriUuid, 0, 8) . '@ihri.local';
            } else {
                $email = 'unknown' . rand(1000,9999) . '@ihri.local';
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

        // Determine Position
        $position = 'EMPLOYEE';
        if (isset($data['on_the_job_training']) || isset($data['onTheJobTraining'])) {
            $position = 'OJT';
        } elseif (isset($data['position_name'])) {
            $position = $data['position_name'];
        } elseif (isset($data['position'])) {
            $position = $data['position'];
        } elseif (isset($data['plantilla']['name'])) {
            $position = $data['plantilla']['name'];
        }

        // Try to find the user by ihri_uuid first, then email
        $existingUser = null;
        if ($ihriUuid) {
            $existingUser = User::where('ihri_uuid', $ihriUuid)->first();
        }
        if (!$existingUser && $email) {
            $existingUser = User::where('email', $email)->first();
        }

        $officeForDb = $officeName ?? $data['office']['name'] ?? null;

        if ($existingUser) {
            // Update existing user
            // Prevent overwriting a real email with a generated fake email
            $isFakeEmail = str_ends_with($email, '@ihri.local');
            $newEmail = (!$isFakeEmail && $email) ? $email : $existingUser->email;
            
            $existingUser->update([
                'name' => $name,
                'position' => $position,
                'office' => $officeForDb ?? $existingUser->office,
                'ihri_uuid' => $ihriUuid ?? $existingUser->ihri_uuid,
                'email' => $newEmail,
            ]);
            $user = $existingUser;
        } else {
            // Create new
            $user = User::create([
                'email' => $email,
                'name' => $name,
                'password' => Hash::make('password123'),
                'position' => $position,
                'office' => $officeForDb,
                'ihri_uuid' => $ihriUuid,
            ]);
        }

        // Extract potential roles from API
        $roleStr = '';
        if (isset($data['roles']) && is_array($data['roles'])) {
            foreach ($data['roles'] as $r) {
                $roleStr .= is_array($r) ? ($r['name'] ?? '') : $r;
            }
        }
        if (isset($data['role'])) {
            $roleStr .= is_array($data['role']) ? ($data['role']['name'] ?? '') : $data['role'];
        }
        
        $isApiSuperAdmin = str_contains(strtolower($roleStr), 'superadmin') || (isset($data['is_superadmin']) && $data['is_superadmin']);

        // Assign default or mapped role
        if ($isApiSuperAdmin) {
            $user->syncRoles(['superadmin']);
        } elseif ($user->roles->isEmpty()) {
            $user->assignRole('user');
        }

        return true;
    }
}
