<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Invoice;
use App\Models\LabTestOrder;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class InvestigationReportingAllReporting extends Component
{
    use WithPagination;

    public $searchDate = '';
    public $searchInvoiceNo = '';
    public $searchDepartmentId = '';
    public $selectedInvoiceId = null;
    public $selectedInvoice = null;
    public $departments = [];
    public $userDepartmentId = null;
    
    // Patient form fields
    public $patientName = '';
    public $patientAge = '';
    public $patientSex = '';
    public $patientId = '';
    public $invoiceNo = '';
    public $doctorCode = '';
    public $doctorName = '';
    public $remarks = '';
    public $inchargeCode = '';
    public $inchargeName = '';
    public $checkedByCode = '';
    public $checkedByName = '';
    
    // Search fields
    public $searchDoctorCode = '';
    public $searchInchargeCode = '';
    public $searchCheckedByCode = '';
    public $searchResults = [];
    public $searchType = ''; // 'doctor', 'incharge', 'checked'
    
    // Test results
    public $testResults = [];

    protected $paginationTheme = 'bootstrap';

    public function mount($userDepartmentId = null)
    {
        $this->departments = Department::where('status', 'active')->get();
        $this->userDepartmentId = $userDepartmentId;
        
        // Set today's date as default
        $this->searchDate = now()->format('Y-m-d');
        
        // Auto-select user's department
        if ($userDepartmentId) {
            $this->searchDepartmentId = $userDepartmentId;
        }
    }

    public function updatedSearchDate()
    {
        $this->resetPage();
    }

    public function updatedSearchInvoiceNo()
    {
        $this->resetPage();
    }

    public function updatedSearchDepartmentId()
    {
        $this->resetPage();
    }
    
    public function searchDoctor()
    {
        $this->searchType = 'doctor';
        $this->searchResults = \App\Models\User::where('code', 'like', '%' . $this->searchDoctorCode . '%')
            ->orWhere('name', 'like', '%' . $this->searchDoctorCode . '%')
            ->limit(10)
            ->get();
    }
    
    public function searchIncharge()
    {
        $this->searchType = 'incharge';
        $this->searchResults = \App\Models\User::where('code', 'like', '%' . $this->searchInchargeCode . '%')
            ->orWhere('name', 'like', '%' . $this->searchInchargeCode . '%')
            ->limit(10)
            ->get();
    }
    
    public function searchCheckedBy()
    {
        $this->searchType = 'checked';
        $this->searchResults = \App\Models\User::where('code', 'like', '%' . $this->searchCheckedByCode . '%')
            ->orWhere('name', 'like', '%' . $this->searchCheckedByCode . '%')
            ->limit(10)
            ->get();
    }
    
    public function selectUser($userId, $type)
    {
        $user = \App\Models\User::find($userId);
        if ($user) {
            switch ($type) {
                case 'doctor':
                    $this->doctorCode = $user->code ?? $user->id;
                    $this->doctorName = $user->name;
                    break;
                case 'incharge':
                    $this->inchargeCode = $user->code ?? $user->id;
                    $this->inchargeName = $user->name;
                    break;
                case 'checked':
                    $this->checkedByCode = $user->code ?? $user->id;
                    $this->checkedByName = $user->name;
                    break;
            }
        }
        $this->searchResults = [];
        $this->searchType = '';
        $this->searchDoctorCode = '';
        $this->searchInchargeCode = '';
        $this->searchCheckedByCode = '';
    }

    public function selectInvoice($invoiceId)
    {
        $this->selectedInvoiceId = $invoiceId;
        $this->selectedInvoice = Invoice::with([
            'patient', 
            'labTestOrders.labTest.department',
            'labTestOrders.labTest.parameters',
            'labTestOrders.referredBy', // Load referring doctor
                            'labTestOrders' => function($query) {
                    $query->with(['labTestResults' => function($q) {
                        $q->with(['checkedBy', 'inchargeBy']);
                    }]);
                }
        ])->find($invoiceId);
        
        // Debug: Log the selected invoice
        \Log::info('Invoice selected:', [
            'invoice_id' => $invoiceId,
            'patient' => $this->selectedInvoice->patient ?? 'No patient',
            'lab_test_orders_count' => $this->selectedInvoice->labTestOrders->count()
        ]);
        
        // Populate patient form fields
        if ($this->selectedInvoice && $this->selectedInvoice->patient) {
            $this->patientName = $this->selectedInvoice->patient->name_en ?? '';
            
            // Calculate age from DOB
            if ($this->selectedInvoice->patient->dob) {
                $dob = \Carbon\Carbon::parse($this->selectedInvoice->patient->dob);
                $this->patientAge = $dob->age;
            } else {
                $this->patientAge = '';
            }
            
            // Set gender with proper mapping
            $gender = $this->selectedInvoice->patient->gender ?? '';
            if ($gender) {
                // Map database gender values to form values
                switch (strtolower(trim($gender))) {
                    case 'male':
                    case 'm':
                        $this->patientSex = 'male';
                        break;
                    case 'female':
                    case 'f':
                        $this->patientSex = 'female';
                        break;
                    default:
                        $this->patientSex = '';
                }
            } else {
                $this->patientSex = '';
            }
            $this->patientId = $this->selectedInvoice->patient->patient_id ?? '';
            $this->searchInvoiceNo = $this->selectedInvoice->invoice_no ?? '';
            
            // Debug: Log the patient data
            \Log::info('Patient data populated:', [
                'name' => $this->patientName,
                'age' => $this->patientAge,
                'sex' => $this->patientSex,
                'id' => $this->patientId,
                'invoice_no' => $this->searchInvoiceNo
            ]);
        }
        
        // Populate doctor info from first lab test order
        $firstOrder = $this->selectedInvoice->labTestOrders->first();
        if ($firstOrder && $firstOrder->referredBy) {
            $this->doctorCode = $firstOrder->referredBy->code ?? $firstOrder->referredBy->id ?? '';
            $this->doctorName = $firstOrder->referredBy->name ?? '';
            
            // Debug: Log the doctor data
            \Log::info('Doctor data populated:', [
                'code' => $this->doctorCode,
                'name' => $this->doctorName,
                'referred_by_id' => $firstOrder->referred_by
            ]);
        } else {
            // Debug: Log if no referred by data
            \Log::info('No referred by data found:', [
                'first_order' => $firstOrder ? $firstOrder->id : 'No order',
                'referred_by' => $firstOrder ? $firstOrder->referred_by : 'No referred_by'
            ]);
        }
        
        // Check if any test results exist to populate incharge/checked by
        $existingResults = \App\Models\LabTestResult::whereIn('lab_test_order_id', $this->selectedInvoice->labTestOrders->pluck('id'))
            ->with(['checkedBy', 'inchargeBy'])
            ->first();
            
        if ($existingResults) {
            // Load incharge data (default to current user if not set)
            if ($existingResults->inchargeBy) {
                $this->inchargeCode = $existingResults->inchargeBy->code ?? $existingResults->inchargeBy->id ?? '';
                $this->inchargeName = $existingResults->inchargeBy->name ?? '';
            } else {
                // Default to current user
                $this->inchargeCode = auth()->user()->code ?? auth()->user()->id ?? '';
                $this->inchargeName = auth()->user()->name ?? '';
            }
            
            // Load checked by data (can be null)
            if ($existingResults->checkedBy) {
                $this->checkedByCode = $existingResults->checkedBy->code ?? $existingResults->checkedBy->id ?? '';
                $this->checkedByName = $existingResults->checkedBy->name ?? '';
            } else {
                // Leave empty if not set
                $this->checkedByCode = '';
                $this->checkedByName = '';
            }
            
            $this->remarks = $existingResults->remarks ?? '';
        } else {
            // Set defaults for new results
            $this->inchargeCode = auth()->user()->code ?? auth()->user()->id ?? '';
            $this->inchargeName = auth()->user()->name ?? '';
            $this->checkedByCode = '';
            $this->checkedByName = '';
            $this->remarks = '';
        }
        
        // Initialize test results array for each parameter
        $this->testResults = [];
        foreach ($this->filteredTests as $order) {
            foreach ($order->labTest->parameters as $parameter) {
                $key = $order->id . '_' . $parameter->id;
                
                // Check if result already exists
                $existingResult = \App\Models\LabTestResult::where('lab_test_order_id', $order->id)
                    ->where('lab_test_parameter_id', $parameter->id)
                    ->first();
                
                $this->testResults[$key] = [
                    'order_id' => $order->id,
                    'parameter_id' => $parameter->id,
                    'result' => $existingResult ? $existingResult->result_value : ($parameter->default_result ?? ''),
                    'unit' => $parameter->unit ?? ''
                ];
            }
        }
        
        // Force Livewire to update the view
        $this->dispatch('$refresh');
    }

    public function clearSelection()
    {
        $this->selectedInvoiceId = null;
        $this->selectedInvoice = null;
        $this->resetPatientFields();
    }
    
    private function resetPatientFields()
    {
        $this->patientName = '';
        $this->patientAge = '';
        $this->patientSex = '';
        $this->patientId = '';
        $this->searchInvoiceNo = '';
        $this->doctorCode = '';
        $this->doctorName = '';
        $this->remarks = '';
        $this->inchargeCode = '';
        $this->inchargeName = '';
        $this->checkedByCode = '';
        $this->checkedByName = '';
        $this->testResults = [];
    }
    
    private function saveTestResults($showNotification = true)
    {
        // Get user IDs for incharge and checked by
        $inchargeUserId = $this->getUserIdByCode($this->inchargeCode) ?? auth()->id(); // Default to current user
        $checkedByUserId = $this->getUserIdByCode($this->checkedByCode); // Can be null
        
        // Save logic for test results
        foreach ($this->testResults as $key => $data) {
            if (!empty($data['result'])) {
                // Check if result already exists
                $existingResult = \App\Models\LabTestResult::where('lab_test_order_id', $data['order_id'])
                    ->where('lab_test_parameter_id', $data['parameter_id'])
                    ->first();
                
                if ($existingResult) {
                    $existingResult->update([
                        'result_value' => $data['result'],
                        'status' => 'tested',
                        'report_date' => now(),
                        'checked_by' => $checkedByUserId ?? auth()->id(),
                        'incharge_by' => $inchargeUserId,
                        'updated_by' => auth()->id(),
                        'remarks' => $this->remarks ?? ''
                    ]);
                } else {
                    \App\Models\LabTestResult::create([
                        'lab_test_order_id' => $data['order_id'],
                        'lab_test_parameter_id' => $data['parameter_id'],
                        'result_value' => $data['result'],
                        'status' => 'tested',
                        'report_date' => now(),
                        'checked_by' => $checkedByUserId ?? auth()->id(),
                        'incharge_by' => $inchargeUserId,
                        'created_by' => auth()->id(),
                        'remarks' => $this->remarks ?? ''
                    ]);
                }
            }
        }
        
        // Save form data to lab test orders
        if ($this->selectedInvoice) {
            foreach ($this->selectedInvoice->labTestOrders as $order) {
                $order->update([
                    'referred_by' => $this->getUserIdByCode($this->doctorCode),
                    'updated_by' => auth()->id()
                ]);
            }
        }
        
        // Debug: Log the save operation
        \Log::info('Report saved:', [
            'invoice_id' => $this->selectedInvoiceId,
            'doctor_code' => $this->doctorCode,
            'incharge_code' => $this->inchargeCode,
            'checked_by_code' => $this->checkedByCode,
            'test_results_count' => count($this->testResults),
            'remarks' => $this->remarks,
            'remarks_length' => strlen($this->remarks ?? ''),
            'remarks_type' => gettype($this->remarks)
        ]);
        
        // Show success notification if requested
        if ($showNotification) {
            $this->dispatch('show-success', 'Report saved successfully!');
        }
        
        // Reload the page after successful save
        $this->dispatch('$refresh');
    }
    
    public function saveReport()
    {
        $this->saveTestResults(true);
    }
    
    private function getUserIdByCode($code)
    {
        if (empty($code)) return null;
        
        // First try to find by code
        $user = \App\Models\User::where('code', $code)->first();
        if ($user) {
            return $user->id;
        }
        
        // If not found by code, try by ID (in case code is actually an ID)
        if (is_numeric($code)) {
            $user = \App\Models\User::find($code);
            if ($user) {
                return $user->id;
            }
        }
        
        return null;
    }
    
    public function saveAndPrintReport()
    {
        // Save the report first
        $this->saveTestResults(false);
        
        // Show success message and trigger print
        if ($this->selectedInvoiceId) {
            $this->dispatch('show-success', 'Report saved successfully!');
            $this->dispatch('trigger-print', ['invoiceId' => $this->selectedInvoiceId]);
        } else {
            $this->dispatch('show-error', 'Please select an invoice to print');
        }
    }
    
    public function viewReport()
    {
        // Do nothing for now
        $this->dispatch('show-success', 'View functionality removed');
    }

    public function printReport()
    {
        if ($this->selectedInvoiceId) {
            // Redirect to print view
            return redirect()->route('admin.investigation-reporting.print-report', ['invoiceId' => $this->selectedInvoiceId]);
        } else {
            $this->dispatch('show-error', 'Please select an invoice to print');
        }
    }
    
    public function exitPage()
    {
        return redirect()->route('admin.investigation-reporting.all-reporting');
    }

    public function getInvoicesProperty()
    {
        $query = Invoice::with(['patient'])
            ->where('invoice_type', 'dia') // Only diagnostic invoices
            ->withCount(['labTestOrders as test_count'])
            ->with(['labTestOrders' => function($q) {
                $q->select('invoice_id', 'lab_test_id')
                    ->with(['labTest:id,department_id']);
            }]);

        // Search by date
        if ($this->searchDate) {
            $query->whereDate('invoice_date', $this->searchDate);
        }

        // Search by invoice number
        if ($this->searchInvoiceNo) {
            $query->where('invoice_no', 'like', '%' . $this->searchInvoiceNo . '%');
        }

        // Filter by department
        if ($this->searchDepartmentId) {
            $query->whereHas('labTestOrders.labTest', function($q) {
                $q->where('department_id', $this->searchDepartmentId);
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }

    public function getFilteredTestsProperty()
    {
        if (!$this->selectedInvoice) {
            return collect();
        }

        $tests = $this->selectedInvoice->labTestOrders;

        // Filter by department if selected
        if ($this->searchDepartmentId) {
            $tests = $tests->filter(function($order) {
                return $order->labTest->department_id == $this->searchDepartmentId;
            });
        }

        return $tests;
    }

    public function render()
    {
        return view('livewire.investigation-reporting-all-reporting', [
            'invoices' => $this->invoices,
            'filteredTests' => $this->filteredTests
        ]);
    }
}