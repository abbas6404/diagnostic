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
     * Search invoices for return page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchInvoicesForReturn(Request $request)
    {
        try {
            $query = $request->get('query', '');
            
            if (strlen($query) < 2) {
                return response()->json([]);
            }
            
            $invoices = DB::table('invoice')
                ->join('patients', 'invoice.patient_id', '=', 'patients.id')
                ->select([
                    'invoice.id as invoice_id',
                    'invoice.invoice_no',
                    'invoice.total_amount',
                    'invoice.paid_amount',
                    'invoice.due_amount',
                    'invoice.invoice_date',
                    'invoice.invoice_type',
                    'patients.name_en as patient_name',
                    'patients.phone as patient_phone',
                    'patients.address as patient_address',
                    'patients.dob',
                    'patients.gender'
                ])
                ->where('invoice.invoice_type', 'ipd') // Only IPD invoices for diagnostics
                ->where(function($q) use ($query) {
                    $q->where('invoice.invoice_no', 'like', "%{$query}%")
                      ->orWhere('patients.name_en', 'like', "%{$query}%")
                      ->orWhere('patients.phone', 'like', "%{$query}%");
                })
                ->where('invoice.paid_amount', '>', 0) // Only invoices with payments
                ->orderBy('invoice.invoice_date', 'desc')
                ->limit(20)
                ->get();
            
            // Calculate age for each patient
            $invoices->each(function($invoice) {
                if ($invoice->dob) {
                    $age = $this->calculateAge($invoice->dob);
                    $invoice->age_years = $age['years'];
                    $invoice->age_months = $age['months'];
                    $invoice->age_days = $age['days'];
                } else {
                    $invoice->age_years = 0;
                    $invoice->age_months = 0;
                    $invoice->age_days = 0;
                }
            });
            
            return response()->json($invoices);
            
        } catch (\Exception $e) {
            \Log::error('Error in searchInvoicesForReturn: ' . $e->getMessage());
            return response()->json([
                'error' => 'Search error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get default invoices for search results.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDefaultInvoices()
    {
        try {
            $invoices = DB::table('invoice')
                ->join('patients', 'invoice.patient_id', '=', 'patients.id')
                ->select([
                    'invoice.id as invoice_id',
                    'invoice.invoice_no',
                    'invoice.total_amount',
                    'invoice.paid_amount',
                    'invoice.due_amount',
                    'invoice.invoice_date',
                    'invoice.invoice_type',
                    'patients.name_en as patient_name',
                    'patients.phone as patient_phone',
                    'patients.address as patient_address',
                    'patients.dob',
                    'patients.gender'
                ])
                ->where('invoice.invoice_type', 'ipd') // Only IPD invoices for diagnostics
                ->where('invoice.paid_amount', '>', 0) // Only invoices with payments
                ->orderBy('invoice.invoice_date', 'desc')
                ->limit(5)
                ->get();
            
            // Calculate age for each patient
            $invoices->each(function($invoice) {
                if ($invoice->dob) {
                    $age = $this->calculateAge($invoice->dob);
                    $invoice->age_years = $age['years'];
                    $invoice->age_months = $age['months'];
                    $invoice->age_days = $age['days'];
                } else {
                    $invoice->age_years = 0;
                    $invoice->age_months = 0;
                    $invoice->age_days = 0;
                }
            });
            
            return response()->json($invoices);
            
        } catch (\Exception $e) {
            \Log::error('Error in getDefaultInvoices: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error loading default invoices: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get invoice details with lab test items for return.
     *
     * @param  int  $invoiceId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInvoiceDetailsForReturn($invoiceId)
    {
        try {
            // Get invoice and patient details
            $invoice = DB::table('invoice')
                ->join('patients', 'invoice.patient_id', '=', 'patients.id')
                ->select([
                    'invoice.*',
                    'patients.name_en as patient_name',
                    'patients.phone as patient_phone',
                    'patients.address as patient_address',
                    'patients.dob',
                    'patients.gender'
                ])
                ->where('invoice.id', $invoiceId)
                ->first();
            
            if (!$invoice) {
                return response()->json(['error' => 'Invoice not found'], 404);
            }
            
            // Calculate age
            if ($invoice->dob) {
                $age = $this->calculateAge($invoice->dob);
                $invoice->age_years = $age['years'];
                $invoice->age_months = $age['months'];
                $invoice->age_days = $age['days'];
            } else {
                $invoice->age_years = 0;
                $invoice->age_months = 0;
                $invoice->age_days = 0;
            }
            
            // Get lab test items for this invoice
            $labTestItems = DB::table('lab_request_items')
                ->join('lab_tests', 'lab_request_items.lab_test_id', '=', 'lab_tests.id')
                ->select([
                    'lab_request_items.id',
                    'lab_tests.code',
                    'lab_tests.name as test_name',
                    'lab_request_items.charge',
                    'lab_request_items.status',
                    'lab_request_items.charge as total'
                ])
                ->where('lab_request_items.invoice_id', $invoiceId)
                ->get();
            
            // If no lab test items found, return empty array but don't error
            if ($labTestItems->isEmpty()) {
                \Log::info("No lab test items found for invoice ID: {$invoiceId}");
            }
            
            return response()->json([
                'invoice' => $invoice,
                'lab_test_items' => $labTestItems
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error in getInvoiceDetailsForReturn: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error loading invoice details: ' . $e->getMessage()
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

    // Re-Print Methods
    public function getDefaultInvoicesForReprint()
    {
        try {
            \Log::info('Loading default invoices for reprint...');
            
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
                ->where('invoice.invoice_type', 'ipd')
                ->orderBy('invoice.created_at', 'desc')
                ->limit(5)
                ->get();

            \Log::info('Found ' . $invoices->count() . ' default invoices');
            \Log::info('Invoice numbers: ' . $invoices->pluck('invoice_no')->implode(', '));

            foreach ($invoices as $invoice) {
                $invoice->age_years = $this->calculateAge($invoice->dob)['years'];
                $invoice->age_months = $this->calculateAge($invoice->dob)['months'];
                $invoice->age_days = $this->calculateAge($invoice->dob)['days'];
            }

            return response()->json([
                'success' => true,
                'invoices' => $invoices
            ]);
        } catch (\Exception $e) {
            \Log::error('Error getting default invoices for reprint: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error loading default invoices'
            ]);
        }
    }

    public function searchInvoicesForReprint(Request $request)
    {
        try {
            $query = $request->get('query');
            \Log::info('Search query: ' . $query);
            
            // First, let's check what IPD invoices exist
            $allIpdInvoices = DB::table('invoice')
                ->where('invoice_type', 'ipd')
                ->select('id', 'invoice_no', 'patient_id')
                ->get();
            
            \Log::info('Total IPD invoices: ' . $allIpdInvoices->count());
            \Log::info('IPD invoice numbers: ' . $allIpdInvoices->pluck('invoice_no')->implode(', '));
            
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
                ->where('invoice.invoice_type', 'ipd')
                ->where(function($q) use ($query) {
                    $q->where('invoice.invoice_no', 'like', "%{$query}%")
                      ->orWhere('patients.name_en', 'like', "%{$query}%")
                      ->orWhere('patients.phone', 'like', "%{$query}%");
                })
                ->orderBy('invoice.created_at', 'desc')
                ->limit(10)
                ->get();

            \Log::info('Search results count: ' . $invoices->count());

            foreach ($invoices as $invoice) {
                $invoice->age_years = $this->calculateAge($invoice->dob)['years'];
                $invoice->age_months = $this->calculateAge($invoice->dob)['months'];
                $invoice->age_days = $this->calculateAge($invoice->dob)['days'];
            }

            return response()->json([
                'success' => true,
                'invoices' => $invoices
            ]);
        } catch (\Exception $e) {
            \Log::error('Error searching invoices for reprint: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error searching invoices'
            ]);
        }
    }

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
                ->where('invoice.invoice_type', 'ipd')
                ->first();

            if (!$invoice) {
                return response()->json([
                    'error' => 'Invoice not found'
                ]);
            }

            $invoice->age_years = $this->calculateAge($invoice->dob)['years'];
            $invoice->age_months = $this->calculateAge($invoice->dob)['months'];
            $invoice->age_days = $this->calculateAge($invoice->dob)['days'];

            $labTestItems = DB::table('lab_request_items')
                ->join('lab_tests', 'lab_request_items.lab_test_id', '=', 'lab_tests.id')
                ->select(
                    'lab_request_items.id',
                    'lab_tests.code',
                    'lab_tests.name as test_name',
                    'lab_request_items.charge',
                    'lab_request_items.status'
                )
                ->where('lab_request_items.invoice_id', $id)
                ->get();

            return response()->json([
                'success' => true,
                'invoice' => $invoice,
                'lab_test_items' => $labTestItems
            ]);
        } catch (\Exception $e) {
            \Log::error('Error getting invoice details for reprint: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error loading invoice details'
            ]);
        }
    }

    public function printInvoice(Request $request)
    {
        try {
            $invoiceId = $request->input('invoice_id');
            $printOption = $request->input('print_option');
            $selectedItems = $request->input('selected_items', []);
            $copies = $request->input('copies', 1);

            // Here you would implement the actual printing logic
            // For now, we'll just return a success response
            $printUrl = route('admin.diagnostics.reprint.print-preview', [
                'invoice_id' => $invoiceId,
                'print_option' => $printOption,
                'selected_items' => $selectedItems,
                'copies' => $copies
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Print job sent successfully',
                'print_url' => $printUrl
            ]);
        } catch (\Exception $e) {
            \Log::error('Error printing invoice: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error sending print job'
            ]);
        }
    }

    public function printSingleItem(Request $request)
    {
        try {
            $invoiceId = $request->input('invoice_id');
            $itemId = $request->input('item_id');

            // Here you would implement the actual printing logic for single item
            $printUrl = route('admin.diagnostics.reprint.print-item-preview', [
                'invoice_id' => $invoiceId,
                'item_id' => $itemId
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Item print job sent successfully',
                'print_url' => $printUrl
            ]);
        } catch (\Exception $e) {
            \Log::error('Error printing single item: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error sending print job'
            ]);
        }
    }

    /**
     * Calculate age from date of birth.
     *
     * @param  string  $dob
     * @return array
     */
    private function calculateAge($dob)
    {
        try {
            $dob = \Carbon\Carbon::parse($dob);
            $now = \Carbon\Carbon::now();
            
            // If DOB is in the future, return 0
            if ($dob->isFuture()) {
                return ['years' => 0, 'months' => 0, 'days' => 0];
            }
            
            // Calculate age more accurately
            $years = $now->year - $dob->year;
            $months = $now->month - $dob->month;
            $days = $now->day - $dob->day;
            
            // Adjust for negative months/days
            if ($days < 0) {
                $months--;
                $days += $now->copy()->subMonth()->endOfMonth()->day;
            }
            
            if ($months < 0) {
                $years--;
                $months += 12;
            }
            
            // Ensure positive values
            return [
                'years' => max(0, $years),
                'months' => max(0, $months),
                'days' => max(0, $days)
            ];
            
        } catch (\Exception $e) {
            return ['years' => 0, 'months' => 0, 'days' => 0];
        }
    }
} 