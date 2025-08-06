<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary">
                    <i class="fas fa-undo me-2"></i> Diagnostics Invoice Return
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
            <!-- Invoice Return Form -->
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

                    <!-- Return Items Table -->
                    <div class="card border mt-3">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0">
                                <i class="fas fa-list me-1"></i> Invoice Items
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 50px;">
                                                <input type="checkbox" class="form-check-input" id="selectAll" wire:click="toggleSelectAll">
                                            </th>
                                            <th>Code</th>
                                            <th>Item Name</th>
                                            <th class="text-end">Charge</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($labTestItems as $item)
                                            <tr class="{{ in_array($item['id'], $selectedItems) ? 'table-warning' : '' }}">
                                                <td class="text-center">
                                                    <input type="checkbox" class="form-check-input" 
                                                           wire:click="toggleItemSelection({{ $item['id'] }})"
                                                           {{ in_array($item['id'], $selectedItems) ? 'checked' : '' }}>
                                                </td>
                                                <td class="fw-bold">{{ $item['code'] }}</td>
                                                <td>
                                                    @if($item['is_collection_kit'] && isset($item['color']))
                                                        <div class="d-flex align-items-center">
                                                            <span class="me-2">{{ $item['test_name'] }}</span>
                                                            <span class="badge" style="background-color: {{ $item['color'] }};">{{ $item['color'] }}</span>
                                                        </div>
                                                    @else
                                                        {{ $item['test_name'] }}
                                                    @endif
                                                </td>
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
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">
                                                    <i class="fas fa-info-circle fa-2x mb-2"></i><br>
                                                    No items found for this invoice
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
                                            <th class="text-end">Paid</th>
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
                                                <td class="text-end text-success fw-bold">৳{{ number_format($invoice['paid_amount'], 0) }}</td>
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

                    <!-- Return Summary -->
                    <div class="card border mb-3">
                        <div class="card-header bg-warning text-dark py-2">
                            <h6 class="mb-0">
                                <i class="fas fa-undo me-1"></i> Return Summary
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <label class="col-sm-6 col-form-label">Selected Items:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-sm text-end" value="{{ count($selectedItems) }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-6 col-form-label">Return Amount:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-sm text-end text-danger fw-bold" wire:model="returnAmount" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-6 col-form-label">Return Reason:</label>
                                <div class="col-sm-6">
                                    <textarea class="form-control form-control-sm" rows="3" wire:model="returnReason" placeholder="Enter return reason..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card border">
                        <div class="card-header bg-warning text-dark py-2">
                            <h6 class="mb-0">
                                <i class="fas fa-undo me-1"></i> Return Actions
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button class="btn btn-warning" wire:click="saveReturn" wire:loading.attr="disabled">
                                    <i class="fas fa-undo me-1"></i> 
                                    <span wire:loading.remove>Process Return</span>
                                    <span wire:loading>Processing...</span>
                                </button>
                                <button class="btn btn-primary" wire:click="saveAndPrint" wire:loading.attr="disabled">
                                    <i class="fas fa-print me-1"></i> 
                                    <span wire:loading.remove>Return & Print</span>
                                    <span wire:loading>Processing...</span>
                                </button>
                                <button class="btn btn-secondary" wire:click="cancelForm">
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