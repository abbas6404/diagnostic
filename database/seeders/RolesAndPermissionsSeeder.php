<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User permissions
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // Role permissions
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            
            // Permission management
            'assign permissions',
            'view permissions',
           
            
            // Dashboard access
            'access admin dashboard',
            
            // Other permissions
            'manage plans',
            'view reports',
            'manage settings'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // Super Admin role
        $superAdminRole = Role::create(['name' => 'Super Admin']);
        $superAdminRole->givePermissionTo(Permission::all());
        
        // Admin role
        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->givePermissionTo([
            'view users',
            'create users',
            'edit users',
            'view roles',
            'access admin dashboard',
            'view reports',
            'manage settings'
        ]);
        
        // Moderator role
        $moderatorRole = Role::create(['name' => 'Moderator']);
        $moderatorRole->givePermissionTo([
            'view users',
            'access admin dashboard',
            'view reports'
        ]);
        
        // User role
        $userRole = Role::create(['name' => 'User']);
        // Regular users don't have admin permissions

        // Create a super admin user
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'phone' => '01742184298',
            'password' => Hash::make('password')
        ]);
        $superAdmin->assignRole('Super Admin');
        
        // Create an admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password')
        ]);
        $admin->assignRole('Admin');
    }
}
