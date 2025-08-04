<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\AgeCalculator;

class DoctorInvoice extends Component
{
    use WithFileUploads, AgeCalculator;

    // Form fields
    public $patient_id = '';
    public $patient_name = '';
    public $patient_phone = '';
    public $patient_address = '';
    public $age_years = '';
    public $age_months = '';
    public $age_days = '';
    public $gender = '';
    public $ticket_date;
    public $ticket_time;
    public $doctor_id = '';
    public $patient_type = 'new';
    public $consultation_fee = 0;
    public $paid_amount = 0;
    public $due_amount = 0;
    public $referred_by = '';
    public $remarks = '';

    // UI state
    public $showSuccess = false;
    public $showError = false;
    public $successMessage = '';
    public $errorMessage = '';
    public $isSaving = false;
    public $shouldPrint = false;

    // Search fields
    public $patient_search = '';
    public $doctor_search = '';
    public $pcp_search = '';
    
    // Search results
    public $searchResults = [];
    public $searchType = '';
    
    // UI state for dropdowns
    public $showSexOptions = false;
    public $showPatientTypeOptions = false;

    protected $rules = [
        'patient_name' => 'required|string|max:255',
        'patient_phone' => 'required|string|max:20',
        'patient_address' => 'nullable|string|max:500',
        'age_years' => 'nullable|integer|min:0|max:150',
        'age_months' => 'nullable|integer|min:0|max:12',
        'age_days' => 'nullable|integer|min:0|max:31',
        'gender' => 'required|in:Male,Female,Other',
        'ticket_date' => 'required|date',
        'ticket_time' => 'required',
        'doctor_id' => 'required|exists:users,id',
        'patient_type' => 'required|in:new,old,follow_up,pcp',
        'consultation_fee' => 'required|numeric|min:0',
        'paid_amount' => 'nullable|numeric|min:0',
        'referred_by' => 'nullable|exists:users,id',
        'remarks' => 'nullable|string|max:500',
    ];

    public function mount()
    {
        $this->ticket_date = date('Y-m-d');
        $this->ticket_time = date('H:i');
        $this->patient_phone = '+88'; // Set default contact value
        $this->calculateDueAmount();
        
        // Load default recent patients when component mounts
        $this->loadDefaultPatients();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        if ($propertyName === 'consultation_fee') {
            $this->autoSetPaidAmount();
        } elseif ($propertyName === 'paid_amount') {
            $this->calculateDueAmount();
        }
        
        // Handle search functionality
        if (in_array($propertyName, ['patient_search', 'doctor_search', 'pcp_search'])) {
            $this->handleSearch($propertyName);
        }
    }
    
    public function handleSearch($searchType)
    {
        $searchTerm = $this->{$searchType};
        
        if (strlen($searchTerm) >= 2) {
            switch ($searchType) {
                case 'patient_search':
                    $this->searchPatients($searchTerm);
                    break;
                case 'doctor_search':
                    $this->searchDoctors($searchTerm);
                    break;
                case 'pcp_search':
                    $this->searchPcps($searchTerm);
                    break;
            }
        } else {
            $this->searchResults = [];
            $this->searchType = '';
        }
    }
    
    public function searchPatients($searchTerm)
    {
        $patients = DB::table('patients')
            ->where(function($query) use ($searchTerm) {
                $query->where('patient_id', 'like', "%{$searchTerm}%")
                      ->orWhere('name', 'like', "%{$searchTerm}%")
                      ->orWhere('phone', 'like', "%{$searchTerm}%")
                      ->orWhere('address', 'like', "%{$searchTerm}%");
            })
            ->limit(10)
            ->get();
            
        $this->searchResults = $patients->toArray();
        $this->searchType = 'Patient';
        
        // Update search title
        $this->dispatch('updateSearchTitle', title: "Search Results for '{$searchTerm}'");
    }
    
    public function searchDoctors($searchTerm)
    {
        $doctorPrefix = \App\Models\SystemSetting::getValue('doctor_code_prefix', 'DR');
        
        $doctors = DB::table('users')
            ->where('code', 'like', $doctorPrefix . '%')
            ->where(function($query) use ($searchTerm) {
                $query->where('code', 'like', "%{$searchTerm}%")
                      ->orWhere('name', 'like', "%{$searchTerm}%");
            })
            ->limit(10)
            ->get();
            
        $this->searchResults = $doctors->toArray();
        $this->searchType = 'Doctor';
        
        // Update search title
        $this->dispatch('updateSearchTitle', title: "Search Results for '{$searchTerm}'");
    }
    
    public function searchPcps($searchTerm)
    {
        $pcpPrefix = \App\Models\SystemSetting::getValue('pcp_code_prefix', 'PCP');
        
        $pcps = DB::table('users')
            ->where('code', 'like', $pcpPrefix . '%')
            ->where(function($query) use ($searchTerm) {
                $query->where('code', 'like', "%{$searchTerm}%")
                      ->orWhere('name', 'like', "%{$searchTerm}%");
            })
            ->limit(10)
            ->get();
            
        $this->searchResults = $pcps->toArray();
        $this->searchType = 'PCP';
        
        // Update search title
        $this->dispatch('updateSearchTitle', title: "Search Results for '{$searchTerm}'");
    }
    
    public function loadDefaultPatients()
    {
        $patients = DB::table('patients')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        $this->searchResults = $patients->toArray();
        $this->searchType = 'Patient';
        
        // Update search title to show "Recent Patients"
        $this->dispatch('updateSearchTitle', title: 'Recent Patients');
    }
    
    public function selectPatient($patientId)
    {
        $patient = DB::table('patients')->find($patientId);
        if ($patient) {
            $this->patient_id = $patient->id;
            $this->patient_name = $patient->name;
            $this->patient_phone = $patient->phone;
            $this->patient_address = $patient->address;
            $this->patient_search = $patient->patient_id;
            
            // Set gender from patient data
            $this->gender = $patient->gender ?? '';
            
            // Calculate age from DOB if available
            if ($patient->dob) {
                $dob = \Carbon\Carbon::parse($patient->dob);
                $now = \Carbon\Carbon::now();
                $age = $dob->diff($now);
                $this->age_years = $age->y;
                $this->age_months = $age->m;
                $this->age_days = $age->d;
            }
            
            $this->patient_type = 'old';
            $this->searchResults = [];
        }
    }
    
    public function selectDoctor($doctorId)
    {
        $doctor = DB::table('users')->find($doctorId);
        if ($doctor) {
            $this->doctor_id = $doctor->id;
            $this->doctor_search = $doctor->code;
            $this->searchResults = [];
        }
    }
    
    public function selectPcp($pcpId)
    {
        $pcp = DB::table('users')->find($pcpId);
        if ($pcp) {
            $this->referred_by = $pcp->id;
            $this->pcp_search = $pcp->code;
            $this->searchResults = [];
        }
    }
    
    public function toggleSexOptions()
    {
        $this->showSexOptions = !$this->showSexOptions;
        // Don't clear search results when toggling sex options
        if ($this->showSexOptions) {
            // Hide search results when sex options are shown
            $this->searchResults = [];
            $this->searchType = '';
        } else {
            // Restore recent patients when sex options are hidden
            $this->loadDefaultPatients();
        }
    }
    
    public function selectSex($sex)
    {
        $this->gender = $sex;
        $this->showSexOptions = false;
        // Restore recent patients after sex selection
        $this->loadDefaultPatients();
    }
    
    public function togglePatientTypeOptions()
    {
        $this->showPatientTypeOptions = !$this->showPatientTypeOptions;
        // Don't clear search results when toggling patient type options
        if ($this->showPatientTypeOptions) {
            // Hide search results when patient type options are shown
            $this->searchResults = [];
            $this->searchType = '';
        } else {
            // Restore recent patients when patient type options are hidden
            $this->loadDefaultPatients();
        }
    }
    
    public function selectPatientType($patientType)
    {
        $this->patient_type = $patientType;
        $this->showPatientTypeOptions = false;
        // Restore recent patients after patient type selection
        $this->loadDefaultPatients();
    }

    public function calculateDueAmount()
    {
        $this->due_amount = max(0, $this->consultation_fee - $this->paid_amount);
    }

    public function autoSetPaidAmount()
    {
        $this->paid_amount = $this->consultation_fee;
        $this->calculateDueAmount();
    }

    public function saveInvoice($shouldPrint = false)
    {
        $this->shouldPrint = $shouldPrint;
        $this->isSaving = true;

        try {
            $this->validate();

            // Start a transaction
            DB::beginTransaction();

            // Handle patient creation if no patient is selected
            $patientId = $this->patient_id;
            if (!$patientId) {
                $patientId = $this->createNewPatient();
            }

            // Generate invoice number
            $invoiceNo = $this->generateInvoiceNumber();

            // Create invoice
            $invoiceId = DB::table('invoice')->insertGetId([
                'invoice_no' => $invoiceNo,
                'patient_id' => $patientId,
                'total_amount' => $this->consultation_fee,
                'payable_amount' => $this->consultation_fee,
                'paid_amount' => $this->paid_amount,
                'due_amount' => $this->due_amount,
                'discount_amount' => 0,
                'discount_percentage' => 0,
                'invoice_date' => $this->ticket_date,
                'invoice_type' => 'consultant',
                'payment_method' => 'cash',
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
                'remarks' => $this->remarks,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Generate ticket number
            $ticketNo = $this->generateTicketNumber($this->doctor_id);

            // Create consultant ticket
            DB::table('consultant_tickets')->insert([
                'invoice_id' => $invoiceId,
                'doctor_id' => $this->doctor_id,
                'patient_id' => $patientId,
                'ticket_no' => $ticketNo,
                'ticket_date' => $this->ticket_date,
                'ticket_time' => $this->ticket_time,
                'consultation_fee' => $this->consultation_fee,
                'paid_amount' => $this->paid_amount,
                'due_amount' => $this->due_amount,
                'patient_type' => $this->patient_type,
                'referred_by' => $this->referred_by ?: null,
                'remarks' => $this->remarks,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            $this->successMessage = "Invoice saved successfully! Invoice No: {$invoiceNo}, Ticket No: {$ticketNo}";
            $this->showSuccess = true;

            // Reset form after successful save
            $this->resetForm();

            if ($shouldPrint) {
                $this->dispatch('openPrintWindow', invoiceId: $invoiceId);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            $this->errorMessage = 'Error creating invoice: ' . $e->getMessage();
            $this->showError = true;
        }

        $this->isSaving = false;
    }

    public function saveOnly()
    {
        $this->shouldPrint = false;
        $this->isSaving = true;

        try {
            $this->validate();

            // Start a transaction
            DB::beginTransaction();

            // Handle patient creation if no patient is selected
            $patientId = $this->patient_id;
            if (!$patientId) {
                $patientId = $this->createNewPatient();
            }

            // Generate invoice number
            $invoiceNo = $this->generateInvoiceNumber();

            // Create invoice
            $invoiceId = DB::table('invoice')->insertGetId([
                'invoice_no' => $invoiceNo,
                'patient_id' => $patientId,
                'total_amount' => $this->consultation_fee,
                'payable_amount' => $this->consultation_fee,
                'paid_amount' => $this->paid_amount,
                'due_amount' => $this->due_amount,
                'discount_amount' => 0,
                'discount_percentage' => 0,
                'invoice_date' => $this->ticket_date,
                'invoice_type' => 'consultant',
                'payment_method' => 'cash',
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
                'remarks' => $this->remarks,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Generate ticket number
            $ticketNo = $this->generateTicketNumber($this->doctor_id);

            // Create consultant ticket
            DB::table('consultant_tickets')->insert([
                'invoice_id' => $invoiceId,
                'doctor_id' => $this->doctor_id,
                'patient_id' => $patientId,
                'ticket_no' => $ticketNo,
                'ticket_date' => $this->ticket_date,
                'ticket_time' => $this->ticket_time,
                'consultation_fee' => $this->consultation_fee,
                'paid_amount' => $this->paid_amount,
                'due_amount' => $this->due_amount,
                'patient_type' => $this->patient_type,
                'referred_by' => $this->referred_by ?: null,
                'remarks' => $this->remarks,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            // Use SweetAlert2 success message for Save button only
            $this->dispatch('show-success', message: "Invoice saved successfully! Invoice No: {$invoiceNo}, Ticket No: {$ticketNo}");

            // Reset form after successful save
            $this->resetForm();

        } catch (\Exception $e) {
            DB::rollBack();
            // Use SweetAlert2 error message for Save button only
            $this->dispatch('show-error', message: 'Error creating invoice: ' . $e->getMessage());
        }

        $this->isSaving = false;
    }

    public function saveAndPrint()
    {
        $this->shouldPrint = true;
        $this->isSaving = true;

        try {
            $this->validate();

            // Start a transaction
            DB::beginTransaction();

            // Handle patient creation if no patient is selected
            $patientId = $this->patient_id;
            if (!$patientId) {
                $patientId = $this->createNewPatient();
            }

            // Generate invoice number
            $invoiceNo = $this->generateInvoiceNumber();

            // Create invoice
            $invoiceId = DB::table('invoice')->insertGetId([
                'invoice_no' => $invoiceNo,
                'patient_id' => $patientId,
                'total_amount' => $this->consultation_fee,
                'payable_amount' => $this->consultation_fee,
                'paid_amount' => $this->paid_amount,
                'due_amount' => $this->due_amount,
                'discount_amount' => 0,
                'discount_percentage' => 0,
                'invoice_date' => $this->ticket_date,
                'invoice_type' => 'consultant',
                'payment_method' => 'cash',
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
                'remarks' => $this->remarks,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Generate ticket number
            $ticketNo = $this->generateTicketNumber($this->doctor_id);

            // Create consultant ticket
            DB::table('consultant_tickets')->insert([
                'invoice_id' => $invoiceId,
                'doctor_id' => $this->doctor_id,
                'patient_id' => $patientId,
                'ticket_no' => $ticketNo,
                'ticket_date' => $this->ticket_date,
                'ticket_time' => $this->ticket_time,
                'consultation_fee' => $this->consultation_fee,
                'paid_amount' => $this->paid_amount,
                'due_amount' => $this->due_amount,
                'patient_type' => $this->patient_type,
                'referred_by' => $this->referred_by ?: null,
                'remarks' => $this->remarks,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            // Use SweetAlert2 success message for Save & Print button
            $this->dispatch('show-success', message: "Invoice saved successfully! Invoice No: {$invoiceNo}, Ticket No: {$ticketNo}");

            // Reset form after successful save
            $this->resetForm();

            // Automatically open print window on success
            $this->dispatch('openPrintWindow', invoiceId: $invoiceId);

        } catch (\Exception $e) {
            DB::rollBack();
            // Use SweetAlert2 error message for Save & Print button
            $this->dispatch('show-error', message: 'Error creating invoice: ' . $e->getMessage());
        }

        $this->isSaving = false;
    }

    public function resetForm()
    {
        $this->reset([
            'patient_id', 'patient_name', 'patient_address',
            'age_years', 'age_months', 'age_days', 'gender', 'doctor_id', 'referred_by',
            'remarks', 'consultation_fee', 'paid_amount', 'due_amount',
            'patient_search', 'doctor_search', 'pcp_search', 'searchResults', 'searchType',
            'showSexOptions', 'showPatientTypeOptions'
        ]);
        $this->patient_type = 'new';
        $this->gender = '';
        $this->patient_phone = '+88'; // Set default contact value
        $this->ticket_date = date('Y-m-d');
        $this->ticket_time = date('H:i');
        $this->calculateDueAmount();
    }

    public function cancelForm()
    {
        return redirect()->route('admin.dashboard');
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

    private function createNewPatient()
    {
        $patientId = $this->generatePatientId();
        $dob = null;

        if ($this->age_years || $this->age_months || $this->age_days) {
            $dob = now()->subYears(intval($this->age_years) ?? 0)
                       ->subMonths(intval($this->age_months) ?? 0)
                       ->subDays(intval($this->age_days) ?? 0);
        }

        return DB::table('patients')->insertGetId([
            'patient_id' => $patientId,
            'name' => $this->patient_name,
            'phone' => $this->patient_phone,
            'address' => $this->patient_address ?? '',
            'dob' => $dob,
            'gender' => $this->gender,
            'reg_date' => now(),
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function generatePatientId()
    {
        return \App\Helpers\PatientIdHelper::generatePatientIdConsistent();
    }

    private function generateInvoiceNumber()
    {
        return \App\Helpers\ConsultantInvoiceHelper::generateConsultantInvoiceNumber();
    }

    private function generateTicketNumber($doctorId)
    {
        return \App\Helpers\DoctorTicketHelper::generateTicketNumber($doctorId);
    }

    public function render()
    {
        return view('livewire.doctor-invoice');
    }
} 