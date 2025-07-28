<?php

namespace Database\Seeders;

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
            'invoice_no' => 'CON-250723-001',    
            'patient_id' => 1,  
            'invoice_date' => '2025-01-01',
            'invoice_type' => 'consultant',    
            'total_amount' => 120,
            'paid_amount' => 100,
            'due_amount' => 20,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        DB::table('invoice')->insert([
            'id' => 2,
            'invoice_no' => 'CON-250723-002',
            'patient_id' => 2,
            'invoice_date' => '2025-01-01',
            'invoice_type' => 'consultant',
            'total_amount' => 250,
            'paid_amount' => 150,
            'due_amount' => 100,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        DB::table('invoice')->insert([
            'id' => 3,
            'invoice_no' => 'DIA-250723-003',
            'patient_id' => 3,
            'invoice_date' => '2025-01-01',
            'invoice_type' => 'dia',
            'total_amount' => 350,
            'paid_amount' => 200,
            'due_amount' => 150,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        DB::table('invoice')->insert([
            'id' => 4,
            'invoice_no' => 'OPD-250723-004',
            'patient_id' => 4,
            'total_amount' => 550,
            'paid_amount' => 300,
            'due_amount' => 250,
            'invoice_date' => '2025-01-01',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 5,
            'invoice_no' => 'OPD-250723-005',
            'patient_id' => 5,
            'total_amount' => 750,
            'paid_amount' => 350,
            'due_amount' => 400,
            'invoice_date' => '2025-01-01',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 6,
            'invoice_no' => 'OPD-250723-006',
            'patient_id' => 6,
            'total_amount' => 1450,
            'paid_amount' => 800,
            'due_amount' => 650,
            'invoice_date' => '2025-01-01',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 7,
            'invoice_no' => 'OPD-250723-007',
            'patient_id' => 7,
            'total_amount' => 1100,
            'paid_amount' => 400,
            'due_amount' => 700,
            'invoice_date' => '2025-01-04',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 8,  
            'invoice_no' => 'OPD-250723-008',
            'patient_id' => 7,
            'total_amount' => 1350,
            'paid_amount' => 550,
            'due_amount' => 800,
            'invoice_date' => '2025-03-15',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 9,
            'invoice_no' => 'OPD-250723-009',
            'patient_id' => 7,
            'total_amount' => 1250,
            'paid_amount' => 500,
            'due_amount' => 750,
            'invoice_date' => '2025-01-18',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 10,
            'invoice_no' => 'OPD-250723-010',
            'patient_id' => 7,
            'total_amount' => 1400,
            'paid_amount' => 600,
            'due_amount' => 800,
            'invoice_date' => '2025-01-18',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 11,
            'invoice_no' => 'OPD-250723-011',
            'patient_id' => 7,
            'total_amount' => 1550,
            'paid_amount' => 700,
            'due_amount' => 850,
            'invoice_date' => '2025-01-18',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 12,
            'invoice_no' => 'OPD-250723-012',
            'patient_id' => 7,
            'total_amount' => 1700,
            'paid_amount' => 800,
            'due_amount' => 900,
            'invoice_date' => '2025-01-18',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 13,
            'invoice_no' => 'OPD-250723-013',
            'patient_id' => 7,
            'total_amount' => 1850,
            'paid_amount' => 900,
            'due_amount' => 950,
            'invoice_date' => '2025-01-18',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 14,
            'invoice_no' => 'OPD-250723-014',
            'patient_id' => 7,
            'total_amount' => 2000,
            'paid_amount' => 1000,
            'due_amount' => 1000,
            'invoice_date' => '2025-01-18',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 15,
            'invoice_no' => 'OPD-250723-015',
            'patient_id' => 7,
            'total_amount' => 2150,
            'paid_amount' => 1100,
            'due_amount' => 1050,
            'invoice_date' => '2025-01-18',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 16,
            'invoice_no' => 'OPD-250723-016',
            'patient_id' => 7,
            'total_amount' => 2300,
            'paid_amount' => 1200,
            'due_amount' => 1100,
            'invoice_date' => '2025-01-18',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 17,
            'invoice_no' => 'OPD-250723-017',
            'patient_id' => 7,
            'total_amount' => 2450,
            'paid_amount' => 1300,
            'due_amount' => 1150,
            'invoice_date' => '2025-01-18',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 18,
            'invoice_no' => 'OPD-250723-018',
            'patient_id' => 7,
            'total_amount' => 2600,
            'paid_amount' => 1400,
            'due_amount' => 1200,
            'invoice_date' => '2025-01-18',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 19,
            'invoice_no' => 'OPD-250723-019',
            'patient_id' => 7,
            'total_amount' => 2750,
            'paid_amount' => 1500,
            'due_amount' => 1250,
            'invoice_date' => '2025-01-18',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 20,
            'invoice_no' => 'OPD-250723-020',
            'patient_id' => 7,
            'total_amount' => 2900,
            'paid_amount' => 1600,
            'due_amount' => 1300,
            'invoice_date' => '2025-01-18',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 21,
            'invoice_no' => 'OPD-250723-021',
            'patient_id' => 8,
            'total_amount' => 3050,
            'paid_amount' => 1700,
            'due_amount' => 1350,
            'invoice_date' => '2025-01-01',
            'invoice_type' => 'opd',
        ]);
        DB::table('invoice')->insert([
            'id' => 22,
            'invoice_no' => 'OPD-250723-022',
            'patient_id' => 9,
            'total_amount' => 3200,
            'paid_amount' => 1800,
            'due_amount' => 1400,
            'invoice_date' => '2025-01-01',
            'invoice_type' => 'opd',
        ]);
    }
}
