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
        return view('admin.opd.rePrint.index');
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
                ->where('invoice.invoice_type', 'opd')
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
                ->where('invoice.invoice_type', 'opd')
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
                ->where('invoice.invoice_type', 'opd')
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

            // Get OPD service items
            $opdItems = DB::table('invoice_opd_item')
                ->join('opd_services', 'invoice_opd_item.opd_service_id', '=', 'opd_services.id')
                ->select(
                    'invoice_opd_item.id',
                    'opd_services.code',
                    'opd_services.name as service_name',
                    'opd_services.charge'
                )
                ->where('invoice_opd_item.invoice_id', $id)
                ->get();

            return response()->json([
                'success' => true,
                'invoice' => $invoice,
                'opd_items' => $opdItems
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
                'print_url' => '/admin/opd/print/' . $invoiceId . '?type=' . $printType . '&copies=' . $copies
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error sending print job: ' . $e->getMessage()
            ], 500);
        }
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
} 