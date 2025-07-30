<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabTestOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lab_test_orders')->insert([
            'id' => 1,
            'order_no' => 'LAB-250730-001',
            'invoice_id' => 1,  
            'lab_test_id' => 1,
            'patient_id' => 1,
            'referred_by' => 1,
            'charge' => 100,
            'status' => 'pending',
            'collection_date' => '2025-07-30',
            'collection_time' => '09:00:00',
            'sample_type' => 'Blood',
            'remarks' => 'Fasting required',
            'created_by' => 1,
            'updated_by' => 1,
        ]); 
        
        DB::table('lab_test_orders')->insert([
            'id' => 2,
            'order_no' => 'LAB-250730-002',
            'invoice_id' => 2,
            'lab_test_id' => 2,
            'patient_id' => 2,
            'referred_by' => 1,
            'charge' => 100,
            'status' => 'pending',
            'collection_date' => '2025-07-30',
            'collection_time' => '10:00:00',
            'sample_type' => 'Urine',
            'remarks' => 'Morning sample',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        
        DB::table('lab_test_orders')->insert([
            'id' => 3,
            'order_no' => 'LAB-250730-003',
            'invoice_id' => 20,
            'lab_test_id' => 1,
            'patient_id' => 3,
            'referred_by' => 1,
            'charge' => 100,
            'status' => 'in_progress',
            'collection_date' => '2025-07-30',
            'collection_time' => '11:00:00',
            'sample_type' => 'Blood',
            'remarks' => 'Routine check',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        
        DB::table('lab_test_orders')->insert([
            'id' => 4,
            'order_no' => 'LAB-250730-004',
            'invoice_id' => 20,
            'lab_test_id' => 2,
            'patient_id' => 3,
            'referred_by' => 1,
            'charge' => 120,
            'status' => 'completed',
            'collection_date' => '2025-07-30',
            'collection_time' => '11:00:00',
            'sample_type' => 'Urine',
            'remarks' => 'Complete analysis',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        
        DB::table('lab_test_orders')->insert([
            'id' => 5,
            'order_no' => 'LAB-250730-005',
            'invoice_id' => 20,
            'lab_test_id' => 3,
            'patient_id' => 3,
            'referred_by' => 1,
            'charge' => 150,
            'status' => 'pending',
            'collection_date' => '2025-07-31',
            'collection_time' => '09:00:00',
            'sample_type' => 'Blood',
            'remarks' => 'Special test',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        
        DB::table('lab_test_orders')->insert([
            'id' => 6,
            'order_no' => 'LAB-250730-006',
            'invoice_id' => 20,
            'lab_test_id' => 4,
            'patient_id' => 3,
            'referred_by' => 1,
            'charge' => 170,
            'status' => 'pending',
            'collection_date' => '2025-07-31',
            'collection_time' => '09:00:00',
            'sample_type' => 'Blood',
            'remarks' => 'Advanced test',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        
        DB::table('lab_test_orders')->insert([
            'id' => 7,  
            'order_no' => 'LAB-250730-007',
            'invoice_id' => 20,
            'lab_test_id' => 5,
            'patient_id' => 3,
            'referred_by' => 1,
            'charge' => 200,
            'status' => 'pending',
            'collection_date' => '2025-07-31',
            'collection_time' => '09:00:00',
            'sample_type' => 'Blood',
            'remarks' => 'Comprehensive test',
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        DB::table('lab_test_orders')->insert([
            'id' => 8,  
            'order_no' => 'LAB-250730-008',
            'invoice_id' => 2,
            'lab_test_id' => 4,
            'patient_id' => 2,
            'referred_by' => 1,
            'charge' => 100,
            'status' => 'pending',
            'collection_date' => '2025-07-30',
            'collection_time' => '14:00:00',
            'sample_type' => 'Blood',
            'remarks' => 'Regular checkup',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
    }
}
