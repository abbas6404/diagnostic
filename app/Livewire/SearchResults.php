<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SearchResults extends Component
{
    public $searchType = 'none'; // none, patient, doctor, pcp
    public $results = [];
    public $query = '';
    
    protected $listeners = [
        'showPatientResults' => 'searchPatients',
        'showDoctorResults' => 'searchDoctors',
        'showPcpResults' => 'searchPcps',
        'showTicketResults' => 'searchTickets',
        'showLabTestResults' => 'searchLabTests',
        'showOpdServiceResults' => 'searchOpdServices',
        'showInvoiceResults' => 'searchInvoices', // NEW
        'showDefaultPatients' => 'loadDefaultPatients',
        'clearResults' => 'clearResults',
        'clear-search-results' => 'clearResults'
    ];
    
    public function mount()
    {
        // Load default recent patients when component mounts
        $this->loadDefaultPatients();
    }
    
    public function loadDefaultPatients()
    {
        $this->searchType = 'patient';
        $this->query = '';
        
        $patients = DB::table('patients')
            ->whereNull('deleted_at')
            ->select('id', 'patient_id', 'name_en', 'phone', 'address', 'dob')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();
        
        // Calculate age for each patient
        $this->results = $patients->map(function($patient) {
            $patient = (array) $patient;
            
            // Calculate age if DOB is available
            if (!empty($patient['dob'])) {
                $dob = Carbon::parse($patient['dob']);
                $now = Carbon::now();
                
                $years = (int) $dob->diffInYears($now);
                $months = (int) $dob->copy()->addYears($years)->diffInMonths($now);
                $days = (int) $dob->copy()->addYears($years)->addMonths($months)->diffInDays($now);
                
                $patient['age_years'] = $years;
                $patient['age_months'] = $months;
                $patient['age_days'] = $days;
            } else {
                $patient['age_years'] = 0;
                $patient['age_months'] = 0;
                $patient['age_days'] = 0;
            }
            
            return $patient;
        });
        
        if (count($this->results) > 0) {
            // Removed auto-selection for patients - let user manually select
            // $this->dispatch('focusFirstResult', 'patient');
        }
    }
    
    public function searchPatients($query)
    {
        $this->query = $query;
        $this->searchType = 'patient';
        $this->dispatch('searchTypeChanged', 'Patient');
        
        $patients = DB::table('patients')
            ->where(function($q) {
                $q->where('patient_id', 'like', "%{$this->query}%")
                  ->orWhere('name_en', 'like', "%{$this->query}%")
                  ->orWhere('phone', 'like', "%{$this->query}%")
                  ->orWhere('address', 'like', "%{$this->query}%");
            })
            ->whereNull('deleted_at')
            ->select('id', 'patient_id', 'name_en', 'phone', 'address', 'dob')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();
        
        // Calculate age for each patient
        $this->results = $patients->map(function($patient) {
            $patient = (array) $patient;
            
            // Calculate age if DOB is available
            if (!empty($patient['dob'])) {
                $dob = Carbon::parse($patient['dob']);
                $now = Carbon::now();
                
                $years = (int) $dob->diffInYears($now);
                $months = (int) $dob->copy()->addYears($years)->diffInMonths($now);
                $days = (int) $dob->copy()->addYears($years)->addMonths($months)->diffInDays($now);
                
                $patient['age_years'] = $years;
                $patient['age_months'] = $months;
                $patient['age_days'] = $days;
            } else {
                $patient['age_years'] = 0;
                $patient['age_months'] = 0;
                $patient['age_days'] = 0;
            }
            
            return $patient;
        });
        
        if (count($this->results) > 0) {
            // Removed auto-selection for patients - let user manually select
            // $this->dispatch('focusFirstResult', 'patient');
        }
    }
    
    public function searchDoctors($query)
    {
        $this->query = $query;
        $this->searchType = 'doctor';
        $this->dispatch('searchTypeChanged', 'Doctor');
        
        $this->results = User::whereHas('roles', function($q) {
                $q->where('name', 'Doctor');
            })
            ->where(function($q) {
                $q->where('name', 'like', "%{$this->query}%")
                  ->orWhere('code', 'like', "%{$this->query}%")
                  ->orWhere('description', 'like', "%{$this->query}%");
            })
            ->where('status', 'active')
            ->select('id', 'name', 'description', 'code')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get()
            ->toArray();
            
        if (count($this->results) > 0) {
            $this->dispatch('focusFirstResult', 'doctor');
        }
    }
    
    public function searchPcps($query)
    {
        $this->query = $query;
        $this->searchType = 'pcp';
        $this->dispatch('searchTypeChanged', 'PCP');
        
        $this->results = User::whereHas('roles', function($q) {
                $q->where('name', 'PCP');
            })
            ->where(function($q) {
                $q->where('name', 'like', "%{$this->query}%")
                  ->orWhere('code', 'like', "%{$this->query}%")
                  ->orWhere('description', 'like', "%{$this->query}%");
            })
            ->where('status', 'active')
            ->select('id', 'name', 'description', 'code')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get()
            ->toArray();
            
        if (count($this->results) > 0) {
            $this->dispatch('focusFirstResult', 'pcp');
        }
    }
    
    public function searchTickets($query)
    {
        $this->query = $query;
        $this->searchType = 'ticket';
        $this->dispatch('searchTypeChanged', 'Ticket');
        
        $tickets = DB::table('consultant_tickets')
            ->where('ticket_no', 'like', "%{$this->query}%")
            ->leftJoin('patients', 'consultant_tickets.patient_id', '=', 'patients.id')
            ->leftJoin('users as doctors', 'consultant_tickets.doctor_id', '=', 'doctors.id')
            ->select(
                'consultant_tickets.id', 
                'consultant_tickets.ticket_no', 
                'consultant_tickets.ticket_date', 
                'consultant_tickets.ticket_status',
                'patients.name_en as patient_name',
                'doctors.name as doctor_name'
            )
            ->orderBy('consultant_tickets.id', 'desc')
            ->limit(10)
            ->get();
        
        $this->results = $tickets->toArray();
    }
    
    public function selectPatient($id, $patientId, $name, $phone, $address)
    {
        // Find the selected patient from results to get age data
        $selectedPatient = collect($this->results)->first(function($patient) use ($id) {
            return is_array($patient) ? $patient['id'] == $id : $patient->id == $id;
        });
        
        // Create patient data object with age information
        $patientData = [
            'id' => $id,
            'patientId' => $patientId,
            'name' => $name,
            'phone' => $phone,
            'address' => $address,
            'age_years' => $selectedPatient['age_years'] ?? 0,
            'age_months' => $selectedPatient['age_months'] ?? 0,
            'age_days' => $selectedPatient['age_days'] ?? 0
        ];
        
        // Dispatch events with patient data
        $this->dispatch('patient-selected', $patientData);
        $this->dispatch('fill-patient-fields', $patientData);
        
        $this->clearResults();
    }
    
    public function selectDoctor($id, $code, $name)
    {
        $this->dispatch('doctor-selected', [
            'id' => $id,
            'code' => $code,
            'name' => $name
        ]);
        $this->clearResults();
    }
    
    public function selectPcp($id, $code, $name)
    {
        $this->dispatch('pcp-selected', [
            'id' => $id,
            'code' => $code,
            'name' => $name
        ]);
        $this->clearResults();
    }

    public function selectTicket($id, $ticketNo, $patientName, $doctorName, $doctorFee)
    {
        $this->dispatch('ticket-selected', [
            'id' => $id,
            'ticketNo' => $ticketNo,
            'patientName' => $patientName,
            'doctorName' => $doctorName,
            'doctorFee' => $doctorFee
        ]);
        
        $this->dispatch('fill-ticket-fields', [
            'id' => $id,
            'ticketNo' => $ticketNo,
            'patientName' => $patientName,
            'doctorName' => $doctorName,
            'doctorFee' => $doctorFee
        ]);
        
        $this->clearResults();
    }
    
    public function searchLabTests($query)
    {
        $this->query = $query;
        $this->searchType = 'labtest';
        $this->dispatch('searchTypeChanged', 'Lab Test');
        
        $labTests = DB::table('lab_tests')
            ->where(function($q) {
                $q->where('lab_tests.code', 'like', "%{$this->query}%")
                  ->orWhere('lab_tests.name', 'like', "%{$this->query}%");
            })
            ->whereNull('lab_tests.deleted_at')
            ->leftJoin('departments', 'lab_tests.department_id', '=', 'departments.id')
            ->select(
                'lab_tests.id', 
                'lab_tests.code', 
                'lab_tests.name as test_name', 
                'lab_tests.description',
                'lab_tests.charge',
                'departments.name as department_name'
            )
            ->orderBy('lab_tests.id', 'desc')
            ->limit(10)
            ->get();
        
        // Get collection kits for each lab test
        foreach ($labTests as $test) {
            $collectionKits = DB::table('lab_test_collection_kit')
                ->join('collection_kits', 'lab_test_collection_kit.collection_kit_id', '=', 'collection_kits.id')
                ->where('lab_test_collection_kit.lab_test_id', $test->id)
                ->select('collection_kits.id', 'collection_kits.pcode', 'collection_kits.name', 'collection_kits.color', 'collection_kits.charge as kit_charge')
                ->get();
            
            $test->collection_kits = $collectionKits;
        }
        
        // Convert to array and debug first result
        $this->results = $labTests->toArray();
        
        if (count($this->results) > 0) {
            // Debug the first result
            \Illuminate\Support\Facades\Log::info('First lab test result:', ['result' => $this->results[0]]);
            $this->dispatch('focusFirstResult', 'labtest');
        }
    }
    
    public function selectLabTest($id, $code, $test_name, $charge, $departmentName)
    {
        // Get collection kits for this lab test
        $collectionKits = DB::table('lab_test_collection_kit')
            ->join('collection_kits', 'lab_test_collection_kit.collection_kit_id', '=', 'collection_kits.id')
            ->where('lab_test_collection_kit.lab_test_id', $id)
            ->select('collection_kits.id', 'collection_kits.pcode', 'collection_kits.name', 'collection_kits.color', 'collection_kits.charge as kit_charge')
            ->get();
        
        $data = [
            'id' => $id,
            'code' => $code,
            'test_name' => $test_name,
            'charge' => $charge,
            'department' => [
                'name' => $departmentName
            ],
            'collection_kits' => $collectionKits->toArray()
        ];
        
        // Log the data being dispatched
        \Illuminate\Support\Facades\Log::info('Lab test selected data:', $data);
        
        $this->dispatch('lab-test-selected', $data);
        $this->clearResults();
    }
    
    public function searchOpdServices($query)
    {
        $this->query = $query;
        $this->searchType = 'opdservice';
        $this->dispatch('searchTypeChanged', 'OPD Service');
        
        $opdServices = DB::table('opd_services')
            ->where(function($q) {
                $q->where('opd_services.code', 'like', "%{$this->query}%")
                  ->orWhere('opd_services.name', 'like', "%{$this->query}%");
            })
            ->whereNull('opd_services.deleted_at')
            ->leftJoin('departments', 'opd_services.department_id', '=', 'departments.id')
            ->select(
                'opd_services.id', 
                'opd_services.code', 
                'opd_services.name as service_name', 
                'opd_services.description',
                'opd_services.charge',
                'departments.name as department_name'
            )
            ->orderBy('opd_services.id', 'desc')
            ->limit(10)
            ->get();
        
        $this->results = $opdServices->toArray();
        
        if (count($this->results) > 0) {
            \Illuminate\Support\Facades\Log::info('First OPD service result:', ['result' => $this->results[0]]);
            $this->dispatch('focusFirstResult', 'opdservice');
        }
    }
    
    public function selectOpdService($id, $code, $service_name, $charge, $departmentName)
    {
        $data = [
            'id' => $id,
            'code' => $code,
            'service_name' => $service_name,
            'charge' => $charge,
            'department' => [
                'name' => $departmentName
            ]
        ];
        
        // Log the data being dispatched
        \Illuminate\Support\Facades\Log::info('OPD service selected data:', $data);
        
        $this->dispatch('opd-service-selected', $data);
        $this->clearResults();
    }
    
    public function searchInvoices($query)
    {
        $this->query = $query;
        $this->searchType = 'invoice';
        $this->dispatch('searchTypeChanged', 'Invoice');

        $invoices = \DB::table('invoice')
            ->leftJoin('patients', 'invoice.patient_id', '=', 'patients.id')
            ->where(function($q) {
                $q->where('invoice.invoice_no', 'like', "%{$this->query}%")
                  ->orWhere('patients.name_en', 'like', "%{$this->query}%")
                  ->orWhere('invoice.invoice_date', 'like', "%{$this->query}%");
            })
            ->select(
                'invoice.id',
                'invoice.invoice_no',
                'invoice.invoice_date',
                'patients.name_en as patient_name',
                'invoice.total_amount',
                'invoice.due_amount'
            )
            ->orderBy('invoice.id', 'desc')
            ->limit(10)
            ->get();

        $this->results = $invoices->toArray();
        if (count($this->results) > 0) {
            $this->dispatch('focusFirstResult', 'invoice');
        }
    }
    
    public function selectInvoice($id, $invoiceNo, $patientName, $date, $total, $due)
    {
        $this->dispatch('invoice-selected', [
            'id' => $id,
            'invoiceNo' => $invoiceNo,
            'patientName' => $patientName,
            'date' => $date,
            'total' => $total,
            'due' => $due
        ]);
        $this->clearResults();
    }
    
    public function clearResults()
    {
        $this->searchType = 'none';
        $this->results = [];
        $this->query = '';
    }
    
    public function render()
    {
        return view('livewire.search-results');
    }
    
    // This hook runs after the component has been rendered
    public function dehydrate()
    {
        if (count($this->results) > 0 && $this->searchType !== 'none') {
            // Don't auto-select for patients - let user manually select
            if ($this->searchType !== 'patient') {
                $this->dispatch('focusFirstResult', $this->searchType);
            }
        }
    }
}
