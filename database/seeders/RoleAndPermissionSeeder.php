<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds following the company standard.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Create Permissions
        Permission::findOrCreate('manage-offices');
        Permission::findOrCreate('manage-users');
        Permission::findOrCreate('view-dashboard');
        Permission::findOrCreate('manage-audits');

        // 2. Create Roles and Assign Permissions
        
        // Admin
        $adminRole = Role::findOrCreate('admin');
        $adminRole->givePermissionTo(Permission::all());

        // Auditor
        $auditorRole = Role::findOrCreate('auditor');
        $auditorRole->givePermissionTo(['view-dashboard', 'manage-audits']);

        // User
        $userRole = Role::findOrCreate('user');
        $userRole->givePermissionTo(['view-dashboard']);

        // 3. Assign role to the local test user
        $testUser = User::where('email', 'test@example.com')->first();
        if ($testUser) {
            $testUser->assignRole('admin');
        }
    }
}
