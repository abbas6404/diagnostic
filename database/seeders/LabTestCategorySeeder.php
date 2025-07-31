<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabTestCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Blood Tests',
                'description' => 'Complete blood count, blood chemistry, and blood-related tests',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'name' => 'Biochemistry',
                'description' => 'Blood chemistry tests including glucose, liver function, kidney function',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'name' => 'Immunology',
                'description' => 'Immune system tests, antibodies, and immunological markers',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'name' => 'Microbiology',
                'description' => 'Culture and sensitivity tests, bacterial identification',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'name' => 'Histopathology',
                'description' => 'Tissue examination, FNAC, and cytological studies',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'name' => 'Urine Analysis',
                'description' => 'Urine examination and analysis',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'name' => 'Hormone Tests',
                'description' => 'Endocrine system tests including thyroid, reproductive hormones',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'name' => 'Tumor Markers',
                'description' => 'Cancer screening and monitoring tests',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'name' => 'Cardiac Markers',
                'description' => 'Heart-related tests and cardiac markers',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'name' => 'Infectious Diseases',
                'description' => 'Tests for infectious diseases like hepatitis, HIV, tuberculosis',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'name' => 'Coagulation Tests',
                'description' => 'Blood clotting and coagulation studies',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'name' => 'Electrolytes',
                'description' => 'Electrolyte balance and mineral tests',
                'created_by' => 1,
                'updated_by' => 1,
            ],
        ];

        foreach ($categories as $category) {
            DB::table('lab_test_categories')->insert($category);
        }

        $this->command->info('Lab Test Categories seeded successfully!');
    }
} 