<?php

namespace App\Livewire;

use App\Models\Patient;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PatientRegistration extends Component
{
    use WithFileUploads;

    // Form fields
    public $reg_date;
    public $patient_id;
    public $name_en;
    public $address;
    public $phone;
    public $original_dob = false;
    public $dob;
    public $age_year;
    public $age_month;
    public $age_day;
    public $gender;
    public $blood_group;
    public $reg_fee = 0;
    public $patient_id_hidden;

    // Search functionality
    public $searchQuery = '';
    public $searchResults = [];
    public $showSearchResults = false;
    
    // Blood group functionality
    public $showBloodGroups = false;
    
    // Sex functionality
    public $showSexOptions = false;

    protected $rules = [
        'reg_date' => 'required|date',
        'name_en' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'address' => 'nullable|string|max:500',
        'dob' => 'nullable|date',
        'age_year' => 'nullable|integer|min:0|max:150',
        'age_month' => 'nullable|integer|min:0|max:12',
        'age_day' => 'nullable|integer|min:0|max:31',
        'gender' => 'nullable|string|in:Male,Female,Other',
        'blood_group' => 'nullable|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        'reg_fee' => 'nullable|numeric|min:0',
    ];

    public function mount()
    {
        $this->reg_date = date('Y-m-d');
        $this->patient_id = $this->generatePatientId();
        $this->phone = '+880'; // Default phone value
        
        // Load 20 most recent patients by default
        $this->searchResults = Patient::orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
        $this->showSearchResults = true;
    }

    public function generatePatientId()
    {
        $prefix = 'P';
        $year = date('Y');
        $month = date('m');
        
        // Get the last patient ID for this month
        $lastPatient = Patient::where('patient_id', 'like', $prefix . $year . $month . '%')
            ->orderBy('patient_id', 'desc')
            ->first();
        
        if ($lastPatient) {
            $lastNumber = intval(substr($lastPatient->patient_id, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public function updatedDob()
    {
        if ($this->dob) {
            $this->calculateAge();
        }
    }

    public function updatedAgeYear()
    {
        $this->calculateDob();
    }

    public function updatedAgeMonth()
    {
        $this->calculateDob();
    }

    public function updatedAgeDay()
    {
        $this->calculateDob();
    }

    public function calculateAge()
    {
        if ($this->dob) {
            $dob = Carbon::parse($this->dob);
            $today = Carbon::now();
            
            $years = $today->diffInYears($dob);
            $months = $today->diffInMonths($dob) % 12;
            $days = $today->diffInDays($dob) % 30;
            
            $this->age_year = $years;
            $this->age_month = $months;
            $this->age_day = $days;
        }
    }

    public function calculateDob()
    {
        if ($this->age_year > 0 || $this->age_month > 0 || $this->age_day > 0) {
            $today = Carbon::now();
            $dob = $today->subYears($this->age_year ?? 0)
                         ->subMonths($this->age_month ?? 0)
                         ->subDays($this->age_day ?? 0);
            
            $this->dob = $dob->format('Y-m-d');
        }
    }

    public function searchPatients()
    {
        if (strlen($this->searchQuery) >= 2) {
            $this->searchResults = Patient::where('name_en', 'like', '%' . $this->searchQuery . '%')
                ->orWhere('name_bn', 'like', '%' . $this->searchQuery . '%')
                ->orWhere('phone', 'like', '%' . $this->searchQuery . '%')
                ->orWhere('patient_id', 'like', '%' . $this->searchQuery . '%')
                ->limit(10)
                ->get();
            
            $this->showSearchResults = true;
            $this->showBloodGroups = false;
            $this->showSexOptions = false;
        } else {
            // Show 20 most recent patient registrations by default
            $this->searchResults = Patient::orderBy('created_at', 'desc')
                ->limit(20)
                ->get();
            $this->showSearchResults = true;
        }
    }
    
    public function toggleBloodGroups()
    {
        $this->showBloodGroups = !$this->showBloodGroups;
        $this->showSearchResults = false;
        $this->showSexOptions = false;
    }
    
    public function selectBloodGroup($bloodGroup)
    {
        $this->blood_group = $bloodGroup;
        $this->showBloodGroups = false;
    }
    
    public function toggleSexOptions()
    {
        $this->showSexOptions = !$this->showSexOptions;
        $this->showSearchResults = false;
        $this->showBloodGroups = false;
    }
    
    public function selectSex($sex)
    {
        $this->gender = $sex;
        $this->showSexOptions = false;
    }

    public function selectPatient($patientId)
    {
        $patient = Patient::find($patientId);
        if ($patient) {
            $this->fillPatientData($patient);
            $this->showSearchResults = false;
            $this->searchQuery = '';
        }
    }

    public function fillPatientData($patient)
    {
        $this->patient_id_hidden = $patient->id;
        $this->name_en = $patient->name_en;
        $this->phone = $patient->phone;
        $this->address = $patient->address;
        $this->dob = $patient->dob;
        
        // Calculate age from DOB if available
        if ($patient->dob) {
            $this->calculateAge();
        }
        
        $this->gender = $patient->gender;
        $this->blood_group = $patient->blood_group;
    }

    public function save()
    {
        $this->validate();

        try {
            $patient = Patient::create([
                'patient_id' => $this->patient_id,
                'name_en' => $this->name_en,
                'phone' => $this->phone,
                'address' => $this->address,
                'dob' => $this->dob,
                'gender' => $this->gender,
                'blood_group' => $this->blood_group,
                'reg_fee' => $this->reg_fee,
                'reg_date' => $this->reg_date,
            ]);

            // Show success notification using dispatch
            $this->dispatch('show-success', 'Patient registered successfully! Patient ID: ' . $this->patient_id);
            
            // Reset form
            $this->reset(['name_en', 'phone', 'address', 'dob', 'age_year', 'age_month', 'age_day', 'gender', 'blood_group', 'reg_fee']);
            $this->patient_id = $this->generatePatientId();
            
            // Reload recent patients
            $this->searchResults = Patient::orderBy('created_at', 'desc')
                ->limit(20)
                ->get();
            $this->showSearchResults = true;
            
        } catch (\Exception $e) {
            $this->dispatch('show-error', 'Error registering patient: ' . $e->getMessage());
        }
    }


    
    public function render()
    {
        return view('livewire.patient-registration');
    }
} 