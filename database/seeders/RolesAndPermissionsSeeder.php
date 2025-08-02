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
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // Super Admin role
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdminRole->givePermissionTo(Permission::all());
        
        // Admin role
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
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
        $moderatorRole = Role::firstOrCreate(['name' => 'Moderator']);
        $moderatorRole->givePermissionTo([
            'view users',
            'access admin dashboard',
            'view reports'
        ]);
        
        // Doctor role
        $doctorRole = Role::firstOrCreate(['name' => 'Doctor']);
        $doctorRole->givePermissionTo([
            'access admin dashboard',
            'view patients',
            'create prescriptions',
            'view medical records',
            'view reports'
        ]);
        
        // Pathologist role
        $pathologistRole = Role::firstOrCreate(['name' => 'pathologist']);
        $pathologistRole->givePermissionTo([
            'access admin dashboard',
            'view patients',
            'view medical records',
            'view reports'
        ]);
        
        $pcpRole = Role::firstOrCreate(['name' => 'PCP']);
        $pcpRole->givePermissionTo([
            'access admin dashboard',
            'view patients',
            'create prescriptions',
            'view medical records',
            'view reports'
        ]);

        
        // User role
        $userRole = Role::firstOrCreate(['name' => 'User']);
        // Regular users don't have admin permissions

        // Create a super admin user
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'phone' => '01742184298',
                'department_id' => 1, // No department for super admin
                'password' => Hash::make('12345678')
            ]
        );
        $superAdmin->assignRole('Super Admin');
        
        // Create an admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin User',
                'phone' => '01752345678',
                'password' => Hash::make('12345678')
            ]
        );
        $admin->assignRole('Admin');

        // Create a Doctor user
        $doctor = User::firstOrCreate(
            ['email' => 'doctor@gmail.com'],
            [
                'name' => 'Dr. Ahmed Hossain',
                'code' => 'DR-001',
                'phone' => '01712345678',
                'description' => 'Consultant',
                'password' => Hash::make('12345678')
            ]
        );
        $doctor->assignRole('Doctor');
        
        // Create another Doctor user
        $doctor2 = User::firstOrCreate(
            ['email' => 'doctor2@gmail.com'],
            [
                'name' => 'Dr. Fatima Begum',
                'code' => 'DR-002',
                'phone' => '01812345678',
                'description' => 'Consultant',
                'password' => Hash::make('12345678')
            ]
        );
        $doctor2->assignRole('Doctor');

        // Create a PCP user
        $pcp = User::firstOrCreate(
            ['email' => 'pcp@gmail.com'],
            [
                'name' => 'Ahmed Hasan',
                'code' => 'PCP-001',
                'phone' => '01912345678',   
                'description' => 'PCP',
                'password' => Hash::make('12345678')
            ]
        );
        $pcp->assignRole('PCP');
        $pcp2 = User::firstOrCreate(
            ['email' => 'pcp2@gmail.com'],
            [
                'name' => 'Makbul Hasan',
                'code' => 'PCP-002',
                'phone' => '01912345675',   
                'description' => 'PCP',
                'password' => Hash::make('12345678')
            ]
        );
        $pcp2->assignRole('PCP');

        // Create a Pathologist user
        $pathologist = User::firstOrCreate(
            ['email' => 'pathologist@gmail.com'],
            [
                'name' => 'Dr. Sarah Johnson',
                'code' => 'PATH-001',
                'phone' => '01612345678',
                'description' => 'Senior Pathologist',
                'password' => Hash::make('12345678')
            ]
        );
        $pathologist->assignRole('pathologist');
        
    }
}
