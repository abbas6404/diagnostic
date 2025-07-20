<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lab_request')->insert([
            'id' => 1,
            'patient_id' => 1,
            'status' => 'pending',
            'request_date' => '2025-01-01',
            'total_amount' => 100,
            'paid_amount' => 100,
            'due_amount' => 0,
            'payment_method' => 'cash',
            'created_by' => '1',
            'updated_by' => '1',
        ]);
        DB::table('lab_request')->insert([
            'id' => 2,
            'patient_id' => 2,
            'status' => 'pending',
            'request_date' => '2025-01-01',
            'total_amount' => 100,
            'paid_amount' => 100,
            'due_amount' => 0,
            'payment_method' => 'cash',
            'created_by' => '1',
            'updated_by' => '1',
        ]);
        DB::table('lab_request')->insert([
            'id' => 3,
            'patient_id' => 3,
            'status' => 'pending',
            'request_date' => '2025-01-01',
            'total_amount' => 100,
            'paid_amount' => 100,
            'due_amount' => 0,
            'payment_method' => 'cash',
            'created_by' => '1',
            'updated_by' => '1',
        ]);
    }
}
