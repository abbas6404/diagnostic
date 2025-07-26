<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OpdController extends Controller
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
        return view('admin.opd.invoice.index');
    }

    /**
     * Show the due collection page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dueCollection()
    {
        return view('admin.opd.dueCollection.index');
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
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
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
            
            // Create payment record
            $paymentId = DB::table('invoice_payments')->insertGetId([
                'invoice_id' => $request->invoice_id,
                'payment_date' => $request->payment_date,
                'payment_method' => $request->payment_method,
                'payment_reference' => $request->payment_reference,
                'amount' => $request->payment_amount,
                'created_by' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
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
            
            // Commit the transaction
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Payment recorded successfully',
                'payment_id' => $paymentId
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the re-print page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function rePrint()
    {
        return view('admin.opd.re_Print.index');
    }

    /**
     * Get due invoices for a patient.
     *
     * @param  int  $patientId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPatientDueInvoices($patientId)
    {
        try {
            $invoices = DB::table('invoice')
                ->leftJoin('users', 'invoice.created_by', '=', 'users.id')
                ->select([
                    'invoice.id',
                    'invoice.invoice_no',
                    'invoice.invoice_date',
                    'invoice.total_amount',
                    'invoice.paid_amount',
                    'invoice.due_amount',
                    'users.name as doctor_name'
                ])
                ->where('invoice.patient_id', $patientId)
                ->where('invoice.due_amount', '>', 0)
                ->where('invoice.deleted_at', null)
                ->orderBy('invoice.invoice_date', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'invoices' => $invoices
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading due invoices: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get invoice details.
     *
     * @param  int  $invoiceId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInvoiceDetails($invoiceId)
    {
        try {
            $details = DB::table('invoice_opd_item')
                ->leftJoin('opd_services', 'invoice_opd_item.opd_service_id', '=', 'opd_services.id')
                ->select([
                    'invoice_opd_item.id',
                    'opd_services.code',
                    'opd_services.name as service_name',
                    'opd_services.charge',
                    'invoice_opd_item.id as item_id'
                ])
                ->where('invoice_opd_item.invoice_id', $invoiceId)
                ->where('invoice_opd_item.deleted_at', null)
                ->get();

            return response()->json([
                'success' => true,
                'details' => $details
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading invoice details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get full invoice data for payment summary.
     *
     * @param  int  $invoiceId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInvoiceFullData($invoiceId)
    {
        try {
            $invoice = DB::table('invoice')
                ->leftJoin('users', 'invoice.created_by', '=', 'users.id')
                ->select([
                    'invoice.id',
                    'invoice.invoice_no',
                    'invoice.invoice_date',
                    'invoice.total_amount',
                    'invoice.discount_percentage',
                    'invoice.discount_amount',
                    'invoice.payable_amount',
                    'invoice.paid_amount',
                    'invoice.due_amount',
                    'users.name as doctor_name'
                ])
                ->where('invoice.id', $invoiceId)
                ->where('invoice.deleted_at', null)
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
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading invoice data: ' . $e->getMessage()
            ], 500);
        }
    }
} 