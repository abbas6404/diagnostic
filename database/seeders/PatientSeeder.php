<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('patients')->insert([
            'patient_id' => '1',
            'reg_date' => '2025-01-01',
            'name_en' => 'Ariyan Abdullah',
            'name_bn' => 'আরিয়ান আব্দুল্লাহ',
            'father_husband_name_en' => 'Ariyan Abdullah',
            'address' => 'Dhaka',
            'phone' => '01717171717',
            'email' => 'ariyan@gmail.com',
            'dob' => '1990-01-01',
            'gender' => 'Male',
            'blood_group' => 'A+',
            'religion' => 'Islam',
            'occupation' => 'Student',
            'reg_fee' => '100',
            'nationality' => 'Bangladeshi',
            'patient_type' => 'Inpatient',
            'created_by' => '1',
            'updated_by' => '1',
        ]);
        DB::table('patients')->insert([
            'patient_id' => '2',
            'reg_date' => '2025-01-01',
            'name_en' => 'Rakibul Islam',
            'name_bn' => 'রাকিবুল ইসলাম',
            'father_husband_name_en' => 'Rakibul Islam',
        ]);
        DB::table('patients')->insert([
            'patient_id' => '3',
            'reg_date' => '2025-01-01',
            'name_en' => 'Rabiul Islam',
            'name_bn' => 'রবিউল ইসলাম',
            'father_husband_name_en' => 'Rabiul Islam',
        ]);
    }
}
