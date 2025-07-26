<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OpdServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        
        // Get department IDs
        $departmentId = DB::table('departments')->where('name', 'OPD')->first()->id ?? 1;
        
        // Sample OPD services
        $opdServices = [
            [
                'id' => 1,
                'code' => 'OPD-001',
                'department_id' => $departmentId,
                'name' => 'General Consultation',
                'description' => 'General doctor consultation',
                'charge' => 500.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'code' => 'OPD-002',
                'department_id' => $departmentId,
                'name' => 'Specialist Consultation',
                'description' => 'Specialist doctor consultation',
                'charge' => 1000.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'code' => 'OPD-003',
                'department_id' => $departmentId,
                'name' => 'Dressing',
                'description' => 'Wound dressing service',
                'charge' => 300.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'code' => 'OPD-004',
                'department_id' => $departmentId,
                'name' => 'Injection',
                'description' => 'Injection administration',
                'charge' => 200.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'code' => 'OPD-005',
                'department_id' => $departmentId,
                'name' => 'Nebulization',
                'description' => 'Nebulization treatment',
                'charge' => 350.00,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
        
        DB::table('opd_services')->insert($opdServices);
    }
} 