<?php

namespace App\Livewire;

use App\Models\Patient;
use App\Models\SystemSetting;
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
        // Get system settings for patient ID generation
        $prefix = SystemSetting::getValue('patient_prefix', 'P');
        $startNumber = (int) SystemSetting::getValue('patient_start', '1');
        $format = SystemSetting::getValue('patient_format', 'prefix-yymmdd-number');
        
        // Default ID length since the setting was removed
        $idLength = 3;
        
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        $yy = date('y'); // 2-digit year
        $mm = date('m'); // 2-digit month
        $dd = date('d'); // 2-digit day
        
        // Determine reset period based on format
        $resetPeriod = $this->getResetPeriod($format);
        $lastPatient = $this->getLastPatientByPeriod($prefix, $resetPeriod);
        
        if ($lastPatient) {
            // Extract the number part from the last patient ID
            $lastPatientId = $lastPatient->patient_id;
            
            // Find the last number in the ID (after the date part)
            if (preg_match('/(\d{' . $idLength . '})$/', $lastPatientId, $matches)) {
                $lastNumber = intval($matches[1]);
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = $startNumber;
            }
        } else {
            // First patient of the period
            $newNumber = $startNumber;
        }
        
        $paddedNumber = str_pad($newNumber, $idLength, '0', STR_PAD_LEFT);
        
        // Handle all format variations
        switch ($format) {
            case 'prefix-yymmdd-number':
                return $prefix . '-' . $yy . $mm . $dd . '-' . $paddedNumber;
                
            case 'prefixyymmddnumber':
                return $prefix . $yy . $mm . $dd . $paddedNumber;
                
            case 'prefix-yymm-number':
                return $prefix . '-' . $yy . $mm . '-' . $paddedNumber;
                
            case 'prefixyymmnumber':
                return $prefix . $yy . $mm . $paddedNumber;
                
            case 'prefix-yy-number':
                return $prefix . '-' . $yy . '-' . $paddedNumber;
                
            case 'prefixyynumber':
                return $prefix . $yy . $paddedNumber;
                
            case 'prefix-number':
                return $prefix . '-' . $paddedNumber;
                
            case 'prefixnumber':
                return $prefix . $paddedNumber;
                
            default:
                // Default format (prefix-yymmdd-number)
                return $prefix . '-' . $yy . $mm . $dd . '-' . $paddedNumber;
        }
    }
    
    /**
     * Get the reset period based on format
     */
    private function getResetPeriod($format)
    {
        switch ($format) {
            case 'prefix-yymmdd-number':
            case 'prefixyymmddnumber':
                return 'daily'; // Reset every day
                
            case 'prefix-yymm-number':
            case 'prefixyymmnumber':
                return 'monthly'; // Reset every month
                
            case 'prefix-yy-number':
            case 'prefixyynumber':
                return 'yearly'; // Reset every year
                
            case 'prefix-number':
            case 'prefixnumber':
                return 'never'; // Never reset, continuous
                
            default:
                return 'daily';
        }
    }
    
    /**
     * Get the last patient based on reset period
     */
    private function getLastPatientByPeriod($prefix, $resetPeriod)
    {
        $query = Patient::where('patient_id', 'like', $prefix . '%');
        
        switch ($resetPeriod) {
            case 'daily':
                $query->whereDate('created_at', date('Y-m-d'));
                break;
                
            case 'monthly':
                $query->whereYear('created_at', date('Y'))
                      ->whereMonth('created_at', date('m'));
                break;
                
            case 'yearly':
                $query->whereYear('created_at', date('Y'));
                break;
                
            case 'never':
                // No date filter - continuous numbering
                break;
        }
        
        return $query->orderBy('patient_id', 'desc')->first();
    }

    public function updatedDob()
    {
        // Calculate age from DOB when DOB changes
        if ($this->dob) {
            $dob = new \DateTime($this->dob);
            $now = new \DateTime();
            $diff = $now->diff($dob);
            
            $this->age_year = $diff->y;
            $this->age_month = $diff->m;
            $this->age_day = $diff->d;
        } else {
            // Clear age fields if DOB is cleared
            $this->age_year = 0;
            $this->age_month = 0;
            $this->age_day = 0;
        }
        
        // Dispatch event for JavaScript
        $this->dispatch('dob-changed');
    }

    public function updatedAgeYear()
    {
        // Calculate DOB from age when age year changes
        $this->calculateDobFromAge();
    }

    public function updatedAgeMonth()
    {
        // Calculate DOB from age when age month changes
        $this->calculateDobFromAge();
    }

    public function updatedAgeDay()
    {
        // Calculate DOB from age when age day changes
        $this->calculateDobFromAge();
    }

    public function calculateAgeFromDob()
    {
        if ($this->dob) {
            $dob = new \DateTime($this->dob);
            $now = new \DateTime();
            $diff = $now->diff($dob);
            
            $this->age_year = $diff->y;
            $this->age_month = $diff->m;
            $this->age_day = $diff->d;
        }
    }

    public function calculateDobFromAge()
    {
        // Only calculate if original_dob is not checked
        if (!$this->original_dob && ((int)$this->age_year > 0 || (int)$this->age_month > 0 || (int)$this->age_day > 0)) {
            $now = new \DateTime();
            // Ensure age components are cast to int to prevent malformed DateInterval string
            $intervalString = 'P' . (int)$this->age_year . 'Y' . (int)$this->age_month . 'M' . (int)$this->age_day . 'D';
            $now->sub(new \DateInterval($intervalString));
            
            $this->dob = $now->format('Y-m-d');
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
            $dob = new \DateTime($patient->dob);
            $now = new \DateTime();
            $diff = $now->diff($dob);
            
            $this->age_year = $diff->y;
            $this->age_month = $diff->m;
            $this->age_day = $diff->d;
        } else {
            // Reset age fields to 0 if no DOB
            $this->age_year = 0;
            $this->age_month = 0;
            $this->age_day = 0;
        }
        
        $this->gender = $patient->gender;
        $this->blood_group = $patient->blood_group;
        $this->reg_fee = $patient->reg_fee ?? 0;
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
            $this->reset(['name_en', 'phone', 'address', 'dob', 'gender', 'blood_group', 'reg_fee']);
            $this->age_year = 0;
            $this->age_month = 0;
            $this->age_day = 0;
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