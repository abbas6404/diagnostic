<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\SystemSetting;

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
     * Store a new OPD invoice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeInvoice(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'invoice_date' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'due_amount' => 'nullable|numeric|min:0',
            'opd_items' => 'required|array|min:1',
            'opd_items.*.opd_service_id' => 'required|exists:opd_services,id',
            'doctor_id' => 'nullable|exists:users,id',
            'referred_by' => 'nullable|exists:users,id',
        ]);

        try {
            // Start a transaction
            DB::beginTransaction();
            
            // Generate invoice number
            $invoiceNo = $this->generateInvoiceNumber();
            
            // Calculate amounts
            $totalAmount = $request->total_amount;
            $discountPercentage = $request->discount_percentage ?? 0;
            $discountAmount = $request->discount_amount ?? 0;
            $payableAmount = $totalAmount - $discountAmount;
            $paidAmount = $request->paid_amount ?? 0;
            $dueAmount = $payableAmount - $paidAmount;
            
            // Create invoice
            $invoiceId = DB::table('invoice')->insertGetId([
                'invoice_no' => $invoiceNo,
                'patient_id' => $request->patient_id,
                'total_amount' => $totalAmount,
                'payable_amount' => $payableAmount,
                'paid_amount' => $paidAmount,
                'due_amount' => $dueAmount,
                'discount_amount' => $discountAmount,
                'discount_percentage' => $discountPercentage,
                'invoice_date' => $request->invoice_date,
                'invoice_type' => 'opd',
                'payment_method' => $request->payment_method ?? null,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
                'remarks' => $request->remarks ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Create OPD items
            foreach ($request->opd_items as $item) {
                DB::table('invoice_opd_item')->insert([
                    'invoice_id' => $invoiceId,
                    'opd_service_id' => $item['opd_service_id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            
            // Commit the transaction
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'OPD invoice created successfully',
                'invoice_id' => $invoiceId,
                'invoice_no' => $invoiceNo,
                'redirect_url' => route('admin.opd.reprint') . '?invoice_id=' . $invoiceId
            ]);
            
        } catch (\Exception $e) {
            // Rollback the transaction
            DB::rollBack();
            
            \Log::error('Error creating OPD invoice: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error creating invoice: ' . $e->getMessage()
            ], 500);
        }
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
     * Generate a unique invoice number for OPD invoices.
     *
     * @return string
     */
    private function generateInvoiceNumber()
    {
        // Get OPD prefix settings from system settings
        $prefix = SystemSetting::getValue('opd_prefix', 'OPD');
        $start = SystemSetting::getValue('opd_start', '1');
        $format = SystemSetting::getValue('opd_format', 'prefix-yymmdd-number');
        
        $date = now()->format('ymd');
        $year = now()->format('y');
        $month = now()->format('m');
        $day = now()->format('d');
        
        // Get the last invoice number for today
        $lastInvoice = DB::table('invoice')
            ->where('invoice_type', 'opd')
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