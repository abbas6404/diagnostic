@extends('admin.layouts.app')

@section('title', 'Doctor Due Collection')

@section('styles')
<style>
    .invoice-row {
        cursor: pointer;
        transition: all 0.2s;
    }
    .invoice-row:hover {
        background-color: #f8f9fa;
    }
    .invoice-row.selected {
        background-color: #e3f2fd;
        border-left: 3px solid #2196F3;
    }
    .payment-header {
        background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
    }
    .search-tabs .nav-link {
        color: #666;
        border: none;
        border-bottom: 2px solid transparent;
    }
    .search-tabs .nav-link.active {
        color: #2196F3;
        border-bottom-color: #2196F3;
        background: none;
    }
    
    /* Triangle indicator for due invoices table */
    .due-invoice-item {
        cursor: pointer;
    }
    .due-invoice-item:hover {
        background-color: rgba(0, 123, 255, 0.1);
    }
    .due-invoice-item.selected {
        background-color: rgba(0, 123, 255, 0.2);
    }
    .triangle-indicator {
        width: 0;
        height: 0;
        border-top: 8px solid transparent;
        border-left: 12px solid #2196F3;
        border-bottom: 8px solid transparent;
        display: inline-block;
        margin-right: 5px;
        visibility: hidden;
        transition: visibility 0.2s ease;
        position: relative;
        top: 2px;
        z-index: 10;
    }
    .due-invoice-item:hover .triangle-indicator {
        visibility: visible;
    }
    .due-invoice-item.selected .triangle-indicator {
        visibility: visible !important;
    }
    
    .keyboard-focus {
        border: 2px solid #2196F3 !important;
        box-shadow: 0 0 5px rgba(33, 150, 243, 0.3) !important;
    }
</style>
@endsection

@section('content')
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
                                    @livewire('doctor-due-collection-search')
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label text-end">Patient Name:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="patient_name" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label text-end">Age:</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="age_years" placeholder="Y" readonly>
                                                <input type="text" class="form-control form-control-sm" id="age_months" placeholder="M" readonly>
                                                <input type="text" class="form-control form-control-sm" id="age_days" placeholder="D" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label text-end">Sex:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="sex" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label text-end">Contact:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="contact" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label text-end">Address:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="address" readonly>
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
                                <table class="table table-sm table-hover mb-0" id="dueInvoicesTable" tabindex="0" style="outline: none;">
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
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                <i class="fas fa-search fa-2x mb-2"></i><br>
                                                Search for a patient or invoice to view due amounts
                                            </td>
                                        </tr>
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
                                <table class="table table-sm table-bordered mb-0" id="consultantTicketsTable">
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
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                <i class="fas fa-info-circle fa-2x mb-2"></i><br>
                                                Select an invoice to view consultant tickets
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-5">
                    <!-- Search Results Section -->
                    <div class="card border mb-3" id="search-results-container" tabindex="0" style="outline: none;">
                        <div class="card-header bg-primary text-white py-2">
                            <h6 class="mb-0"><i class="fas fa-search me-1"></i> <span id="search-title">Search Results</span></h6>
                        </div>
                        <div class="card-body p-0" style="height: 250px; overflow-y: auto;" id="search-results-body">
                            @livewire('doctor-due-collection-search-results')
                        </div>
                    </div>
                    
                    <!-- Payment Summary -->
                    <div class="card border">
                        <div class="card-header payment-header text-white py-2">
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
                                                <span class="h6" id="invoiceTotalDisplay">৳ 0.00</span>
                                </div>
                                            <div class="col-6">
                                                <strong>Already Paid:</strong><br>
                                                <span class="h6 text-success" id="paidAmountDisplay">৳ 0.00</span>
                            </div>
                                    </div>
                                </div>
                            </div>
                                </div>
                            
                            <!-- Due Collection Section -->
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label text-danger fw-bold">Due Amount</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control form-control-sm text-end text-danger fw-bold" id="dueAmount" value="0.00" readonly>
                            </div>
                                </div>
                            
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label">Collection Amount</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control form-control-sm text-end" id="collectionAmount" value="0.00" step="0.01" min="0">
                            </div>
                                </div>
                            
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label">Remaining Due</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control form-control-sm text-end text-warning fw-bold" id="remainingDue" value="0.00" readonly>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label class="col-sm-5 col-form-label">Remarks</label>
                                <div class="col-sm-7">
                                    <textarea class="form-control form-control-sm" id="remarks" rows="2" placeholder="Enter payment remarks (optional)"></textarea>
                                </div>
                            </div>

                            
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-success" id="savePaymentBtn" disabled>
                                    <i class="fas fa-save me-1"></i> Save & Print
                                </button>
                                <button class="btn btn-info" id="viewHistoryBtn" disabled>
                                    <i class="fas fa-history me-1"></i> History
                                </button>
                                <button class="btn btn-secondary" id="resetBtn">
                                    <i class="fas fa-redo me-1"></i> Reset
                                </button>
            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Payment History Modal -->
    <div class="modal fade" id="paymentHistoryModal" tabindex="-1" aria-labelledby="paymentHistoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentHistoryModalLabel">
                        <i class="fas fa-history me-2"></i> Payment History
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover" id="paymentHistoryTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Collection #</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th class="text-end">Amount</th>
                                    <th class="text-end">Due Before</th>
                                    <th class="text-end">Due After</th>
                                    <th>Collected By</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="fas fa-info-circle fa-2x mb-2"></i><br>
                                        Select an invoice to view payment history
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Flag to track if we're in due invoices mode
        let isInDueInvoicesMode = false;
        
        // Auto-select first search result when results are updated
        document.addEventListener('search-results-updated', function() {
            // Reset due invoices mode when new search results are loaded
            isInDueInvoicesMode = false;
            
            setTimeout(() => {
                const firstSearchItem = document.querySelector('.search-item');
                if (firstSearchItem) {
                    // Remove selected class from all items
                    document.querySelectorAll('.search-item').forEach(item => {
                        item.classList.remove('selected');
                        const triangle = item.querySelector('.triangle-indicator');
                        if (triangle) {
                            triangle.style.visibility = 'hidden';
                        }
                    });
                    
                    // Add selected class to first item
                    firstSearchItem.classList.add('selected');
                    
                    // Show triangle indicator for first item
                    const triangle = firstSearchItem.querySelector('.triangle-indicator');
                    if (triangle) {
                        triangle.style.visibility = 'visible';
                    }
                }
            }, 100);
        });
    
    // Handle arrow key navigation in search results (like invoice page)
    document.addEventListener('keydown', function(e) {
        // Handle arrow keys if we have search results AND not in due invoices mode
        if ((e.key === 'ArrowDown' || e.key === 'ArrowUp') && document.querySelector('.search-item') && !isInDueInvoicesMode) {
            // Focus the search results container if it's not already focused
            const searchResultsContainer = document.getElementById('search-results-container');
            if (searchResultsContainer && !searchResultsContainer.contains(document.activeElement)) {
                searchResultsContainer.focus();
            }
            e.preventDefault();
            
            const selectedItem = document.querySelector('.search-item.selected');
            let nextItem;
            
            if (e.key === 'ArrowDown') {
                if (selectedItem) {
                    // Get the next sibling that is a search item
                    nextItem = selectedItem.nextElementSibling;
                    while (nextItem && !nextItem.classList.contains('search-item')) {
                        nextItem = nextItem.nextElementSibling;
                    }
                    
                    // If no next item, select the first one
                    if (!nextItem) {
                        nextItem = document.querySelector('.search-item');
                    }
                } else {
                    // No selected item, select the first one
                    nextItem = document.querySelector('.search-item');
                }
            } else if (e.key === 'ArrowUp') {
                if (selectedItem) {
                    // Get the previous sibling that is a search item
                    nextItem = selectedItem.previousElementSibling;
                    while (nextItem && !nextItem.classList.contains('search-item')) {
                        nextItem = nextItem.previousElementSibling;
                    }
                    
                    // If no previous item, select the last one
                    if (!nextItem) {
                        const allItems = document.querySelectorAll('.search-item');
                        nextItem = allItems[allItems.length - 1];
                    }
                } else {
                    // No selected item, select the last one
                    const allItems = document.querySelectorAll('.search-item');
                    nextItem = allItems[allItems.length - 1];
                }
            }
            
            if (nextItem) {
                // Remove selected class from all items
                document.querySelectorAll('.search-item').forEach(item => {
                    item.classList.remove('selected');
                    // Hide all triangle indicators
                    const triangle = item.querySelector('.triangle-indicator');
                    if (triangle) {
                        triangle.style.visibility = 'hidden';
                    }
                });
                
                // Add selected class to next item
                nextItem.classList.add('selected');
                
                // Show triangle indicator for selected item
                const triangle = nextItem.querySelector('.triangle-indicator');
                if (triangle) {
                    triangle.style.visibility = 'visible';
                }
                
                // Scroll the item into view
                nextItem.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }
        // Handle Enter key to select the highlighted item
        else if (e.key === 'Enter' && document.querySelector('.search-item.selected')) {
            e.preventDefault();
            document.querySelector('.search-item.selected').click();
            
            // Set flag to disable search results arrow navigation
            isInDueInvoicesMode = true;
            
            // Focus due invoices table after selection and disable search results arrow navigation
            setTimeout(() => {
                const dueInvoicesTable = document.getElementById('dueInvoicesTable');
                const searchResultsContainer = document.getElementById('search-results-container');
                
                if (dueInvoicesTable) {
                    dueInvoicesTable.focus();
                    // Add visual feedback
                    document.querySelectorAll('.keyboard-focus').forEach(el => el.classList.remove('keyboard-focus'));
                    dueInvoicesTable.classList.add('keyboard-focus');
                    
                    // Remove focus from search results container to disable arrow navigation
                    if (searchResultsContainer) {
                        searchResultsContainer.blur();
                    }
                    
                    // Auto-select first due invoice if none is selected
                    const selectedItem = document.querySelector('.due-invoice-item.selected');
                    if (!selectedItem) {
                        const firstItem = document.querySelector('.due-invoice-item');
                        if (firstItem) {
                            // Remove selected class from all items
                            document.querySelectorAll('.due-invoice-item').forEach(item => {
                                item.classList.remove('selected');
                                const triangle = item.querySelector('.triangle-indicator');
                                if (triangle) {
                                    triangle.style.visibility = 'hidden';
                                }
                            });
                            
                            // Add selected class to first item
                            firstItem.classList.add('selected');
                            const triangle = firstItem.querySelector('.triangle-indicator');
                            if (triangle) {
                                triangle.style.visibility = 'visible';
                            }
                        }
                    }
                }
            }, 100);
        }
        
        // Arrow key navigation for due invoices table
        else if ((e.key === 'ArrowDown' || e.key === 'ArrowUp') && document.querySelector('.due-invoice-item') && 
                 (document.activeElement.id === 'dueInvoicesTable' || document.activeElement.closest('#dueInvoicesTable'))) {
            e.preventDefault();
            
            const allDueInvoiceItems = document.querySelectorAll('.due-invoice-item');
            const selectedItem = document.querySelector('.due-invoice-item.selected');
            let nextItem;
            
            if (e.key === 'ArrowDown') {
                if (selectedItem) {
                    // Find the index of the currently selected item
                    const currentIndex = Array.from(allDueInvoiceItems).indexOf(selectedItem);
                    
                    // Get the next item
                    const nextIndex = (currentIndex + 1) % allDueInvoiceItems.length;
                    nextItem = allDueInvoiceItems[nextIndex];
                } else {
                    // No selected item, select the first one
                    nextItem = allDueInvoiceItems[0];
                }
            } else if (e.key === 'ArrowUp') {
                if (selectedItem) {
                    // Find the index of the currently selected item
                    const currentIndex = Array.from(allDueInvoiceItems).indexOf(selectedItem);
                    
                    // Get the previous item
                    const prevIndex = currentIndex === 0 ? allDueInvoiceItems.length - 1 : currentIndex - 1;
                    nextItem = allDueInvoiceItems[prevIndex];
            } else {
                    // No selected item, select the last one
                    nextItem = allDueInvoiceItems[allDueInvoiceItems.length - 1];
                }
            }
            
            if (nextItem) {
                // Remove selected class from all items and clear triangles
                document.querySelectorAll('.due-invoice-item').forEach(item => {
                    item.classList.remove('selected');
                    // Clear triangle from first cell
                    const firstCell = item.querySelector('td:first-child');
                    if (firstCell) {
                        firstCell.innerHTML = '';
                    }
                });
                
                // Add selected class to next item
                nextItem.classList.add('selected');
                
                // Show triangle indicator for selected item
                const firstCell = nextItem.querySelector('td:first-child');
                if (firstCell) {
                    // Clear existing content and create new triangle
                    firstCell.innerHTML = '';
                    const triangle = document.createElement('div');
                    triangle.innerHTML = '▶'; // Unicode triangle
                    triangle.style.cssText = `
                        color: #00ff00;
                        font-size: 16px;
                        font-weight: bold;
                        display: inline-block;
                        margin-right: 5px;
                        visibility: visible;
                        text-align: center;
                    `;
                    firstCell.appendChild(triangle);
                }
                
                // Load consultant tickets for the selected item
                const invoiceId = nextItem.getAttribute('data-invoice-id');
                if (invoiceId) {
                    loadConsultantTickets(invoiceId);
                }
                
                // Scroll the item into view
                nextItem.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }
        // Handle Enter key to select due invoice
        else if (e.key === 'Enter' && document.querySelector('.due-invoice-item.selected') && 
                 (document.activeElement.id === 'dueInvoicesTable' || document.activeElement.closest('#dueInvoicesTable'))) {
            e.preventDefault();
            const selectedItem = document.querySelector('.due-invoice-item.selected');
            selectedItem.click();
            
            // Focus collection amount after selection
            setTimeout(() => {
                const collectionAmountInput = document.getElementById('collectionAmount');
                if (collectionAmountInput) {
                    collectionAmountInput.focus();
                    collectionAmountInput.select();
                }
            }, 100);
        }
        
        // Handle Enter key on collection amount to focus save button
        else if (e.key === 'Enter' && document.activeElement.id === 'collectionAmount') {
            e.preventDefault();
            const remarksInput = document.getElementById('remarks');
            if (remarksInput) {
                remarksInput.focus();
            }
        }
        
        // Handle Enter key on remarks to focus save button
        else if (e.key === 'Enter' && document.activeElement.id === 'remarks') {
            e.preventDefault();
            const saveButton = document.getElementById('savePaymentBtn');
            if (saveButton && !saveButton.disabled) {
                saveButton.focus();
            }
        }
        
        // Handle Enter key on save button to submit
        else if (e.key === 'Enter' && document.activeElement.id === 'savePaymentBtn') {
            e.preventDefault();
            if (window.savePayment) {
                window.savePayment();
            }
        }
    });
    
    // Add click handler to due invoices table for keyboard navigation
    const dueInvoicesTable = document.getElementById('dueInvoicesTable');
    if (dueInvoicesTable) {
        dueInvoicesTable.addEventListener('click', function() {
            this.focus();
            // Add visual feedback
            document.querySelectorAll('.keyboard-focus').forEach(el => el.classList.remove('keyboard-focus'));
            this.classList.add('keyboard-focus');
        });
    }
    
    // Add click handler to search results container for keyboard navigation
    const searchResultsContainer = document.getElementById('search-results-container');
    if (searchResultsContainer) {
        searchResultsContainer.addEventListener('click', function() {
            this.focus();
            // Add visual feedback
            document.querySelectorAll('.keyboard-focus').forEach(el => el.classList.remove('keyboard-focus'));
            this.classList.add('keyboard-focus');
        });
    }
    
    // Listen for Livewire events
window.addEventListener('invoice-selected', event => {
    let invoice = event.detail;
    
    // Handle case where invoice might be an array
    if (Array.isArray(invoice) && invoice.length > 0) {
        invoice = invoice[0];
    }
    
    if (!invoice) {
        return;
    }
    
    // Update search input with patient code
    const searchInput = document.querySelector('input[wire\\:model\\.live\\.debounce\\.300ms="search"]');
    if (searchInput && invoice.patient_code) {
        searchInput.value = invoice.patient_code;
    }
    
    // Fill patient information with proper null checks
    const patientNameInput = document.getElementById('patient_name');
    if (patientNameInput) patientNameInput.value = invoice.patient_name || '';
    const ageYearsInput = document.getElementById('age_years');
    if (ageYearsInput) ageYearsInput.value = invoice.age_years !== undefined && invoice.age_years !== null ? Math.floor(invoice.age_years) : '';
    const ageMonthsInput = document.getElementById('age_months');
    if (ageMonthsInput) ageMonthsInput.value = invoice.age_months !== undefined && invoice.age_months !== null ? Math.floor(invoice.age_months) : '';
    const ageDaysInput = document.getElementById('age_days');
    if (ageDaysInput) ageDaysInput.value = invoice.age_days !== undefined && invoice.age_days !== null ? Math.floor(invoice.age_days) : '';
    const sexInput = document.getElementById('sex');
    if (sexInput) sexInput.value = invoice.gender || '';
    const contactInput = document.getElementById('contact');
    if (contactInput) contactInput.value = invoice.phone || '';
    const addressInput = document.getElementById('address');
    if (addressInput) addressInput.value = invoice.address || '';
    
    // Fill payment summary
    const totalAmountInput = document.getElementById('totalAmount');
    if (totalAmountInput) totalAmountInput.value = parseFloat(invoice.due_amount).toFixed(0);
    const discountPercentInput = document.getElementById('discountPercent');
    if (discountPercentInput) discountPercentInput.value = invoice.discount_percentage || '0.00';
    const discountAmountInput = document.getElementById('discountAmount');
    if (discountAmountInput) discountAmountInput.value = parseFloat(invoice.discount_amount || 0).toFixed(0);
    const netPayableInput = document.getElementById('netPayable');
    if (netPayableInput) netPayableInput.value = parseFloat(invoice.payable_amount || invoice.total_amount).toFixed(0);
    const paidAmountInput = document.getElementById('paidAmount');
    if (paidAmountInput) paidAmountInput.value = parseFloat(invoice.paid_amount).toFixed(0);
    const dueAmountInput = document.getElementById('dueAmount');
    if (dueAmountInput) dueAmountInput.value = parseFloat(invoice.due_amount).toFixed(0);
    const collectionAmountInput = document.getElementById('collectionAmount');
    if (collectionAmountInput) collectionAmountInput.value = parseFloat(invoice.due_amount).toFixed(0);
    const remainingDueInput = document.getElementById('remainingDue');
    if (remainingDueInput) remainingDueInput.value = '0';
    
    // Enable save button
    document.getElementById('savePaymentBtn').disabled = false;
    
    // Enable history button and store selected invoice ID
    document.getElementById('viewHistoryBtn').disabled = false;
    window.selectedInvoiceId = invoice.invoice_id;
    
    // Select the corresponding invoice in Due Invoices table
    setTimeout(() => {
        selectInvoiceInDueInvoicesTable(invoice.invoice_id);
    }, 1000); // Increased delay to ensure Due Invoices table is fully loaded
});

window.addEventListener('patient-due-invoices-loaded', event => {
    let invoices = event.detail;
    
    // Handle case where invoices might be wrapped in an array
    if (Array.isArray(invoices) && invoices.length > 0 && Array.isArray(invoices[0])) {
        invoices = invoices[0];
    }
    
    if (!invoices || !Array.isArray(invoices)) {
        return;
    }
    
    updateDueInvoicesTable(invoices);
    
    // Auto-selection handled in the triangle visibility setup below
    
    // After updating the table, try to select the invoice that was selected in Search Results
    setTimeout(() => {
        const searchItems = document.querySelectorAll('.search-item');
        const selectedSearchItem = Array.from(searchItems).find(item => item.classList.contains('selected'));
        if (selectedSearchItem) {
            const selectedInvoiceId = selectedSearchItem.getAttribute('data-invoice-id');
            if (selectedInvoiceId) {
                selectInvoiceInDueInvoicesTable(selectedInvoiceId);
            }
        }
    }, 200);
    
    // Fix triangle visibility after a delay - only show green on selected item
    setTimeout(() => {
        const dueInvoiceItems = document.querySelectorAll('.due-invoice-item');
        
        // Clear all triangles first
        dueInvoiceItems.forEach((item, index) => {
            const firstCell = item.querySelector('td:first-child');
            if (firstCell) {
                firstCell.innerHTML = '';
            }
        });
        
        // Only show green triangle on first (selected) item
        if (dueInvoiceItems.length > 0) {
            const firstItem = dueInvoiceItems[0];
            const firstCell = firstItem.querySelector('td:first-child');
            if (firstCell) {
                const triangle = document.createElement('div');
                triangle.innerHTML = '▶'; // Unicode triangle
                triangle.style.cssText = `
                    color: #00ff00;
                    font-size: 16px;
                    font-weight: bold;
                    display: inline-block;
                    margin-right: 5px;
                    visibility: visible;
                    text-align: center;
                `;
                firstCell.appendChild(triangle);
                firstItem.classList.add('selected');
            }
        }
    }, 300);
});

window.addEventListener('consultant-tickets-loaded', event => {
    let tickets = event.detail;
    
    // Handle case where tickets might be wrapped in an array
    if (Array.isArray(tickets) && tickets.length > 0 && Array.isArray(tickets[0])) {
        tickets = tickets[0];
    }
    
    if (!tickets || !Array.isArray(tickets)) {
        return;
    }
    
    updateConsultantTicketsTable(tickets);
});

function selectInvoiceInDueInvoicesTable(invoiceId) {
    const dueInvoiceItems = document.querySelectorAll('.due-invoice-item');
    
    let found = false;
    
    dueInvoiceItems.forEach((item, index) => {
        const itemInvoiceId = item.getAttribute('data-invoice-id');
        if (itemInvoiceId == invoiceId) {
            // Remove selected class from all items and clear triangles
            dueInvoiceItems.forEach(row => {
                    row.classList.remove('selected');
                const firstCell = row.querySelector('td:first-child');
                if (firstCell) {
                    firstCell.innerHTML = '';
                }
            });
            
            // Add selected class to matching item and create green triangle
            item.classList.add('selected');
            const firstCell = item.querySelector('td:first-child');
            if (firstCell) {
                const triangle = document.createElement('div');
                triangle.innerHTML = '▶'; // Unicode triangle
                triangle.style.cssText = `
                    color: #00ff00;
                    font-size: 16px;
                    font-weight: bold;
                    display: inline-block;
                    margin-right: 5px;
                    visibility: visible;
                    text-align: center;
                `;
                firstCell.appendChild(triangle);
            }
            
            // Scroll to the selected item
            item.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            
            // Load consultant tickets
            loadConsultantTickets(invoiceId);
            
            found = true;
        }
    });
}

function selectInvoiceInSearchResults(invoiceId) {
    const searchItems = document.querySelectorAll('.search-item');
    let found = false;
    
    searchItems.forEach((item, index) => {
        const itemInvoiceId = item.getAttribute('data-invoice-id');
        if (itemInvoiceId == invoiceId) {
            // Remove selected class from all items
            searchItems.forEach(row => {
                row.classList.remove('selected');
                const triangle = row.querySelector('.triangle-indicator');
                if (triangle) {
                    triangle.style.visibility = 'hidden';
                }
            });
            
            // Add selected class to matching item
            item.classList.add('selected');
            const triangle = item.querySelector('.triangle-indicator');
            if (triangle) {
                triangle.style.visibility = 'visible';
            }
            
            // Scroll to the selected item
            item.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            
            found = true;
        }
    });
}

function preserveSearchResultsSelection() {
    // This function ensures Search Results selection is never changed from external actions
    // Do nothing - this prevents any external changes to Search Results
}

function updateDueInvoicesTable(invoices) {
        const tbody = document.querySelector('#dueInvoicesTable tbody');
        tbody.innerHTML = '';
        
        if (invoices.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-muted py-4">
                    No invoices found for this patient
                </td>
            </tr>
        `;
            return;
        }
        
    invoices.forEach((invoice, index) => {
            const tr = document.createElement('tr');
        tr.className = 'due-invoice-item';
        tr.setAttribute('data-invoice-id', invoice.id);
        tr.setAttribute('data-index', index);
        
                        tr.onclick = () => {
                // Remove selected class from all rows
                document.querySelectorAll('.due-invoice-item').forEach(row => {
                    row.classList.remove('selected');
                    const triangle = row.querySelector('.triangle-indicator');
                    if (triangle) {
                        triangle.style.visibility = 'hidden';
                    }
                });
                
                // Add selected class to clicked row
                tr.classList.add('selected');
                const triangle = tr.querySelector('.triangle-indicator');
                if (triangle) {
                    triangle.style.visibility = 'visible';
                }
                
                loadConsultantTickets(invoice.id);
                
                // Focus the due invoices table for keyboard navigation
                const dueInvoicesTable = document.getElementById('dueInvoicesTable');
                if (dueInvoicesTable) {
                    dueInvoicesTable.focus();
                }
            };
        
        // Determine due amount color
        const dueAmount = parseFloat(invoice.due_amount);
        const dueClass = dueAmount > 0 ? 'text-danger fw-bold' : 'text-success';
        const dueText = dueAmount > 0 ? dueAmount.toFixed(0) : 'Paid';
            
            tr.innerHTML = `
            <td style="width: 20px; text-align: center;"><div class="triangle-indicator" style="visibility: hidden; display: inline-block;"></div></td>
            <td>${invoice.invoice_no}</td>
            <td>${invoice.invoice_date}</td>
            <td class="text-end">${parseFloat(invoice.total_amount).toFixed(0)}</td>
            <td class="text-end">${parseFloat(invoice.paid_amount).toFixed(0)}</td>
            <td class="text-end ${dueClass}">${dueText}</td>
        `;
            
            tbody.appendChild(tr);
        });
    
    // Focus the due invoices table for keyboard navigation
    const dueInvoicesTable = document.getElementById('dueInvoicesTable');
    if (dueInvoicesTable) {
        dueInvoicesTable.focus();
    }
}

function loadConsultantTickets(invoiceId) {
    // Make AJAX call to load consultant tickets
    fetch(`/admin/doctor/duecollection/invoice/${invoiceId}/tickets`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.tickets) {
                updateConsultantTicketsTable(data.tickets);
            }
        })
        .catch(error => {
            console.error('Error loading consultant tickets:', error);
        });
    
    // Also fetch full invoice data to update payment summary
    fetch(`/admin/doctor/duecollection/invoice/${invoiceId}/full-data`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.invoice) {
                updatePaymentSummary(data.invoice);
            }
        })
        .catch(error => {
            console.error('Error loading full invoice data:', error);
        });
}

function updatePaymentSummary(invoice) {
    // Update invoice summary display
    document.getElementById('invoiceTotalDisplay').textContent = '৳ ' + parseFloat(invoice.total_amount).toFixed(0);
    document.getElementById('paidAmountDisplay').textContent = '৳ ' + parseFloat(invoice.paid_amount).toFixed(0);
    
    // Update due collection fields
    document.getElementById('dueAmount').value = parseFloat(invoice.due_amount).toFixed(0);
    document.getElementById('collectionAmount').value = parseFloat(invoice.due_amount).toFixed(0);
    document.getElementById('remainingDue').value = '0';
    
    // Enable save button
    document.getElementById('savePaymentBtn').disabled = false;
    
    // Set up event listeners for the collection amount field
    setupCollectionAmountListeners();
    
    // Trigger initial calculation
    setTimeout(() => {
        window.calculateRemainingDue();
    }, 200);
}

// Function to set up collection amount listeners
function setupCollectionAmountListeners() {
    const collectionAmountInput = document.getElementById('collectionAmount');
    
    if (collectionAmountInput) {
        // Remove any existing listeners first
        collectionAmountInput.removeEventListener('input', handleCollectionAmountChange);
        collectionAmountInput.removeEventListener('blur', handleCollectionAmountChange);
        collectionAmountInput.removeEventListener('keyup', handleCollectionAmountChange);
        
        // Add new listeners
        collectionAmountInput.addEventListener('input', handleCollectionAmountChange);
        collectionAmountInput.addEventListener('blur', handleCollectionAmountChange);
        collectionAmountInput.addEventListener('keyup', handleCollectionAmountChange);
    }
}

// Handler function for collection amount changes
function handleCollectionAmountChange(e) {
    window.calculateRemainingDue();
}

// Add event listeners
document.addEventListener('DOMContentLoaded', function() {
    const savePaymentBtn = document.getElementById('savePaymentBtn');
    const viewHistoryBtn = document.getElementById('viewHistoryBtn');
    const resetBtn = document.getElementById('resetBtn');
    
    if (savePaymentBtn) {
        savePaymentBtn.addEventListener('click', window.savePayment);
    }
    
    if (viewHistoryBtn) {
        viewHistoryBtn.addEventListener('click', window.viewPaymentHistory);
    }

    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            document.getElementById('collectionAmount').value = '';
            document.getElementById('remarks').value = '';
            document.getElementById('dueAmount').value = '0.00';
            document.getElementById('remainingDue').value = '0.00';
            document.getElementById('invoiceTotalDisplay').textContent = '৳ 0.00';
            document.getElementById('paidAmountDisplay').textContent = '৳ 0.00';
            document.getElementById('savePaymentBtn').disabled = true;
            document.getElementById('viewHistoryBtn').disabled = true;
            window.selectedInvoiceId = null;
            // Clear triangle indicators
            document.querySelectorAll('.due-invoice-item').forEach(item => {
                const firstCell = item.querySelector('td:first-child');
                if (firstCell) {
                    firstCell.innerHTML = '';
                }
            });
            document.querySelectorAll('.search-item').forEach(item => {
                item.classList.remove('selected');
                const triangle = item.querySelector('.triangle-indicator');
                if (triangle) {
                    triangle.style.visibility = 'hidden';
                }
            });
        });
    }
    
    // Set up collection amount listeners
    setupCollectionAmountListeners();
});

// Make function globally accessible
window.calculateRemainingDue = function() {
    const dueAmountElement = document.getElementById('dueAmount');
    const collectionAmountElement = document.getElementById('collectionAmount');
    const remainingDueElement = document.getElementById('remainingDue');
    
    if (!dueAmountElement || !collectionAmountElement || !remainingDueElement) {
        return;
    }
    
    // Get the raw values from the input fields
    const dueAmountRaw = dueAmountElement.value;
    const collectionAmountRaw = collectionAmountElement.value;
    
    const dueAmount = parseFloat(dueAmountRaw) || 0;
    const collectionAmount = parseFloat(collectionAmountRaw) || 0;
    
    if (collectionAmount > dueAmount) {
        alert('Collection amount cannot exceed due amount');
        collectionAmountElement.value = dueAmount.toFixed(2);
        remainingDueElement.value = '0.00';
    } else {
        const remainingDue = dueAmount - collectionAmount;
        remainingDueElement.value = remainingDue.toFixed(2);
    }
};

// Make function globally accessible
window.savePayment = function() {
    const collectionAmount = parseFloat(document.getElementById('collectionAmount').value);
    const dueAmount = parseFloat(document.getElementById('dueAmount').value);
    const remarks = document.getElementById('remarks').value;
    
    // Validate collection amount
    if (collectionAmount <= 0) {
        Livewire.dispatch('showError', { message: 'Please enter a valid collection amount' });
        return;
    }
    
    if (collectionAmount > dueAmount) {
        Livewire.dispatch('showError', { message: 'Collection amount cannot exceed due amount' });
        return;
    }
    
    // Get selected invoice ID
    const selectedInvoiceId = window.selectedInvoiceId;
    if (!selectedInvoiceId) {
        Livewire.dispatch('showError', { message: 'Please select an invoice first' });
        return;
    }
    
    // Disable save button to prevent double submission
    const saveBtn = document.getElementById('savePaymentBtn');
    const originalText = saveBtn.innerHTML;
    saveBtn.disabled = true;
    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Saving...';
    
    const paymentData = {
        invoice_id: selectedInvoiceId,
        collection_amount: collectionAmount,
        remarks: remarks
    };
    
    // Send payment data to server
    fetch('/admin/doctor/duecollection/store', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(paymentData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success toast with payment details
            Livewire.dispatch('showPaymentSuccess', { 
                message: 'Payment collected successfully!',
                invoiceNo: data.collection_no
            });
            
            // Update the UI
            updatePaymentUI(data.updated_invoice);
            
            // Clear the collection form
            document.getElementById('collectionAmount').value = '';
            document.getElementById('remarks').value = '';
            
            // Refresh the due invoices list by triggering a search
            const searchInput = document.querySelector('input[wire\\:model\\.live\\.debounce\\.300ms="search"]');
            if (searchInput && searchInput.value) {
                // Trigger a new search to refresh the data
                searchInput.dispatchEvent(new Event('input'));
            }
            
        } else {
            // Show error toast
            Livewire.dispatch('showError', { message: 'Error saving payment: ' + data.message });
        }
        
        // Re-enable save button
        saveBtn.disabled = false;
        saveBtn.innerHTML = originalText;
    })
    .catch(error => {
        console.error('Error:', error);
        // Show error toast
        Livewire.dispatch('showError', { message: 'Error saving payment. Please try again.' });
        
        // Re-enable save button
        saveBtn.disabled = false;
        saveBtn.innerHTML = originalText;
    });
}

function updatePaymentUI(updatedInvoice) {
    // Update the payment summary display
    if (updatedInvoice) {
        document.getElementById('invoiceTotalDisplay').textContent = '৳ ' + parseFloat(updatedInvoice.total_amount || 0).toFixed(0);
        document.getElementById('paidAmountDisplay').textContent = '৳ ' + parseFloat(updatedInvoice.paid_amount || 0).toFixed(0);
        document.getElementById('dueAmount').value = parseFloat(updatedInvoice.due_amount || 0).toFixed(0);
        
        // Update collection amount to remaining due
        document.getElementById('collectionAmount').value = parseFloat(updatedInvoice.due_amount || 0).toFixed(0);
        document.getElementById('remainingDue').value = '0.00';
        
        // Disable save button if no due amount
        const saveBtn = document.getElementById('savePaymentBtn');
        if (parseFloat(updatedInvoice.due_amount || 0) <= 0) {
            saveBtn.disabled = true;
        }
    }
}

function loadDueInvoices() {
    // This function would reload the due invoices for the current patient
    // Implementation depends on how you want to refresh the data
    console.log('Reloading due invoices...');
    // You can trigger a Livewire event or make an AJAX call here
}

// Make function globally accessible
window.viewPaymentHistory = function() {
    const selectedInvoiceId = window.selectedInvoiceId;
    if (!selectedInvoiceId) {
        Livewire.dispatch('showError', { message: 'Please select an invoice first' });
        return;
    }
    
    // Load payment history
    fetch(`/admin/doctor/duecollection/invoice/${selectedInvoiceId}/payment-history`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updatePaymentHistoryTable(data.payments);
                // Show the modal
                const modal = new bootstrap.Modal(document.getElementById('paymentHistoryModal'));
                modal.show();
            } else {
                Livewire.dispatch('showError', { message: 'Error loading payment history: ' + data.message });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Livewire.dispatch('showError', { message: 'Error loading payment history. Please try again.' });
        });
}

function updatePaymentHistoryTable(payments) {
    const tbody = document.querySelector('#paymentHistoryTable tbody');
    if (!tbody) {
        return;
    }
    
    tbody.innerHTML = '';
    
    if (!payments || payments.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="8" class="text-center text-muted py-4">
                    <i class="fas fa-info-circle fa-2x mb-2"></i><br>
                    No payment history found for this invoice
                </td>
            </tr>
        `;
        return;
    }
    
    payments.forEach(payment => {
        const tr = document.createElement('tr');
        
        tr.innerHTML = `
            <td><strong>${payment.collection_no}</strong></td>
            <td>${payment.collection_date}</td>
            <td>${payment.collection_time}</td>
            <td class="text-end text-success fw-bold">৳ ${parseFloat(payment.collection_amount).toFixed(0)}</td>
            <td class="text-end">৳ ${parseFloat(payment.due_before_collection).toFixed(0)}</td>
            <td class="text-end">৳ ${parseFloat(payment.due_after_collection).toFixed(0)}</td>
            <td>${payment.collected_by_name || 'N/A'}</td>
            <td>${payment.remarks || '-'}</td>
        `;
        
        tbody.appendChild(tr);
    });
}

function updateConsultantTicketsTable(tickets) {
    const tbody = document.querySelector('#consultantTicketsTable tbody');
    if (!tbody) {
        return;
    }
    
    tbody.innerHTML = '';
    
    if (tickets.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-muted py-4">
                    No consultant tickets found for this invoice
                </td>
            </tr>
        `;
        return;
    }
    
    tickets.forEach(ticket => {
        const tr = document.createElement('tr');
        tr.className = 'ticket-row';
        
        // Determine status badge color
        let statusClass = 'badge bg-secondary';
        if (ticket.ticket_status === 'completed') {
            statusClass = 'badge bg-success';
        } else if (ticket.ticket_status === 'pending') {
            statusClass = 'badge bg-warning';
        } else if (ticket.ticket_status === 'cancelled') {
            statusClass = 'badge bg-danger';
        }
        
        tr.innerHTML = `
            <td>${Number(ticket.ticket_no || 0)}</td>
            <td>${ticket.doctor_name || '-'}</td>
            <td>${ticket.ticket_date || '-'}</td>
            <td>${ticket.ticket_time || '-'}</td>
            <td class="text-end">N/A</td>
            <td class="text-center"><span class="${statusClass}">${ticket.ticket_status || 'pending'}</span></td>
        `;
        tbody.appendChild(tr);
    });
}

});
</script>
@endsection 