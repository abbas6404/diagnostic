<?php

namespace App\Http\Controllers;

use App\Helpers\DepartmentSerialHelper;
use Illuminate\Http\Request;

class DepartmentSerialController extends Controller
{
    /**
     * Show ONE serial per department for an invoice
     */
    public function showInvoiceSerials($invoiceId)
    {
        $serials = DepartmentSerialHelper::generateInvoiceDepartmentSerials($invoiceId);
        
        return response()->json([
            'invoice_id' => $invoiceId,
            'department_serials' => $serials,
            'summary' => [
                'total_departments' => count($serials),
                'departments' => array_keys($serials)
            ]
        ]);
    }

    /**
     * Show today's department summary
     */
    public function showTodaySummary()
    {
        $summary = DepartmentSerialHelper::getTodayDepartmentSummary();
        
        return response()->json([
            'date' => today()->format('Y-m-d'),
            'departments' => $summary
        ]);
    }

    /**
     * Example: Patient with 10 tests across 3 departments
     */
    public function example()
    {
        // Simulate the scenario you described
        $example = [
            'patient_name' => 'John Doe',
            'invoice_id' => 'INV-241201-001',
            'total_tests' => 10,
            'department_breakdown' => [
                'PATHOLOGY' => [
                    'tests_count' => 5,
                    'serial_number' => 1, // ONE serial for entire department
                    'tests' => ['CBC', 'Lipid Profile', 'Blood Sugar', 'Urea', 'Creatinine']
                ],
                'MRI/CT SCAN' => [
                    'tests_count' => 3,
                    'serial_number' => 1, // ONE serial for entire department
                    'tests' => ['MRI Brain', 'CT Chest', 'CT Abdomen']
                ],
                'X-RAY' => [
                    'tests_count' => 2,
                    'serial_number' => 1, // ONE serial for entire department
                    'tests' => ['Chest X-Ray', 'KUB X-Ray']
                ]
            ],
            'explanation' => 'Each department gets ONE serial number, regardless of how many tests are in that department'
        ];

        return response()->json($example);
    }
} 