<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\AgeCalculator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
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
            'collection_amount' => 'required|numeric|min:0.01',
            'remarks' => 'nullable|string|max:500',
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
            
            // Check if collection amount is valid
            if ($request->collection_amount > $invoice->due_amount) {
                return response()->json([
                    'success' => false,
                    'message' => 'Collection amount cannot exceed due amount'
                ], 400);
            }
            
            // Calculate amounts
            $dueBeforeCollection = $invoice->due_amount;
            $dueAfterCollection = $dueBeforeCollection - $request->collection_amount;
            
            // Generate collection number
            $collectionNo = $this->generateCollectionNumber();
            
            // Create payment collection record
            $collectionId = DB::table('payment_collections')->insertGetId([
                'collection_no' => $collectionNo,
                'invoice_id' => $request->invoice_id,
                'patient_id' => $invoice->patient_id,
                'collection_amount' => $request->collection_amount,
                'due_before_collection' => $dueBeforeCollection,
                'due_after_collection' => $dueAfterCollection,
                'remarks' => $request->remarks,
                'collection_date' => now()->toDateString(),
                'collection_time' => now()->toTimeString(),
                'collected_by' => Auth::id(),
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Update invoice paid and due amounts
            $newPaidAmount = $invoice->paid_amount + $request->collection_amount;
            $newDueAmount = $invoice->due_amount - $request->collection_amount;
            
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
                'message' => 'Payment collected successfully',
                'collection_id' => $collectionId,
                'collection_no' => $collectionNo,
                'updated_invoice' => [
                    'paid_amount' => $newPaidAmount,
                    'due_amount' => $newDueAmount
                ]
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
     * Get payment history for an invoice.
     *
     * @param  int  $invoiceId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPaymentHistory($invoiceId)
    {
        try {
            $payments = DB::table('payment_collections')
                ->leftJoin('users', 'payment_collections.collected_by', '=', 'users.id')
                ->select([
                    'payment_collections.id',
                    'payment_collections.collection_no',
                    'payment_collections.collection_amount',
                    'payment_collections.due_before_collection',
                    'payment_collections.due_after_collection',
                    'payment_collections.remarks',
                    'payment_collections.collection_date',
                    'payment_collections.collection_time',
                    'users.name as collected_by_name'
                ])
                ->where('payment_collections.invoice_id', $invoiceId)
                ->whereNull('payment_collections.deleted_at')
                ->orderBy('payment_collections.created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'payments' => $payments
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading payment history: ' . $e->getMessage()
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
            ->select(
                'consultant_tickets.id',
                'consultant_tickets.ticket_no',
                'consultant_tickets.ticket_date',
                'consultant_tickets.ticket_time',
                'consultant_tickets.ticket_status',
                'consultant_tickets.patient_type',
                'doctors.name as doctor_name',
                'referred_by.name as referred_by_name'
            )
            ->where('consultant_tickets.invoice_id', $invoiceId)
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
     * Store a doctor invoice
     */
    public function storeInvoice(Request $request)
    {
        $request->validate([
            'patient_id' => 'nullable|exists:patients,id', // Changed to nullable
            'patient_name' => 'required|string|max:255', // Added patient name validation
            'patient_phone' => 'required|string|max:20', // Added patient phone validation
            'patient_address' => 'nullable|string|max:500', // Added patient address validation
            'patient_age_years' => 'nullable|integer|min:0|max:150', // Added age validation
            'patient_age_months' => 'nullable|integer|min:0|max:12',
            'patient_age_days' => 'nullable|integer|min:0|max:31',
            'ticket_date' => 'required|date',
            'ticket_time' => 'required',
            'doctor_id' => 'required|exists:users,id',
            'patient_type' => 'required|in:new,old,follow_up,pcp',
            'consultation_fee' => 'required|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'referred_by' => 'nullable|exists:users,id',
            'remarks' => 'nullable|string|max:500',
        ]);

        try {
            // Start a transaction
            DB::beginTransaction();
            
            // Handle patient creation if no patient is selected
            $patientId = $request->patient_id;
            $patientCreated = false;
            if (!$patientId) {
                // Create new patient
                $patientId = $this->createNewPatient($request);
                $patientCreated = true;
            }
            
            // Generate invoice number using system settings
            $invoiceNo = $this->generateInvoiceNumber();
            
            // Calculate amounts
            $consultationFee = $request->consultation_fee;
            $paidAmount = $request->paid_amount ?? 0;
            $dueAmount = $consultationFee - $paidAmount;
            
            // Create invoice
            $invoiceId = DB::table('invoice')->insertGetId([
                'invoice_no' => $invoiceNo,
                'patient_id' => $patientId,
                'total_amount' => $consultationFee,
                'payable_amount' => $consultationFee,
                'paid_amount' => $paidAmount,
                'due_amount' => $dueAmount,
                'discount_amount' => 0,
                'discount_percentage' => 0,
                'invoice_date' => $request->ticket_date,
                'invoice_type' => 'consultant',
                'payment_method' => 'cash',
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
                'remarks' => $request->remarks ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Generate ticket number
            $ticketNo = $this->generateTicketNumber($request->doctor_id);
            
            // Create consultant ticket
            DB::table('consultant_tickets')->insert([
                'ticket_no' => $ticketNo,
                'ticket_status' => 'pending',
                'ticket_date' => $request->ticket_date,
                'ticket_time' => $request->ticket_time,
                'invoice_id' => $invoiceId,
                'patient_id' => $patientId,
                'patient_type' => $request->patient_type,
                'doctor_id' => $request->doctor_id,
                'referred_by' => $request->referred_by,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Commit the transaction
            DB::commit();
            
            // Show success toast
            $message = $patientCreated 
                ? "New patient created and invoice created successfully! Invoice: {$invoiceNo}, Ticket: {$ticketNo}"
                : "Consultant invoice created successfully! Invoice: {$invoiceNo}, Ticket: {$ticketNo}";
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'invoice_id' => $invoiceId,
                'invoice_no' => $invoiceNo,
                'ticket_no' => $ticketNo,
                'patient_created' => $patientCreated,
                'redirect_url' => route('admin.doctor.reprint') . '?invoice_id=' . $invoiceId
            ]);
            
        } catch (\Exception $e) {
            // Rollback the transaction
            DB::rollBack();
            
            \Log::error('Error creating consultant invoice: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error creating invoice: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a new patient with the provided information
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    private function createNewPatient(Request $request)
    {
        // Generate patient ID
        $patientId = $this->generatePatientId();
        
        // Calculate DOB from age if provided
        $dob = null;
        if ($request->patient_age_years || $request->patient_age_months || $request->patient_age_days) {
            $dob = now()->subYears($request->patient_age_years ?? 0)
                       ->subMonths($request->patient_age_months ?? 0)
                       ->subDays($request->patient_age_days ?? 0);
        }
        
        // Create patient record
        $patientId = DB::table('patients')->insertGetId([
            'patient_id' => $patientId,
            'name_en' => $request->patient_name,
            'phone' => $request->patient_phone,
            'address' => $request->patient_address ?? '',
            'dob' => $dob,
            'reg_date' => now(), // Add the missing reg_date field
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        return $patientId;
    }

    /**
     * Generate a unique patient ID
     *
     * @return string
     */
    private function generatePatientId()
    {
        $today = now();
        $datePrefix = $today->format('ymd'); // Format: YYMMDD
        
        // Get the last patient registered today
        $lastPatientToday = DB::table('patients')
            ->where('patient_id', 'like', $datePrefix . '%')
            ->orderBy('id', 'desc')
            ->first();
        
        if ($lastPatientToday) {
            // Extract the sequential number and increment it
            $lastId = substr($lastPatientToday->patient_id, 6); // Get digits after YYMMDD
            $nextId = intval($lastId) + 1;
        } else {
            // First patient of the day
            $nextId = 1;
        }
        
        // Format: YYMMDD + sequential number (padded to 3 digits)
        return $datePrefix . str_pad($nextId, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Generate a unique invoice number for consultant invoices.
     *
     * @return string
     */
    private function generateInvoiceNumber()
    {
        // Get consultant prefix settings from system settings
        $prefix = \App\Models\SystemSetting::getValue('consolidated_invoice_prefix', 'CON');
        $start = \App\Models\SystemSetting::getValue('consolidated_invoice_start', '1');
        $format = \App\Models\SystemSetting::getValue('consolidated_invoice_format', 'prefix-yymmdd-number');
        
        $date = now()->format('ymd');
        $year = now()->format('y');
        $month = now()->format('m');
        $day = now()->format('d');
        
        // Get the last invoice number for today
        $lastInvoice = DB::table('invoice')
            ->where('invoice_type', 'consultant')
            ->orderBy('invoice_no', 'desc')
            ->first();
        
        $sequence = 1;
        if ($lastInvoice) {
            // Try to extract sequence from the last invoice number
            $lastNumber = $lastInvoice->invoice_no;
            
            // Handle different formats
            switch ($format) {
                case 'prefix-yymmdd-number':
                    if (preg_match('/^' . preg_quote($prefix) . '-(\d{6})-(\d+)$/', $lastNumber, $matches)) {
                        if ($matches[1] === $date) {
                            $sequence = intval($matches[2]) + 1;
                        }
                    }
                    break;
                    
                case 'prefixyymmddnumber':
                    if (preg_match('/^' . preg_quote($prefix) . '(\d{6})(\d+)$/', $lastNumber, $matches)) {
                        if ($matches[1] === $date) {
                            $sequence = intval($matches[2]) + 1;
                        }
                    }
                    break;
                    
                case 'prefix-yymm-number':
                    $yearMonth = $year . $month;
                    if (preg_match('/^' . preg_quote($prefix) . '-(\d{4})-(\d+)$/', $lastNumber, $matches)) {
                        if ($matches[1] === $yearMonth) {
                            $sequence = intval($matches[2]) + 1;
                        }
                    }
                    break;
                    
                case 'prefixyymmnumber':
                    $yearMonth = $year . $month;
                    if (preg_match('/^' . preg_quote($prefix) . '(\d{4})(\d+)$/', $lastNumber, $matches)) {
                        if ($matches[1] === $yearMonth) {
                            $sequence = intval($matches[2]) + 1;
                        }
                    }
                    break;
                    
                case 'prefix-yy-number':
                    if (preg_match('/^' . preg_quote($prefix) . '-(\d{2})-(\d+)$/', $lastNumber, $matches)) {
                        if ($matches[1] === $year) {
                            $sequence = intval($matches[2]) + 1;
                        }
                    }
                    break;
                    
                case 'prefixyynumber':
                    if (preg_match('/^' . preg_quote($prefix) . '(\d{2})(\d+)$/', $lastNumber, $matches)) {
                        if ($matches[1] === $year) {
                            $sequence = intval($matches[2]) + 1;
                        }
                    }
                    break;
                    
                case 'prefix-number':
                    if (preg_match('/^' . preg_quote($prefix) . '-(\d+)$/', $lastNumber, $matches)) {
                        $sequence = intval($matches[1]) + 1;
                    }
                    break;
                    
                case 'prefixnumber':
                    if (preg_match('/^' . preg_quote($prefix) . '(\d+)$/', $lastNumber, $matches)) {
                        $sequence = intval($matches[1]) + 1;
                    }
                    break;
            }
        }
        
        // Generate invoice number based on format
        switch ($format) {
            case 'prefix-yymmdd-number':
                return $prefix . '-' . $date . '-' . str_pad($sequence, 3, '0', STR_PAD_LEFT);
                
            case 'prefixyymmddnumber':
                return $prefix . $date . str_pad($sequence, 3, '0', STR_PAD_LEFT);
                
            case 'prefix-yymm-number':
                return $prefix . '-' . $year . $month . '-' . str_pad($sequence, 3, '0', STR_PAD_LEFT);
                
            case 'prefixyymmnumber':
                return $prefix . $year . $month . str_pad($sequence, 3, '0', STR_PAD_LEFT);
                
            case 'prefix-yy-number':
                return $prefix . '-' . $year . '-' . str_pad($sequence, 3, '0', STR_PAD_LEFT);
                
            case 'prefixyynumber':
                return $prefix . $year . str_pad($sequence, 3, '0', STR_PAD_LEFT);
                
            case 'prefix-number':
                return $prefix . '-' . str_pad($sequence, 3, '0', STR_PAD_LEFT);
                
            case 'prefixnumber':
                return $prefix . str_pad($sequence, 3, '0', STR_PAD_LEFT);
                
            default:
                // Fallback to default format
                return $prefix . '-' . $date . '-' . str_pad($sequence, 3, '0', STR_PAD_LEFT);
        }
    }

    /**
     * Generate a unique ticket number for consultant tickets.
     * This creates daily individual doctor sequences (each doctor starts from 1 every day)
     * Format: DT-001 where DT prefix comes from system settings
     *
     * @return string
     */
    private function generateTicketNumber($doctorId)
    {
        // Get prefix from system settings
        $prefix = \App\Models\SystemSetting::getValue('doctor_ticket_prefix', 'DT');
        $date = now()->format('ymd');
        
        // Get the last ticket number for this specific doctor for today
        $lastTicket = DB::table('consultant_tickets')
            ->where('doctor_id', $doctorId)
            ->where('ticket_date', now()->toDateString())
            ->orderBy('ticket_no', 'desc')
            ->first();
        
        if ($lastTicket) {
            // Extract the sequence number from the last ticket
            // Format: DT-001, DT-002, etc.
            $parts = explode('-', $lastTicket->ticket_no);
            if (count($parts) >= 2) {
                $sequence = intval($parts[1]) + 1;
            } else {
                $sequence = 1;
            }
        } else {
            // First ticket of the day for this doctor
            $sequence = 1;
        }
        
        return $prefix . '-' . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Get the current ticket count for a doctor on a specific date.
     *
     * @param  int  $doctorId
     * @param  string  $date (optional, defaults to today)
     * @return int
     */
    private function getDoctorTicketCountInternal($doctorId, $date = null)
    {
        if (!$date) {
            $date = now()->toDateString();
        }
        
        return DB::table('consultant_tickets')
            ->where('doctor_id', $doctorId)
            ->where('ticket_date', $date)
            ->count();
    }

    /**
     * Get current ticket count for a doctor (API endpoint).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDoctorTicketCount(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'date' => 'nullable|date'
        ]);

        try {
            $count = $this->getDoctorTicketCountInternal($request->doctor_id, $request->date);
            
            return response()->json([
                'success' => true,
                'ticket_count' => $count,
                'next_ticket_number' => $count + 1
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error getting ticket count: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate a unique collection number.
     *
     * @return string
     */
    private function generateCollectionNumber()
    {
        $prefix = 'COL';
        $date = now()->format('ymd');
        
        // Get the last collection number for today
        $lastCollection = DB::table('payment_collections')
            ->where('collection_no', 'like', $prefix . '-' . $date . '-%')
            ->orderBy('collection_no', 'desc')
            ->first();
        
        if ($lastCollection) {
            // Extract the sequence number and increment
            $parts = explode('-', $lastCollection->collection_no);
            $sequence = intval($parts[2]) + 1;
        } else {
            $sequence = 1;
        }
        
        return $prefix . '-' . $date . '-' . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    }

    // searchDoctors and searchPcps methods removed - now using Livewire components
} 