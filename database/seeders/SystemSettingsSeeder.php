<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SystemSetting;

class SystemSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Prefix Settings
        SystemSetting::setValue(
            'consolidated_invoice_prefix',
            'DT',
            'string',
            'prefix',
            'Prefix for doctor ticket numbers'
        );

        SystemSetting::setValue(
            'consolidated_invoice_start',
            '1',
            'integer',
            'prefix',
            'Starting number for doctor ticket sequence'
        );

        SystemSetting::setValue(
            'consolidated_invoice_format',
            'prefix-yymmdd-number',
            'string',
            'prefix',
            'Format for doctor ticket numbering'
        );

        SystemSetting::setValue(
            'diagnosis_prefix',
            'DIA',
            'string',
            'prefix',
            'Prefix for diagnosis codes'
        );

        SystemSetting::setValue(
            'diagnosis_start',
            '1',
            'integer',
            'prefix',
            'Starting number for diagnosis sequence'
        );

        SystemSetting::setValue(
            'diagnosis_format',
            'prefix-yymmdd-number',
            'string',
            'prefix',
            'Format for diagnosis numbering'
        );

        SystemSetting::setValue(
            'opd_prefix',
            'OPD',
            'string',
            'prefix',
            'Prefix for OPD service codes'
        );

        SystemSetting::setValue(
            'opd_start',
            '1',
            'integer',
            'prefix',
            'Starting number for OPD sequence'
        );

        SystemSetting::setValue(
            'opd_format',
            'prefix-yymmdd-number',
            'string',
            'prefix',
            'Format for OPD numbering'
        );

        // Doctor Ticket Prefix Setting
        SystemSetting::setValue(
            'doctor_ticket_prefix',
            'DT',
            'string',
            'prefix',
            'Prefix for doctor ticket numbers (daily per doctor)'
        );

        // Patient Prefix Settings
        SystemSetting::setValue(
            'patient_prefix',
            'P',
            'string',
            'prefix',
            'Prefix for patient ID numbers'
        );

        SystemSetting::setValue(
            'patient_start',
            '1',
            'integer',
            'prefix',
            'Starting number for patient sequence'
        );

        SystemSetting::setValue(
            'patient_format',
            'prefix-yymmdd-number',
            'string',
            'prefix',
            'Format for patient ID numbering'
        );



        SystemSetting::setValue(
            'app_version',
            '1.0.0',
            'string',
            'system',
            'Application version'
        );

        SystemSetting::setValue(
            'maintenance_mode',
            'false',
            'boolean',
            'system',
            'Maintenance mode status'
        );

        // Hospital/Clinic Information Settings
        SystemSetting::setValue(
            'hospital_name',
            'City General Hospital & Diagnostic Center',
            'string',
            'hospital',
            'Hospital/Clinic name for invoices and reports'
        );

        SystemSetting::setValue(
            'hospital_address',
            '123 Medical Plaza, City Center, Dhaka-1200',
            'string',
            'hospital',
            'Hospital/Clinic address'
        );

        SystemSetting::setValue(
            'hospital_phone',
            '+880 2-955-1234',
            'string',
            'hospital',
            'Hospital/Clinic phone number'
        );

        SystemSetting::setValue(
            'hospital_phone_2',
            '+880 2-955-1235',
            'string',
            'hospital',
            'Hospital/Clinic second phone number'
        );

        SystemSetting::setValue(
            'hospital_email',
            'info@cityhospital.com',
            'string',
            'hospital',
            'Hospital/Clinic email address'
        );

        SystemSetting::setValue(
            'hospital_website',
            'www.cityhospital.com',
            'string',
            'hospital',
            'Hospital/Clinic website'
        );

        SystemSetting::setValue(
            'hospital_logo',
            '',
            'string',
            'hospital',
            'Hospital/Clinic logo file path'
        );





    }
}
