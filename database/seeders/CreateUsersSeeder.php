<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the 'User' role
        $userRole = Role::where('name', 'User')->first();
        
        // Create users with specific email addresses and password
        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'name' => 'User ' . $i,
                'email' => 'aio' . $i . '@gmail.com',
                'password' => Hash::make('12345678'),
            ]);
            
            // Assign the 'User' role
            if ($userRole) {
                $user->assignRole($userRole);
            }
        }
    }
} 