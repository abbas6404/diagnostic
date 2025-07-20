<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(UpdateAdminPermissionsSeeder::class);
        $this->call(CreateUsersSeeder::class);
        $this->call(PatientSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(LabTestSeeder::class);
        $this->call(LabRequestSeeder::class);
        $this->call(LabRequestItemSeeder::class);
        $this->call(InventoryItemSeeder::class);
        $this->call(InventoryStockEntriesSeeder::class);
        $this->call(InventoryStockUsagesSeeder::class);
        
        // User::factory(10)->create();

        // Comment out or remove this as we're creating users in our RolesAndPermissionsSeeder
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
