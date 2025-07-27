<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
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
     * Show the doctor invoice form
     */
    public function invoice()
    {
        return view('admin.doctor.invoice.index');
    }

    /**
     * Show the due collection page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dueCollection()
    {
        return view('admin.doctor.dueCollection.index');
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
            ->where('invoice_type', 'consultant')
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
     * Get consultant tickets for an invoice.
     *
     * @param  int  $invoiceId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getConsultantTickets($invoiceId)
    {
        $tickets = DB::table('consultant_tickets')
            ->leftJoin('users as doctors', 'consultant_tickets.doctor_id', '=', 'doctors.id')
            ->leftJoin('users as referred_by', 'consultant_tickets.referred_by', '=', 'referred_by.id')
            ->where('consultant_tickets.invoice_id', $invoiceId)
            ->select(
                'consultant_tickets.id',
                'consultant_tickets.ticket_no',
                'consultant_tickets.ticket_date',
                'consultant_tickets.ticket_time',
                'consultant_tickets.doctor_fee',
                'consultant_tickets.ticket_status',
                'consultant_tickets.patient_type',
                'doctors.name as doctor_name',
                'referred_by.name as referred_by_name'
            )
            ->get();
            
        return response()->json([
            'success' => true,
            'tickets' => $tickets
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
            ->where('invoice_type', 'consultant')
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
     * Show the report page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function report()
    {
        return view('admin.doctor.report.index');
    }
    
    /**
     * Store a doctor invoice
     */
    public function storeInvoice(Request $request)
    {
        // Process and store the invoice
        // This will be implemented later
        
        return redirect()->route('admin.doctor.invoice')->with('success', 'Invoice created successfully');
    }

    // searchDoctors and searchPcps methods removed - now using Livewire components
} 