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
        
        // Superadmin
        $superadminRole = Role::findOrCreate('superadmin');
        $superadminRole->givePermissionTo(Permission::all());

        // Admin (can manage audits and offices, but not users like superadmin does)
        $adminRole = Role::findOrCreate('admin');
        $adminRole->givePermissionTo(['manage-offices', 'view-dashboard', 'manage-audits']);

        // Auditor
        $auditorRole = Role::findOrCreate('auditor');
        $auditorRole->givePermissionTo(['view-dashboard', 'manage-audits']);

        // User (can only view dashboard)
        $userRole = Role::findOrCreate('user');
        $userRole->givePermissionTo(['view-dashboard']);

        // 3. Assign role to the local test users
        $adminUser = User::where('email', 'admin@example.com')->first();
        if ($adminUser) {
            $adminUser->syncRoles(['admin']);
        }

        $normalUser = User::where('email', 'user@example.com')->first();
        if ($normalUser) {
            $normalUser->syncRoles(['user']);
        }
    }
}
