<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\SystemSetting;
use App\Traits\AgeCalculator;

class DoctorDueCollection extends Component
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

    // Consultant tickets
    public $consultantTickets = [];

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
        $invoices = DB::table('invoice')
            ->leftJoin('patients', 'invoice.patient_id', '=', 'patients.id')
            ->where('invoice.due_amount', '>', 0)
            ->where('invoice.invoice_type', 'consultant')
            ->where(function($query) use ($searchTerm) {
                $query->where('invoice.invoice_no', 'like', "%{$searchTerm}%")
                      ->orWhere('patients.patient_id', 'like', "%{$searchTerm}%")
                      ->orWhere('patients.name', 'like', "%{$searchTerm}%")
                      ->orWhere('patients.phone', 'like', "%{$searchTerm}%")
                      ->orWhere('patients.address', 'like', "%{$searchTerm}%");
            })
            ->whereNull('invoice.deleted_at')
            ->select([
                'invoice.id as invoice_id',
                'invoice.invoice_no',
                'invoice.invoice_date',
                'invoice.total_amount',
                'invoice.paid_amount',
                'invoice.due_amount',
                'patients.id as patient_id',
                'patients.name as patient_name',
                'patients.patient_id as patient_code',
                'patients.phone',
                'patients.address',
                'patients.gender',
                'patients.dob as date_of_birth'
            ])
            ->groupBy('invoice.id')
            ->orderBy('invoice.invoice_date', 'desc')
            ->limit(20)
            ->get()
            ->map(function($invoice) {
                $invoiceArray = (array) $invoice;
                
                // Calculate age if DOB exists
                if ($invoiceArray['date_of_birth']) {
                    $dob = \Carbon\Carbon::parse($invoiceArray['date_of_birth']);
                    $now = \Carbon\Carbon::now();
                    
                    $invoiceArray['age_years'] = (int) $dob->diffInYears($now);
                    $invoiceArray['age_months'] = (int) $dob->copy()->addYears($invoiceArray['age_years'])->diffInMonths($now);
                    $invoiceArray['age_days'] = (int) $dob->copy()->addYears($invoiceArray['age_years'])->addMonths($invoiceArray['age_months'])->diffInDays($now);
                } else {
                    $invoiceArray['age_years'] = 0;
                    $invoiceArray['age_months'] = 0;
                    $invoiceArray['age_days'] = 0;
                }
                
                return $invoiceArray;
            })
            ->toArray();
            
        $this->dueInvoiceSearchResults = $invoices;
        $this->dispatch('updateDueInvoiceSearchTitle', title: "Due Invoice Search Results for '{$searchTerm}'");
    }

    public function loadDefaultDueInvoices()
    {
        $invoices = DB::table('invoice')
            ->leftJoin('patients', 'invoice.patient_id', '=', 'patients.id')
            ->where('invoice.due_amount', '>', 0)
            ->where('invoice.invoice_type', 'consultant')
            ->whereNull('invoice.deleted_at')
            ->select([
                'invoice.id as invoice_id',
                'invoice.invoice_no',
                'invoice.invoice_date',
                'invoice.total_amount',
                'invoice.paid_amount',
                'invoice.due_amount',
                'patients.id as patient_id',
                'patients.name as patient_name',
                'patients.patient_id as patient_code',
                'patients.phone',
                'patients.address',
                'patients.gender',
                'patients.dob as date_of_birth'
            ])
            ->groupBy('invoice.id')
            ->orderBy('invoice.invoice_date', 'desc')
            ->limit(10)
            ->get()
            ->map(function($invoice) {
                $invoiceArray = (array) $invoice;
                
                // Calculate age if DOB exists
                if ($invoiceArray['date_of_birth']) {
                    $dob = \Carbon\Carbon::parse($invoiceArray['date_of_birth']);
                    $now = \Carbon\Carbon::now();
                    
                    $invoiceArray['age_years'] = (int) $dob->diffInYears($now);
                    $invoiceArray['age_months'] = (int) $dob->copy()->addYears($invoiceArray['age_years'])->diffInMonths($now);
                    $invoiceArray['age_days'] = (int) $dob->copy()->addYears($invoiceArray['age_years'])->addMonths($invoiceArray['age_months'])->diffInDays($now);
                } else {
                    $invoiceArray['age_years'] = 0;
                    $invoiceArray['age_months'] = 0;
                    $invoiceArray['age_days'] = 0;
                }
                
                return $invoiceArray;
            })
            ->toArray();
            
        $this->dueInvoiceSearchResults = $invoices;
        $this->dispatch('updateDueInvoiceSearchTitle', title: 'Recent Due Invoices');
    }

    public function selectDueInvoice($invoiceId)
    {
        $invoice = collect($this->dueInvoiceSearchResults)->firstWhere('invoice_id', $invoiceId);
        if ($invoice) {
            // Set patient information from the invoice
            $this->patient_id = $invoice['patient_id'];
            $this->patient_name = $invoice['patient_name'];
            $this->patient_phone = $invoice['phone'];
            $this->patient_address = $invoice['address'];
            $this->gender = $invoice['gender'] ?? '';
            $this->age_years = $invoice['age_years'] ?? '';
            $this->age_months = $invoice['age_months'] ?? '';
            $this->age_days = $invoice['age_days'] ?? '';
            
            // Load due invoices for this patient
            $this->loadDueInvoices($invoice['patient_id']);
            
            // Select this specific invoice
            $this->selectInvoice($invoiceId);
            
            // Clear search results
            $this->dueInvoiceSearchResults = [];
        }
    }

    public function loadDueInvoices($patientId)
    {
        $invoices = DB::table('invoice')
            ->where('patient_id', $patientId)
            ->where('due_amount', '>', 0)
            ->orderBy('invoice_date', 'desc')
            ->get();

        $this->dueInvoices = $invoices->toArray();
        
        // Auto-select first invoice if available
        if (count($this->dueInvoices) > 0) {
            $this->selectInvoice($this->dueInvoices[0]->id);
        }
    }

    public function selectInvoice($invoiceId)
    {
        $this->selectedInvoiceId = $invoiceId;
        
        // Find the selected invoice
        $this->selectedInvoice = collect($this->dueInvoices)->firstWhere('id', $invoiceId);
        
        if ($this->selectedInvoice) {
            $this->dueAmount = $this->selectedInvoice->due_amount;
            $this->collectionAmount = $this->selectedInvoice->due_amount;
            $this->remainingDue = 0;
            
            // Load consultant tickets
            $this->loadConsultantTickets($invoiceId);
        }
    }

    public function loadConsultantTickets($invoiceId)
    {
        $tickets = DB::table('consultant_tickets')
            ->join('users', 'consultant_tickets.doctor_id', '=', 'users.id')
            ->where('consultant_tickets.invoice_id', $invoiceId)
            ->select(
                'consultant_tickets.*',
                'users.name as doctor_name'
            )
            ->get();

        $this->consultantTickets = $tickets->toArray();
    }

    public function calculateRemainingDue()
    {
        if ($this->collectionAmount > $this->dueAmount) {
            $this->collectionAmount = $this->dueAmount;
        }
        
        $this->remainingDue = $this->dueAmount - $this->collectionAmount;
    }

    public function savePayment()
    {
        $this->validate([
            'collectionAmount' => 'required|numeric|min:0.01',
            'selectedInvoiceId' => 'required',
        ]);

        if ($this->collectionAmount > $this->dueAmount) {
            $this->showError = true;
            $this->errorMessage = 'Collection amount cannot exceed due amount';
            return;
        }

        try {
            DB::beginTransaction();

            // Create payment collection record
            $collectionNo = $this->generateCollectionNumber();
            
            DB::table('payment_collections')->insert([
                'collection_no' => $collectionNo,
                'invoice_id' => $this->selectedInvoiceId,
                'collection_amount' => $this->collectionAmount,
                'due_before_collection' => $this->dueAmount,
                'due_after_collection' => $this->remainingDue,
                'remarks' => $this->remarks,
                'collected_by' => auth()->id(),
                'collection_date' => now()->format('Y-m-d'),
                'collection_time' => now()->format('H:i:s'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update invoice paid amount
            DB::table('invoice')
                ->where('id', $this->selectedInvoiceId)
                ->update([
                    'paid_amount' => DB::raw('paid_amount + ' . $this->collectionAmount),
                    'due_amount' => $this->remainingDue,
                    'updated_at' => now(),
                ]);

            DB::commit();

            // Show success message
            $this->showSuccess = true;
            $this->successMessage = "Payment collected successfully! Collection #: {$collectionNo}";

            // Reset form
            $this->collectionAmount = 0;
            $this->remarks = '';
            $this->remainingDue = 0;

            // Refresh due invoices
            if ($this->patient_id) {
                $this->loadDueInvoices($this->patient_id);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            $this->showError = true;
            $this->errorMessage = 'Error saving payment: ' . $e->getMessage();
        }
    }

    private function generateCollectionNumber()
    {
        $prefix = SystemSetting::getValue('collection_prefix', 'COL');
        $today = now();
        $datePrefix = $today->format('ymd');
        
        // Find the last collection number for today
        $lastCollection = DB::table('payment_collections')
            ->where('collection_no', 'like', $prefix . $datePrefix . '%')
            ->orderBy('collection_no', 'desc')
            ->first();

        if ($lastCollection) {
            $lastNumber = (int) substr($lastCollection->collection_no, -3);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return $prefix . $datePrefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public function resetForm()
    {
        $this->reset([
            'searchDueInvoices', 'dueInvoiceSearchResults',
            'patient_id', 'patient_name', 'patient_phone', 'patient_address', 
            'age_years', 'age_months', 'age_days', 'gender',
            'dueInvoices', 'selectedInvoiceId', 'selectedInvoice', 'consultantTickets',
            'collectionAmount', 'remarks', 'dueAmount', 'remainingDue'
        ]);
        
        $this->loadDefaultDueInvoices();
    }

    public function closeSuccess()
    {
        $this->showSuccess = false;
        $this->successMessage = '';
    }

    public function closeError()
    {
        $this->showError = false;
        $this->errorMessage = '';
    }

    public function render()
    {
        return view('livewire.doctor-due-collection');
    }
} 