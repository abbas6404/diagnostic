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
            'charge' => 100,
            'status' => 'pending',
           
        ]); 
        DB::table('lab_request_items')->insert([
            'id' => 2,
            'invoice_id' => 2,
            'lab_test_id' => 2,
            'charge' => 100,
            'status' => 'pending',
        ]);
        DB::table('lab_request_items')->insert([
            'id' => 3,
            'invoice_id' => 20,
            'lab_test_id' => 1,
            'charge' => 100,
            'status' => 'pending',
        ]);
        DB::table('lab_request_items')->insert([
            'id' => 4,
            'invoice_id' => 20,
            'lab_test_id' => 2,
            'charge' => 120,
            'status' => 'pending',
        ]);
        DB::table('lab_request_items')->insert([
            'id' => 5,
            'invoice_id' => 20,
            'lab_test_id' => 3,
            'charge' => 150,
            'status' => 'pending',
        ]);
        DB::table('lab_request_items')->insert([
            'id' => 6,
            'invoice_id' => 20,
            'lab_test_id' => 4,
            'charge' => 170,
            'status' => 'pending',
        ]);
        DB::table('lab_request_items')->insert([
            'id' => 7,  
            'invoice_id' => 20,
            'lab_test_id' => 5,
            'charge' => 200,
            'status' => 'pending',
        ]);

        DB::table('lab_request_items')->insert([
            'id' => 8,  
            'invoice_id' => 2,
            'lab_test_id' => 4,
            'charge' => 100,
            'status' => 'pending',
        ]);

    }
}
