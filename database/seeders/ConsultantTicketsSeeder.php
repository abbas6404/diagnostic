<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConsultantTicketsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('consultant_tickets')->insert([
            'id' => 1,
            'ticket_no' => 'dt-00001',
            'ticket_status' => 'pending',
            'ticket_date' => '2025-01-01',  
            'ticket_time' => '10:00',
            'doctor_fee' => '100',
            'patient_type' => 'new',
            'patient_id' => 1,
            'doctor_id' => 1,
           
        ]);
        DB::table('consultant_tickets')->insert([
            'id' => 2,
            'ticket_no' => 'dt-00002',
            'ticket_status' => 'pending',   
            'ticket_date' => '2025-01-01',  
            'ticket_time' => '10:00',
            'doctor_fee' => '100',
            'patient_type' => 'old',
            'patient_id' => 2,
            'doctor_id' => 2,
           
        ]); 
        DB::table('consultant_tickets')->insert([
            'id' => 3,
            'ticket_no' => 'dt-00003',
            'ticket_status' => 'pending',   
            'ticket_date' => '2025-01-01',  
            'ticket_time' => '10:00',
            'doctor_fee' => '100',
            'patient_type' => 'old',
            'patient_id' => 3,
            'doctor_id' => 3,
           
        ]); 
    }
}
