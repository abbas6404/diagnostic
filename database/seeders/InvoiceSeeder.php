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
            'invoice_no' => 'INV-250723-001',    
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
            'invoice_no' => 'INV-250723-002',
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
            'invoice_no' => 'INV-250723-003',
            'patient_id' => 3,
            'invoice_date' => '2025-01-01',
            'invoice_type' => 'lab',
            'total_amount' => 300,
            'paid_amount' => 100,
            'due_amount' => 200,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        DB::table('invoice')->insert([
            'id' => 4,
            'invoice_no' => 'INV-250723-004',
            'patient_id' => 4,
            'total_amount' => 500,
            'paid_amount' => 100,
            'due_amount' => 400,
            'invoice_date' => '2025-01-01',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 5,
            'invoice_no' => 'OPD-250723-005',
            'patient_id' => 5,
            'total_amount' => 700,
            'paid_amount' => 300,
            'due_amount' => 400,
            'invoice_date' => '2025-01-01',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 6,
            'invoice_no' => 'OPD-250723-006',
            'patient_id' => 6,
            'total_amount' => 1400,
            'paid_amount' => 500,
            'due_amount' => 900,
            'invoice_date' => '2025-01-01',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 7,
            'invoice_no' => 'OPD-250723-007',
            'patient_id' => 7,
            'total_amount' => 1000,
            'paid_amount' => 300,
            'due_amount' => 700,
            'invoice_date' => '2025-01-04',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 8,  
            'invoice_no' => 'OPD-250723-008',
            'patient_id' => 7,
            'total_amount' => 1300,
            'paid_amount' => 500,
            'due_amount' => 800,
            'invoice_date' => '2025-03-015',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 9,
            'invoice_no' => 'IPD-250723-007',
            'patient_id' => 7,
            'total_amount' => 1000,
            'paid_amount' => 300,
            'due_amount' => 700,
            'invoice_date' => '2025-01-18',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 10,
            'invoice_no' => 'IPD-250723-009',
            'patient_id' => 7,
            'total_amount' => 1000,
            'paid_amount' => 300,
            'due_amount' => 700,
            'invoice_date' => '2025-01-18',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 11,
            'invoice_no' => 'IPD-250723-010',
            'patient_id' => 7,
            'total_amount' => 1000,
            'paid_amount' => 300,
            'due_amount' => 700,
            'invoice_date' => '2025-01-18',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 12,
            'invoice_no' => 'IPD-250723-011',
            'patient_id' => 7,
            'total_amount' => 1000,
            'paid_amount' => 300,
            'due_amount' => 700,
            'invoice_date' => '2025-01-18',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 13,
            'invoice_no' => 'IPD-250723-012',
            'patient_id' => 7,
            'total_amount' => 1000,
            'paid_amount' => 300,
            'due_amount' => 700,
            'invoice_date' => '2025-01-18',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 14,
            'invoice_no' => 'IPD-250723-013',
            'patient_id' => 7,
            'total_amount' => 1000,
            'paid_amount' => 300,
            'due_amount' => 700,
            'invoice_date' => '2025-01-18',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 15,
            'invoice_no' => 'IPD-250723-014',
            'patient_id' => 7,
            'total_amount' => 1000,
            'paid_amount' => 300,
            'due_amount' => 700,
            'invoice_date' => '2025-01-18',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 16,
            'invoice_no' => 'IPD-250723-015',
            'patient_id' => 7,
            'total_amount' => 1000,
            'paid_amount' => 300,
            'due_amount' => 700,
            'invoice_date' => '2025-01-18',
            'invoice_type' => 'opd',
        ]);

        DB::table('invoice')->insert([
            'id' => 17,
            'invoice_no' => 'IPD-250723-016',
            'patient_id' => 7,
            'total_amount' => 1000,
            'paid_amount' => 300,
            'due_amount' => 700,
            'invoice_date' => '2025-01-18',
            'invoice_type' => 'opd',
        ]);

        DB::table('invoice')->insert([
            'id' => 18,
            'invoice_no' => 'IPD-250723-017',
            'patient_id' => 7,
            'total_amount' => 1000,
            'paid_amount' => 300,
            'due_amount' => 700,
            'invoice_date' => '2025-01-18',
            'invoice_type' => 'opd',
        ]);

        DB::table('invoice')->insert([
            'id' => 19,
            'invoice_no' => 'IPD-250723-018',
            'patient_id' => 7,
            'total_amount' => 1000,
            'paid_amount' => 300,
            'due_amount' => 700,
            'invoice_date' => '2025-01-18',
            'invoice_type' => 'opd',
        ]);

        DB::table('invoice')->insert([
                'id' => 20,
            'invoice_no' => 'IPD-250723-019',
            'patient_id' => 7,
            'total_amount' => 1000,
            'paid_amount' => 300,
            'due_amount' => 700,
            'invoice_date' => '2025-01-18',
            'invoice_type' => 'opd',
        ]);


        DB::table('invoice')->insert([
            'id' => 21,
            'invoice_no' => 'IPD-250723-020',
            'patient_id' => 8,
            'total_amount' => 1000,
            'paid_amount' => 700,
            'due_amount' => 300,
            'invoice_date' => '2025-01-01',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 22,
            'invoice_no' => 'IPD-250723-021',
            'patient_id' => 9,
            'total_amount' => 1000,
            'paid_amount' => 200,
            'due_amount' => 800,
            'invoice_date' => '2025-01-01',
            'invoice_type' => 'opd',
        ]);
        
        
     
    }
}
