<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 users with the 'User' role
        User::factory(10)->create()->each(function ($user) {
            $userRole = Role::where('name', 'User')->first();
            if ($userRole) {
                $user->assignRole($userRole);
            }
        });
    }
} 