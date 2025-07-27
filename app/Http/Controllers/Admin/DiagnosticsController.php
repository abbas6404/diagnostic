<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DiagnosticsController extends Controller
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
     * Store a due collection payment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storePayment(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|exists:invoice,id',
            'payment_amount' => 'required|numeric|min:0.01',
        ]);

        try {
            // Start a transaction
            DB::beginTransaction();
            
            // Get the invoice
            $invoice = DB::table('invoice')->where('id', $request->invoice_id)->first();
            
            if (!$invoice) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invoice not found'
                ], 404);
            }
            
            // Check if payment amount is valid
            if ($request->payment_amount > $invoice->due_amount) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment amount cannot exceed due amount'
                ], 400);
            }
            
            // Update invoice paid and due amounts
            $newPaidAmount = $invoice->paid_amount + $request->payment_amount;
            $newDueAmount = $invoice->due_amount - $request->payment_amount;
            
            DB::table('invoice')
                ->where('id', $request->invoice_id)
                ->update([
                    'paid_amount' => $newPaidAmount,
                    'due_amount' => $newDueAmount,
                    'updated_by' => Auth::id(),
                    'updated_at' => now()
                ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Payment collected successfully'
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Error saving payment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get patient due invoices.
     *
     * @param  int  $patientId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPatientDueInvoices($patientId)
    {
        $invoices = DB::table('invoice')
            ->where('patient_id', $patientId)
            ->whereNull('deleted_at')
            ->select([
                'id',
                'invoice_no',
                'invoice_date',
                'total_amount',
                'paid_amount',
                'due_amount'
            ])
            ->orderBy('invoice_date', 'desc')
            ->get();
            
        return response()->json([
            'success' => true,
            'invoices' => $invoices
        ]);
    }

    /**
     * Get invoice details.
     *
     * @param  int  $invoiceId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInvoiceDetails($invoiceId)
    {
        $details = DB::table('lab_request_items')
            ->join('lab_tests', 'lab_request_items.lab_test_id', '=', 'lab_tests.id')
            ->where('lab_request_items.invoice_id', $invoiceId)
            ->whereNull('lab_request_items.deleted_at')
            ->select(
                'lab_tests.code',
                'lab_tests.name as test_name',
                'lab_request_items.charge',
                'lab_request_items.id as item_id',
                'lab_request_items.status'
            )
            ->get();
            
        return response()->json([
            'success' => true,
            'details' => $details
        ]);
    }

    /**
     * Get full invoice data for payment summary.
     *
     * @param  int  $invoiceId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInvoiceFullData($invoiceId)
    {
        $invoice = DB::table('invoice')
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

    /**
     * Show the re-print page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function rePrint()
    {
        return view('admin.diagnostics.re_Print.index');
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
} 