<?php

namespace App\Livewire;

use App\Models\Patient;
use App\Models\SystemSetting;
use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use App\Helpers\PatientIdHelper;
use Illuminate\Support\Facades\Auth;

class PatientRegistration extends Component
{
    use WithFileUploads;

    // Form fields
    public $reg_date;
    public $patient_id;
    public $name;
    public $father_husband_name;
    public $address;
    public $phone;
    public $email;
    public $dob;
    public $age_year;
    public $age_month;
    public $age_day;
    public $gender;
    public $blood_group;
    public $religion;
    public $occupation;
    public $reg_fee = 0;
    public $nationality;
    public $patient_type;

    // Search functionality
    public $searchQuery = '';
    public $searchResults = [];
    public $showSearchResults = false;
    public $isPatientSelected = false;
    
    // UI state
    public $showBloodGroups = false;
    public $showSexOptions = false;

    protected $rules = [
        'reg_date' => 'required|date',
        'name' => 'required|string|max:255',
        'father_husband_name' => 'nullable|string|max:255',
        'phone' => 'required|string|max:20',
        'email' => 'nullable|email|max:255',
        'address' => 'nullable|string|max:500',
        'dob' => 'nullable|date',
        'age_year' => 'nullable|integer|min:0|max:150',
        'age_month' => 'nullable|integer|min:0|max:12',
        'age_day' => 'nullable|integer|min:0|max:31',
        'gender' => 'nullable|string|in:Male,Female,Other',
        'blood_group' => 'nullable|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        'religion' => 'nullable|string|max:100',
        'occupation' => 'nullable|string|max:100',
        'reg_fee' => 'nullable|numeric|min:0',
        'nationality' => 'nullable|string|max:100',
        'patient_type' => 'nullable|string|max:50',
    ];

    protected $messages = [
        'name.required' => 'Patient name is required.',
        'phone.required' => 'Phone number is required.',
        'reg_date.required' => 'Registration date is required.',
        'reg_date.date' => 'Please enter a valid date.',
        'dob.date' => 'Please enter a valid date of birth.',
        'age_year.integer' => 'Age year must be a number.',
        'age_month.integer' => 'Age month must be a number.',
        'age_day.integer' => 'Age day must be a number.',
        'reg_fee.numeric' => 'Registration fee must be a number.',
        'email.email' => 'Please enter a valid email address.',
    ];

    public function mount()
    {
        $this->reg_date = date('Y-m-d');
        $this->patient_id = PatientIdHelper::generatePatientIdConsistent();
        $this->phone = '+88';
        
        $this->loadRecentPatients();
    }

    public function loadRecentPatients()
    {
        $this->searchResults = Patient::orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
        $this->showSearchResults = true;
    }

    public function updatedDob()
    {
        if ($this->dob) {
            $dob = new \DateTime($this->dob);
            $now = new \DateTime();
            $diff = $now->diff($dob);
            
            $this->age_year = $diff->y;
            $this->age_month = $diff->m;
            $this->age_day = $diff->d;
        } else {
            $this->age_year = 0;
            $this->age_month = 0;
            $this->age_day = 0;
        }
        
        $this->dispatch('dob-changed');
    }

    public function updatedAgeYear()
    {
        $this->calculateDobFromAge();
    }

    public function updatedAgeMonth()
    {
        $this->calculateDobFromAge();
    }

    public function updatedAgeDay()
    {
        $this->calculateDobFromAge();
    }

    public function calculateDobFromAge()
    {
        if ((int)$this->age_year > 0 || (int)$this->age_month > 0 || (int)$this->age_day > 0) {
            $now = new \DateTime();
            $intervalString = 'P' . (int)$this->age_year . 'Y' . (int)$this->age_month . 'M' . (int)$this->age_day . 'D';
            $now->sub(new \DateInterval($intervalString));
            
            $this->dob = $now->format('Y-m-d');
        }
    }

    public function searchPatients()
    {
        if (strlen($this->searchQuery) >= 2) {
            $this->searchResults = Patient::where('name', 'like', '%' . $this->searchQuery . '%')
                ->orWhere('father_husband_name', 'like', '%' . $this->searchQuery . '%')
                ->orWhere('phone', 'like', '%' . $this->searchQuery . '%')
                ->orWhere('patient_id', 'like', '%' . $this->searchQuery . '%')
                ->limit(10)
                ->get();
            
            $this->showSearchResults = true;
            $this->showBloodGroups = false;
            $this->showSexOptions = false;
        } else {
            $this->loadRecentPatients();
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
            $this->isPatientSelected = true;
        }
    }

    public function fillPatientData($patient)
    {
        $this->name = $patient->name;
        $this->father_husband_name = $patient->father_husband_name;
        $this->phone = $patient->phone;
        $this->email = $patient->email;
        $this->address = $patient->address;
        $this->dob = $patient->dob;
        
        if ($patient->dob) {
            $dob = new \DateTime($patient->dob);
            $now = new \DateTime();
            $diff = $now->diff($dob);
            
            $this->age_year = $diff->y;
            $this->age_month = $diff->m;
            $this->age_day = $diff->d;
        } else {
            $this->age_year = 0;
            $this->age_month = 0;
            $this->age_day = 0;
        }
        
        $this->gender = $patient->gender;
        $this->blood_group = $patient->blood_group;
        $this->religion = $patient->religion;
        $this->occupation = $patient->occupation;
        $this->reg_fee = $patient->reg_fee ?? 0;
        $this->nationality = $patient->nationality;
        $this->patient_type = $patient->patient_type;
    }

    public function save()
    {
        if ($this->isPatientSelected) {
            $this->dispatch('show-warning', 'A patient is already selected. Please reset the form to create a new patient.');
            return;
        }

        $this->validate();

        try {
            $this->patient_id = PatientIdHelper::generatePatientIdConsistent();
            
            $patient = Patient::create([
                'patient_id' => $this->patient_id,
                'name' => $this->name,
                'father_husband_name' => $this->father_husband_name,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
                'dob' => $this->dob,
                'gender' => $this->gender,
                'blood_group' => $this->blood_group,
                'religion' => $this->religion,
                'occupation' => $this->occupation,
                'reg_fee' => $this->reg_fee,
                'reg_date' => $this->reg_date,
                'nationality' => $this->nationality,
                'patient_type' => $this->patient_type,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            $this->dispatch('show-success', 'Patient registered successfully! Patient ID: ' . $this->patient_id);
            $this->resetForm();
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorMessages = [];
            foreach ($e->errors() as $field => $errors) {
                $errorMessages[] = $field . ': ' . implode(', ', $errors);
            }
            $this->dispatch('show-error', 'Validation failed: ' . implode('; ', $errorMessages));
        } catch (\Exception $e) {
            $this->dispatch('show-error', 'Error registering patient: ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->reset(['name', 'father_husband_name', 'phone', 'email', 'address', 'dob', 'gender', 'blood_group', 'religion', 'occupation', 'reg_fee', 'nationality', 'patient_type']);
        $this->age_year = 0;
        $this->age_month = 0;
        $this->age_day = 0;
        $this->patient_id = PatientIdHelper::generatePatientIdConsistent();
        $this->isPatientSelected = false;
        
        $this->loadRecentPatients();
    }

    public function render()
    {
        return view('livewire.patient-registration');
    }
} 