<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lab Report Templates
        $labReportTemplates = [
            [
                'template_type' => 'lab_report',
                'lab_test_id' => 1, // CBC
                'template_name' => 'cbc_report',
                'file_path' => 'report_templates/cbc_report_template.docx',
                'uploaded_by' => 1,
                'status' => 'active'
            ],
            [
                'template_type' => 'lab_report',
                'lab_test_id' => 27, // Fasting Blood Sugar
                'template_name' => 'blood_sugar_report',
                'file_path' => 'report_templates/blood_sugar_template.docx',
                'uploaded_by' => 1,
                'status' => 'active'
            ],
            [
                'template_type' => 'lab_report',
                'lab_test_id' => 17, // HBsAg
                'template_name' => 'hepatitis_b_report',
                'file_path' => 'report_templates/hepatitis_b_template.docx',
                'uploaded_by' => 1,
                'status' => 'active'
            ]
        ];

        // OPD Invoice Templates
        $opdInvoiceTemplates = [
            [
                'template_type' => 'invoice',
                'lab_test_id' => null,
                'template_name' => 'opd_invoice',
                'file_path' => 'report_templates/opd_invoice_standard.docx',
                'uploaded_by' => 1,
                'status' => 'active'
            ],
            [
                'template_type' => 'invoice',
                'lab_test_id' => null,
                'template_name' => 'opd_invoice_with_logo',
                'file_path' => 'report_templates/opd_invoice_with_logo.docx',
                'uploaded_by' => 1,
                'status' => 'active'
            ]
        ];

        // Diagnostic Invoice Templates
        $diagnosticInvoiceTemplates = [
            [
                'template_type' => 'invoice',
                'lab_test_id' => null,
                'template_name' => 'diagnostic_invoice',
                'file_path' => 'report_templates/diagnostic_invoice.docx',
                'uploaded_by' => 1,
                'status' => 'active'
            ],
            [
                'template_type' => 'invoice',
                'lab_test_id' => null,
                'template_name' => 'radiology_invoice',
                'file_path' => 'report_templates/radiology_invoice.docx',
                'uploaded_by' => 1,
                'status' => 'active'
            ]
        ];

        // Consultant Invoice Templates
        $consultantInvoiceTemplates = [
            [
                'template_type' => 'invoice',
                'lab_test_id' => null,
                'template_name' => 'consultant_invoice',
                'file_path' => 'report_templates/consultant_invoice.docx',
                'uploaded_by' => 1,
                'status' => 'active'
            ],
            [
                'template_type' => 'invoice',
                'lab_test_id' => null,
                'template_name' => 'specialist_consultation_invoice',
                'file_path' => 'report_templates/specialist_consultation_invoice.docx',
                'uploaded_by' => 1,
                'status' => 'active'
            ]
        ];

        // Insert all templates
        $allTemplates = array_merge(
            $labReportTemplates,
            $opdInvoiceTemplates,
            $diagnosticInvoiceTemplates,
            $consultantInvoiceTemplates
        );

        foreach ($allTemplates as $template) {
            DB::table('report_templates')->insert($template);
        }
    }
}
