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
            'manage settings',
            
            // Doctor permissions
            'access doctor dashboard',
            'view patients',
            'create prescriptions',
            'view medical records'
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
        
        // Doctor role
        $doctorRole = Role::create(['name' => 'Doctor']);
        $doctorRole->givePermissionTo([
            'access admin dashboard',
            'view patients',
            'create prescriptions',
            'view medical records',
            'view reports'
        ]);
        $pcpRole = Role::create(['name' => 'PCP']);
        $pcpRole->givePermissionTo([
            'access admin dashboard',
            'view patients',
            'create prescriptions',
            'view medical records',
            'view reports'
        ]);

        
        // User role
        $userRole = Role::create(['name' => 'User']);
        // Regular users don't have admin permissions

        // Create a super admin user
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'phone' => '01742184298',
            'password' => Hash::make('12345678')
        ]);
        $superAdmin->assignRole('Super Admin');
        
        // Create an admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'phone' => '01752345678',
            'password' => Hash::make('12345678')
        ]);
        $admin->assignRole('Admin');

        // Create a Doctor user
        $doctor = User::create([
            'name' => 'Dr. Ahmed Hossain',
            'code' => 'DT-001',
            'email' => 'doctor@gmail.com',
            'phone' => '01712345678',
            'description' => 'Consultant',
            'password' => Hash::make('12345678')
        ]);
        $doctor->assignRole('Doctor');
        
        // Create another Doctor user
        $doctor2 = User::create([
            'name' => 'Dr. Fatima Begum',
            'code' => 'DT-002',
            'email' => 'doctor2@gmail.com',
            'phone' => '01812345678',
            'description' => 'Consultant',
            'password' => Hash::make('12345678')
        ]);
        $doctor2->assignRole('Doctor');

        // Create a PCP user
        $pcp = User::create([
            'name' => 'PCP User',
            'code' => 'PCP-001',
            'email' => 'pcp@gmail.com',
            'phone' => '01912345678',   
            'description' => 'PCP',
            'password' => Hash::make('12345678')
        ]);
        $pcp->assignRole('PCP');
        $pcp2 = User::create([
            'name' => 'PCP User 2',
            'code' => 'PCP-002',
            'email' => 'pcp2@gmail.com',
            'phone' => '01912345675',   
            'description' => 'PCP',
            'password' => Hash::make('12345678')
        ]);
        $pcp2->assignRole('PCP');

        
    }
}
