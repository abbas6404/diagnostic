<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([
            'id' => 1,
            'name' => 'Cardiology', // 1
            'description' => 'Cardiology is the study of the heart and blood vessels.',
        ]);
        DB::table('departments')->insert([
            'id' => 2,
            'name' => 'Neurology', // 2
            'description' => 'Neurology is the study of the nervous system.',
        ]);
        DB::table('departments')->insert([
            'id' => 3,
            'name' => 'Orthopedics', // 3
            'description' => 'Orthopedics is the study of the musculoskeletal system.',
        ]);
        DB::table('departments')->insert([
            'id' => 4,
            'name' => 'Pathology', // 4
            'description' => 'Pathology is the study of the diseases and their causes.',
        ]);
        DB::table('departments')->insert([
            'id' => 5,
            'name' => 'Radiology', // 5
            'description' => 'Radiology is the study of the diseases and their causes.',
        ]);
    }
}
