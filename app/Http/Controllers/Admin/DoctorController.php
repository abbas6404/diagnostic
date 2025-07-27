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
     * Show the reprint page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function rePrint()
    {
        return view('admin.doctor.rePrint.index');
    }

    /**
     * Get default invoices for reprint.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDefaultInvoicesForReprint()
    {
        try {
            $invoices = DB::table('invoice')
                ->join('patients', 'invoice.patient_id', '=', 'patients.id')
                ->select(
                    'invoice.id as invoice_id',
                    'invoice.invoice_no',
                    'invoice.total_amount',
                    'invoice.paid_amount',
                    'invoice.due_amount',
                    'invoice.invoice_date',
                    'patients.name_en as patient_name',
                    'patients.phone as patient_phone',
                    'patients.address as patient_address',
                    'patients.dob',
                    'patients.gender'
                )
                ->where('invoice.invoice_type', 'consultant')
                ->orderBy('invoice.created_at', 'desc')
                ->limit(5)
                ->get();

            // Calculate age for each patient
            foreach ($invoices as $invoice) {
                $age = $this->calculateAge($invoice->dob);
                $invoice->age_years = $age['years'];
                $invoice->age_months = $age['months'];
                $invoice->age_days = $age['days'];
                
                // Debug logging
                \Log::info('Age calculation for invoice ' . $invoice->invoice_no . ': DOB=' . $invoice->dob . ', Age=' . json_encode($age));
            }

            return response()->json([
                'success' => true,
                'invoices' => $invoices
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in getDefaultInvoicesForReprint: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error loading default invoices: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search invoices for reprint.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchInvoicesForReprint(Request $request)
    {
        try {
            $query = $request->get('query', '');
            
            $invoices = DB::table('invoice')
                ->join('patients', 'invoice.patient_id', '=', 'patients.id')
                ->select(
                    'invoice.id as invoice_id',
                    'invoice.invoice_no',
                    'invoice.total_amount',
                    'invoice.paid_amount',
                    'invoice.due_amount',
                    'invoice.invoice_date',
                    'patients.name_en as patient_name',
                    'patients.phone as patient_phone',
                    'patients.address as patient_address',
                    'patients.dob',
                    'patients.gender'
                )
                ->where('invoice.invoice_type', 'consultant')
                ->where(function($q) use ($query) {
                    $q->where('invoice.invoice_no', 'like', "%{$query}%")
                      ->orWhere('patients.name_en', 'like', "%{$query}%")
                      ->orWhere('patients.phone', 'like', "%{$query}%");
                })
                ->orderBy('invoice.created_at', 'desc')
                ->limit(10)
                ->get();

            // Calculate age for each patient
            foreach ($invoices as $invoice) {
                $age = $this->calculateAge($invoice->dob);
                $invoice->age_years = $age['years'];
                $invoice->age_months = $age['months'];
                $invoice->age_days = $age['days'];
                
                // Debug logging
                \Log::info('Age calculation for invoice ' . $invoice->invoice_no . ': DOB=' . $invoice->dob . ', Age=' . json_encode($age));
            }

            return response()->json([
                'success' => true,
                'invoices' => $invoices
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in searchInvoicesForReprint: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error searching invoices: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get invoice details for reprint.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInvoiceDetailsForReprint($id)
    {
        try {
            $invoice = DB::table('invoice')
                ->join('patients', 'invoice.patient_id', '=', 'patients.id')
                ->select(
                    'invoice.id as invoice_id',
                    'invoice.invoice_no',
                    'invoice.total_amount',
                    'invoice.paid_amount',
                    'invoice.due_amount',
                    'invoice.invoice_date',
                    'patients.name_en as patient_name',
                    'patients.phone as patient_phone',
                    'patients.address as patient_address',
                    'patients.dob',
                    'patients.gender'
                )
                ->where('invoice.id', $id)
                ->where('invoice.invoice_type', 'consultant')
                ->first();

            if (!$invoice) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invoice not found'
                ], 404);
            }

            // Calculate age
            $age = $this->calculateAge($invoice->dob);
            $invoice->age_years = $age['years'];
            $invoice->age_months = $age['months'];
            $invoice->age_days = $age['days'];
            
            // Debug logging
            \Log::info('Age calculation for invoice ' . $invoice->invoice_no . ': DOB=' . $invoice->dob . ', Age=' . json_encode($age));

            // Get consultant tickets
            $consultantTickets = DB::table('consultant_tickets')
                ->leftJoin('users as doctors', 'consultant_tickets.doctor_id', '=', 'doctors.id')
                ->leftJoin('users as referred_by', 'consultant_tickets.referred_by', '=', 'referred_by.id')
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
                ->where('consultant_tickets.invoice_id', $id)
                ->get();

            return response()->json([
                'success' => true,
                'invoice' => $invoice,
                'consultant_tickets' => $consultantTickets
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in getInvoiceDetailsForReprint: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error loading invoice details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Print invoice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function printInvoice(Request $request)
    {
        try {
            $invoiceId = $request->input('invoice_id');
            $printType = $request->input('print_type', 'full_invoice');
            $copies = $request->input('copies', 1);

            // Here you would implement the actual printing logic
            // For now, we'll return a success response with a placeholder print URL

            return response()->json([
                'success' => true,
                'message' => 'Print job sent successfully',
                'print_url' => '/admin/doctor/print/' . $invoiceId . '?type=' . $printType . '&copies=' . $copies
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error sending print job: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate age from date of birth.
     *
     * @param  string|null  $dob
     * @return array
     */
    private function calculateAge($dob)
    {
        if (!$dob) {
            return ['years' => 0, 'months' => 0, 'days' => 0];
        }

        try {
            $dob = \Carbon\Carbon::parse($dob);
            $now = \Carbon\Carbon::now();
            
            // If date of birth is in the future, return 0
            if ($dob->isFuture()) {
                return ['years' => 0, 'months' => 0, 'days' => 0];
            }
            
            // Calculate the difference
            $diff = $now->diff($dob);
            
            return [
                'years' => max(0, $diff->y),
                'months' => max(0, $diff->m),
                'days' => max(0, $diff->d)
            ];
        } catch (\Exception $e) {
            return ['years' => 0, 'months' => 0, 'days' => 0];
        }
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