<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LabTestResult;
use App\Models\LabTest;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class InvestigationReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'permission:access admin dashboard']);
    }

    /**
     * Display the lab reporting page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function testReporting()
    {
        $departments = Department::where('status', 'active')->get();
        
        // Get logged-in user's department
        $userDepartmentId = Auth::user()->department_id;
        
        return view('admin.investigation-reports.reporting.index', compact('departments', 'userDepartmentId'));
    }

    /**
     * Print a lab report.
     *
     * @param int $invoiceId
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function printReport($invoiceId)
    {
        // Get the invoice with related data
        $invoice = \App\Models\Invoice::with([
            'patient',
            'labTestOrders.labTest.department',
            'labTestOrders.labTest.parameters',
            'labTestOrders.labTestResults.parameter',
            'labTestOrders.referredBy'
        ])->findOrFail($invoiceId);

        // Prepare report data
        $reportData = [
            'patient_name' => $invoice->patient->name ?? 'N/A',
            'patient_id' => $invoice->patient->patient_id ?? 'N/A',
            'patient_age' => $invoice->patient->age ?? 'N/A',
            'patient_sex' => $invoice->patient->gender ?? 'N/A',
            'invoice_no' => $invoice->invoice_no ?? 'N/A',
            'report_date' => $invoice->invoice_date ? date('d/m/Y', strtotime($invoice->invoice_date)) : date('d/m/Y'),
            'doctor_name' => $invoice->labTestOrders->first()->referredBy->name ?? 'N/A',
            'department' => $invoice->labTestOrders->first()->labTest->department->name ?? 'N/A',
            'remarks' => null,
            'incharge_name' => null,
            'checked_by_name' => null,
            'test_results' => []
        ];

        // Get test results
        $testResults = [];
        foreach ($invoice->labTestOrders as $order) {
            foreach ($order->labTestResults as $result) {
                $testResults[] = [
                    'test_name' => $result->parameter->name_description ?? 'N/A',
                    'result' => $result->result_value ?? 'N/A',
                    'unit' => $result->parameter->unit ?? 'N/A',
                    'normal_range' => $result->parameter->normal_value ?? 'N/A',
                    'status' => $this->determineTestStatus($result->result_value, $result->parameter->normal_value)
                ];
            }
        }
        $reportData['test_results'] = $testResults;

        // Get remarks from the first test result
        if ($invoice->labTestOrders->first() && $invoice->labTestOrders->first()->labTestResults->first()) {
            $reportData['remarks'] = $invoice->labTestOrders->first()->labTestResults->first()->remarks ?? null;
        }

        // Get incharge and checked by names
        if ($invoice->labTestOrders->first() && $invoice->labTestOrders->first()->labTestResults->first()) {
            $firstResult = $invoice->labTestOrders->first()->labTestResults->first();
            $reportData['incharge_name'] = $firstResult->inchargeBy->name ?? 'N/A';
            $reportData['checked_by_name'] = $firstResult->checkedBy->name ?? 'N/A';
        }

        return view('admin.investigation-reports.reporting.print', compact('reportData'));
    }

    /**
     * Determine test status based on result and normal range.
     *
     * @param string $result
     * @param string $normalRange
     * @return string
     */
    private function determineTestStatus($result, $normalRange)
    {
        if (!$result || !$normalRange) {
            return 'N/A';
        }

        // Simple logic - can be enhanced based on requirements
        $result = floatval($result);
        $normalRange = $normalRange;

        // Extract min and max from normal range (assuming format like "10-20" or "10.5-20.5")
        if (preg_match('/(\d+(?:\.\d+)?)\s*-\s*(\d+(?:\.\d+)?)/', $normalRange, $matches)) {
            $min = floatval($matches[1]);
            $max = floatval($matches[2]);

            if ($result >= $min && $result <= $max) {
                return 'Normal';
            } else {
                return 'Abnormal';
            }
        }

        return 'N/A';
    }
}