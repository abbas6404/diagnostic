<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\AgeCalculator;

class DiagnosticsController extends Controller
{
    use AgeCalculator;
    
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
     * Show the invoice page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function invoice()
    {
        return view('admin.diagnostics.invoice.index');
    }

    /**
     * Show the invoice return page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function invoiceReturn()
    {
        return view('admin.diagnostics.invoiceReturn.index');
    }

    /**
     * Show the due collection page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dueCollection()
    {
        return view('admin.diagnostics.due_Collection.index');
    }

    /**
     * Show the re-print page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function rePrint()
    {
        return view('admin.diagnostics.rePrint.index');
    }

    /**
     * Show the report page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function report()
    {
        return view('admin.diagnostics.report.index');
    }

    /**
     * Get invoice details for general use (if still needed by other modules).
     *
     * @param  int  $invoiceId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInvoiceDetails($invoiceId)
    {
        // Get lab test items
        $labTestDetails = DB::table('lab_test_orders')
            ->join('lab_tests', 'lab_test_orders.lab_test_id', '=', 'lab_tests.id')
            ->where('lab_test_orders.invoice_id', $invoiceId)
            ->whereNull('lab_test_orders.deleted_at')
            ->select(
                'lab_tests.code',
                'lab_tests.name as test_name',
                'lab_test_orders.charge',
                'lab_test_orders.id as item_id',
                'lab_test_orders.status',
                DB::raw("'lab_test' as item_type"),
                DB::raw("0 as is_collection_kit")
            )
            ->get();
            
        // Get collection kits for this invoice
        $collectionKitDetails = DB::table('lab_test_orders')
            ->join('lab_test_collection_kit', 'lab_test_orders.lab_test_id', '=', 'lab_test_collection_kit.lab_test_id')
            ->join('collection_kits', 'lab_test_collection_kit.collection_kit_id', '=', 'collection_kits.id')
            ->where('lab_test_orders.invoice_id', $invoiceId)
            ->select(
                'collection_kits.pcode as code',
                'collection_kits.name as test_name',
                'collection_kits.charge',
                'collection_kits.id as item_id',
                DB::raw("'active' as status"),
                DB::raw("'collection_kit' as item_type"),
                DB::raw("1 as is_collection_kit"),
                'collection_kits.color'
            )
            ->distinct()
            ->get();
            
        // Combine lab tests and collection kits
        $allDetails = $labTestDetails->merge($collectionKitDetails);
            
        return response()->json([
            'success' => true,
            'details' => $allDetails
        ]);
    }

    /**
     * Get full invoice data for payment summary (if still needed by other modules).
     *
     * @param  int  $invoiceId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInvoiceFullData($invoiceId)
    {
        $invoice = DB::table('invoices')
            ->where('id', $invoiceId)
            ->whereNull('deleted_at')
            ->first();
            
        if (!$invoice) {
            return response()->json([
                'success' => false,
                'message' => 'Invoice not found'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'invoice' => $invoice
        ]);
    }
} 