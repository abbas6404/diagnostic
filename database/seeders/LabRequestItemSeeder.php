<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabRequestItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lab_request_items')->insert([
            'id' => 1,
            'invoice_id' => 1,  
            'lab_test_id' => 1,
            'price' => 100,
            
           
        ]); 
        DB::table('lab_request_items')->insert([
            'id' => 2,
            'invoice_id' => 2,
            'lab_test_id' => 2,
            'price' => 100,
        ]);
        DB::table('lab_request_items')->insert([
            'id' => 3,
            'invoice_id' => 3,
            'lab_test_id' => 3,
            'price' => 100,
        ]);
    }
}
