<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class DoctorDueCollectionSearchResults extends Component
{
    public $results = [];
    public $search = '';
    public $selectedInvoice = null;
    
    public function mount()
    {
        // Load last 5 due invoices by default
        $this->loadDefaultDueInvoices();
    }
    
    public function loadDefaultDueInvoices()
    {
        // First, let's check if there are any consultant invoices at all
        $allConsultantInvoices = \DB::table('invoice')
            ->where('invoice_type', 'consultant')
            ->whereNull('deleted_at')
            ->count();
            
        // If no consultant invoices exist, show a message
        if ($allConsultantInvoices == 0) {
            $this->results = [];
            return;
        }
        
        // Check for consultant invoices with due amounts
        $dueConsultantInvoices = \DB::table('invoice')
            ->where('invoice_type', 'consultant')
            ->where('due_amount', '>', 0)
            ->whereNull('deleted_at')
            ->count();
            
        // If no due consultant invoices, show all consultant invoices instead
        if ($dueConsultantInvoices == 0) {
            $dueInvoices = \DB::table('invoice')
                ->join('patients', 'invoice.patient_id', '=', 'patients.id')
                ->leftJoin('consultant_tickets', 'invoice.id', '=', 'consultant_tickets.invoice_id')
                ->select([
                    'invoice.id as invoice_id',
                    'invoice.invoice_no',
                    'invoice.invoice_date',
                    'invoice.total_amount',
                    'invoice.paid_amount',
                    'invoice.due_amount',
                    'patients.id as patient_id',
                    'patients.name_en as patient_name',
                    'patients.patient_id as patient_code',
                    'patients.phone',
                    'patients.address',
                    'patients.gender',
                    'patients.dob as date_of_birth'
                ])
                ->where('invoice.invoice_type', 'consultant')
                ->whereNull('invoice.deleted_at')
                ->groupBy('invoice.id')
                ->orderBy('invoice.invoice_date', 'desc')
                ->limit(5)
                ->get()
                ->map(function($invoice) {
                    $invoiceArray = (array) $invoice;
                    
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
        } else {
            // Original query for due consultant invoices
            $dueInvoices = \DB::table('invoice')
                ->join('patients', 'invoice.patient_id', '=', 'patients.id')
                ->leftJoin('consultant_tickets', 'invoice.id', '=', 'consultant_tickets.invoice_id')
                ->select([
                    'invoice.id as invoice_id',
                    'invoice.invoice_no',
                    'invoice.invoice_date',
                    'invoice.total_amount',
                    'invoice.paid_amount',
                    'invoice.due_amount',
                    'patients.id as patient_id',
                    'patients.name_en as patient_name',
                    'patients.patient_id as patient_code',
                    'patients.phone',
                    'patients.address',
                    'patients.gender',
                    'patients.dob as date_of_birth'
                ])
                ->where('invoice.due_amount', '>', 0)
                ->where('invoice.invoice_type', 'consultant')
                ->whereNull('invoice.deleted_at')
                ->groupBy('invoice.id')
                ->orderBy('invoice.invoice_date', 'desc')
                ->limit(5)
                ->get()
                ->map(function($invoice) {
                    $invoiceArray = (array) $invoice;
                    
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
        }
            
        $this->results = $dueInvoices;
        
        // Auto-select first item if results exist
        if (count($dueInvoices) > 0) {
            $this->selectedInvoice = $dueInvoices[0]['invoice_id'];
        }
    }
    
    #[On('search-results-updated')]
    public function updateResults($data = null)
    {
        if ($data) {
            $this->results = $data['results'];
            $this->search = $data['search'];
        }
    }
    
    #[On('invoice-selected')]
    public function markSelected($invoice = null)
    {
        if ($invoice) {
            $this->selectedInvoice = $invoice['invoice_id'] ?? null;
        }
    }
    
    public function selectInvoice($invoiceId)
    {
        $invoice = collect($this->results)->first(function($item) use ($invoiceId) {
            return $item['invoice_id'] == $invoiceId;
        });
        
        if ($invoice) {
            $this->selectedInvoice = $invoiceId;
            
            // Dispatch to main search component with patient code
            $this->dispatch('select-invoice-from-results', [
                'invoiceId' => $invoiceId,
                'patientCode' => $invoice['patient_code']
            ]);
        }
    }
    
    public function render()
    {
        return view('livewire.doctor-due-collection-search-results');
    }
} 