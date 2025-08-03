<div>
    <div class="row">
        <!-- Left Side - Patient Info -->
        <div class="col-md-4">
            <!-- Patient Information Card -->
            <div class="patient-info-card">
                <!-- Search Fields at Top -->
                <div class="row mb-2">
                    <div class="col-12">
                        <label class="form-label" style="font-size: 12px !important;">Date</label>
                        <input type="date" wire:model.live="searchDate" class="form-control patient-input" style="padding: 6px 10px !important; font-size: 13px !important; height: 32px !important;">
                    </div>
                </div>
                
                <div class="row mb-2">
                    <div class="col-6">
                        <label class="form-label" style="font-size: 12px !important;">Invoice/Serial No</label>
                                                 <input type="text" wire:model="searchInvoiceNo" 
                                class="form-control patient-input" 
                                placeholder="Invoice no..."
                                value="{{ $searchInvoiceNo }}"
                                style="padding: 6px 10px !important; font-size: 13px !important; height: 32px !important;">
                    </div>
                    <div class="col-6">
                        <label class="form-label" style="font-size: 12px !important;">Department</label>
                        <select wire:model.live="searchDepartmentId" class="form-control patient-input" style="padding: 6px 10px !important; font-size: 13px !important; height: 32px !important;">
                            <option value="">All Departments</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <hr class="my-2">
                
                <!-- Patient Fields -->
                <div class="row">
                    <div class="col-8">
                        <div class="mb-2">
                            <label class="form-label" style="font-size: 12px !important;">Name</label>
                                                         <input type="text" class="form-control patient-input" 
                                    wire:model="patientName"
                                    value="{{ $patientName }}"
                                    style="padding: 6px 10px !important; font-size: 13px !important; height: 32px !important;">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mb-2">
                            <label class="form-label" style="font-size: 12px !important;">Age</label>
                                                         <input type="number" class="form-control patient-input" 
                                    wire:model="patientAge"
                                    value="{{ $patientAge }}"
                                    style="padding: 6px 10px !important; font-size: 13px !important; height: 32px !important;">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <div class="mb-2">
                            <label class="form-label" style="font-size: 12px !important;">Sex</label>
                                                         <select class="form-control patient-input" wire:model="patientSex" style="padding: 6px 10px !important; font-size: 13px !important; height: 32px !important;">
                                 <option value="">Select Sex</option>
                                 <option value="male" {{ $patientSex == 'male' ? 'selected' : '' }}>Male</option>
                                 <option value="female" {{ $patientSex == 'female' ? 'selected' : '' }}>Female</option>
                                 <option value="other" {{ $patientSex == 'other' ? 'selected' : '' }}>Other</option>
                             </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-2">
                            <label class="form-label" style="font-size: 12px !important;">Patient ID</label>
                                                         <input type="text" class="form-control patient-input" 
                                    wire:model="patientId" readonly
                                    value="{{ $patientId }}"
                                    style="padding: 6px 10px !important; font-size: 13px !important; height: 32px !important;">
                        </div>
                    </div>
                </div>

                                 <div class="row">
                     <div class="col-4">
                         <div class="mb-2">
                             <label class="form-label" style="font-size: 12px !important;">Doctor Code</label>
                             <div class="position-relative">
                                 <input type="text" class="form-control patient-input" 
                                        wire:model.live.debounce.300ms="searchDoctorCode"
                                        wire:keyup="searchDoctor"
                                        placeholder="Search doctor..."
                                        value="{{ $doctorCode }}"
                                        style="padding: 6px 10px !important; font-size: 13px !important; height: 32px !important;">
                                 @if($searchType == 'doctor' && count($searchResults) > 0)
                                     <div class="position-absolute w-100 bg-white border rounded shadow-sm" style="z-index: 1000; max-height: 200px; overflow-y: auto;">
                                         @foreach($searchResults as $user)
                                             <div class="px-3 py-2 cursor-pointer hover:bg-gray-100" 
                                                  wire:click="selectUser({{ $user->id }}, 'doctor')"
                                                  style="cursor: pointer; border-bottom: 1px solid #eee;">
                                                 <small><strong>{{ $user->code ?? $user->id }}</strong> - {{ $user->name }}</small>
                                             </div>
                                         @endforeach
                                     </div>
                                 @endif
                             </div>
                         </div>
                     </div>
                     <div class="col-8">
                         <div class="mb-2">
                             <label class="form-label" style="font-size: 12px !important;">Name</label>
                             <input type="text" class="form-control patient-input" 
                                    wire:model="doctorName"
                                    value="{{ $doctorName }}"
                                    placeholder="Doctor name will auto-populate"
                                    style="padding: 6px 10px !important; font-size: 13px !important; height: 32px !important;">
                         </div>
                     </div>
                 </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="mb-2">
                            <label class="form-label" style="font-size: 12px !important;">Remarks For Report</label>
                            <textarea class="form-control patient-input" wire:model="remarks" rows="3" style="padding: 6px 10px !important; font-size: 13px !important;"></textarea>
                        </div>
                    </div>
                </div>
                
                                 <div class="row">
                     <div class="col-4">
                         <div class="mb-2">
                             <label class="form-label" style="font-size: 12px !important;">Incharge Code</label>
                             <div class="position-relative">
                                 <input type="text" class="form-control patient-input" 
                                        wire:model.live.debounce.300ms="searchInchargeCode"
                                        wire:keyup="searchIncharge"
                                        placeholder="Search incharge..."
                                        value="{{ $inchargeCode }}"
                                        style="padding: 6px 10px !important; font-size: 13px !important; height: 32px !important;">
                                 @if($searchType == 'incharge' && count($searchResults) > 0)
                                     <div class="position-absolute w-100 bg-white border rounded shadow-sm" style="z-index: 1000; max-height: 200px; overflow-y: auto;">
                                         @foreach($searchResults as $user)
                                             <div class=" px-3 py-2 cursor-pointer hover:bg-gray-100" 
                                                  wire:click="selectUser({{ $user->id }}, 'incharge')"
                                                  style="cursor: pointer; border-bottom: 1px solid #eee;">
                                                 <small><strong>{{ $user->code ?? $user->id }}</strong> - {{ $user->name }}</small>
                                             </div>
                                         @endforeach
                                     </div>
                                 @endif
                             </div>
                         </div>
                     </div>
                     <div class="col-8">
                         <div class="mb-2">
                             <label class="form-label" style="font-size: 12px !important;">Name</label>
                             <input type="text" class="form-control patient-input" 
                                    wire:model="inchargeName"
                                    value="{{ $inchargeName }}"
                                    placeholder="Incharge name will auto-populate"
                                    style="padding: 6px 10px !important; font-size: 13px !important; height: 32px !important;">
                         </div>
                     </div>
                 </div>
                 
                 <div class="row">
                     <div class="col-4">
                         <div class="mb-2">
                             <label class="form-label" style="font-size: 12px !important;">Checked By Code</label>
                             <div class="position-relative">
                                 <input type="text" class="form-control patient-input" 
                                        wire:model.live.debounce.300ms="searchCheckedByCode"
                                        wire:keyup="searchCheckedBy"
                                        placeholder="Search checked by..."
                                        value="{{ $checkedByCode }}"
                                        style="padding: 6px 10px !important; font-size: 13px !important; height: 32px !important;">
                                 @if($searchType == 'checked' && count($searchResults) > 0)
                                     <div class="position-absolute w-100 bg-white border rounded shadow-sm" style="z-index: 1000; max-height: 200px; overflow-y: auto;">
                                         @foreach($searchResults as $user)
                                             <div class="px-3 py-2 cursor-pointer hover:bg-gray-100" 
                                                  wire:click="selectUser({{ $user->id }}, 'checked')"
                                                  style="cursor: pointer; border-bottom: 1px solid #eee;">
                                                 <small><strong>{{ $user->code ?? $user->id }}</strong> - {{ $user->name }}</small>
                                             </div>
                                         @endforeach
                                     </div>
                                 @endif
                             </div>
                         </div>
                     </div>
                     <div class="col-8">
                         <div class="mb-2">
                             <label class="form-label" style="font-size: 12px !important;">Name</label>
                             <input type="text" class="form-control patient-input" 
                                    wire:model="checkedByName"
                                    value="{{ $checkedByName }}"
                                    placeholder="Checked by name will auto-populate"
                                    style="padding: 6px 10px !important; font-size: 13px !important; height: 32px !important;">
                         </div>
                     </div>
                 </div>
                
                <div class="row mt-3">
                    <div class="col-6">
                        <button wire:click="saveReport" class="btn btn-action btn-save w-100" style="padding: 6px 12px !important; font-size: 12px !important;">
                            <i class="fas fa-save me-1"></i>Save
                        </button>
                    </div>
                    <div class="col-6">
                        <button wire:click="saveAndPrintReport" class="btn btn-action btn-save-print w-100" style="padding: 6px 12px !important; font-size: 12px !important;">
                            <i class="fas fa-print me-1"></i>Save & Print
                        </button>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-6">
                        <button wire:click="printReport" class="btn btn-action btn-view w-100" style="padding: 6px 12px !important; font-size: 12px !important;">
                            <i class="fas fa-print me-1"></i>View Report
                        </button>
                    </div>
                    <div class="col-6">
                        <button wire:click="exitPage" class="btn btn-action btn-exit w-100" style="padding: 6px 12px !important; font-size: 12px !important;">
                            <i class="fas fa-times me-1"></i>Exit
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <script>
            // Listen for print trigger event
            document.addEventListener('livewire:init', () => {
                Livewire.on('trigger-print', (data) => {
                    // Create a hidden iframe to load the print page
                    const iframe = document.createElement('iframe');
                    iframe.style.display = 'none';
                    iframe.src = '{{ route("admin.investigation-reporting.print-report", ["invoiceId" => "INVOICE_ID"]) }}'.replace('INVOICE_ID', data.invoiceId);
                    
                    document.body.appendChild(iframe);
                    
                    // Wait for iframe to load, then print
                    iframe.onload = function() {
                        try {
                            iframe.contentWindow.print();
                        } catch (e) {
                            console.log('Print triggered');
                        }
                        
                        // Remove iframe after printing
                        setTimeout(() => {
                            document.body.removeChild(iframe);
                        }, 1000);
                    };
                });
            });
        </script>

        <!-- Right Side - Test Results or Search Results -->
        <div class="col-md-8">
            @if($selectedInvoice)
                <!-- Test Results Table -->
                <div class="test-results-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0" style="font-size: 16px !important;">
                            <i class="fas fa-flask me-2"></i>Test Reporting
                        </h5>
                        <div>
                            <span class="badge bg-info">Invoice: {{ $selectedInvoice->invoice_no }}</span>
                            <button wire:click="clearSelection" class="btn btn-sm btn-secondary ms-2">
                                <i class="fas fa-arrow-left"></i> Back
                            </button>
                        </div>
                    </div>

                    <!-- Test Results Table -->
                    <div class="table-responsive">
                        <table class="table lab-reporting-table">
                            <thead>
                                <tr>
                                    <th>Test Name</th>
                                    <th>Result</th>
                                    <th>Unit</th>
                                    <th>Normal Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($filteredTests as $order)
                                    @foreach($order->labTest->parameters as $parameter)
                                        <tr>
                                            <td>
                                                <div class="px-2 py-1">
                                                    <small class="text-muted">{{ $parameter->name_description }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" 
                                                       wire:model="testResults.{{ $order->id }}_{{ $parameter->id }}.result"
                                                       data-order-id="{{ $order->id }}"
                                                       data-parameter-id="{{ $parameter->id }}"
                                                       style="padding: 6px 10px !important; font-size: 13px !important; height: 32px !important;">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" 
                                                       wire:model="testResults.{{ $order->id }}_{{ $parameter->id }}.unit"
                                                       value="{{ $parameter->unit ?? '' }}"
                                                       style="padding: 6px 10px !important; font-size: 13px !important; height: 32px !important;">
                                            </td>
                                            <td>
                                                <span class="normal-value px-2 py-1">{{ $parameter->normal_value ?? '' }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">
                                            No tests found for this invoice
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <!-- Search Results Table -->
                <div class="test-results-card">
                    <h5 class="mb-4" style="font-size: 16px !important;">
                        <i class="fas fa-search me-2"></i>Search Results
                    </h5>
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Sr No</th>
                                    <th>Date</th>
                                    <th>Invoice No</th>
                                    <th>Patient Name</th>
                                    <th>Department</th>
                                    <th>Test Count</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $index => $invoice)
                                    <tr wire:click="selectInvoice({{ $invoice->id }})" style="cursor: pointer;">
                                        <td>{{ $invoices->firstItem() + $index }}</td>
                                        <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</td>
                                        <td><strong>{{ $invoice->invoice_no }}</strong></td>
                                        <td>{{ $invoice->patient->name_en ?? 'N/A' }}</td>
                                        <td>
                                            @php
                                                $departments = $invoice->labTestOrders->pluck('labTest.department.name')->unique()->filter();
                                            @endphp
                                            @if($departments->count() > 0)
                                                <small>{{ $departments->implode(', ') }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $invoice->test_count }}</span>
                                        </td>
                                       
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-3">
                                            No invoices found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($invoices->hasPages())
                        <div class="mt-3">
                            {{ $invoices->links() }}
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Event listener removed to avoid multiple instances -->



