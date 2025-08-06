<?php

namespace App\Livewire;

use App\Models\Patient;
use App\Models\SystemSetting;
use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use App\Helpers\PatientIdHelper;
use Illuminate\Support\Facades\Auth;
use App\Traits\AgeCalculator;

class PatientRegistration extends Component
{
    use WithFileUploads, AgeCalculator;

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
        'dob' => 'nullable|date|nullable',
        'age_year' => 'nullable|integer|min:0|max:150',
        'age_month' => 'nullable|integer|min:0|max:12',
        'age_day' => 'nullable|integer|min:0|max:31',
        'gender' => 'required|string|in:Male,Female,Other',
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
        'gender.required' => 'Patient sex is required.',
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
        $this->phone = '';
        $this->dob = ''; // Initialize DOB
        
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
        if ($this->dob && trim($this->dob) !== '') {
            // Ensure DOB is in Y-m-d format
            $this->dob = Carbon::parse($this->dob)->format('Y-m-d');
            
            $age = $this->calculateAge($this->dob);
            
            $this->age_year = $age['years'];
            $this->age_month = $age['months'];
            $this->age_day = $age['days'];
        } else {
            $this->dob = null; // Set to null if empty
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
            $now = Carbon::now();
            $now->subYears((int)$this->age_year);
            $now->subMonths((int)$this->age_month);
            $now->subDays((int)$this->age_day);
            
            $this->dob = $now->format('Y-m-d');
        } else {
            $this->dob = null;
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
            
            // Show info notification
            $this->dispatch('show-alert', [
                'type' => 'info',
                'message' => 'Patient selected: ' . $patient->name . ' (ID: ' . $patient->patient_id . '). Form is now in view mode.'
            ]);
        }
    }

    public function fillPatientData($patient)
    {
        $this->name = $patient->name;
        $this->father_husband_name = $patient->father_husband_name;
        $this->phone = $patient->phone;
        $this->email = $patient->email;
        $this->address = $patient->address;
        $this->dob = $patient->dob ? Carbon::parse($patient->dob)->format('Y-m-d') : '';
        
        if ($patient->dob) {
            $age = $this->calculateAge($patient->dob);
            
            $this->age_year = $age['years'];
            $this->age_month = $age['months'];
            $this->age_day = $age['days'];
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
            $this->dispatch('show-alert', [
                'type' => 'warning',
                'message' => 'A patient is already selected. Please reset the form to create a new patient.'
            ]);
            return;
        }

        try {
            // Validate the form data
            $this->validate();
            
            // Generate patient ID
            $this->patient_id = PatientIdHelper::generatePatientIdConsistent();
            
            // Create the patient
            $patient = Patient::create([
                'patient_id' => $this->patient_id,
                'name' => $this->name,
                'father_husband_name' => $this->father_husband_name,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
                'dob' => $this->dob ?: null, // Convert empty string to null
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

            // Show success notification
            $this->dispatch('show-alert', [
                'type' => 'success',
                'message' => '✅ Patient Registration Successful!<br><br>Patient ID: ' . $this->patient_id . '<br>Patient Name: ' . $this->name . '<br><br>Patient has been registered successfully!'
            ]);
            $this->resetForm(false); // Pass false to prevent showing notification
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            $errorMessages = [];
            foreach ($e->errors() as $field => $errors) {
                $errorMessages[] = ucfirst($field) . ': ' . implode(', ', $errors);
            }
            $this->dispatch('show-alert', [
                'type' => 'error',
                'message' => '❌ Form Validation Failed!<br><br>Errors:<br>• ' . implode('<br>• ', $errorMessages) . '<br><br>Please fill in all required fields and try again.'
            ]);
            
        } catch (\Exception $e) {
            // Handle database errors
            $this->dispatch('show-alert', [
                'type' => 'error',
                'message' => '❌ Error registering patient!<br><br>Error: ' . $e->getMessage() . '<br><br>Please try again or contact support.'
            ]);
        }
    }

    public function resetForm($showNotification = true)
    {
        $this->reset(['name', 'father_husband_name', 'phone', 'email', 'address', 'dob', 'gender', 'blood_group', 'religion', 'occupation', 'reg_fee', 'nationality', 'patient_type']);
        $this->age_year = 0;
        $this->age_month = 0;
        $this->age_day = 0;
        $this->patient_id = PatientIdHelper::generatePatientIdConsistent();
        $this->isPatientSelected = false;
        
        $this->loadRecentPatients();
        
        // No notification shown when form is reset
    }


    

    
    /**
     * Get formatted DOB for display
     */
    public function getFormattedDobProperty()
    {
        return $this->dob && trim($this->dob) !== '' ? Carbon::parse($this->dob)->format('Y-m-d') : '';
    }

    public function render()
    {
        return view('livewire.patient-registration');
    }
} 