<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\AgeCalculator;
use App\Helpers\InvoiceReturnHelper;

class DiagnosticsInvoiceReturn extends Component
{
    use AgeCalculator;

    // Search properties
    public $searchInvoices = '';
    public $invoiceSearchResults = [];

    // Selected invoice
    public $selectedInvoiceId = null;
    public $selectedInvoice = null;

    // Patient information
    public $patient_name = '';
    public $patient_phone = '';
    public $patient_address = '';
    public $age_years = '';
    public $age_months = '';
    public $age_days = '';
    public $gender = '';

    // Invoice details
    public $invoice_date = '';
    public $total_amount = 0;
    public $paid_amount = 0;
    public $due_amount = 0;

    // Return items
    public $labTestItems = [];
    public $selectedItems = [];
    public $returnAmount = 0;
    public $returnReason = '';

    // UI states
    public $showSuccess = false;
    public $showError = false;
    public $successMessage = '';
    public $errorMessage = '';
    public $isSaving = false;

    public function mount()
    {
        $this->loadDefaultInvoices();
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'searchInvoices') {
            $this->handleInvoiceSearch();
        }
    }

    public function handleInvoiceSearch()
    {
        if (empty($this->searchInvoices)) {
            $this->loadDefaultInvoices();
            return;
        }

        $this->searchInvoices($this->searchInvoices);
    }

    public function searchInvoices($searchTerm)
    {
        $invoices = DB::table('invoices')
            ->join('patients', 'invoices.patient_id', '=', 'patients.id')
            ->select([
                'invoices.id as invoice_id',
                'invoices.invoice_no',
                'invoices.total_amount',
                'invoices.paid_amount',
                'invoices.due_amount',
                'invoices.invoice_date',
                'invoices.invoice_type',
                'patients.name as patient_name',
                'patients.phone as patient_phone',
                'patients.address as patient_address',
                'patients.dob',
                'patients.gender'
            ])
            ->where('invoices.invoice_type', 'dia')
            ->where(function($q) use ($searchTerm) {
                $q->where('invoices.invoice_no', 'like', "%{$searchTerm}%")
                  ->orWhere('patients.name', 'like', "%{$searchTerm}%")
                  ->orWhere('patients.phone', 'like', "%{$searchTerm}%");
            })
            ->where('invoices.paid_amount', '>', 0)
            ->orderBy('invoices.invoice_date', 'desc')
            ->limit(20)
            ->get()
            ->map(function($invoice) {
                $invoiceArray = (array) $invoice;
                
                // Calculate age if DOB exists
                if ($invoice->dob) {
                    $age = $this->calculateAge($invoice->dob);
                    $invoiceArray['age_years'] = $age['years'];
                    $invoiceArray['age_months'] = $age['months'];
                    $invoiceArray['age_days'] = $age['days'];
                } else {
                    $invoiceArray['age_years'] = 0;
                    $invoiceArray['age_months'] = 0;
                    $invoiceArray['age_days'] = 0;
                }
                
                return $invoiceArray;
            });

        $this->invoiceSearchResults = $invoices->toArray();
    }

    public function loadDefaultInvoices()
    {
        $invoices = DB::table('invoices')
            ->join('patients', 'invoices.patient_id', '=', 'patients.id')
            ->select([
                'invoices.id as invoice_id',
                'invoices.invoice_no',
                'invoices.total_amount',
                'invoices.paid_amount',
                'invoices.due_amount',
                'invoices.invoice_date',
                'invoices.invoice_type',
                'patients.name as patient_name',
                'patients.phone as patient_phone',
                'patients.address as patient_address',
                'patients.dob',
                'patients.gender'
            ])
            ->where('invoices.invoice_type', 'dia')
            ->where('invoices.paid_amount', '>', 0)
            ->orderBy('invoices.invoice_date', 'desc')
            ->limit(5)
            ->get()
            ->map(function($invoice) {
                $invoiceArray = (array) $invoice;
                
                // Calculate age if DOB exists
                if ($invoice->dob) {
                    $age = $this->calculateAge($invoice->dob);
                    $invoiceArray['age_years'] = $age['years'];
                    $invoiceArray['age_months'] = $age['months'];
                    $invoiceArray['age_days'] = $age['days'];
                } else {
                    $invoiceArray['age_years'] = 0;
                    $invoiceArray['age_months'] = 0;
                    $invoiceArray['age_days'] = 0;
                }
                
                return $invoiceArray;
            });

        $this->invoiceSearchResults = $invoices->toArray();
    }

    public function selectInvoice($invoiceId)
    {
        $invoice = collect($this->invoiceSearchResults)->firstWhere('invoice_id', $invoiceId);
        
        if ($invoice) {
            $this->selectedInvoiceId = $invoiceId;
            $this->selectedInvoice = $invoice;
            
            // Set patient information
            $this->patient_name = $invoice['patient_name'];
            $this->patient_phone = $invoice['patient_phone'];
            $this->patient_address = $invoice['patient_address'];
            $this->gender = $invoice['gender'];
            $this->age_years = $invoice['age_years'];
            $this->age_months = $invoice['age_months'];
            $this->age_days = $invoice['age_days'];
            
            // Set invoice information
            $this->invoice_date = $invoice['invoice_date'];
            $this->total_amount = $invoice['total_amount'];
            $this->paid_amount = $invoice['paid_amount'];
            $this->due_amount = $invoice['due_amount'];
            
            // Load invoice items
            $this->loadInvoiceItems($invoiceId);
        }
    }

    public function loadInvoiceItems($invoiceId)
    {
        // Get lab test items for this invoice
        $labTestItems = DB::table('lab_test_orders')
            ->join('lab_tests', 'lab_test_orders.lab_test_id', '=', 'lab_tests.id')
            ->select([
                'lab_test_orders.id',
                'lab_tests.code',
                'lab_tests.name as test_name',
                'lab_test_orders.charge',
                'lab_test_orders.status',
                'lab_test_orders.charge as total',
                DB::raw("'lab_test' as item_type"),
                DB::raw("0 as is_collection_kit")
            ])
            ->where('lab_test_orders.invoice_id', $invoiceId)
            ->get();

        // Get collection kits for this invoice
        $collectionKitItems = DB::table('lab_test_orders')
            ->join('lab_test_collection_kit', 'lab_test_orders.lab_test_id', '=', 'lab_test_collection_kit.lab_test_id')
            ->join('collection_kits', 'lab_test_collection_kit.collection_kit_id', '=', 'collection_kits.id')
            ->select([
                'collection_kits.id',
                'collection_kits.pcode as code',
                'collection_kits.name as test_name',
                'collection_kits.charge',
                'collection_kits.color',
                DB::raw("'active' as status"),
                'collection_kits.charge as total',
                DB::raw("'collection_kit' as item_type"),
                DB::raw("1 as is_collection_kit")
            ])
            ->where('lab_test_orders.invoice_id', $invoiceId)
            ->distinct()
            ->get();

        // Combine lab tests and collection kits
        $this->labTestItems = $labTestItems->merge($collectionKitItems)->toArray();
        $this->selectedItems = [];
        $this->returnAmount = 0;
    }

    public function toggleItemSelection($itemId)
    {
        if (in_array($itemId, $this->selectedItems)) {
            $this->selectedItems = array_diff($this->selectedItems, [$itemId]);
        } else {
            $this->selectedItems[] = $itemId;
        }
        
        $this->calculateReturnAmount();
    }

    public function calculateReturnAmount()
    {
        $this->returnAmount = 0;
        
        foreach ($this->labTestItems as $item) {
            if (in_array($item['id'], $this->selectedItems)) {
                $this->returnAmount += $item['charge'];
            }
        }
    }

    public function saveReturn()
    {
        if (empty($this->selectedItems)) {
            $this->dispatch('show-error', 'Please select at least one item to return.');
            return;
        }

        if (empty($this->returnReason)) {
            $this->dispatch('show-error', 'Please provide a reason for return.');
            return;
        }

        if ($this->returnAmount <= 0) {
            $this->dispatch('show-error', 'Return amount must be greater than 0.');
            return;
        }

        try {
            DB::beginTransaction();

            // Generate return number
            $returnNumber = InvoiceReturnHelper::generateInvoiceReturnNumber();

            // Create invoice return record
            $returnId = DB::table('invoice_returns')->insertGetId([
                'return_no' => $returnNumber,
                'invoice_id' => $this->selectedInvoiceId,
                'patient_id' => $this->selectedInvoice['patient_id'],
                'return_amount' => $this->returnAmount,
                'return_reason' => $this->returnReason,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Create return items
            foreach ($this->labTestItems as $item) {
                if (in_array($item['id'], $this->selectedItems)) {
                    DB::table('invoice_return_items')->insert([
                        'invoice_return_id' => $returnId,
                        'item_id' => $item['id'],
                        'item_type' => $item['item_type'],
                        'item_name' => $item['test_name'],
                        'item_code' => $item['code'],
                        'charge' => $item['charge'],
                        'created_by' => Auth::id(),
                        'updated_by' => Auth::id(),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            // Update invoice amounts
            $newPaidAmount = $this->paid_amount - $this->returnAmount;
            $newDueAmount = $this->due_amount + $this->returnAmount;
            
            DB::table('invoices')
                ->where('id', $this->selectedInvoiceId)
                ->update([
                    'paid_amount' => $newPaidAmount,
                    'due_amount' => $newDueAmount,
                    'updated_by' => Auth::id(),
                    'updated_at' => now()
                ]);

            DB::commit();

            $this->dispatch('show-success', 'Invoice return processed successfully! Return No: ' . $returnNumber);
            $this->resetForm();

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('DiagnosticsInvoiceReturn saveReturn error: ' . $e->getMessage());
            $this->dispatch('show-error', 'Error processing return: ' . $e->getMessage());
        }
    }

    public function saveAndPrint()
    {
        // Save the return first
        $this->saveReturn();
        
        // After saving, trigger print
        if ($this->selectedInvoiceId) {
            $this->dispatch('openPrintWindow', [
                'url' => route('admin.diagnostics.reprint.print-preview', [
                    'invoice_id' => $this->selectedInvoiceId,
                    'print_option' => 'return_receipt'
                ])
            ]);
        }
    }

    public function cancelForm()
    {
        return redirect()->route('admin.dashboard');
    }

    public function resetForm()
    {
        $this->reset([
            'searchInvoices', 'invoiceSearchResults', 'selectedInvoiceId', 'selectedInvoice',
            'patient_name', 'patient_phone', 'patient_address', 'age_years', 'age_months', 'age_days',
            'gender', 'invoice_date', 'total_amount', 'paid_amount', 'due_amount',
            'labTestItems', 'selectedItems', 'returnAmount', 'returnReason'
        ]);
        
        $this->loadDefaultInvoices();
    }

    public function render()
    {
        return view('livewire.diagnostics-invoice-return');
    }
} 