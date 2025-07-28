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
            'name' => 'PATHOLOGY', // 4
            'description' => 'LAB',
        ]);
        DB::table('departments')->insert([
            'id' => 2,
            'name' => 'Microbiology (C/S)', 
            'description' => 'Microbiology (C/S)',
        ]);
        DB::table('departments')->insert([
            'id' => 3,
            'name' => 'Histopathology / Cytology Test', 
            'description' => 'Histopathology / Cytology Test',
        ]);
       
        DB::table('departments')->insert([
            'id' => 4,  
            'name' => 'MRI / CT Scan', 
            'description' => 'MRI / CT Scan',
        ]);
    
        DB::table('departments')->insert([
            'id' => 5,
            'name' => 'URINE', // 4
            'description' => 'URINE',
        ]);
        DB::table('departments')->insert([
            'id' => 6,  
            'name' => 'X-RAY', // 4
            'description' => 'X-RAY',
        ]);
        DB::table('departments')->insert([
            'id' => 7,
            'name' => 'ULTRASONOGRAM', // 4
            'description' => 'ULTRASONOGRAM',
        ]);
       
        DB::table('departments')->insert([
            'id' => 8,
            'name' => 'Endoscopy/Colonoscopy', // 4
            'description' => 'Endoscopy/Colonoscopy',
        ]);
        DB::table('departments')->insert([
            'id' => 9,
            'name' => 'ECG', // 4
            'description' => 'ECG',
        ]);
        DB::table('departments')->insert([
            'id' => 10,
            'name' => 'ECHO Cardiogram', // 4
            'description' => 'ECHO Cardiogram',
        ]);

       
       
        
        
        
        
            
     
    }
}
