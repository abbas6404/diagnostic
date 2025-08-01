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
        $this->call(DepartmentSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(UpdateAdminPermissionsSeeder::class);
        $this->call(CreateUsersSeeder::class);
        $this->call(PatientSeeder::class);
        $this->call(LabTestCategorySeeder::class);
        $this->call(InvoiceSeeder::class);
        $this->call(LabTestSeeder::class);
        $this->call(LabTestParameterSeeder::class);
        $this->call(LabTestOrderSeeder::class);
        $this->call(LabTestResultSeeder::class);
        $this->call(OpdServiceSeeder::class);
        $this->call(InventoryItemSeeder::class);
        $this->call(InventoryStockEntriesSeeder::class);
        $this->call(InventoryStockUsagesSeeder::class);
        $this->call(ConsultantTicketsSeeder::class);
        $this->call(InvoiceOpdItemSeeder::class);
        $this->call(DueCollectionDataSeeder::class);
        $this->call(InvoiceReturnDataSeeder::class);
        $this->call(CollectionKitSeeder::class);
        $this->call(LabTestCollectionKitSeeder::class);
        $this->call(SystemSettingsSeeder::class);
        
    }
}
