<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary">
                    <i class="fas fa-print me-2"></i> Diagnostics Re-Print
                </h5>
                <div>
                    <a href="{{ route('admin.diagnostics.invoice') }}" class="btn btn-sm btn-outline-secondary me-2">
                        <i class="fas fa-file-invoice me-1"></i> New Invoice
                    </a>
                    <button class="btn btn-sm btn-primary" wire:click="resetForm">
                        <i class="fas fa-sync-alt me-1"></i> Reset
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Re-Print Form -->
            <div class="row mb-4">
                <!-- Left Column -->
                <div class="col-md-7">
                    <div class="card border">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0">Patient Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Patient Name:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" wire:model="patient_name" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Age:</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" placeholder="Y" style="width: 30%;" wire:model="age_years" readonly>
                                                <input type="text" class="form-control form-control-sm" placeholder="M" style="width: 30%;" wire:model="age_months" readonly>
                                                <input type="text" class="form-control form-control-sm" placeholder="D" style="width: 30%;" wire:model="age_days" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Sex:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" wire:model="gender" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Contact:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" wire:model="patient_phone" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Address:</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control form-control-sm" rows="2" wire:model="patient_address" readonly></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Invoice Date:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" wire:model="invoice_date" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Total Amount:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm text-end" wire:model="total_amount" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Paid Amount:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm text-end text-success" wire:model="paid_amount" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Due Amount:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm text-end text-danger" wire:model="due_amount" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lab Test Items Table -->
                    <div class="card border mt-3">
                        <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">
                                <i class="fas fa-vial me-1"></i> Lab Test Items
                            </h6>
                            <div>
                                <button type="button" class="btn btn-sm btn-outline-secondary" wire:click="resetForm">
                                    <i class="fas fa-undo me-1"></i> Reset
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 80px;">Code</th>
                                            <th>Test Name</th>
                                            <th style="width: 80px;" class="text-end">Charge</th>
                                            <th style="width: 100px;" class="text-center">Status</th>
                                            <th style="width: 100px;" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Lab Tests Section -->
                                        <tr class="table-info">
                                            <td colspan="5" class="fw-bold">
                                                <i class="fas fa-vial me-1"></i> Lab Tests
                                            </td>
                                        </tr>
                                        @forelse($labTestItems as $item)
                                            @if(!$item['is_collection_kit'])
                                                <tr class="item-print-row">
                                                    <td class="fw-bold">{{ $item['code'] }}</td>
                                                    <td>{{ $item['test_name'] }}</td>
                                                    <td class="text-end">৳{{ number_format($item['charge'], 0) }}</td>
                                                    <td class="text-center">
                                                        @if($item['status'] == 'completed')
                                                            <span class="badge bg-success">Completed</span>
                                                        @elseif($item['status'] == 'pending')
                                                            <span class="badge bg-warning">Pending</span>
                                                        @else
                                                            <span class="badge bg-secondary">{{ $item['status'] }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <button class="btn btn-sm btn-outline-primary" wire:click="printSingleItem({{ $item['id'] }})">
                                                            <i class="fas fa-print"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">
                                                    <i class="fas fa-info-circle fa-2x mb-2"></i><br>
                                                    No lab test items found for this invoice
                                                </td>
                                            </tr>
                                        @endforelse
                                        
                                        <!-- Collection Kits Section -->
                                        <tr class="table-warning">
                                            <td colspan="5" class="fw-bold">
                                                <i class="fas fa-box me-1"></i> Collection Kits
                                            </td>
                                        </tr>
                                        @forelse($labTestItems as $item)
                                            @if($item['is_collection_kit'])
                                                <tr class="item-print-row collection-kit-row">
                                                    <td class="fw-bold">{{ $item['code'] }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span class="me-2">{{ $item['test_name'] }}</span>
                                                            @if(isset($item['color']))
                                                                <span class="badge" style="background-color: {{ $item['color'] }};">{{ $item['color'] }}</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="text-end">৳{{ number_format($item['charge'], 0) }}</td>
                                                    <td class="text-center">
                                                        <span class="badge bg-success">Active</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <button class="btn btn-sm btn-outline-primary" wire:click="printSingleItem({{ $item['id'] }})">
                                                            <i class="fas fa-print"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">
                                                    <i class="fas fa-info-circle fa-2x mb-2"></i><br>
                                                    No collection kits found for this invoice
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-5">
                    <!-- Search Results Area -->
                    <div class="card border mb-3">
                        <div class="card-header bg-primary text-white py-2">
                            <h6 class="mb-0">
                                <i class="fas fa-search me-1"></i> Search Invoices
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <input type="text" class="form-control" wire:model.live="searchInvoices" placeholder="Search by invoice number, patient name, or phone...">
                            </div>
                            <div class="table-responsive" style="height: 400px; overflow-y: auto;">
                                <table class="table table-sm table-hover mb-0">
                                    <thead class="table-light sticky-top">
                                        <tr>
                                            <th>Invoice No</th>
                                            <th>Patient</th>
                                            <th class="text-end">Total</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($invoiceSearchResults as $invoice)
                                            <tr class="search-item" wire:click="selectInvoice({{ $invoice['invoice_id'] }})" style="cursor: pointer;">
                                                <td class="fw-bold">{{ $invoice['invoice_no'] }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="fw-bold me-2">{{ $invoice['patient_name'] }}</span>
                                                        <span class="text-muted small">{{ $invoice['patient_phone'] }}</span>
                                                    </div>
                                                </td>
                                                <td class="text-end">৳{{ number_format($invoice['total_amount'], 0) }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">
                                                    <i class="fas fa-search fa-2x mb-2"></i><br>
                                                    No invoices found
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Print Summary -->
                    <div class="card border">
                        <div class="card-header bg-primary text-white py-2">
                            <h6 class="mb-0">
                                <i class="fas fa-file-invoice-dollar me-1"></i> Print Summary
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label">Invoice Total</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control form-control-sm text-end fw-bold" wire:model="total_amount" readonly>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label">Paid Amount</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control form-control-sm text-end fw-bold text-success" wire:model="paid_amount" readonly>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label">Due Amount</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control form-control-sm text-end fw-bold text-danger" wire:model="due_amount" readonly>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label">Print Type</label>
                                <div class="col-sm-7">
                                    <select class="form-select form-select-sm" wire:model="printType">
                                        <option value="full_invoice">Full Invoice</option>
                                        <option value="receipt">Receipt Only</option>
                                        <option value="lab_report">Lab Report</option>
                                        <option value="selected_items">Selected Items</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label">Copies</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control form-control-sm" wire:model="printCopies" min="1" max="10">
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-center gap-2 mt-4">
                                <button class="btn btn-success" wire:click="printInvoice" wire:loading.attr="disabled">
                                    <i class="fas fa-print me-1"></i> 
                                    <span wire:loading.remove>Print Invoice</span>
                                    <span wire:loading>Processing...</span>
                                </button>
                                <button class="btn btn-primary" wire:click="resetForm">
                                    <i class="fas fa-sync-alt me-1"></i> Reset
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
    <div class="alert alert-success alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999;">
        <i class="fas fa-check-circle me-2"></i>{{ $successMessage }}
        <button type="button" class="btn-close" wire:click="$set('showSuccess', false)"></button>
    </div>
@endif

@if($showError)
    <div class="alert alert-danger alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999;">
        <i class="fas fa-exclamation-circle me-2"></i>{{ $errorMessage }}
        <button type="button" class="btn-close" wire:click="$set('showError', false)"></button>
    </div>
@endif

<script>
    // Listen for Livewire events
    document.addEventListener('livewire:init', () => {
        Livewire.on('show-success', (message) => {
            // You can add custom success handling here
        });
        
        Livewire.on('show-error', (message) => {
            // You can add custom error handling here
        });
        
        Livewire.on('openPrintWindow', (data) => {
            if (data.url) {
                window.open(data.url, '_blank');
            }
        });
    });
</script> 