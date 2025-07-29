<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OpdService;
use App\Models\Department;

class OpdServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get departments
        $departments = Department::all();
        
        if ($departments->isEmpty()) {
            $this->command->warn('No departments found. Please run DepartmentSeeder first.');
            return;
        }

        $opdServices = [
            [
                'code' => 'OPD-001',
                'department_id' => $departments->first()->id,
                'name' => 'General Consultation',
                'description' => 'Basic consultation with general physician',
                'charge' => 500.00,
            ],
            [
                'code' => 'OPD-002',
                'department_id' => $departments->first()->id,
                'name' => 'Specialist Consultation',
                'description' => 'Consultation with specialist doctor',
                'charge' => 1000.00,
            ],
            [
                'code' => 'OPD-003',
                'department_id' => $departments->first()->id,
                'name' => 'Emergency Consultation',
                'description' => 'Emergency consultation service',
                'charge' => 1500.00,
            ],
            [
                'code' => 'OPD-004',
                'department_id' => $departments->first()->id,
                'name' => 'Follow-up Consultation',
                'description' => 'Follow-up consultation for existing patients',
                'charge' => 300.00,
            ],
            [
                'code' => 'OPD-005',
                'department_id' => $departments->first()->id,
                'name' => 'Health Check-up',
                'description' => 'Comprehensive health check-up service',
                'charge' => 2000.00,
            ],
        ];

        foreach ($opdServices as $service) {
            OpdService::create([
                'code' => $service['code'],
                'department_id' => $service['department_id'],
                'name' => $service['name'],
                'description' => $service['description'],
                'charge' => $service['charge'],
                'created_by' => 1, // Assuming admin user ID is 1
                'updated_by' => 1,
            ]);
        }

        $this->command->info('OPD Services seeded successfully!');
    }
} 