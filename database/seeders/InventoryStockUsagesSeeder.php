<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoryStockUsagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('inventory_stock_usages')->insert([
            'id' => 1,
            'inventory_item_id' => 1,
            'quantity' => 1,
            'used_for' => 'lab_request',
            'used_date' => '2025-01-01',
            'used_by' => '1',
        ]);
        DB::table('inventory_stock_usages')->insert([
            'id' => 2,
            'inventory_item_id' => 2,
            'quantity' => 1,
            'used_for' => 'lab_request',
            'used_date' => '2025-01-01',
            'used_by' => '1',
        ]);
        DB::table('inventory_stock_usages')->insert([
            'id' => 3,
            'inventory_item_id' => 3,
            'quantity' => 1,
            'used_for' => 'lab_request',
            'used_date' => '2025-01-01',
            'used_by' => '1',
        ]);
    }
}
