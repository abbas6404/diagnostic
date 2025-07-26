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
            'id' => 1,
            'patient_id' => '250722001',
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
            'id' => 2,
            'patient_id' => '250722002',
            'reg_date' => '2025-01-01',
            'name_en' => 'Rakibul Islam',
            'name_bn' => 'রাকিবুল ইসলাম',
            'dob' => '1993-01-01',
            'gender' => 'Male',
            'blood_group' => 'A+',
            'religion' => 'Islam',
            'occupation' => 'Student',
            'reg_fee' => '100',
            'nationality' => 'Bangladeshi',
            'phone' => '01717171718',
            'address' => 'Barishal', 
            'father_husband_name_en' => 'Rakibul Islam',
        ]);
        DB::table('patients')->insert([
            'id' => 3,
            'patient_id' => '250722003',
            'reg_date' => '2025-01-01',
            'name_en' => 'Arafat Hossain',
            'name_bn' => 'আরফত হোসেন',
            'dob' => '1994-01-01',
            'gender' => 'Male',
            'blood_group' => 'A+',
            'religion' => 'Islam',
            'occupation' => 'Student',
            'reg_fee' => '100',
            'nationality' => 'Bangladeshi',
            'phone' => '01717171719',
            'address' => 'Sylhet', 
            'father_husband_name_en' => 'Arafat Hossain',
        ]);
        DB::table('patients')->insert([
            'id' => 4,
            'patient_id' => '250722004',
            'reg_date' => '2025-01-01', 
            'name_en' => 'Abdur Rahim',
            'name_bn' => 'আবদুর রহিম',
            'dob' => '1995-01-01',
            'phone' => '01717171720',
            'address' => 'Rajshahi', 
            'father_husband_name_en' => 'Abdur Rahim',
        ]);
        DB::table('patients')->insert([ 
            'id' => 5,
            'patient_id' => '250722005',
            'reg_date' => '2025-01-01',
            'name_en' => 'Abbas Hossain',
            'name_bn' => 'আবাস হোসেন',
            'dob' => '1996-01-01',
            'phone' => '01717171721',
            'address' => 'Khulna', 
            'father_husband_name_en' => 'Abbas Hossain',
        ]);
        DB::table('patients')->insert([
            'id' => 6,
            'patient_id' => '250722006',
            'reg_date' => '2025-01-01',
            'name_en' => 'Sojol Hossain',
            'name_bn' => 'সোজল হোসেন',
            'dob' => '1997-01-01',
            'phone' => '01717171722',
            'address' => 'Chittagong', 
            'father_husband_name_en' => 'Sojol Hossain',
        ]);
        DB::table('patients')->insert([
            'id' => 7,
            'patient_id' => '240522001',
            'reg_date' => '2025-01-01',
            'name_en' => 'Raju Hossain',
            'name_bn' => 'রাজু হোসেন',
            'gender' => 'Male',
            'dob' => '1998-01-01',
            'phone' => '01717171723',
            'address' => 'Mymensingh', 
            'father_husband_name_en' => 'Raju Hossain',
        ]);
        DB::table('patients')->insert([
            'id' => 8,
            'patient_id' => '230722001',
            'reg_date' => '2025-01-01',
            'dob' => '1999-01-01',
            'name_en' => 'Raju Hossain',
            'name_bn' => 'রাজু হোসেন',
            'phone' => '01717171725',
            'address' => 'Rangpur', 
            'father_husband_name_en' => 'Raju Hossain',
        ]);
        DB::table('patients')->insert([
            'id' => 9,
            'patient_id' => '220722001',
            'reg_date' => '2025-01-01',
            'name_en' => 'Rajaul Hossain',
            'name_bn' => 'রাজাল হোসেন',
            'dob' => '2000-01-01',
            'phone' => '01717171726',
            'address' => 'Barisal', 
            'father_husband_name_en' => 'Raju Hossain',
        ]);
        DB::table('patients')->insert([
            'id' => 10,
            'patient_id' => '210722089',
            'reg_date' => '2025-01-01',
            'name_en' => 'Rajaul Hossain',
            'dob' => '2001-01-01',
            'name_bn' => 'রাজাল হোসেন', 
            'phone' => '01717171726',
            'address' => 'Barisal', 
            'father_husband_name_en' => 'Raju Hossain',
        ]);
        DB::table('patients')->insert([
            'id' => 11,
            'patient_id' => '230722005',
            'dob' => '2002-01-01',
            'reg_date' => '2025-01-01',
            'name_en' => 'Rajaul Hossain',
            'name_bn' => 'রাজাল হোসেন', 
            'phone' => '01717171726',
            'address' => 'Barisal', 
            'father_husband_name_en' => 'Raju Hossain',
        ]);

    }
}
