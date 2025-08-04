<div>
    <style>
        .search-item {
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .search-item:hover {
            background-color: #f8f9fa;
        }
        .search-item.selected {
            background-color: #e3f2fd;
            border-left: 3px solid #2196f3;
        }
        .triangle-indicator {
            width: 0;
            height: 0;
            border-left: 5px solid #2196f3;
            border-top: 5px solid transparent;
            border-bottom: 5px solid transparent;
            display: inline-block;
            margin-right: 5px;
            visibility: hidden;
        }
    </style>

    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 text-primary">
                        <i class="fas fa-print me-2"></i> Doctor/Consultation Re-Print
                    </h5>
                    <div>
                        <a href="{{ route('admin.doctor.invoice') }}" class="btn btn-sm btn-outline-secondary me-2">
                            <i class="fas fa-file-invoice me-1"></i> New Invoice
                        </a>
                        
                        <button class="btn btn-sm btn-primary" wire:click="resetForm">
                            <i class="fas fa-plus-circle me-1"></i> New Print Job
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
                                <h6 class="mb-0">Invoice Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Search Invoice:</label>
                                            <div class="col-sm-8">
                                                <input type="text" autocomplete="off" class="form-control form-control-sm" 
                                                       wire:model.live="searchInvoices" 
                                                       placeholder="Enter invoice number, patient name, or phone..." 
                                                       tabindex="1">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Patient Name:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" 
                                                       wire:model="patient_name" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Age:</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" placeholder="Y" 
                                                           style="width: 30%;" wire:model="age_years" readonly>
                                                    <input type="text" class="form-control form-control-sm" placeholder="M" 
                                                           style="width: 30%;" wire:model="age_months" readonly>
                                                    <input type="text" class="form-control form-control-sm" placeholder="D" 
                                                           style="width: 30%;" wire:model="age_days" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Sex:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" 
                                                       wire:model="gender" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Contact:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" 
                                                       wire:model="patient_phone" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Address:</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control form-control-sm" rows="2" 
                                                          wire:model="patient_address" readonly></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Invoice Date:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" 
                                                       wire:model="invoice_date" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Total Amount:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm text-end fw-bold" 
                                                       wire:model="total_amount" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Paid Amount:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm text-end fw-bold text-success" 
                                                       wire:model="paid_amount" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Due Amount:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm text-end fw-bold text-danger" 
                                                       wire:model="due_amount" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Consultant Tickets Table -->
                        <div class="card border mt-3">
                            <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">
                                    <i class="fas fa-user-md me-1"></i>Consultant Tickets
                                </h6>
                                <div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" wire:click="resetForm">
                                        <i class="fas fa-undo me-1"></i> Reset
                                    </button>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered mb-0" id="consultantTicketsTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 100px;">Ticket No</th>
                                                <th style="width: 100px;">Date</th>
                                                <th style="width: 80px;">Time</th>
                                                <th>Doctor Name</th>
                                              
                                         
                                                <th style="width: 100px;" class="text-center">Patient Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($consultantTickets) > 0)
                                                @foreach($consultantTickets as $ticket)
                                                    <tr>
                                                        <td class="fw-bold">{{ $ticket['ticket_no'] ?? '' }}</td>
                                                        <td>{{ $ticket['ticket_date'] ?? '' }}</td>
                                                        <td>{{ $ticket['ticket_time'] ?? '' }}</td>
                                                        <td>{{ $ticket['doctor_name'] ?? '' }}</td>
                                                        
                                                      
                                                        <td class="text-center">{{ $ticket['patient_type'] ?? '' }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="7" class="text-center text-muted py-4">
                                                        <i class="fas fa-info-circle fa-2x mb-2"></i><br>
                                                        @if($selectedInvoiceId)
                                                            No consultant tickets found for this invoice
                                                        @else
                                                            Select an invoice to view consultant tickets
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
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
                                    <i class="fas fa-search me-1"></i> 
                                    @if(empty($searchInvoices))
                                        Recent Invoices
                                    @else
                                        Search Results for '{{ $searchInvoices }}'
                                    @endif
                                </h6>
                            </div>
                            <div class="card-body p-0" style="height: 250px; overflow-y: auto;">
                                <div id="search-results-body">
                                    @if(count($invoiceSearchResults) > 0)
                                        <div class="table-responsive">
                                            <table class="table table-sm table-hover mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Invoice No</th>
                                                        <th>Patient Name</th>
                                                        <th class="text-end">Total</th>
                                                        <th class="text-end">Paid</th>
                                                        <th class="text-end">Due</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($invoiceSearchResults as $invoice)
                                                        <tr class="search-item" wire:click="selectInvoice({{ $invoice['invoice_id'] }})" style="cursor: pointer;">
                                                            <td class="fw-bold">
                                                                <div class="triangle-indicator"></div>{{ $invoice['invoice_no'] }}
                                                            </td>
                                                            <td>{{ $invoice['patient_name'] ?? 'N/A' }}</td>
                                                            <td class="text-end">{{ number_format($invoice['total_amount'], 0) }}</td>
                                                            <td class="text-end text-success">{{ number_format($invoice['paid_amount'], 0) }}</td>
                                                            <td class="text-end text-danger">{{ number_format($invoice['due_amount'], 0) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="p-3 text-center text-muted">
                                            <i class="fas fa-search fa-2x mb-2"></i><br>
                                            @if(empty($searchInvoices))
                                                No recent invoices found
                                            @else
                                                No invoices found matching your search
                                            @endif
                                        </div>
                                    @endif
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
                                        <input type="text" class="form-control form-control-sm text-end fw-bold" 
                                               value="{{ number_format($total_amount, 2) }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-sm-5 col-form-label">Paid Amount</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control form-control-sm text-end fw-bold text-success" 
                                               value="{{ number_format($paid_amount, 2) }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-sm-5 col-form-label">Due Amount</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control form-control-sm text-end fw-bold text-danger" 
                                               value="{{ number_format($due_amount, 2) }}" readonly>
                                    </div>
                                </div>
                            
                              
                                
                                <div class="d-flex justify-content-center gap-2 mt-4">
                                    <button class="btn btn-success" wire:click="printInvoice" 
                                            @if(!$selectedInvoiceId) disabled @endif>
                                        <i class="fas fa-print me-1"></i> Print Invoice
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

    <script>
        // Listen for Livewire events
        document.addEventListener('livewire:init', () => {
            // Listen for print window events
            Livewire.on('openPrintWindow', (data) => {
                const printData = Array.isArray(data) ? data[0] : data;
                const templateUrl = printData.url;
                
                // Create hidden iframe for printing
                const iframe = document.createElement('iframe');
                iframe.style.display = 'none';
                iframe.src = templateUrl;
                document.body.appendChild(iframe);
                
                // Wait for iframe to load then print
                iframe.onload = function() {
                    try {
                        iframe.contentWindow.focus();
                        iframe.contentWindow.print();
                    } catch (e) {
                        console.error('Print failed:', e);
                        // Fallback: open in new window
                        window.open(templateUrl, '_blank');
                    }
                    
                    // Remove iframe after printing
                    setTimeout(() => {
                        document.body.removeChild(iframe);
                    }, 1000);
                };
            });
        });
    </script>
</div> 