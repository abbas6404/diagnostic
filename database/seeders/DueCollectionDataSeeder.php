<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DueCollectionDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add more OPD invoices with due amounts
        DB::table('invoices')->insert([
            'id' => 23,
            'invoice_no' => 'OPD-250823-022',
            'patient_id' => 1,
            'total_amount' => 800,
            'paid_amount' => 300,
            'due_amount' => 500,
            'invoice_date' => '2025-01-15',
            'invoice_type' => 'opd',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        
        DB::table('invoices')->insert([
            'id' => 24,
            'invoice_no' => 'OPD-250723-023',
            'patient_id' => 2,
            'total_amount' => 1200,
            'paid_amount' => 400,
            'due_amount' => 800,
            'invoice_date' => '2025-01-16',
            'invoice_type' => 'opd',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        
        DB::table('invoices')->insert([
            'id' => 25,
            'invoice_no' => 'OPD-250723-024',
            'patient_id' => 3,
            'total_amount' => 950,
            'paid_amount' => 200,
            'due_amount' => 750,
            'invoice_date' => '2025-01-17',
            'invoice_type' => 'opd',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        
        // Add diagnostics invoices with due amounts
        DB::table('invoices')->insert([
            'id' => 26,
            'invoice_no' => 'DIA-250723-022',
            'patient_id' => 1,
            'total_amount' => 2500,
            'paid_amount' => 1000,
            'due_amount' => 1500,
            'invoice_date' => '2025-01-15',
            'invoice_type' => 'dia',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        
        DB::table('invoices')->insert([
            'id' => 27,
            'invoice_no' => 'DIA-250723-023',
            'patient_id' => 2,
            'total_amount' => 3200,
            'paid_amount' => 1200,
            'due_amount' => 2000,
            'invoice_date' => '2025-01-16',
            'invoice_type' => 'dia',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        
        DB::table('invoices')->insert([
            'id' => 28,
            'invoice_no' => 'DIA-250723-024',
            'patient_id' => 3,
            'total_amount' => 1800,
            'paid_amount' => 600,
            'due_amount' => 1200,
            'invoice_date' => '2025-01-17',
            'invoice_type' => 'dia',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        
        DB::table('invoices')->insert([
            'id' => 29,
            'invoice_no' => 'DIA-250723-025',
            'patient_id' => 4,
            'total_amount' => 4100,
            'paid_amount' => 1500,
            'due_amount' => 2600,
            'invoice_date' => '2025-01-18',
            'invoice_type' => 'dia',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        
        DB::table('invoices')->insert([
            'id' => 30,
            'invoice_no' => 'DIA-250723-026',
            'patient_id' => 5,
            'total_amount' => 2800,
            'paid_amount' => 800,
            'due_amount' => 2000,
            'invoice_date' => '2025-01-19',
            'invoice_type' => 'dia',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        
        // Add more Consultant invoices with due amounts
        DB::table('invoices')->insert([
            'id' => 31,
            'invoice_no' => 'CON-250723-003',
            'patient_id' => 1,
            'total_amount' => 500,
            'paid_amount' => 200,
            'due_amount' => 300,
            'invoice_date' => '2025-01-15',
            'invoice_type' => 'consultant',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        
        DB::table('invoices')->insert([
            'id' => 32,
            'invoice_no' => 'CON-250723-004',
            'patient_id' => 2,
            'total_amount' => 750,
            'paid_amount' => 300,
            'due_amount' => 450,
            'invoice_date' => '2025-01-16',
            'invoice_type' => 'consultant',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        
        DB::table('invoices')->insert([ 
            'id' => 33,
            'invoice_no' => 'CON-250723-005',
            'patient_id' => 3,
            'total_amount' => 600,
            'paid_amount' => 150,
            'due_amount' => 450,
            'invoice_date' => '2025-01-17',
            'invoice_type' => 'consultant',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        
        DB::table('invoices')->insert([
            'id' => 34,
            'invoice_no' => 'CON-250723-006',
            'patient_id' => 4,
            'total_amount' => 900,
            'paid_amount' => 400,
            'due_amount' => 500,
            'invoice_date' => '2025-01-18',
            'invoice_type' => 'consultant',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        
        DB::table('invoices')->insert([ 
            'id' => 35,
            'invoice_no' => 'CON-250723-007',
            'patient_id' => 5,
            'total_amount' => 1200,
            'paid_amount' => 500,
            'due_amount' => 700,
            'invoice_date' => '2025-01-19',
            'invoice_type' => 'consultant',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        
        // Add Consultant Tickets for the new consultant invoices
        DB::table('consultant_tickets')->insert([
            'id' => 11,
            'ticket_no' => 'dt-00011',
            'ticket_status' => 'completed',
            'ticket_date' => '2025-01-15',
            'ticket_time' => '14:30',
            'patient_type' => 'new',
            'patient_id' => 1,
            'doctor_id' => 1,
            'invoice_id' => 31,
        ]);
        
        DB::table('consultant_tickets')->insert([
            'id' => 12,
            'ticket_no' => 'dt-00012',
            'ticket_status' => 'pending',
            'ticket_date' => '2025-01-16',
            'ticket_time' => '09:15',
            'patient_type' => 'old',
            'patient_id' => 2,
            'doctor_id' => 2,
            'invoice_id' => 32,
        ]);
        
        DB::table('consultant_tickets')->insert([
            'id' => 13,
            'ticket_no' => 'dt-00013',
            'ticket_status' => 'completed',
            'ticket_date' => '2025-01-17',
            'ticket_time' => '11:45',
            'patient_type' => 'new',
            'patient_id' => 3,
            'doctor_id' => 3,
            'invoice_id' => 33,
        ]);
        
        DB::table('consultant_tickets')->insert([
            'id' => 14,
            'ticket_no' => 'dt-00014',
            'ticket_status' => 'pending',
            'ticket_date' => '2025-01-18',
            'ticket_time' => '16:00',
            'patient_type' => 'old',
            'patient_id' => 4,
            'doctor_id' => 4,
            'invoice_id' => 34,
        ]);
        
        DB::table('consultant_tickets')->insert([
            'id' => 15,
            'ticket_no' => 'dt-00015',
            'ticket_status' => 'cancelled',
            'ticket_date' => '2025-01-19',
            'ticket_time' => '13:20',   
            'patient_type' => 'new',
            'patient_id' => 5,
            'doctor_id' => 5,
            'invoice_id' => 35,
        ]);
        
        // Add OPD Service Items for OPD invoices
        DB::table('invoice_opd_item')->insert([
            'id' => 24,
            'invoice_id' => 23,
            'opd_service_id' => 1,
        ]);
        
        DB::table('invoice_opd_item')->insert([
            'id' => 25,
            'invoice_id' => 23,
            'opd_service_id' => 2,
        ]);
        
        DB::table('invoice_opd_item')->insert([
            'id' => 26,
            'invoice_id' => 24,
            'opd_service_id' => 1,
        ]);
        
        DB::table('invoice_opd_item')->insert([
            'id' => 27,
            'invoice_id' => 25,
            'opd_service_id' => 3,
        ]);
        
        DB::table('invoice_opd_item')->insert([
            'id' => 28,
            'invoice_id' => 25,
            'opd_service_id' => 2,
        ]);
        
        // Add Lab Test Orders for diagnostics invoices
        DB::table('lab_test_orders')->insert([
            'id' => 9,
            'order_no' => 'LAB-250730-014',
            'invoice_id' => 26,
            'lab_test_id' => 1,
            'patient_id' => 1,
            'referred_by' => 1,
            'charge' => 1500,
            'status' => 'completed',
            'collection_date' => '2025-07-30',
            'collection_time' => '08:00:00',
            'sample_type' => 'Blood',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        
        DB::table('lab_test_orders')->insert([
            'id' => 10,
            'order_no' => 'LAB-250730-015',
            'invoice_id' => 27,
            'lab_test_id' => 2,
            'patient_id' => 2,
            'referred_by' => 1,
            'charge' => 2000,
            'status' => 'pending',
            'collection_date' => '2025-07-30',
            'collection_time' => '09:00:00',
            'sample_type' => 'Urine',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        
        DB::table('lab_test_orders')->insert([
            'id' => 11,
            'order_no' => 'LAB-250730-016',
            'invoice_id' => 28,
            'lab_test_id' => 3,
            'patient_id' => 3,
            'referred_by' => 1,
            'charge' => 1200,
            'status' => 'completed',
            'collection_date' => '2025-07-30',
            'collection_time' => '10:00:00',
            'sample_type' => 'Blood',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        
        DB::table('lab_test_orders')->insert([
            'id' => 12,
            'order_no' => 'LAB-250730-017',
            'invoice_id' => 29,
            'lab_test_id' => 1,
            'patient_id' => 4,
            'referred_by' => 1,
            'charge' => 2600,
            'status' => 'pending',
            'collection_date' => '2025-07-30',
            'collection_time' => '11:00:00',
            'sample_type' => 'Blood',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        
        DB::table('lab_test_orders')->insert([
            'id' => 13,
            'order_no' => 'LAB-250730-018',
            'invoice_id' => 30,
            'lab_test_id' => 2,
            'patient_id' => 5,
            'referred_by' => 1,
            'charge' => 2000,
            'status' => 'cancelled',
            'collection_date' => '2025-07-30',
            'collection_time' => '12:00:00',
            'sample_type' => 'Urine',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
    }
} 