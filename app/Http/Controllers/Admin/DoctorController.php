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
     * Store a doctor invoice
     */
    public function storeInvoice(Request $request)
    {
        $request->validate([
            'patient_id' => 'nullable|exists:patients,id',
            'patient_name' => 'required|string|max:255',
            'patient_phone' => 'required|string|max:20',
            'patient_address' => 'nullable|string|max:500',
            'patient_age_years' => 'nullable|integer|min:0|max:150',
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
            'name' => $request->patient_name,
            'phone' => $request->patient_phone,
            'address' => $request->patient_address ?? '',
            'dob' => $dob,
            'reg_date' => now(),
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
            $count = DB::table('consultant_tickets')
                ->where('doctor_id', $request->doctor_id)
                ->where('ticket_date', $request->date ?? now()->toDateString())
                ->count();
            
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
} 