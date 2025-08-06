<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\AgeCalculator;
use App\Helpers\PaymentCollectionHelper;

class DiagnosticsDueCollection extends Component
{
    use AgeCalculator;

    // Search properties
    public $searchDueInvoices = '';
    public $dueInvoiceSearchResults = [];

    // Patient information
    public $patient_id = '';
    public $patient_name = '';
    public $patient_phone = '';
    public $patient_address = '';
    public $age_years = '';
    public $age_months = '';
    public $age_days = '';
    public $gender = '';

    // Due invoices
    public $dueInvoices = [];
    public $selectedInvoiceId = null;
    public $selectedInvoice = null;

    // Lab tests
    public $labTests = [];

    // Payment collection
    public $collectionAmount = 0;
    public $remarks = '';
    public $dueAmount = 0;
    public $remainingDue = 0;

    // UI states
    public $showSuccess = false;
    public $showError = false;
    public $successMessage = '';
    public $errorMessage = '';
    public $isSaving = false;

    public function mount()
    {
        $this->loadDefaultDueInvoices();
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'searchDueInvoices') {
            $this->handleDueInvoiceSearch();
        }
        
        if ($propertyName === 'collectionAmount') {
            $this->collectionAmount = (float) $this->collectionAmount;
            $this->calculateRemainingDue();
        }
    }

    public function handleDueInvoiceSearch()
    {
        if (empty($this->searchDueInvoices)) {
            $this->loadDefaultDueInvoices();
            return;
        }

        $this->searchDueInvoices($this->searchDueInvoices);
    }

    public function searchDueInvoices($searchTerm)
    {
        $invoices = DB::table('invoices')
            ->leftJoin('patients', 'invoices.patient_id', '=', 'patients.id')
            ->where('invoices.due_amount', '>', 0)
            ->where('invoices.invoice_type', 'dia')
            ->where(function($query) use ($searchTerm) {
                $query->where('invoices.invoice_no', 'like', "%{$searchTerm}%")
                      ->orWhere('patients.patient_id', 'like', "%{$searchTerm}%")
                      ->orWhere('patients.name', 'like', "%{$searchTerm}%")
                      ->orWhere('patients.phone', 'like', "%{$searchTerm}%")
                      ->orWhere('patients.address', 'like', "%{$searchTerm}%");
            })
            ->whereNull('invoices.deleted_at')
            ->select([
                'invoices.id as invoice_id',
                'invoices.invoice_no',
                'invoices.invoice_date',
                'invoices.total_amount',
                'invoices.paid_amount',
                'invoices.due_amount',
                'patients.id as patient_id',
                'patients.name as patient_name',
                'patients.patient_id as patient_code',
                'patients.phone',
                'patients.address',
                'patients.gender',
                'patients.dob as date_of_birth'
            ])
            ->groupBy('invoices.id')
            ->orderBy('invoices.invoice_date', 'desc')
            ->limit(20)
            ->get()
            ->map(function($invoice) {
                $invoiceArray = (array) $invoice;
                
                // Calculate age if DOB exists
                if ($invoice->date_of_birth) {
                    $age = $this->calculateAge($invoice->date_of_birth);
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

        $this->dueInvoiceSearchResults = $invoices->toArray();
    }

    public function loadDefaultDueInvoices()
    {
        $invoices = DB::table('invoices')
            ->leftJoin('patients', 'invoices.patient_id', '=', 'patients.id')
            ->where('invoices.due_amount', '>', 0)
            ->where('invoices.invoice_type', 'dia')
            ->whereNull('invoices.deleted_at')
            ->select([
                'invoices.id as invoice_id',
                'invoices.invoice_no',
                'invoices.invoice_date',
                'invoices.total_amount',
                'invoices.paid_amount',
                'invoices.due_amount',
                'patients.id as patient_id',
                'patients.name as patient_name',
                'patients.patient_id as patient_code',
                'patients.phone',
                'patients.address',
                'patients.gender',
                'patients.dob as date_of_birth'
            ])
            ->groupBy('invoices.id')
            ->orderBy('invoices.invoice_date', 'desc')
            ->limit(10)
            ->get()
            ->map(function($invoice) {
                $invoiceArray = (array) $invoice;
                
                // Calculate age if DOB exists
                if ($invoice->date_of_birth) {
                    $age = $this->calculateAge($invoice->date_of_birth);
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

        $this->dueInvoiceSearchResults = $invoices->toArray();
    }

    public function selectDueInvoice($invoiceId)
    {
        $invoice = collect($this->dueInvoiceSearchResults)->firstWhere('invoice_id', $invoiceId);
        
        if ($invoice) {
            $this->selectedInvoiceId = $invoiceId;
            $this->selectedInvoice = $invoice;
            
            // Set patient information
            $this->patient_id = $invoice['patient_id'];
            $this->patient_name = $invoice['patient_name'];
            $this->patient_phone = $invoice['phone'];
            $this->patient_address = $invoice['address'];
            $this->gender = $invoice['gender'];
            $this->age_years = $invoice['age_years'];
            $this->age_months = $invoice['age_months'];
            $this->age_days = $invoice['age_days'];
            
            // Set payment information
            $this->dueAmount = (float) $invoice['due_amount'];
            $this->collectionAmount = (float) $invoice['due_amount']; // Default to full amount
            $this->remainingDue = 0;
            
            // Load due invoices for this patient
            $this->loadDueInvoices($invoice['patient_id']);
            
            // Load lab tests for this invoice
            $this->loadLabTests($invoiceId);
        }
    }

    public function loadDueInvoices($patientId)
    {
        $invoices = DB::table('invoices')
            ->where('patient_id', $patientId)
            ->where('due_amount', '>', 0)
            ->where('invoice_type', 'dia')
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
            ->get()
            ->map(function($invoice) {
                return (array) $invoice;
            });

        $this->dueInvoices = $invoices->toArray();
    }

    public function loadLabTests($invoiceId)
    {
        $labTests = DB::table('lab_test_orders')
            ->leftJoin('lab_tests', 'lab_test_orders.lab_test_id', '=', 'lab_tests.id')
            ->leftJoin('departments', 'lab_tests.department_id', '=', 'departments.id')
            ->where('lab_test_orders.invoice_id', $invoiceId)
            ->select([
                'lab_tests.code as test_code',
                'lab_tests.name as test_name',
                'departments.name as department_name',
                'lab_tests.charge'
            ])
            ->get()
            ->map(function($test) {
                return (array) $test;
            });

        $this->labTests = $labTests->toArray();
        
        // Debug logging
        \Log::info('loadLabTests for invoice ' . $invoiceId . ': ' . json_encode($this->labTests));
    }

    public function selectInvoice($invoiceId)
    {
        $invoice = collect($this->dueInvoices)->firstWhere('id', $invoiceId);
        
        if ($invoice) {
            $this->selectedInvoiceId = $invoiceId;
            $this->dueAmount = (float) $invoice['due_amount'];
            $this->collectionAmount = (float) $invoice['due_amount']; // Default to full amount
            $this->calculateRemainingDue();
            
            // Load lab tests for this invoice
            $this->loadLabTests($invoiceId);
        }
    }

    public function calculateRemainingDue()
    {
        $dueAmount = (float) $this->dueAmount;
        $collectionAmount = (float) $this->collectionAmount;
        $this->remainingDue = max(0, $dueAmount - $collectionAmount);
    }

    public function saveOnly()
    {
        if (!$this->selectedInvoiceId) {
            $this->dispatch('show-error', 'Please select an invoice first.');
            return;
        }

        if ($this->collectionAmount <= 0) {
            $this->dispatch('show-error', 'Collection amount must be greater than 0.');
            return;
        }

        if ($this->collectionAmount > $this->dueAmount) {
            $this->dispatch('show-error', 'Collection amount cannot exceed due amount.');
            return;
        }

        try {
            DB::beginTransaction();

            // Get the invoice
            $invoice = DB::table('invoices')->where('id', $this->selectedInvoiceId)->first();
            
            if (!$invoice) {
                $this->dispatch('show-error', 'Invoice not found.');
                return;
            }

            // Update invoice paid and due amounts
            $newPaidAmount = $invoice->paid_amount + $this->collectionAmount;
            $newDueAmount = $invoice->due_amount - $this->collectionAmount;
            
            DB::table('invoices')
                ->where('id', $this->selectedInvoiceId)
                ->update([
                    'paid_amount' => $newPaidAmount,
                    'due_amount' => $newDueAmount,
                    'updated_by' => Auth::id(),
                    'updated_at' => now()
                ]);

            // Create payment collection record
            $collectionNumber = PaymentCollectionHelper::generateCollectionNumber();
            
            DB::table('payment_collections')->insert([
                'collection_no' => $collectionNumber,
                'invoice_id' => $this->selectedInvoiceId,
                'patient_id' => $this->patient_id,
                'collection_amount' => $this->collectionAmount,
                'due_before_collection' => $this->dueAmount,
                'due_after_collection' => $this->remainingDue,
                'remarks' => $this->remarks,
                'collected_by' => Auth::id(),
                'updated_by' => Auth::id(),
                'collection_date' => now()->toDateString(),
                'collection_time' => now()->toTimeString(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            $this->dispatch('show-success', 'Payment collected successfully! Collection No: ' . $collectionNumber);
            $this->resetForm();

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('DiagnosticsDueCollection saveOnly error: ' . $e->getMessage());
            $this->dispatch('show-error', 'Error saving payment: ' . $e->getMessage());
        }
    }

    public function saveAndPrint()
    {
        // Save the payment first
        $this->saveOnly();
        
        // After saving, trigger print
        if ($this->selectedInvoiceId) {
            $this->dispatch('openPrintWindow', [
                'invoiceId' => $this->selectedInvoiceId
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
            'searchDueInvoices', 'dueInvoiceSearchResults', 'patient_id', 'patient_name',
            'patient_phone', 'patient_address', 'age_years', 'age_months', 'age_days',
            'gender', 'dueInvoices', 'selectedInvoiceId', 'selectedInvoice',
            'labTests', 'collectionAmount', 'remarks', 'dueAmount', 'remainingDue'
        ]);
        
        $this->loadDefaultDueInvoices();
    }

    public function render()
    {
        return view('livewire.diagnostics-due-collection');
    }
} 