<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Livewire\Attributes\On;

class DoctorDueCollectionSearch extends Component
{
    public $search = '';
    public $results = [];
    public $selectedInvoice = null;
    
    public function updatedSearch()
    {
        if (strlen($this->search) >= 2) {
            $this->searchDueInvoices();
        } else {
            $this->results = [];
            $this->selectedInvoice = null;
            // Update search results component
            $this->dispatch('search-results-updated', [
                'results' => [],
                'search' => $this->search
            ]);
        }
    }
    
    private function searchDueInvoices()
    {
        $query = trim($this->search);
        
        $this->results = DB::table('invoice')
            ->leftJoin('patients', 'invoice.patient_id', '=', 'patients.id')
            ->leftJoin('consultant_tickets', 'invoice.id', '=', 'consultant_tickets.invoice_id')
            ->where('invoice.due_amount', '>', 0)
            ->where('invoice.invoice_type', 'consultant')
            ->where(function($q) use ($query) {
                $q->where('invoice.invoice_no', 'like', "%{$query}%")
                  ->orWhere('patients.patient_id', 'like', "%{$query}%")
                  ->orWhere('patients.name_en', 'like', "%{$query}%")
                  ->orWhere('patients.phone', 'like', "%{$query}%")
                  ->orWhere('patients.address', 'like', "%{$query}%");
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
                'patients.name_en as patient_name',
                'patients.patient_id as patient_code',
                'patients.phone',
                'patients.address',
                'patients.dob as date_of_birth'
            ])
            ->groupBy('invoice.id') // Group to avoid duplicates
            ->orderBy('invoice.invoice_date', 'desc')
            ->limit(20)
            ->get()
            ->map(function($invoice) {
                $invoiceArray = (array) $invoice;
                
                // Calculate age if DOB exists
                if ($invoiceArray['date_of_birth']) {
                    $dob = Carbon::parse($invoiceArray['date_of_birth']);
                    $now = Carbon::now();
                    
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
            
        // Dispatch results to search results component
        $this->dispatch('search-results-updated', [
            'results' => $this->results,
            'search' => $this->search
        ]);
    }
    
    public function selectInvoice($invoiceId)
    {
        $invoice = collect($this->results)->first(function($item) use ($invoiceId) {
            return $item['invoice_id'] == $invoiceId;
        });
        
        if ($invoice) {
            $this->selectedInvoice = $invoice;
            
            // Update search input with patient ID
            $this->search = $invoice['patient_code'];
            
            // Dispatch browser event to fill patient information
            $this->dispatch('invoice-selected', (array) $invoice);
            
            // Load patient's all due invoices
            $this->loadPatientDueInvoices($invoice['patient_id']);
            
            // Load consultant tickets
            $this->loadConsultantTickets($invoice['invoice_id']);
        }
    }
    
    private function loadPatientDueInvoices($patientId)
    {
        $dueInvoices = DB::table('invoice')
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
            ->get()
            ->toArray();
            
        $this->dispatch('patient-due-invoices-loaded', $dueInvoices);
    }
    
    private function loadConsultantTickets($invoiceId)
    {
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
            ->where('consultant_tickets.invoice_id', $invoiceId)
            ->get();
            
        $this->dispatch('consultant-tickets-loaded', $consultantTickets);
    }
    
    #[On('select-invoice-from-results')]
    public function handleResultSelection($data)
    {
        // Get the invoice data from the results component
        $invoiceId = $data['invoiceId'];
        $patientCode = $data['patientCode'] ?? '';
        
        // Find the invoice in the database
        $invoice = DB::table('invoice')
            ->join('patients', 'invoice.patient_id', '=', 'patients.id')
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
            ->where('invoice.id', $invoiceId)
            ->where('invoice.invoice_type', 'consultant')
            ->first();
            
        if ($invoice) {
            $invoiceArray = (array) $invoice;
            
            // Calculate age
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
            
            // Update search input with patient code
            $this->search = $invoiceArray['patient_code'];
            
            // Dispatch browser event to fill patient information
            $this->dispatch('invoice-selected', $invoiceArray);
            
            // Load patient's all due invoices
            $this->loadPatientDueInvoices($invoiceArray['patient_id']);
            
            // Load consultant tickets
            $this->loadConsultantTickets($invoiceArray['invoice_id']);
        }
    }
    
    public function render()
    {
        return view('livewire.doctor-due-collection-search');
    }
} 