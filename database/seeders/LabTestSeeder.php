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
            'department_id' => 1,
            'name' => 'Blood Test', // 1
            'description' => 'Blood Test',
            'price' => '100',
        ]);
        DB::table('lab_tests')->insert([
            'id' => 2,
            'department_id' => 2,
            'name' => 'Urine Test', // 2
            'description' => 'Urine Test',
            'price' => '100',
        ]);
        DB::table('lab_tests')->insert([
            'id' => 3,
            'department_id' => 3,
            'name' => 'X-Ray', // 3
            'description' => 'X-Ray',
            'price' => '100',
        ]);
        
        

    }
}
