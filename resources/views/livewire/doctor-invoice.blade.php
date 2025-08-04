<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary">
                    <i class="fas fa-user-md me-2"></i> Doctor/Consultant Invoice
                </h5>
                <div>
                    <a href="{{ route('admin.patients.index') }}" class="btn btn-sm btn-outline-secondary me-2">
                        <i class="fas fa-list me-1"></i> Patient List
                    </a>
                    <button class="btn btn-sm btn-primary" wire:click="resetForm">
                        <i class="fas fa-plus-circle me-1"></i> New Invoice
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Success/Error Messages -->
            @if($showSuccess)
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ $successMessage }}
                    <button type="button" class="btn-close" wire:click="closeSuccess"></button>
                </div>
            @endif

            @if($showError)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ $errorMessage }}
                    <button type="button" class="btn-close" wire:click="closeError"></button>
                </div>
            @endif



            <!-- Invoice Form -->
            <form wire:submit.prevent="saveInvoice">
                <div class="row mb-4">
                    <!-- Left Column -->
                    <div class="col-md-7">
                        <div class="card border">
                            <div class="card-header bg-light py-2">
                                <h6 class="mb-0">Consultation Details =><span class="text-info"> DT-001 (Daily Ticket No - Each Doctor Starts from 1)</span></h6>  
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Patient ID:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" wire:model.live.debounce.300ms="patient_search" 
                                                       placeholder="Search Patient ID/Name/Phone/Address" 
                                                       wire:focus="loadDefaultPatients">
                                                <input type="hidden" wire:model="patient_id">
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Name: <span class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" wire:model="patient_name" required>
                                                @error('patient_name') <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Age:</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" wire:model="age_years" placeholder="Y" style="width: 30%;">
                                                    <input type="text" class="form-control form-control-sm" wire:model="age_months" placeholder="M" style="width: 30%;">
                                                    <input type="text" class="form-control form-control-sm" wire:model="age_days" placeholder="D" style="width: 30%;">
                                                </div>
                                            </div>
                                        </div>
                                                                                 <div class="row mb-2">
                                             <label class="col-sm-4 col-form-label">Sex: <span class="text-danger">*</span></label>
                                             <div class="col-sm-8">
                                                 <button type="button" wire:click="toggleSexOptions" class="form-control text-start" style="height: 38px; border: 1px solid #ced4da; background-color: #f8f9fa; color: #495057;">
                                                     {{ $gender ?: 'Click to select sex' }}
                                                 </button>
                                                 <input type="hidden" wire:model="gender">
                                                 @error('gender') <span class="text-danger small">{{ $message }}</span> @enderror
                                             </div>
                                         </div>
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Contact: <span class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" wire:model="patient_phone" required>
                                                @error('patient_phone') <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                     
                                        <div class="row mb-2">
                                            <label class="col-sm-2 col-form-label">Address:</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control form-control-sm" wire:model="patient_address" rows="2"></textarea>
                                                @error('patient_address') <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Date:</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <input type="date" class="form-control form-control-sm" wire:model="ticket_date" required>
                                                    <button class="btn btn-sm btn-outline-secondary" type="button"><i class="fas fa-calendar"></i></button>
                                                </div>
                                                @error('ticket_date') <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Time:</label>
                                            <div class="col-sm-8">
                                                <input type="time" class="form-control form-control-sm" wire:model="ticket_time" required>
                                                @error('ticket_time') <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Doctor: <span class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" wire:model.live.debounce.300ms="doctor_search" placeholder="Search DR Code/Name">
                                                <input type="hidden" wire:model="doctor_id">
                                                @error('doctor_id') <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <!-- PCP Referral Section -->
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Ref:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" wire:model.live.debounce.300ms="pcp_search" placeholder="Search PCP Code/Name">
                                                <input type="hidden" wire:model="referred_by">
                                                @error('referred_by') <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                                                                 <div class="row mb-2">
                                             <label class="col-sm-4 col-form-label">Patient Type:</label>
                                             <div class="col-sm-8">
                                                 <button type="button" class="btn btn-outline-secondary btn-sm w-100 text-start" 
                                                         wire:click="togglePatientTypeOptions" 
                                                         style="height: 38px; border: 1px solid #ced4da;">
                                                     <span id="patient-type-display">
                                                         {{ $patient_type ? ucfirst(str_replace('_', ' ', $patient_type)) : 'Click to select patient type' }}
                                                     </span>
                                                     <i class="fas fa-chevron-down float-end"></i>
                                                 </button>
                                                 @error('patient_type') <span class="text-danger small">{{ $message }}</span> @enderror
                                             </div>
                                         </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-5">
                        <!-- Search Results Area -->
                        <div class="card border mb-3" id="search-results-container">
                            <div class="card-header bg-primary text-white py-2">
                                <h6 class="mb-0"><i class="fas fa-search me-1"></i> <span id="search-title">Recent Patients</span></h6>
                            </div>
                                                         <div class="card-body p-0" style="height: 250px; overflow-y: auto;" id="search-results-body">
                                 @if($showSexOptions)
                                     <!-- Sex Options -->
                                     <div class="list-group list-group-flush">
                                         <div class="list-group-item list-group-item-action" 
                                              wire:click="selectSex('Male')" 
                                              style="cursor: pointer;">
                                             <div class="d-flex justify-content-between align-items-center">
                                                 <span><i class="fas fa-mars text-primary me-2"></i>Male</span>
                                                 <small class="text-primary">Male</small>
                                             </div>
                                         </div>
                                         <div class="list-group-item list-group-item-action" 
                                              wire:click="selectSex('Female')" 
                                              style="cursor: pointer;">
                                             <div class="d-flex justify-content-between align-items-center">
                                                 <span><i class="fas fa-venus text-danger me-2"></i>Female</span>
                                                 <small class="text-danger">Female</small>
                                             </div>
                                         </div>
                                         <div class="list-group-item list-group-item-action" 
                                              wire:click="selectSex('Other')" 
                                              style="cursor: pointer;">
                                             <div class="d-flex justify-content-between align-items-center">
                                                 <span><i class="fas fa-genderless text-secondary me-2"></i>Other</span>
                                                 <small class="text-secondary">Other</small>
                                             </div>
                                         </div>
                                     </div>
                                 @elseif($showPatientTypeOptions)
                                     <div class="list-group list-group-flush">
                                         <div class="list-group-item list-group-item-action" 
                                              wire:click="selectPatientType('new')" 
                                              style="cursor: pointer;">
                                             <div class="d-flex justify-content-between align-items-center">
                                                 <div>
                                                     <i class="fas fa-user-plus text-success me-2"></i>
                                                     <strong>New</strong>
                                                     <br><small class="text-muted">First time patient</small>
                                                 </div>
                                                 <i class="fas fa-chevron-right text-muted"></i>
                                             </div>
                                         </div>
                                         <div class="list-group-item list-group-item-action" 
                                              wire:click="selectPatientType('old')" 
                                              style="cursor: pointer;">
                                             <div class="d-flex justify-content-between align-items-center">
                                                 <div>
                                                     <i class="fas fa-user text-primary me-2"></i>
                                                     <strong>Old</strong>
                                                     <br><small class="text-muted">Returning patient</small>
                                                 </div>
                                                 <i class="fas fa-chevron-right text-muted"></i>
                                             </div>
                                         </div>
                                         <div class="list-group-item list-group-item-action" 
                                              wire:click="selectPatientType('follow_up')" 
                                              style="cursor: pointer;">
                                             <div class="d-flex justify-content-between align-items-center">
                                                 <div>
                                                     <i class="fas fa-redo text-warning me-2"></i>
                                                     <strong>Follow-up</strong>
                                                     <br><small class="text-muted">Follow-up visit</small>
                                                 </div>
                                                 <i class="fas fa-chevron-right text-muted"></i>
                                             </div>
                                         </div>
                                         <div class="list-group-item list-group-item-action" 
                                              wire:click="selectPatientType('pcp')" 
                                              style="cursor: pointer;">
                                             <div class="d-flex justify-content-between align-items-center">
                                                 <div>
                                                     <i class="fas fa-user-md text-info me-2"></i>
                                                     <strong>PCP (Referral)</strong>
                                                     <br><small class="text-muted">Referred by PCP</small>
                                                 </div>
                                                 <i class="fas fa-chevron-right text-muted"></i>
                                             </div>
                                         </div>
                                     </div>
                                 @elseif(count($searchResults) > 0)
                                     <div class="list-group list-group-flush">
                                         @foreach($searchResults as $result)
                                             <div class="list-group-item list-group-item-action py-2" 
                                                  wire:click="@if($searchType == 'PCP')selectPcp({{ $result->id }})@else select{{ $searchType }}({{ $result->id }})@endif"
                                                  style="cursor: pointer;">
                                                 <div class="d-flex justify-content-between align-items-center">
                                                     <div>
                                                         @if($searchType == 'Patient')
                                                             <strong>{{ $result->patient_id }}</strong> - {{ $result->name_en }}
                                                             <br><small class="text-muted">{{ $result->phone }}</small>
                                                         @elseif($searchType == 'Doctor')
                                                             <strong>{{ $result->code }}</strong> - {{ $result->name }}
                                                         @elseif($searchType == 'PCP')
                                                             <strong>{{ $result->code }}</strong> - {{ $result->name }}
                                                         @endif
                                                     </div>
                                                     <i class="fas fa-chevron-right text-muted"></i>
                                                 </div>
                                             </div>
                                         @endforeach
                                     </div>
                                 @else
                                     <div class="text-center text-muted py-4">
                                         <i class="fas fa-search fa-2x mb-2"></i>
                                         <p>No {{ $searchType }} found</p>
                                     </div>
                                 @endif
                             </div>
                                                 </div>
                         
                         <!-- Invoice Summary -->
                        <div class="card border">
                            <div class="card-header bg-primary text-white py-2">
                                <h6 class="mb-0"><i class="fas fa-file-invoice-dollar me-1"></i> Payment Summary</h6>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <label class="col-sm-5 col-form-label">Consultation Fee</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control form-control-sm text-end fw-bold" wire:model="consultation_fee" wire:change="calculateDueAmount">
                                        @error('consultation_fee') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                               
                                <div class="row mb-2">
                                    <label class="col-sm-5 col-form-label">Paid Amount</label>
                                    <div class="col-sm-7">
                                        <input type="number" class="form-control form-control-sm text-end" wire:model="paid_amount" wire:change="calculateDueAmount" step="0.01" min="0">
                                        @error('paid_amount') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-sm-5 col-form-label text-danger fw-bold">Due Amount</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control form-control-sm text-end fw-bold text-danger" value="{{ $due_amount }}" readonly>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <label class="col-sm-5 col-form-label">Remarks:</label>
                                    <div class="col-sm-7">
                                        <textarea class="form-control form-control-sm" wire:model="remarks" rows="3" placeholder="Any additional notes..."></textarea>
                                        @error('remarks') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-center gap-2 mt-4">
                                    <button type="button" class="btn btn-primary" wire:click="saveOnly" wire:loading.attr="disabled" wire:loading.class="disabled">
                                        <i class="fas fa-save me-1"></i> 
                                        <span wire:loading.remove>Save</span>
                                        <span wire:loading>Saving...</span>
                                    </button>
                                    <button type="button" class="btn btn-success" wire:click="saveAndPrint" wire:loading.attr="disabled" wire:loading.class="disabled">
                                        <i class="fas fa-print me-1"></i> 
                                        <span wire:loading.remove>Save & Print</span>
                                        <span wire:loading>Saving...</span>
                                    </button>
                                    <button type="button" class="btn btn-secondary" wire:click="resetForm">
                                        <i class="fas fa-sync-alt me-1"></i> Reset
                                    </button>
                                    <button type="button" class="btn btn-danger" wire:click="cancelForm">
                                        <i class="fas fa-times me-1"></i> Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Listen for print window event
    document.addEventListener('livewire:init', () => {
        // Listen for search title updates
        Livewire.on('updateSearchTitle', (data) => {
            const searchTitle = document.getElementById('search-title');
            if (searchTitle) {
                searchTitle.textContent = data.title;
            }
        });
        
        // Listen for SweetAlert2 success messages
        Livewire.on('show-success', (data) => {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message,
                confirmButtonColor: '#28a745',
                confirmButtonText: 'OK'
            });
        });
        
        // Listen for SweetAlert2 error messages
        Livewire.on('show-error', (data) => {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: data.message,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'OK'
            });
        });
        
        Livewire.on('openPrintWindow', (data) => {
            const templateUrl = '{{ route("admin.admin.invoice-templates.doctor-consultant") }}?invoice_id=' + data.invoiceId;
            console.log('Opening print window with URL:', templateUrl);
            
            let printWindow = null;
            let iframeUsed = false;
            
            // Create a hidden iframe for printing
            const printFrame = document.createElement('iframe');
            printFrame.style.display = 'none';
            printFrame.src = templateUrl;
            document.body.appendChild(printFrame);
            
            printFrame.onload = function() {
                console.log('Print frame loaded, attempting to print automatically...');
                iframeUsed = true;
                
                setTimeout(() => {
                    try {
                        // Try to print automatically without dialog
                        const frameWindow = printFrame.contentWindow;
                        frameWindow.focus();
                        frameWindow.print();
                        console.log('Automatic print triggered successfully');
                        
                        // Remove the iframe after printing
                        setTimeout(() => {
                            if (document.body.contains(printFrame)) {
                                document.body.removeChild(printFrame);
                            }
                        }, 1000);
                        
                    } catch (printError) {
                        console.error('Automatic print error:', printError);
                        
                        // Only open fallback window if iframe method was used
                        if (iframeUsed && !printWindow) {
                            printWindow = window.open(templateUrl, '_blank', 'width=800,height=600,scrollbars=yes,resizable=yes');
                            
                            if (printWindow) {
                                printWindow.onload = function() {
                                    setTimeout(() => {
                                        try {
                                            printWindow.print();
                                            console.log('Fallback print dialog opened');
                                            
                                            // Close the popup window after printing
                                            setTimeout(() => {
                                                printWindow.close();
                                                console.log('Print window closed automatically');
                                            }, 3000);
                                            
                                        } catch (fallbackError) {
                                            console.error('Fallback print error:', fallbackError);
                                            Livewire.dispatch('show-error', { 
                                                message: 'Error printing. Please try printing manually from the new window.' 
                                            });
                                            // Close the popup window even if print fails
                                            setTimeout(() => {
                                                printWindow.close();
                                            }, 2000);
                                        }
                                    }, 2000);
                                };
                            } else {
                                console.error('Popup was blocked');
                                Livewire.dispatch('show-error', { 
                                    message: 'Popup was blocked. Please allow popups and try again.' 
                                });
                            }
                        }
                        
                        // Remove the iframe
                        if (document.body.contains(printFrame)) {
                            document.body.removeChild(printFrame);
                        }
                    }
                }, 1500);
            };
            
            // Fallback if iframe doesn't load (only if iframe wasn't used)
            setTimeout(() => {
                if (document.body.contains(printFrame) && !iframeUsed) {
                    console.log('Iframe timeout, trying fallback...');
                    document.body.removeChild(printFrame);
                    
                    // Only open fallback window if no window is already open
                    if (!printWindow) {
                        printWindow = window.open(templateUrl, '_blank', 'width=800,height=600,scrollbars=yes,resizable=yes');
                        
                        if (printWindow) {
                            printWindow.onload = function() {
                                setTimeout(() => {
                                    try {
                                        printWindow.print();
                                        console.log('Fallback print dialog opened');
                                        
                                        // Close the popup window after printing
                                        setTimeout(() => {
                                            printWindow.close();
                                            console.log('Print window closed automatically');
                                        }, 3000);
                                        
                                    } catch (fallbackError) {
                                        console.error('Fallback print error:', fallbackError);
                                        Livewire.dispatch('show-error', { 
                                            message: 'Error printing. Please try printing manually from the new window.' 
                                        });
                                        // Close the popup window even if print fails
                                        setTimeout(() => {
                                            printWindow.close();
                                        }, 2000);
                                    }
                                }, 2000);
                            };
                        } else {
                            console.error('Popup was blocked');
                            Livewire.dispatch('show-error', { 
                                message: 'Popup was blocked. Please allow popups and try again.' 
                            });
                        }
                    }
                }
            }, 5000);
        });
        

    });
</script> 