<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lab_tests')->insert([
            'id' => 1,  
            'code' => 'BT-001',
            'department_id' => 1,
            'name' => 'Blood Test', // 1
            'description' => 'Blood Test',
            'charge' => '100',
        ]);
        DB::table('lab_tests')->insert([
            'id' => 2,
            'code' => 'UT-002',
            'department_id' => 2,
            'name' => 'Urine Test', // 2
            'description' => 'Urine Test',
            'charge' => '120',
        ]);
        DB::table('lab_tests')->insert([
            'id' => 3,
            'code' => 'XR-003',
            'department_id' => 3,
            'name' => 'X-Ray', // 3
            'description' => 'X-Ray',
            'charge' => '300',
        ]);
        DB::table('lab_tests')->insert([
            'id' => 4,
            'code' => 'CT-004',
            'department_id' => 2,
            'name' => 'CT Scan', // 4
            'description' => 'CT Scan',
            'charge' => '500',
        ]);
        DB::table('lab_tests')->insert([
            'id' => 5,
            'code' => 'ECG-005',
            'department_id' => 3,
            'name' => 'ECG', // 5
            'description' => 'ECG',
            'charge' => '200',
        ]);

        
        

    }
}
