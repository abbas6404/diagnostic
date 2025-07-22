<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('invoice')->insert([
            'id' => 1,
            'invoice_no' => '1',    
            'patient_id' => 1,  
            'invoice_date' => '2025-01-01',
            'invoice_type' => 'lab',    
            'total_amount' => 100,
            'paid_amount' => 100,
            'due_amount' => 0,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        DB::table('invoice')->insert([
            'id' => 2,
            'invoice_no' => '2',
            'patient_id' => 2,
            'invoice_date' => '2025-01-01',
            'invoice_type' => 'opd',
            'total_amount' => 200,
            'paid_amount' => 100,
            'due_amount' => 100,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        DB::table('invoice')->insert([
            'id' => 3,
            'invoice_no' => '3',
            'patient_id' => 3,
            'invoice_date' => '2025-01-01',
            'invoice_type' => 'lab',
            'total_amount' => 100,
            'paid_amount' => 100,
            'due_amount' => 0,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        
     
    }
}
