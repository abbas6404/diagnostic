<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UpdateAdminPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find or create the admin user
        $admin = User::where('email', 'admin@gmail.com')->first();
        
        if (!$admin) {
            $this->command->error('Admin user not found. Please run the RolesAndPermissionsSeeder first.');
            return;
        }
        
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        // These are the required permissions for the admin
        $requiredPermissions = [
            'view users',
            'create users',
            'edit users',
            'view roles',
            'access admin dashboard',
            'view reports',
            'manage settings'
        ];
        
        // Find the Admin role
        $adminRole = Role::where('name', 'Admin')->first();
        
        if ($adminRole) {
            // Sync permissions to the Admin role
            $adminRole->syncPermissions($requiredPermissions);
            $this->command->info('Admin role permissions updated successfully.');
        } else {
            $this->command->error('Admin role not found. Please run the RolesAndPermissionsSeeder first.');
            return;
        }
        
        // Ensure admin user has the Admin role
        if (!$admin->hasRole('Admin')) {
            $admin->assignRole('Admin');
            $this->command->info('Admin role assigned to the admin user.');
        }
        
        $this->command->info('Admin user now has the required permissions.');
    }
} 