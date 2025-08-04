<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Traits\AgeCalculator;

class DoctorRePrint extends Component
{
    use AgeCalculator;

    // Search properties
    public $searchInvoices = '';
    public $invoiceSearchResults = [];

    // Invoice details
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

    // Consultant tickets
    public $consultantTickets = [];

    // Print settings
    public $printType = 'full_invoice';
    public $printCopies = 1;

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
            ->leftJoin('patients', 'invoices.patient_id', '=', 'patients.id')
            ->where('invoices.invoice_type', 'consultant')
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
            
        $this->invoiceSearchResults = $invoices;
    }

    public function loadDefaultInvoices()
    {
        $invoices = DB::table('invoices')
            ->leftJoin('patients', 'invoices.patient_id', '=', 'patients.id')
            ->where('invoices.invoice_type', 'consultant')
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
            
        $this->invoiceSearchResults = $invoices;
    }

    public function selectInvoice($invoiceId)
    {
        $this->selectedInvoiceId = $invoiceId;
        
        // Find the selected invoice
        $this->selectedInvoice = collect($this->invoiceSearchResults)->firstWhere('invoice_id', $invoiceId);
        
        if ($this->selectedInvoice) {
            // Set patient information
            $this->patient_name = $this->selectedInvoice['patient_name'] ?? '';
            $this->patient_phone = $this->selectedInvoice['phone'] ?? '';
            $this->patient_address = $this->selectedInvoice['address'] ?? '';
            $this->gender = $this->selectedInvoice['gender'] ?? '';
            $this->age_years = $this->selectedInvoice['age_years'] ?? '';
            $this->age_months = $this->selectedInvoice['age_months'] ?? '';
            $this->age_days = $this->selectedInvoice['age_days'] ?? '';
            
            // Set invoice details
            $this->invoice_date = $this->selectedInvoice['invoice_date'] ?? '';
            $this->total_amount = $this->selectedInvoice['total_amount'] ?? 0;
            $this->paid_amount = $this->selectedInvoice['paid_amount'] ?? 0;
            $this->due_amount = $this->selectedInvoice['due_amount'] ?? 0;
            
            // Load consultant tickets
            $this->loadConsultantTickets($invoiceId);
            
            // Clear search results
            $this->invoiceSearchResults = [];
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

        // Convert stdClass objects to arrays
        $this->consultantTickets = $tickets->map(function($ticket) {
            return (array) $ticket;
        })->toArray();
    }

    public function printInvoice()
    {
        if (!$this->selectedInvoiceId) {
            $this->dispatch('show-error', 'Please select an invoice first');
            return;
        }

        try {
            // Generate print URL
            $printUrl = route('admin.admin.invoice-templates.doctor-consultant', [
                'invoice_id' => $this->selectedInvoiceId,
                'print_type' => $this->printType,
                'copies' => $this->printCopies
            ]);

            // Open print window
            $this->dispatch('openPrintWindow', [
                'url' => $printUrl,
                'printType' => $this->printType,
                'copies' => $this->printCopies
            ]);

            $this->dispatch('show-success', 'Print job sent successfully!');

        } catch (\Exception $e) {
            $this->dispatch('show-error', 'Error sending print job: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->reset([
            'searchInvoices', 'invoiceSearchResults',
            'selectedInvoiceId', 'selectedInvoice',
            'patient_name', 'patient_phone', 'patient_address',
            'age_years', 'age_months', 'age_days', 'gender',
            'invoice_date', 'total_amount', 'paid_amount', 'due_amount',
            'consultantTickets', 'printType', 'printCopies'
        ]);
        
        $this->printType = 'full_invoice';
        $this->printCopies = 1;
        
        $this->loadDefaultInvoices();
    }

    public function cancelForm()
    {
        return redirect()->route('admin.dashboard');
    }

    public function render()
    {
        return view('livewire.doctor-re-print')
            ->layout('admin.layouts.app');
    }
} 