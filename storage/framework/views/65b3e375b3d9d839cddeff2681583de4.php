<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary">
                    <i class="fas fa-user-md me-2"></i> Doctor Due Collection
                </h5>
                <div>
                    <a href="#" class="btn btn-sm btn-outline-secondary me-2">
                        <i class="fas fa-list me-1"></i> Patient List
                    </a>
                    <a href="#" class="btn btn-sm btn-primary">
                        <i class="fas fa-file-invoice me-1"></i> New Invoice
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Success/Error Messages -->
            <!--[if BLOCK]><![endif]--><?php if($showSuccess): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?php echo e($successMessage); ?>

                    <button type="button" class="btn-close" wire:click="closeSuccess"></button>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <!--[if BLOCK]><![endif]--><?php if($showError): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?php echo e($errorMessage); ?>

                    <button type="button" class="btn-close" wire:click="closeError"></button>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <div class="row">
                <!-- Left Column -->
                <div class="col-md-7">
                    <!-- Patient Information -->
                    <div class="card border mb-3">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0"><i class="fas fa-user me-1"></i> Patient Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 position-relative">
                                    <!-- Search Due Invoice Input -->
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label text-end">Search Due Invoice:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" 
                                                   wire:model.live.debounce.300ms="searchDueInvoices" 
                                                   placeholder="Search Invoice No/Patient/Phone/Address"
                                                   wire:focus="loadDefaultDueInvoices">
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label text-end">Patient Name:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" value="<?php echo e($patient_name); ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label text-end">Age:</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" value="<?php echo e($age_years); ?>" placeholder="Y" readonly>
                                                <input type="text" class="form-control form-control-sm" value="<?php echo e($age_months); ?>" placeholder="M" readonly>
                                                <input type="text" class="form-control form-control-sm" value="<?php echo e($age_days); ?>" placeholder="D" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label text-end">Sex:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" value="<?php echo e($gender); ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label text-end">Contact:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" value="<?php echo e($patient_phone); ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label text-end">Address:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" value="<?php echo e($patient_address); ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Due Invoices -->
                    <div class="card border mb-3">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0"><i class="fas fa-file-invoice me-1"></i> Due Invoices</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                                <table class="table table-sm table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 20px;"></th>
                                            <th>Invoice #</th>
                                            <th>Date</th>
                                            <th class="text-end">Total</th>
                                            <th class="text-end">Paid</th>
                                            <th class="text-end">Due</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!--[if BLOCK]><![endif]--><?php if(count($dueInvoices) > 0): ?>
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $dueInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr wire:click="selectInvoice(<?php echo e($invoice->id); ?>)" 
                                                    class="<?php echo e($selectedInvoiceId == $invoice->id ? 'table-primary' : ''); ?>"
                                                    style="cursor: pointer;">
                                                    <td style="width: 20px; text-align: center;">
                                                        <!--[if BLOCK]><![endif]--><?php if($selectedInvoiceId == $invoice->id): ?>
                                                            <div style="color: #00ff00; font-size: 16px; font-weight: bold;">▶</div>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </td>
                                                    <td><?php echo e($invoice->invoice_no); ?></td>
                                                    <td><?php echo e($invoice->invoice_date); ?></td>
                                                    <td class="text-end"><?php echo e(number_format($invoice->total_amount, 0)); ?></td>
                                                    <td class="text-end"><?php echo e(number_format($invoice->paid_amount, 0)); ?></td>
                                                    <td class="text-end text-danger fw-bold"><?php echo e(number_format($invoice->due_amount, 0)); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">
                                                    <i class="fas fa-search fa-2x mb-2"></i><br>
                                                    Search for a due invoice to view details
                                                </td>
                                            </tr>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                
                    <!-- Consultant Tickets -->
                    <div class="card border">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0"><i class="fas fa-ticket-alt me-1"></i> Consultant Tickets</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 120px;">Ticket No</th>
                                            <th>Doctor</th>
                                            <th style="width: 100px;">Date</th>
                                            <th style="width: 80px;">Time</th>
                                            <th style="width: 100px;" class="text-end">Fee</th>
                                            <th style="width: 80px;" class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!--[if BLOCK]><![endif]--><?php if(count($consultantTickets) > 0): ?>
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $consultantTickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($ticket->ticket_no); ?></td>
                                                    <td><?php echo e($ticket->doctor_name ?? '-'); ?></td>
                                                    <td><?php echo e($ticket->ticket_date ?? '-'); ?></td>
                                                    <td><?php echo e($ticket->ticket_time ?? '-'); ?></td>
                                                    <td class="text-end"><?php echo e(number_format($ticket->consultation_fee ?? 0, 0)); ?></td>
                                                    <td class="text-center">
                                                        <span class="badge bg-<?php echo e($ticket->ticket_status == 'completed' ? 'success' : ($ticket->ticket_status == 'pending' ? 'warning' : 'secondary')); ?>">
                                                            <?php echo e($ticket->ticket_status ?? 'pending'); ?>

                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">
                                                    <i class="fas fa-info-circle fa-2x mb-2"></i><br>
                                                    Select an invoice to view consultant tickets
                                                </td>
                                            </tr>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-5">
                    <!-- Search Results Section -->
                    <div class="card border mb-3">
                        <div class="card-header bg-primary text-white py-2">
                            <h6 class="mb-0"><i class="fas fa-search me-1"></i> <span id="search-title">Due Invoice Search Results</span></h6>
                        </div>
                        <div class="card-body p-0" style="height: 250px; overflow-y: auto;" id="search-results-body">
                            <!--[if BLOCK]><![endif]--><?php if(count($dueInvoiceSearchResults) > 0): ?>
                                <!-- Due Invoice Search Results -->
                                <div class="list-group list-group-flush">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $dueInvoiceSearchResults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="list-group-item list-group-item-action py-2" 
                                             wire:click="selectDueInvoice(<?php echo e($invoice['invoice_id']); ?>)"
                                             style="cursor: pointer;">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="flex-grow-1">
                                                    <strong><?php echo e($invoice['invoice_no']); ?></strong> - <?php echo e($invoice['patient_name'] ?? 'N/A'); ?>

                                                    <br><small class="text-muted"><?php echo e($invoice['patient_code'] ?? 'N/A'); ?></small>
                                                    <!--[if BLOCK]><![endif]--><?php if($invoice['address']): ?>
                                                        <br><small class="text-muted"><?php echo e($invoice['address']); ?></small>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                                <div class="text-end ms-2" style="min-width: 120px;">
                                                    <small class="text-danger fw-bold">Due: ৳<?php echo e(number_format($invoice['due_amount'], 0)); ?></small>
                                                    <br><small class="text-muted"><?php echo e($invoice['phone'] ?? 'N/A'); ?></small>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            <?php else: ?>
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-search fa-2x mb-2"></i>
                                    <p>No due invoices found</p>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                    
                    <!-- Payment Summary -->
                    <div class="card border">
                        <div class="card-header bg-success text-white py-2">
                            <h6 class="mb-0"><i class="fas fa-calculator me-1"></i> Payment Summary</h6>
                        </div>
                        <div class="card-body">
                            <!-- Invoice Summary -->
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="alert alert-info mb-0">
                                        <div class="row">
                                            <div class="col-6">
                                                <strong>Invoice Total:</strong><br>
                                                <span class="h6"><?php echo e($selectedInvoice ? '৳ ' . number_format($selectedInvoice->total_amount, 0) : '৳ 0.00'); ?></span>
                                            </div>
                                            <div class="col-6">
                                                <strong>Already Paid:</strong><br>
                                                <span class="h6 text-success"><?php echo e($selectedInvoice ? '৳ ' . number_format($selectedInvoice->paid_amount, 0) : '৳ 0.00'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Due Collection Section -->
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label text-danger fw-bold">Due Amount</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control form-control-sm text-end text-danger fw-bold" 
                                           value="<?php echo e(number_format($dueAmount, 2)); ?>" readonly>
                                </div>
                            </div>
                            
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label">Collection Amount</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control form-control-sm text-end" 
                                           wire:model="collectionAmount" step="0.01" min="0">
                                </div>
                            </div>
                            
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label">Remaining Due</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control form-control-sm text-end text-warning fw-bold" 
                                           value="<?php echo e(number_format($remainingDue, 2)); ?>" readonly>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label class="col-sm-5 col-form-label">Remarks</label>
                                <div class="col-sm-7">
                                    <textarea class="form-control form-control-sm" wire:model="remarks" 
                                              rows="2" placeholder="Enter payment remarks (optional)"></textarea>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-success" wire:click="savePayment" 
                                        wire:loading.attr="disabled" wire:loading.class="disabled"
                                        <?php echo e(!$selectedInvoiceId ? 'disabled' : ''); ?>>
                                    <i class="fas fa-save me-1"></i> 
                                    <span wire:loading.remove>Save & Print</span>
                                    <span wire:loading>Saving...</span>
                                </button>
                                <button class="btn btn-info" disabled>
                                    <i class="fas fa-history me-1"></i> History
                                </button>
                                <button class="btn btn-secondary" wire:click="resetForm">
                                    <i class="fas fa-redo me-1"></i> Reset
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
        // Listen for due invoice search title updates
        Livewire.on('updateDueInvoiceSearchTitle', (data) => {
            const searchTitle = document.getElementById('search-title');
            if (searchTitle) {
                searchTitle.textContent = data.title;
            }
        });
    });
</script> <?php /**PATH C:\Users\aioli\Herd\diagnostic\resources\views/livewire/doctor-due-collection.blade.php ENDPATH**/ ?>