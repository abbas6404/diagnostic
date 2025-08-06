<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary">
                    <i class="fas fa-file-invoice me-2"></i> Diagnostics Invoice
                </h5>
                <div>
                    <a href="{{ route('admin.patients.index') }}" class="btn btn-sm btn-outline-secondary me-2">
                        <i class="fas fa-list me-1"></i> Patient List
                    </a>
                    
                    <button class="btn btn-sm btn-primary" wire:click="$refresh">
                        <i class="fas fa-plus-circle me-1"></i> New Invoice
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Invoice Form -->
            <div class="row mb-4">
                <!-- Left Column -->
                <div class="col-md-7">
                    <div class="card border">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0">Invoice Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Patient ID:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" 
                                                   wire:model.live.debounce.300ms="patientSearch" 
                                                   placeholder="Search patient...">
                                        </div>
                                    </div>
                                                                         <div class="row mb-2">
                                         <label class="col-sm-4 col-form-label">Name: <span class="text-danger">*</span></label>
                                         <div class="col-sm-8">
                                             <input type="text" class="form-control form-control-sm" 
                                                    wire:model="patient_name">
                                         </div>
                                     </div>
                                    
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Age:</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" 
                                                       placeholder="Y" style="width: 30%;" 
                                                       wire:model="age_years">
                                                <input type="text" class="form-control form-control-sm" 
                                                       placeholder="M" style="width: 30%;" 
                                                       wire:model="age_months">
                                                <input type="text" class="form-control form-control-sm" 
                                                       placeholder="D" style="width: 30%;" 
                                                       wire:model="age_days">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Sex: <span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" 
                                                   wire:model.live.debounce.300ms="genderSearch" 
                                                   wire:click="searchGenders"
                                                   placeholder="Click to select gender..."
                                                   value="{{ $gender }}" readonly>
                                        </div>
                                    </div>
                                                                         <div class="row mb-2">
                                         <label class="col-sm-4 col-form-label">Contact: <span class="text-danger">*</span></label>
                                         <div class="col-sm-8">
                                                                                             <input type="text" class="form-control form-control-sm" 
                                                        wire:model="patient_phone">
                                         </div>
                                     </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Address:</label>
                                        <div class="col-sm-8">
                                                                                            <textarea class="form-control form-control-sm" rows="2" 
                                                          wire:model="patient_address"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Date: <span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="date" class="form-control form-control-sm" 
                                                       wire:model="invoice_date">
                                                <button class="btn btn-sm btn-outline-secondary" type="button">
                                                    <i class="fas fa-calendar"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Dr. Ticket:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" 
                                                   wire:model.live.debounce.300ms="ticketSearch" 
                                                   placeholder="Search ticket...">
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Cons. Dr:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" 
                                                   wire:model.live.debounce.300ms="doctorSearch" 
                                                   placeholder="Search doctor...">
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Ref. By:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" 
                                                   wire:model.live.debounce.300ms="pcpSearch" 
                                                   placeholder="Search PCP...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Test Items Table -->
                    <div class="card border mt-3">
                        <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"><i class="fas fa-vial me-1"></i>Lab Tests & Collection Kits</h6>
                            <div>
                                <input type="text" class="form-control form-control-sm" 
                                       wire:model.live.debounce.300ms="labTestSearch" 
                                       placeholder="Search lab tests..." style="width: 200px;">
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 80px;">Code</th>
                                            <th>Particulars</th>
                                            <th style="width: 100px;">Charge</th>
                                            <th style="width: 120px;">Delivery Date</th>
                                            <th style="width: 80px;">Quantity</th>
                                            <th style="width: 100px;">Total</th>
                                            <th style="width: 40px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Lab Tests Section -->
                                        @if(count($testItems) > 0)
                                        <tr class="table-info">
                                            <td colspan="7" class="fw-bold">
                                                <i class="fas fa-vial me-1"></i> Lab Tests
                                            </td>
                                        </tr>
                                        @foreach($testItems as $index => $item)
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" 
                                                       value="{{ $item['code'] }}" readonly>
                                            </td>
                                            <td>{{ $item['name'] }}</td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" 
                                                       wire:model="testItems.{{ $index }}.charge" 
                                                       step="0.01" min="0">
                                            </td>
                                            <td>
                                                <input type="date" class="form-control form-control-sm" 
                                                       wire:model="testItems.{{ $index }}.delivery_date">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" 
                                                       wire:model="testItems.{{ $index }}.quantity" 
                                                       min="1" wire:change="updateTestItemQuantity({{ $index }}, $event.target.value)">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" 
                                                       value="{{ number_format($item['charge'] * $item['quantity'], 2) }}" readonly>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger" 
                                                        wire:click="removeTestItem({{ $index }})">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                        
                                        <!-- Collection Kits Section -->
                                        @if(count($collectionKitItems) > 0)
                                        <tr class="table-warning">
                                            <td colspan="7" class="fw-bold">
                                                <i class="fas fa-box me-1"></i> Collection Kits
                                            </td>
                                        </tr>
                                        @foreach($collectionKitItems as $index => $item)
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" 
                                                       value="{{ $item['code'] }}" readonly>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="me-2">{{ $item['name'] }}</span>
                                                    @if($item['color'])
                                                    <span class="badge" style="background-color: {{ $item['color'] }}; color: white;">
                                                        {{ $item['color'] }}
                                                    </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" 
                                                       wire:model="collectionKitItems.{{ $index }}.charge" 
                                                       step="0.01" min="0">
                                            </td>
                                            <td>
                                                <span class="text-muted">-</span>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm" 
                                                       wire:model="collectionKitItems.{{ $index }}.quantity" 
                                                       min="1" wire:change="updateCollectionKitQuantity({{ $index }}, $event.target.value)">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" 
                                                       value="{{ number_format($item['charge'] * $item['quantity'], 2) }}" readonly>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger" 
                                                        wire:click="removeCollectionKit({{ $index }})">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <td colspan="5" class="text-end fw-bold">Subtotal:</td>
                                            <td colspan="2">
                                                <input type="text" class="form-control form-control-sm" 
                                                       value="{{ number_format($totalAmount, 2) }}" readonly>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-5">
                    <!-- Search Results Area -->
                    <div class="card border mb-3" id="search-results-container">
                        <div class="card-header bg-primary text-white py-2">
                            <h6 class="mb-0"><i class="fas fa-search me-1"></i> 
                                <span id="search-title">{{ $searchType ? $searchType . ' Search Results' : 'Search Results' }}</span>
                            </h6>
                        </div>
                        <div class="card-body p-0" style="height: 400px; overflow-y: auto;" id="search-results-body">
                            @if(count($searchResults) > 0)
                                @foreach($searchResults as $result)
                                <div class="search-item p-2 border-bottom" 
                                     wire:click="@if($searchType === 'Gender') selectGender('{{ $result['id'] }}') @elseif($searchType === 'PCP') selectPcp({{ $result->id }}) @elseif($searchType === 'Lab Test') selectLabTest({{ $result->id }}) @else select{{ $searchType }}({{ $result->id }}) @endif"
                                     style="cursor: pointer;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center">
                                                @if($searchType === 'Gender')
                                                    <strong class="me-2">{{ $result['name'] }}</strong>
                                                    <span class="text-muted small">{{ $result['code'] }}</span>
                                                @elseif($searchType === 'Ticket')
                                                    <div class="d-flex flex-column">
                                                        <div class="d-flex align-items-center">
                                                            <strong class="me-2">Ticket: {{ $result->ticket_no }}</strong>
                                                            <span class="badge bg-primary me-2">{{ $result->doctor_code ?? 'N/A' }}</span>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <span class="text-muted small me-2">{{ $result->doctor_name ?? 'No Doctor' }}</span>
                                                            <span class="text-muted small">| {{ $result->patient_name ?? 'N/A' }}</span>
                                                        </div>
                                                    </div>
                                                @elseif($searchType === 'Lab Test')
                                                    <div class="d-flex align-items-center justify-content-between w-100">
                                                        <div class="d-flex align-items-center">
                                                            <span class="badge bg-primary me-2">{{ $result->code }}</span>
                                                            <span class="fw-bold me-3">{{ $result->name }}</span>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <span class="text-success fw-bold me-3">{{ number_format($result->charge, 2) }}</span>
                                                            <small class="text-muted">{{ $result->department_name ?? 'N/A' }}</small>
                                                        </div>
                                                    </div>
                                                @else
                                                    <strong class="me-2">{{ $result->name ?? $result->patient_name ?? '' }}</strong>
                                                    <span class="text-muted small">
                                                        {{ $result->patient_id ?? $result->code ?? '' }}
                                                        @if(isset($result->phone))
                                                        | {{ $result->phone }}
                                                        @endif
                                                        @if(isset($result->address) && !empty($result->address))
                                                        | {{ Str::limit($result->address, 30) }}
                                                        @endif
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="triangle-indicator" style="visibility: hidden;">▶</div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="p-3 text-center text-muted">
                                    <i class="fas fa-search fa-2x mb-2"></i>
                                    <p>No results found</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Invoice Summary -->
                    <div class="card border">
                        <div class="card-header bg-primary text-white py-2">
                            <h6 class="mb-0"><i class="fas fa-file-invoice-dollar me-1"></i> Invoice Summary</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label">Total Amount</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control form-control-sm text-end fw-bold" 
                                           value="{{ number_format($totalAmount, 2) }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label">Discount (%)</label>
                                <div class="col-sm-7">
                                    <div class="input-group input-group-sm">
                                        <input type="number" class="form-control text-end" 
                                               wire:model.live="discountPercent" min="0" max="100">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label">Discount Amount</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control form-control-sm text-end" 
                                           wire:model.live="discountAmount" step="0.01" min="0">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label fw-bold">Net Payable</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control form-control-sm text-end fw-bold bg-light" 
                                           value="{{ number_format($netPayable, 2) }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label">Paid Amount</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control form-control-sm text-end" 
                                           wire:model.live="paidAmount" step="0.01" min="0">
                                </div>
                            </div>
                                                         <div class="row mb-2">
                                 <label class="col-sm-5 col-form-label text-danger fw-bold">Due Amount</label>
                                 <div class="col-sm-7">
                                     <input type="text" class="form-control form-control-sm text-end fw-bold text-danger" 
                                            value="{{ number_format($dueAmount, 2) }}" readonly>
                                 </div>
                             </div>
                             <div class="row mb-2">
                                 <label class="col-sm-5 col-form-label">Remarks</label>
                                 <div class="col-sm-7">
                                     <textarea class="form-control form-control-sm" 
                                               wire:model="remarks" 
                                               rows="3" 
                                               placeholder="Enter any remarks..."></textarea>
                                 </div>
                             </div>
                            
                                                         <div class="d-flex justify-content-center gap-2 mt-4">
                                 <button class="btn btn-primary" wire:click="saveInvoice" 
                                         wire:loading.attr="disabled">
                                     <i class="fas fa-save me-1"></i> 
                                     <span wire:loading.remove>Save</span>
                                     <span wire:loading>Saving...</span>
                                 </button>
                                 <button class="btn btn-success" wire:click="saveAndPrint" 
                                         wire:loading.attr="disabled">
                                     <i class="fas fa-print me-1"></i> 
                                     <span wire:loading.remove>Save & Print</span>
                                     <span wire:loading>Saving...</span>
                                 </button>
                                 <button class="btn btn-info" wire:click="testPrint">
                                     <i class="fas fa-print me-1"></i> Test Print
                                 </button>
                                 <button class="btn btn-warning" wire:click="resetForm">
                                     <i class="fas fa-undo me-1"></i> Restore
                                 </button>
                                 <button class="btn btn-danger" wire:click="cancelForm">
                                     <i class="fas fa-times me-1"></i> Cancel
                                 </button>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
@if($showSuccess)
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $successMessage }}
        <button type="button" class="btn-close" wire:click="$set('showSuccess', false)"></button>
    </div>
</div>
@endif

@if($showError)
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $errorMessage }}
        <button type="button" class="btn-close" wire:click="$set('showError', false)"></button>
    </div>
</div>
@endif

<script>
document.addEventListener('livewire:init', () => {
    console.log('Diagnostics Invoice JS loaded - Version 2.0');
    
    // Global handlers are already set up in admin-layout.js
    // No need to duplicate them here

    Livewire.on('updateSearchTitle', (data) => {
        const titleElement = document.getElementById('search-title');
        if (titleElement) {
            titleElement.textContent = data.title;
        }
    });

    Livewire.on('openPrintWindow', (data) => {
        console.log('openPrintWindow event received:', data);
        if (data.invoiceId) {
            const templateUrl = '{{ route("admin.admin.invoice-templates.diagnosis-invoice") }}?invoice_id=' + data.invoiceId;
            console.log('Opening URL:', templateUrl);
            
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
            }, 3000);
        } else {
            console.error('No invoiceId provided in openPrintWindow event');
        }
    });
});
</script> 