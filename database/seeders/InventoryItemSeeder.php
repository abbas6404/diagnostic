<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoryItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('inventory_items')->insert([
            'id' => 1,
            'name' => 'Paracetamol',
            'description' => 'Paracetamol is a common painkiller and fever reducer.',
            'department_id' => 1,
            'reorder_level' => 10,
        ]);
        DB::table('inventory_items')->insert([
            'id' => 2,
            'name' => 'Ibuprofen',
            'description' => 'Ibuprofen is a common painkiller and fever reducer.',
            'department_id' => 1,
            'reorder_level' => 10,
        ]);
        DB::table('inventory_items')->insert([
            'id' => 3,
            'name' => 'Aspirin',
            'description' => 'Aspirin is a common painkiller and fever reducer.',
            'department_id' => 1,
            'reorder_level' => 10,
        ]);
    }
}
