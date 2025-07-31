<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DepartmentSerialHelper
{
    /**
     * Generate ONE serial number for a department (1, 2, 3...)
     * This is for the entire department in an invoice, not per test
     */
    public static function generateDepartmentSerial($departmentId, $date = null)
    {
        $date = $date ? Carbon::parse($date) : Carbon::today();
        
        // Count how many invoices have orders for this department on this date
        $count = DB::table('lab_test_orders')
            ->join('lab_tests', 'lab_test_orders.lab_test_id', '=', 'lab_tests.id')
            ->where('lab_tests.department_id', $departmentId)
            ->whereDate('lab_test_orders.created_at', $date)
            ->distinct('lab_test_orders.invoice_id')
            ->count('lab_test_orders.invoice_id');
        
        return $count + 1; // Start from 1
    }

    /**
     * Get department name for display
     */
    public static function getDepartmentName($departmentId)
    {
        $department = DB::table('departments')->find($departmentId);
        return $department ? $department->name : 'Unknown';
    }

    /**
     * Generate ONE serial number per department for an invoice
     */
    public static function generateInvoiceDepartmentSerials($invoiceId)
    {
        $orders = DB::table('lab_test_orders')
            ->join('lab_tests', 'lab_test_orders.lab_test_id', '=', 'lab_tests.id')
            ->join('departments', 'lab_tests.department_id', '=', 'departments.id')
            ->where('lab_test_orders.invoice_id', $invoiceId)
            ->select('lab_tests.department_id', 'departments.name as department_name')
            ->distinct()
            ->get();

        $departmentSerials = [];
        
        foreach ($orders as $order) {
            $serial = self::generateDepartmentSerial($order->department_id);
            $departmentSerials[$order->department_id] = [
                'department_name' => $order->department_name,
                'serial_number' => $serial
            ];
        }
        
        return $departmentSerials;
    }

    /**
     * Get today's serial number for a department
     */
    public static function getTodaySerial($departmentId)
    {
        return self::generateDepartmentSerial($departmentId, Carbon::today());
    }

    /**
     * Get next serial number for a department (without incrementing)
     */
    public static function getNextSerial($departmentId, $date = null)
    {
        $date = $date ? Carbon::parse($date) : Carbon::today();
        
        $count = DB::table('lab_test_orders')
            ->join('lab_tests', 'lab_test_orders.lab_test_id', '=', 'lab_tests.id')
            ->where('lab_tests.department_id', $departmentId)
            ->whereDate('lab_test_orders.created_at', $date)
            ->distinct('lab_test_orders.invoice_id')
            ->count('lab_test_orders.invoice_id');
        
        return $count + 1;
    }

    /**
     * Get department summary for today
     */
    public static function getTodayDepartmentSummary()
    {
        $departments = DB::table('departments')->get();
        $summary = [];
        
        foreach ($departments as $department) {
            $count = DB::table('lab_test_orders')
                ->join('lab_tests', 'lab_test_orders.lab_test_id', '=', 'lab_tests.id')
                ->where('lab_tests.department_id', $department->id)
                ->whereDate('lab_test_orders.created_at', today())
                ->distinct('lab_test_orders.invoice_id')
                ->count('lab_test_orders.invoice_id');
            
            $summary[] = [
                'department_name' => $department->name,
                'today_invoices' => $count,
                'next_serial' => $count + 1
            ];
        }
        
        return $summary;
    }
} 