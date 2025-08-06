<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\AgeCalculator;
use App\Helpers\DiagnosisInvoiceHelper;
use App\Helpers\PatientIdHelper;
use App\Helpers\LabTestOrderHelper;

class DiagnosticsInvoice extends Component
{
    use WithFileUploads, AgeCalculator;

    // Patient Information
    public $patient_id = '';
    public $patient_name = '';
    public $patient_phone = '';
    public $patient_address = '';
    public $age_years = '';
    public $age_months = '';
    public $age_days = '';
    public $gender = '';

    // Invoice Details
    public $invoice_date = '';
    public $ticket_id = '';
    public $doctor_id = '';
    public $referred_by = '';

    // Test Items
    public $testItems = [];
    public $collectionKitItems = [];

    // Invoice Summary
    public $totalAmount = 0;
    public $discountPercent = 0;
    public $discountAmount = 0;
    public $netPayable = 0;
    public $paidAmount = 0;
    public $dueAmount = 0;
    public $remarks = '';

    // Search functionality
    public $patientSearch = '';
    public $ticketSearch = '';
    public $doctorSearch = '';
    public $pcpSearch = '';
    public $labTestSearch = '';
    public $genderSearch = '';
    
    // Search results
    public $searchResults = [];
    public $searchType = '';

    // UI states
    public $showSuccess = false;
    public $showError = false;
    public $successMessage = '';
    public $errorMessage = '';
    public $isSaving = false;

    protected $rules = [
        'patient_name' => 'required|string|max:255',
        'patient_phone' => 'required|string|max:20',
        'patient_address' => 'nullable|string|max:500',
        'age_years' => 'nullable|integer|min:0|max:150',
        'age_months' => 'nullable|integer|min:0|max:12',
        'age_days' => 'nullable|integer|min:0|max:31',
        'gender' => 'required|string|max:10',
        'invoice_date' => 'required|date',
        'remarks' => 'nullable|string|max:500',
    ];

    public function mount()
    {
        $this->invoice_date = date('Y-m-d');
        $this->patient_phone = ''; // Remove default contact value
        $this->gender = ''; // Initialize gender as empty string
        $this->calculateDueAmount();
        
        // Load default recent patients when component mounts
        $this->loadDefaultPatients();
    }

    public function loadDefaultPatients()
    {
        $patients = DB::table('patients')
            ->select('*')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        $this->searchResults = $patients;
        $this->searchType = 'Patient';
        
        // Update search title
        $this->dispatch('updateSearchTitle', title: 'Recent Patients');
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'discountPercent') {
            $this->calculateDiscount();
        } elseif ($propertyName === 'discountAmount') {
            $this->calculateDiscountPercent();
        } elseif ($propertyName === 'paidAmount') {
            $this->calculateDueAmount();
        } elseif (in_array($propertyName, ['patientSearch', 'ticketSearch', 'doctorSearch', 'pcpSearch', 'labTestSearch', 'genderSearch'])) {
            $this->handleSearch($propertyName);
        }
        
        // Clear validation errors when user starts typing
        if (in_array($propertyName, ['patient_name', 'patient_phone', 'gender', 'pcpSearch'])) {
            $this->resetValidation($propertyName);
        }
    }
    
    public function handleSearch($searchType)
    {
        $searchTerm = $this->{$searchType};
        
        if ($searchType === 'genderSearch') {
            // For gender search, show options immediately
            $this->searchGenders();
        } elseif (strlen($searchTerm) >= 2) {
            switch ($searchType) {
                case 'patientSearch':
                    $this->searchPatients($searchTerm);
                    break;
                case 'ticketSearch':
                    $this->searchTickets($searchTerm);
                    break;
                case 'doctorSearch':
                    $this->searchDoctors($searchTerm);
                    break;
                case 'pcpSearch':
                    $this->searchPcps($searchTerm);
                    break;
                case 'labTestSearch':
                    $this->searchLabTests($searchTerm);
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
            
        $this->searchResults = $patients;
        $this->searchType = 'Patient';
        
        // Update search title
        $this->dispatch('updateSearchTitle', title: "Search Results for '{$searchTerm}'");
    }

    public function searchTickets($searchTerm)
    {
        $tickets = DB::table('consultant_tickets')
            ->join('patients', 'consultant_tickets.patient_id', '=', 'patients.id')
            ->leftJoin('users as doctors', 'consultant_tickets.doctor_id', '=', 'doctors.id')
            ->select([
                'consultant_tickets.*',
                'patients.name as patient_name',
                'patients.patient_id as patient_code',
                'doctors.name as doctor_name',
                'doctors.code as doctor_code'
            ])
            ->where(function($query) use ($searchTerm) {
                $query->where('consultant_tickets.ticket_no', 'like', "%{$searchTerm}%")
                      ->orWhere('patients.name', 'like', "%{$searchTerm}%")
                      ->orWhere('patients.patient_id', 'like', "%{$searchTerm}%")
                      ->orWhere('doctors.name', 'like', "%{$searchTerm}%")
                      ->orWhere('doctors.code', 'like', "%{$searchTerm}%");
            })
            ->orderBy('consultant_tickets.ticket_date', 'desc')
            ->orderBy('consultant_tickets.ticket_no', 'asc')
            ->limit(15)
            ->get();
            
        $this->searchResults = $tickets;
        $this->searchType = 'Ticket';
        
        // Update search title
        $this->dispatch('updateSearchTitle', title: "Search Results for '{$searchTerm}'");
    }

    public function searchDoctors($searchTerm)
    {
        $doctors = DB::table('users')
            ->where('code', 'like', 'DR%')
            ->where(function($query) use ($searchTerm) {
                $query->where('code', 'like', "%{$searchTerm}%")
                      ->orWhere('name', 'like', "%{$searchTerm}%");
            })
            ->limit(10)
            ->get();
            
        $this->searchResults = $doctors;
        $this->searchType = 'Doctor';
        
        // Update search title
        $this->dispatch('updateSearchTitle', title: "Search Results for '{$searchTerm}'");
    }

    public function searchPcps($searchTerm)
    {
        try {
            // First try to find users with PCP prefix
            $pcps = DB::table('users')
                ->where('code', 'like', 'PCP%')
                ->where(function($query) use ($searchTerm) {
                    $query->where('code', 'like', "%{$searchTerm}%")
                          ->orWhere('name', 'like', "%{$searchTerm}%");
                })
                ->limit(10)
                ->get();
            
            // If no PCP users found, search for any users that might be PCPs
            if ($pcps->isEmpty()) {
                $pcps = DB::table('users')
                    ->where(function($query) use ($searchTerm) {
                        $query->where('code', 'like', "%{$searchTerm}%")
                              ->orWhere('name', 'like', "%{$searchTerm}%");
                    })
                    ->where('code', '!=', '') // Exclude empty codes
                    ->limit(10)
                    ->get();
            }
                
            $this->searchResults = $pcps;
            $this->searchType = 'PCP';
            
            // Update search title
            $this->dispatch('updateSearchTitle', title: "Search Results for '{$searchTerm}'");
        } catch (\Exception $e) {
            \Log::error('Error searching PCPs: ' . $e->getMessage());
            $this->searchResults = [];
            $this->searchType = '';
            $this->dispatch('show-error', 'Error searching PCPs. Please try again.');
        }
    }

    public function searchLabTests($searchTerm)
    {
        $tests = DB::table('lab_tests')
            ->join('departments', 'lab_tests.department_id', '=', 'departments.id')
            ->select([
                'lab_tests.*',
                'departments.name as department_name'
            ])
            ->where(function($query) use ($searchTerm) {
                $query->where('lab_tests.code', 'like', "%{$searchTerm}%")
                      ->orWhere('lab_tests.name', 'like', "%{$searchTerm}%")
                      ->orWhere('departments.name', 'like', "%{$searchTerm}%");
            })
            ->limit(10)
            ->get();
            
        $this->searchResults = $tests;
        $this->searchType = 'Lab Test';
        
        // Update search title
        $this->dispatch('updateSearchTitle', title: "Search Results for '{$searchTerm}'");
    }

    public function searchGenders()
    {
        $genders = [
            ['id' => 'Male', 'name' => 'Male', 'code' => 'M'],
            ['id' => 'Female', 'name' => 'Female', 'code' => 'F'],
            ['id' => 'Other', 'name' => 'Other', 'code' => 'O']
        ];
            
        $this->searchResults = collect($genders);
        $this->searchType = 'Gender';
        
        // Update search title
        $this->dispatch('updateSearchTitle', title: 'Select Gender');
    }

    public function calculateDiscount()
    {
        $this->discountAmount = ($this->totalAmount * $this->discountPercent / 100);
        $this->calculateNetPayable();
    }

    public function calculateDiscountPercent()
    {
        if ($this->totalAmount > 0) {
            $this->discountPercent = ($this->discountAmount * 100 / $this->totalAmount);
        } else {
            $this->discountPercent = 0;
        }
        $this->calculateNetPayable();
    }

    public function calculateNetPayable()
    {
        $this->netPayable = max(0, $this->totalAmount - $this->discountAmount);
        // Set paid amount equal to net payable by default
        $this->paidAmount = $this->netPayable;
        $this->calculateDueAmount();
    }

    public function calculateDueAmount()
    {
        $this->dueAmount = max(0, $this->netPayable - $this->paidAmount);
    }

    public function calculateTotalAmount()
    {
        $total = 0;
        
        // Calculate from test items
        foreach ($this->testItems as $item) {
            $total += ($item['charge'] * $item['quantity']);
        }
        
        // Calculate from collection kit items
        foreach ($this->collectionKitItems as $item) {
            $total += ($item['charge'] * $item['quantity']);
        }
        
        $this->totalAmount = $total;
        $this->calculateNetPayable();
    }

    public function addTestItem($testData)
    {
        // Check if test already exists
        $existingIndex = collect($this->testItems)->search(function($item) use ($testData) {
            return $item['id'] == $testData['id'];
        });

        if ($existingIndex !== false) {
            // Update quantity of existing item
            $this->testItems[$existingIndex]['quantity']++;
        } else {
            // Add new test item
            $this->testItems[] = [
                'id' => $testData['id'],
                'code' => $testData['code'],
                'name' => $testData['name'],
                'charge' => $testData['charge'],
                'delivery_date' => date('Y-m-d', strtotime('+1 day')),
                'quantity' => 1,
                'total' => $testData['charge']
            ];
        }

        // Auto-add collection kits for this test
        $this->autoAddCollectionKits($testData['id']);

        $this->calculateTotalAmount();
    }

    public function autoAddCollectionKits($testId)
    {
        try {
            // Get collection kits associated with this lab test
            $collectionKits = DB::table('lab_test_collection_kit')
                ->join('collection_kits', 'lab_test_collection_kit.collection_kit_id', '=', 'collection_kits.id')
                ->where('lab_test_collection_kit.lab_test_id', $testId)
                ->select('collection_kits.*')
                ->get();

            foreach ($collectionKits as $kit) {
                // Check if kit already exists in collection kit items
                $existingIndex = collect($this->collectionKitItems)->search(function($item) use ($kit) {
                    return $item['id'] == $kit->id;
                });

                if ($existingIndex === false) {
                    // Add new collection kit item
                    $this->collectionKitItems[] = [
                        'id' => $kit->id,
                        'code' => $kit->pcode,
                        'name' => $kit->name,
                        'charge' => $kit->charge,
                        'color' => $kit->color,
                        'quantity' => 1,
                        'total' => $kit->charge
                    ];
                } else {
                    // If kit already exists, we don't increase quantity
                    // This ensures same collection kit appears only once
                    // even if multiple lab tests require it
                }
            }
        } catch (\Exception $e) {
            \Log::error('Error auto-adding collection kits: ' . $e->getMessage());
            // Don't throw error, just log it and continue
        }
    }

    public function addCollectionKit($kitData)
    {
        // Check if kit already exists
        $existingIndex = collect($this->collectionKitItems)->search(function($item) use ($kitData) {
            return $item['id'] == $kitData['id'];
        });

        if ($existingIndex !== false) {
            // Update quantity of existing item
            $this->collectionKitItems[$existingIndex]['quantity']++;
        } else {
            // Add new collection kit item
            $this->collectionKitItems[] = [
                'id' => $kitData['id'],
                'code' => $kitData['pcode'],
                'name' => $kitData['name'],
                'charge' => $kitData['charge'],
                'color' => $kitData['color'],
                'quantity' => 1,
                'total' => $kitData['charge']
            ];
        }

        $this->calculateTotalAmount();
    }

    public function updateTestItemQuantity($index, $quantity)
    {
        if (isset($this->testItems[$index])) {
            $this->testItems[$index]['quantity'] = max(1, $quantity);
            $this->testItems[$index]['total'] = $this->testItems[$index]['charge'] * $this->testItems[$index]['quantity'];
            $this->calculateTotalAmount();
        }
    }

    public function updateCollectionKitQuantity($index, $quantity)
    {
        if (isset($this->collectionKitItems[$index])) {
            $this->collectionKitItems[$index]['quantity'] = max(1, $quantity);
            $this->collectionKitItems[$index]['total'] = $this->collectionKitItems[$index]['charge'] * $this->collectionKitItems[$index]['quantity'];
            $this->calculateTotalAmount();
        }
    }

    public function removeTestItem($index)
    {
        if (isset($this->testItems[$index])) {
            unset($this->testItems[$index]);
            $this->testItems = array_values($this->testItems);
            $this->calculateTotalAmount();
        }
    }

    public function removeCollectionKit($index)
    {
        if (isset($this->collectionKitItems[$index])) {
            unset($this->collectionKitItems[$index]);
            $this->collectionKitItems = array_values($this->collectionKitItems);
            $this->calculateTotalAmount();
        }
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
            'gender' => $this->gender ?: null, // Handle empty gender safely
            'reg_date' => now(),
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function generatePatientId()
    {
        return PatientIdHelper::generatePatientIdConsistent();
    }

    public function selectPatient($patientId)
    {
        $patient = DB::table('patients')->find($patientId);
        if ($patient) {
            $this->patient_id = $patient->id;
            $this->patient_name = $patient->name;
            $this->patient_phone = $patient->phone;
            $this->patient_address = $patient->address;
            $this->patientSearch = $patient->patient_id;
            
            // Set gender from patient data safely
            $this->gender = $patient->gender ?? '';
            
            // Calculate age from DOB if available
            if ($patient->dob) {
                $age = $this->calculateAge($patient->dob);
                $this->age_years = $age['years'];
                $this->age_months = $age['months'];
                $this->age_days = $age['days'];
            }
            
            $this->searchResults = [];
        }
    }
    
    public function selectTicket($ticketId)
    {
        $ticket = DB::table('consultant_tickets')->find($ticketId);
        if ($ticket) {
            $this->ticket_id = $ticket->id;
            $this->ticketSearch = $ticket->ticket_no;
            $this->searchResults = [];
        }
    }
    
    public function selectDoctor($doctorId)
    {
        $doctor = DB::table('users')->find($doctorId);
        if ($doctor) {
            $this->doctor_id = $doctor->id;
            $this->doctorSearch = $doctor->code;
            $this->searchResults = [];
        }
    }
    
    public function selectPcp($pcpId)
    {
        try {
            $pcp = DB::table('users')->find($pcpId);
            if ($pcp) {
                $this->referred_by = $pcp->id;
                $this->pcpSearch = $pcp->code;
                $this->searchResults = [];
            } else {
                $this->dispatch('show-error', 'PCP not found. Please try again.');
            }
        } catch (\Exception $e) {
            \Log::error('Error selecting PCP: ' . $e->getMessage());
            $this->dispatch('show-error', 'Error selecting PCP. Please try again.');
        }
    }
    
    public function selectLabTest($testId)
    {
        $test = DB::table('lab_tests')->find($testId);
        if ($test) {
            $this->addTestItem([
                'id' => $test->id,
                'code' => $test->code,
                'name' => $test->name,
                'charge' => $test->charge,
                'delivery_date' => date('Y-m-d', strtotime('+1 day'))
            ]);
            $this->searchResults = [];
            $this->labTestSearch = ''; // Clear the search field
        }
    }

    public function selectGender($genderValue)
    {
        $this->gender = $genderValue;
        $this->genderSearch = $genderValue;
        $this->searchResults = [];
        $this->searchType = '';
    }

    public function clearPcpSelection()
    {
        $this->referred_by = null;
        $this->pcpSearch = '';
        $this->searchResults = [];
        $this->searchType = '';
        $this->dispatch('show-success', 'PCP selection cleared. Invoice can be saved without PCP.');
    }

    public function saveInvoice()
    {
        // Validate required fields
        if (empty($this->patient_name)) {
            $errorMessage = 'Patient name is required';
            \Log::info('Dispatching name error: ' . $errorMessage);
            $this->dispatch('show-error', $errorMessage);
            return null;
        }

        if (empty($this->patient_phone)) {
            $errorMessage = 'Patient contact number is required';
            \Log::info('Dispatching phone error: ' . $errorMessage);
            $this->dispatch('show-error', $errorMessage);
            return null;
        }

        if (empty($this->gender)) {
            $errorMessage = 'Patient gender is required';
            \Log::info('Dispatching gender error: ' . $errorMessage);
            $this->dispatch('show-error', $errorMessage);
            return null;
        }

        if (empty($this->testItems) && empty($this->collectionKitItems)) {
            $errorMessage = 'Please add at least one test or collection kit';
            \Log::info('Dispatching items error: ' . $errorMessage);
            $this->dispatch('show-error', $errorMessage);
            return null;
        }

        // Validate the form data with better error handling
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation errors:', $e->errors());
            
            $errorMessages = [];
            foreach ($e->errors() as $field => $errors) {
                $errorMessages[] = implode(', ', $errors);
            }
            $specificError = 'Please check the form data: ' . implode('; ', $errorMessages);
            \Log::info('Dispatching validation error: ' . $specificError);
            $this->dispatch('show-error', $specificError);
            return null;
        }

        try {
            DB::beginTransaction();

            // Handle patient creation if no patient is selected
            $patientId = $this->patient_id;
            if (!$patientId) {
                $patientId = $this->createNewPatient();
            }

            // Generate invoice number
            $invoiceNumber = DiagnosisInvoiceHelper::generateDiagnosisInvoiceNumber();

            // Create invoice with all required fields
            $invoiceId = DB::table('invoices')->insertGetId([
                'invoice_no' => $invoiceNumber,
                'patient_id' => $patientId,
                'invoice_type' => 'dia',
                'invoice_date' => $this->invoice_date,
                'total_amount' => $this->totalAmount,
                'payable_amount' => $this->netPayable,
                'paid_amount' => $this->paidAmount,
                'due_amount' => $this->dueAmount,
                'discount_percentage' => $this->discountPercent,
                'discount_amount' => $this->discountAmount,
                'payment_method' => 'cash',
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
                'remarks' => $this->remarks ?: null,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Save test items
            foreach ($this->testItems as $item) {
                DB::table('lab_test_orders')->insert([
                    'order_no' => LabTestOrderHelper::generateOrderNumber(),
                    'invoice_id' => $invoiceId,
                    'lab_test_id' => $item['id'],
                    'patient_id' => $patientId,
                    'referred_by' => $this->referred_by ?: null,
                    'charge' => $item['charge'],
                    'quantity' => $item['quantity'],
                    'status' => 'pending',
                    'collection_date' => $item['delivery_date'],
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // Save collection kit items
            foreach ($this->collectionKitItems as $item) {
                DB::table('invoice_collection_kit_items')->insert([
                    'invoice_id' => $invoiceId,
                    'collection_kit_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'charge' => $item['charge'],
                    'total' => $item['total'],
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            DB::commit();

            $this->dispatch('show-success', message: 'Invoice saved successfully! Invoice No: ' . $invoiceNumber);
            $this->resetForm();
            
            return $invoiceId;

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('DiagnosticsInvoice saveInvoice error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Log the specific error details
            \Log::error('Error details:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'code' => $e->getCode()
            ]);
            
            $errorMessage = 'Error saving invoice: ' . $e->getMessage();
            \Log::info('Dispatching error message: ' . $errorMessage);
            $this->dispatch('show-error', $errorMessage);
            return null;
        }
    }

    public function saveAndPrint()
    {
        \Log::info('saveAndPrint method called');
        
        // Save the invoice first and get the invoice ID
        $invoiceId = $this->saveInvoice();
        
        \Log::info('Invoice saved with ID: ' . $invoiceId);
        
        // After saving, trigger print with the saved invoice ID
        if ($invoiceId) {
            // Get the invoice number for the success message
            $invoice = DB::table('invoices')->where('id', $invoiceId)->first();
            $invoiceNumber = $invoice ? $invoice->invoice_no : 'Unknown';
            
            $this->dispatch('show-success', message: 'Invoice saved and ready for printing! Invoice No: ' . $invoiceNumber);
            
            $this->dispatch('openPrintWindow', invoiceId: $invoiceId);
            
            \Log::info('openPrintWindow event dispatched with invoiceId: ' . $invoiceId);
        } else {
            \Log::error('Failed to save invoice in saveAndPrint');
        }
    }

    public function testPrint()
    {
        $printUrl = route('admin.admin.invoice-templates.diagnosis-invoice', ['invoice_id' => 1]);
        \Log::info('Test print URL: ' . $printUrl);
        
        return redirect()->away($printUrl);
    }

    public function resetForm()
    {
        $this->reset([
            'patient_id', 'patient_name', 'patient_phone', 'patient_address', 'age_years', 'age_months', 'age_days',
            'gender', 'invoice_date', 'ticket_id', 'doctor_id',
            'referred_by', 'testItems', 'collectionKitItems', 'totalAmount',
            'discountPercent', 'discountAmount', 'netPayable', 'paidAmount', 'dueAmount', 'remarks',
            'patientSearch', 'ticketSearch', 'doctorSearch', 'pcpSearch', 'labTestSearch', 'genderSearch',
            'searchResults', 'searchType'
        ]);
        
        $this->invoice_date = date('Y-m-d');
        $this->patient_phone = ''; // Remove default contact value
        $this->gender = ''; // Reset gender to empty string
        $this->discountPercent = 0;
        $this->discountAmount = 0;
        $this->paidAmount = 0;
        $this->referred_by = null; // Ensure PCP is cleared
        $this->pcpSearch = ''; // Ensure PCP search is cleared
        
        // Reload recent patients after reset
        $this->loadDefaultPatients();
    }

    public function cancelForm()
    {
        return redirect()->route('admin.dashboard');
    }

    public function render()
    {
        return view('livewire.diagnostics-invoice');
    }
} 