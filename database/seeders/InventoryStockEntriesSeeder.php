<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoryStockEntriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('inventory_stock_entries')->insert([
            'id' => 1,
            'inventory_item_id' => 1,
            'quantity' => 10,
            'unit_price' => 10,
            'total_price' => 100,
            'entry_date' => '2025-01-01',
            'supplier_id' => 1,
            'created_by' => '1',
            'updated_by' => '1',
        ]);
        
        DB::table('inventory_stock_entries')->insert([
            'id' => 2,
            'inventory_item_id' => 2,
            'quantity' => 10,
            'unit_price' => 10,
            'total_price' => 100,
            'entry_date' => '2025-01-01',
            'supplier_id' => 1,
            'created_by' => '1',
            'updated_by' => '1',
        ]); 
        
        
    }
}
