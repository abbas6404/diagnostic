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
        // System Settings
        SystemSetting::setValue('app_version', '1.0.0', 'string', 'system', 'Application version');
        SystemSetting::setValue('maintenance_mode', 'false', 'boolean', 'system', 'Maintenance mode status');

        // Hospital/Clinic Information Settings
        SystemSetting::setValue('hospital_name', 'City General Hospital & Diagnostic Center', 'string', 'hospital', 'Hospital/Clinic name for invoices and reports');
        SystemSetting::setValue('hospital_address', '123 Medical Plaza, City Center, Dhaka-1200', 'string', 'hospital', 'Hospital/Clinic address');
        SystemSetting::setValue('hospital_phone', '+880 2-955-1234', 'string', 'hospital', 'Hospital/Clinic phone number');
        SystemSetting::setValue('hospital_phone_2', '+880 2-955-1235', 'string', 'hospital', 'Hospital/Clinic second phone number');
        SystemSetting::setValue('hospital_email', 'info@cityhospital.com', 'string', 'hospital', 'Hospital/Clinic email address');
        SystemSetting::setValue('hospital_website', 'www.cityhospital.com', 'string', 'hospital', 'Hospital/Clinic website');
        SystemSetting::setValue('hospital_logo', '', 'string', 'hospital', 'Hospital/Clinic logo file path');


        // Consultant Invoice Settings
        SystemSetting::setValue('consultant_invoice_prefix', 'CON', 'string', 'prefix', 'Prefix for consultant invoice numbers');
        SystemSetting::setValue('consultant_invoice_start', '1', 'integer', 'prefix', 'Starting number for consultant invoice sequence');
        SystemSetting::setValue('consultant_invoice_format', 'prefix-yymmdd-number', 'string', 'prefix', 'Format for consultant invoice numbering');

        // Doctor Ticket Prefix Settings
        SystemSetting::setValue('doctor_ticket_prefix', 'DT', 'string', 'prefix', 'Prefix for doctor ticket numbers (daily per doctor)');
        SystemSetting::setValue('doctor_ticket_start', '1', 'integer', 'prefix', 'Starting number for doctor ticket sequence');
        SystemSetting::setValue('doctor_ticket_format', 'prefix-number', 'string', 'prefix', 'Format for doctor ticket numbering');

        // Diagnosis Settings
        SystemSetting::setValue('diagnosis_prefix', 'DIA', 'string', 'prefix', 'Prefix for diagnosis codes');
        SystemSetting::setValue('diagnosis_start', '1', 'integer', 'prefix', 'Starting number for diagnosis sequence');
        SystemSetting::setValue('diagnosis_format', 'prefix-yymmdd-number', 'string', 'prefix', 'Format for diagnosis numbering');

        // OPD Settings
        SystemSetting::setValue('opd_prefix', 'OPD', 'string', 'prefix', 'Prefix for OPD service codes');
        SystemSetting::setValue('opd_start', '1', 'integer', 'prefix', 'Starting number for OPD sequence');
        SystemSetting::setValue('opd_format', 'prefix-yymmdd-number', 'string', 'prefix', 'Format for OPD numbering');

        // Doctor Code Prefix Settings
        SystemSetting::setValue('doctor_code_prefix', 'DR', 'string', 'prefix', 'Prefix for doctor user codes');

        // PCP Code Prefix Settings
        SystemSetting::setValue('pcp_code_prefix', 'PCP', 'string', 'prefix', 'Prefix for PCP user codes');

        // Collection Prefix Settings
        SystemSetting::setValue('collection_prefix', 'COL', 'string', 'prefix', 'Prefix for payment collection numbers');
        SystemSetting::setValue('collection_start', '1', 'integer', 'prefix', 'Starting number for payment collection sequence');
        SystemSetting::setValue('collection_format', 'prefix-yymmdd-number', 'string', 'prefix', 'Format for payment collection numbering');

        // Return Prefix Settings
        SystemSetting::setValue('return_prefix', 'RET', 'string', 'prefix', 'Prefix for invoice return numbers');
        SystemSetting::setValue('return_start', '1', 'integer', 'prefix', 'Starting number for invoice return sequence');
        SystemSetting::setValue('return_format', 'prefix-yymmdd-number', 'string', 'prefix', 'Format for invoice return numbering');

        // Patient Prefix Settings
        SystemSetting::setValue('patient_prefix', 'P', 'string', 'prefix', 'Prefix for patient ID numbers');
        SystemSetting::setValue('patient_start', '1', 'integer', 'prefix', 'Starting number for patient sequence');
        SystemSetting::setValue('patient_format', 'prefix-yymmdd-number', 'string', 'prefix', 'Format for patient ID numbering');

        // Lab Test Order Prefix Settings
        SystemSetting::setValue('lab_test_order_prefix', 'LTO', 'string', 'prefix', 'Prefix for lab test order numbers');
        SystemSetting::setValue('lab_test_order_start', '1', 'integer', 'prefix', 'Starting number for lab test order sequence');
        SystemSetting::setValue('lab_test_order_format', 'prefix-yymmdd-number', 'string', 'prefix', 'Format for lab test order numbering');

        // Search Result Display Settings
        SystemSetting::setValue('patient_search_result_display', '20', 'integer', 'system', 'Patient search result display status'); 
        SystemSetting::setValue('doctor_search_result_display', '20', 'integer', 'system', 'Doctor search result display status');
        SystemSetting::setValue('pcp_search_result_display', '20', 'integer', 'system', 'PCP search result display status'); 
        SystemSetting::setValue('lab_test_search_result_display', '20', 'integer', 'system', 'Lab test search result display status');
        SystemSetting::setValue('lab_test_search_result_display', '20', 'integer', 'system', 'Lab test search result display status');
        SystemSetting::setValue('lab_test_order_search_result_display', '20', 'integer', 'system', 'Lab test order search result display status');
        SystemSetting::setValue('lab_test_result_search_result_display', '20', 'integer', 'system', 'Lab test result search result display status');
        SystemSetting::setValue('invoice_search_result_display', '20', 'integer', 'system', 'Invoice search result display status');

        // default result display settings
        SystemSetting::setValue('default_patient_search_result_display', '20', 'integer', 'system', 'Default patient search result display status'); 
        SystemSetting::setValue('default_doctor_search_result_display', '20', 'integer', 'system', 'Default doctor search result display status');
        SystemSetting::setValue('default_pcp_search_result_display', '20', 'integer', 'system', 'Default PCP search result display status'); 
        SystemSetting::setValue('default_lab_test_search_result_display', '20', 'integer', 'system', 'Default lab test search result display status');
        SystemSetting::setValue('default_lab_test_order_search_result_display', '20', 'integer', 'system', 'Default lab test order search result display status');
        SystemSetting::setValue('default_lab_test_result_search_result_display', '20', 'integer', 'system', 'Default lab test result search result display status'); 



    }
}
