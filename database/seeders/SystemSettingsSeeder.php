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


    }
}
