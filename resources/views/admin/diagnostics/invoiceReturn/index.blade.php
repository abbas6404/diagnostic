@extends('admin.layouts.app')

@section('title', 'Invoice Return - Diagnostics')

@section('styles')
<style>
    .search-results {
        max-height: 200px;
        overflow-y: auto;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        position: absolute;
        z-index: 1000;
        background-color: white;
        width: 100%;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .search-item {
        cursor: pointer;
    }
    .search-item:hover {
        background-color: rgba(220,53,69,0.1);
    }
    .search-item.selected {
        background-color: rgba(220,53,69,0.2);
    }
    .col-sm-8 {
        position: relative;
    }
    .return-header {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    }
    .item-checkbox {
        transform: scale(1.2);
        margin-right: 8px;
    }
    .selected-item {
        background-color: rgba(220, 53, 69, 0.1) !important;
        border-left: 3px solid #dc3545;
    }
    .refund-amount-input {
        width: 80px;
        text-align: center;
    }
    .refund-percentage {
        font-size: 0.8em;
        color: #666;
    }
    .item-refund-row {
        transition: all 0.2s ease;
    }
    .item-refund-row:hover {
        background-color: rgba(220, 53, 69, 0.05);
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-danger">
                    <i class="fas fa-undo me-2"></i> Lab Test Refund - Diagnostics
                </h5>
                <div>
                    <a href="#" class="btn btn-sm btn-outline-secondary me-2">
                        <i class="fas fa-list me-1"></i> Invoice List
                    </a>
                    <button class="btn btn-sm btn-danger" id="newReturnBtn">
                        <i class="fas fa-undo me-1"></i> New Refund
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
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
                                        <label class="col-sm-4 col-form-label">Invoice No:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="invoice_search" placeholder="Search invoice..." tabindex="1">
                                            <input type="hidden" id="invoice_id_hidden">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Patient Name:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="patient_name" readonly tabindex="2">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Age:</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" placeholder="Y" style="width: 30%;" id="age_years" readonly tabindex="3">
                                                <input type="text" class="form-control form-control-sm" placeholder="M" style="width: 30%;" id="age_months" readonly tabindex="4">
                                                <input type="text" class="form-control form-control-sm" placeholder="D" style="width: 30%;" id="age_days" readonly tabindex="5">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Sex:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="gender" readonly tabindex="6">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Contact:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="patient_phone" readonly tabindex="7">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Address:</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control form-control-sm" rows="2" id="patient_address" readonly tabindex="8"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Invoice Date:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" id="invoice_date" readonly tabindex="9">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Total Amount:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm text-end fw-bold" id="total_amount" readonly tabindex="10">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Paid Amount:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm text-end text-success fw-bold" id="paid_amount" readonly tabindex="11">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Due Amount:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm text-end text-danger fw-bold" id="due_amount" readonly tabindex="12">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Lab Test Details with Refund Options -->
                    <div class="card border mt-3">
                        <div class="card-header bg-light py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0"><i class="fas fa-flask me-1"></i> Lab Test Details</h6>
                                <div>
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="selectAllBtn">
                                        <i class="fas fa-check-square me-1"></i> Select All
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="deselectAllBtn">
                                        <i class="fas fa-square me-1"></i> Deselect All
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                <table class="table table-sm table-bordered mb-0" id="testItemsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 40px;">
                                                <input type="checkbox" class="form-check-input item-checkbox" id="selectAllCheckbox">
                                            </th>
                                            <th style="width: 80px;">Code</th>
                                            <th>Test Name</th>
                                            <th style="width: 80px;" class="text-end">Charge</th>
                                            <th style="width: 100px;" class="text-center">Status</th>
                                            <th style="width: 100px;" class="text-end">Refund Amount</th>
                                            <th style="width: 80px;" class="text-center">%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">
                                                <i class="fas fa-info-circle fa-2x mb-2"></i><br>
                                                Select an invoice to view test details
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
                    <!-- Search Results Area -->
                    <div class="card border mb-3" id="search-results-container">
                        <div class="card-header bg-danger text-white py-2">
                            <h6 class="mb-0"><i class="fas fa-search me-1"></i> <span id="search-title">Search Results</span></h6>
                        </div>
                        <div class="card-body p-0" style="height: 250px; overflow-y: auto;" id="search-results-body">
                            <div class="p-3 text-center text-muted">
                                <i class="fas fa-search fa-2x mb-2"></i><br>
                                Search for invoices to process refunds
                            </div>
                        </div>
                    </div>
                    
                    <!-- Refund Summary -->
                    <div class="card border">
                        <div class="card-header return-header text-white py-2">
                            <h6 class="mb-0"><i class="fas fa-undo me-1"></i> Refund Summary</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <label class="col-sm-6 col-form-label">Selected Items:</label>
                                <div class="col-sm-6">
                                    <span class="badge bg-primary" id="selectedItemsCount">0</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-6 col-form-label">Total Refund Amount:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-sm text-end fw-bold text-danger" id="totalRefundAmount" readonly value="0.00">
                                </div>
                            </div>
                            
                            <div class="row mb-2">
                                <label class="col-sm-6 col-form-label">Refund Reason</label>
                                <div class="col-sm-6">
                                    <select class="form-select form-select-sm" id="returnReason" tabindex="20" disabled>
                                        <option value="">Select reason</option>
                                        <option value="Test Cancelled">Test Cancelled</option>
                                        <option value="Patient Request">Patient Request</option>
                                        <option value="Technical Issue">Technical Issue</option>
                                        <option value="Sample Rejected">Sample Rejected</option>
                                        <option value="Equipment Failure">Equipment Failure</option>
                                        <option value="Duplicate Payment">Duplicate Payment</option>
                                        <option value="Overpayment">Overpayment</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row mb-2">
                                <label class="col-sm-6 col-form-label">Other Reason</label>
                                <div class="col-sm-6">
                                    <textarea class="form-control form-control-sm" id="otherReason" rows="2" placeholder="Specify other reason..." tabindex="21" disabled></textarea>
                                </div>
                            </div>
                            
                            <div class="row mb-2">
                                <label class="col-sm-6 col-form-label">Remaining Amount</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control form-control-sm text-end text-success fw-bold" id="remainingAmount" readonly value="0.00">
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-center gap-2 mt-4">
                                <button class="btn btn-danger" id="processReturnBtn" disabled tabindex="22">
                                    <i class="fas fa-undo me-1"></i> Process Refund
                                </button>
                                <button class="btn btn-secondary" id="resetFormBtn" tabindex="23">
                                    <i class="fas fa-sync-alt me-1"></i> Reset
                                </button>
                                <button class="btn btn-outline-secondary" id="cancelBtn" tabindex="24">
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
@endsection

@section('scripts')
<script>
let selectedInvoiceId = null;
let currentPaidAmount = 0;
let selectedItems = new Map(); // itemId -> {charge, refundAmount, percentage}
let testItems = [];
let searchResults = [];
let selectedSearchIndex = -1;

// Search functionality with debouncing
let searchTimeout;
document.getElementById('invoice_search').addEventListener('input', function() {
    const query = this.value.trim();
    
    // Clear previous timeout
    clearTimeout(searchTimeout);
    
    if (query.length < 2) {
        clearSearchResults();
        return;
    }
    
    // Debounce search
    searchTimeout = setTimeout(() => {
        searchInvoices(query);
    }, 300);
});

function searchInvoices(query) {
    fetch(`/admin/diagnostics/invoice-return/search?query=${encodeURIComponent(query)}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                console.error('Search error:', data.error);
                clearSearchResults();
                return;
            }
            searchResults = data;
            displaySearchResults(data);
            
            // Update search title
            document.getElementById('search-title').textContent = 'Search Results';
        })
        .catch(error => {
            console.error('Search error:', error);
            clearSearchResults();
        });
}

function displaySearchResults(results) {
    const container = document.getElementById('search-results-body');
    
    if (results.length === 0) {
        container.innerHTML = `
            <div class="p-3 text-center text-muted">
                <i class="fas fa-info-circle fa-2x mb-2"></i><br>
                No invoices found matching your search
            </div>
        `;
        return;
    }
    
    let html = '<div class="table-responsive"><table class="table table-sm table-hover mb-0">';
    html += '<thead class="table-light"><tr>';
    html += '<th>Invoice No</th>';
    html += '<th>Patient Name</th>';
    html += '<th class="text-end">Total</th>';
    html += '<th class="text-end">Paid</th>';
    html += '<th class="text-end">Due</th>';
    html += '</tr></thead><tbody>';
    
    results.forEach((invoice, index) => {
        const rowClass = index === selectedSearchIndex ? 'search-item selected' : 'search-item';
        html += `
            <tr class="${rowClass}" data-index="${index}" onclick="selectInvoiceFromSearch(${invoice.invoice_id})" style="cursor: pointer;">
                <td class="fw-bold">${invoice.invoice_no}</td>
                <td>${invoice.patient_name || 'N/A'}</td>
                <td class="text-end">${Number(invoice.total_amount).toFixed(0)}</td>
                <td class="text-end text-success">${Number(invoice.paid_amount).toFixed(0)}</td>
                <td class="text-end text-danger">${Number(invoice.due_amount).toFixed(0)}</td>
            </tr>
        `;
    });
    
    html += '</tbody></table></div>';
    container.innerHTML = html;
    
    // Auto-select first item if none selected
    if (selectedSearchIndex === -1 && results.length > 0) {
        selectedSearchIndex = 0;
        updateSearchSelection();
    }
}

function updateSearchSelection() {
    // Remove previous selection
    document.querySelectorAll('.search-item').forEach(item => {
        item.classList.remove('selected');
    });
    
    // Add selection to current item
    if (selectedSearchIndex >= 0 && selectedSearchIndex < searchResults.length) {
        const selectedRow = document.querySelector(`[data-index="${selectedSearchIndex}"]`);
        if (selectedRow) {
            selectedRow.classList.add('selected');
        }
    }
}

function selectInvoiceFromSearch(invoiceId) {
    fetch(`/admin/diagnostics/invoice-return/invoice/${invoiceId}/details`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                alert('Error loading invoice details: ' + data.error);
                return;
            }
            
            selectedInvoiceId = invoiceId;
            populateInvoiceData(data.invoice);
            updateTestItemsTable(data.lab_test_items);
            
            // Update search input with selected invoice number
            document.getElementById('invoice_search').value = data.invoice.invoice_no;
            clearSearchResults();
        })
        .catch(error => {
            console.error('Error loading invoice details:', error);
            alert('Error loading invoice details: ' + error.message);
        });
}

function clearSearchResults() {
    const container = document.getElementById('search-results-body');
    container.innerHTML = `
        <div class="p-3 text-center text-muted">
            <i class="fas fa-search fa-2x mb-2"></i><br>
            Search for invoices to process refunds
        </div>
    `;
    searchResults = [];
    selectedSearchIndex = -1;
    
    // Reset search title
    document.getElementById('search-title').textContent = 'Search Results';
}

function populateInvoiceData(invoice) {
    // Populate patient information
    document.getElementById('patient_name').value = invoice.patient_name || '';
    document.getElementById('gender').value = invoice.gender || '';
    document.getElementById('patient_phone').value = invoice.patient_phone || '';
    document.getElementById('patient_address').value = invoice.patient_address || '';
    
    // Calculate and display age
    if (invoice.age_years !== undefined) {
        document.getElementById('age_years').value = invoice.age_years || '';
        document.getElementById('age_months').value = invoice.age_months || '';
        document.getElementById('age_days').value = invoice.age_days || '';
    } else {
        document.getElementById('age_years').value = '';
        document.getElementById('age_months').value = '';
        document.getElementById('age_days').value = '';
    }
    
    // Populate invoice information
    document.getElementById('invoice_date').value = invoice.invoice_date ? new Date(invoice.invoice_date).toLocaleDateString() : '';
    document.getElementById('total_amount').value = invoice.total_amount ? Number(invoice.total_amount).toFixed(0) : '';
    document.getElementById('paid_amount').value = invoice.paid_amount ? Number(invoice.paid_amount).toFixed(0) : '';
    document.getElementById('due_amount').value = invoice.due_amount ? Number(invoice.due_amount).toFixed(0) : '';
    
    // Store current paid amount
    currentPaidAmount = parseFloat(invoice.paid_amount) || 0;
    
    // Enable return fields
    document.getElementById('returnReason').disabled = false;
    document.getElementById('otherReason').disabled = false;
    
    // Reset return fields
    document.getElementById('returnReason').value = '';
    document.getElementById('otherReason').value = '';
    document.getElementById('processReturnBtn').disabled = true;
    
    // Reset selected items
    selectedItems.clear();
    updateSelectedItemsDisplay();
}

function updateTestItemsTable(testItems) {
    this.testItems = testItems || [];
    const tbody = document.querySelector('#testItemsTable tbody');
    tbody.innerHTML = '';
    
    if (testItems && testItems.length > 0) {
        testItems.forEach(item => {
            const row = document.createElement('tr');
            row.className = 'item-refund-row';
            row.dataset.itemId = item.id;
            
            // Status badge
            let statusBadge = '';
            if (item.status === 'completed') {
                statusBadge = '<span class="badge bg-success">Completed</span>';
            } else if (item.status === 'pending') {
                statusBadge = '<span class="badge bg-warning">Pending</span>';
            } else if (item.status === 'cancelled') {
                statusBadge = '<span class="badge bg-danger">Cancelled</span>';
            } else {
                statusBadge = '<span class="badge bg-secondary">' + (item.status || 'Unknown') + '</span>';
            }
            
            row.innerHTML = `
                <td>
                    <input type="checkbox" class="form-check-input item-checkbox item-selector" 
                           data-item-id="${item.id}" data-charge="${item.charge}">
                </td>
                <td class="fw-bold">${item.code || ''}</td>
                <td>${item.test_name || ''}</td>
                <td class="text-end">${Number(item.charge || 0).toFixed(0)}</td>
                <td class="text-center">${statusBadge}</td>
                <td class="text-end">
                    <input type="number" class="form-control form-control-sm refund-amount-input" 
                           data-item-id="${item.id}" data-original-charge="${item.charge}" 
                           value="0" min="0" max="${item.charge}" step="1" disabled>
                </td>
                <td class="text-center">
                    <span class="refund-percentage" data-item-id="${item.id}">0%</span>
                </td>
            `;
            tbody.appendChild(row);
        });
        
        // Add event listeners to checkboxes
        document.querySelectorAll('.item-selector').forEach(checkbox => {
            checkbox.addEventListener('change', handleItemSelection);
        });
        
        // Add event listeners to refund amount inputs
        document.querySelectorAll('.refund-amount-input').forEach(input => {
            input.addEventListener('input', handleRefundAmountChange);
        });
    } else {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center text-muted py-4">
                    <i class="fas fa-info-circle fa-2x mb-2"></i><br>
                    No lab test items found for this invoice
                </td>
            </tr>
        `;
    }
}

function handleItemSelection(event) {
    const checkbox = event.target;
    const itemId = checkbox.dataset.itemId;
    const charge = parseFloat(checkbox.dataset.charge) || 0;
    const row = checkbox.closest('tr');
    const refundInput = row.querySelector('.refund-amount-input');
    const percentageSpan = row.querySelector('.refund-percentage');
    
    if (checkbox.checked) {
        // Initialize item in selectedItems
        selectedItems.set(itemId, {
            charge: charge,
            refundAmount: 0,
            percentage: 0
        });
        
        row.classList.add('selected-item');
        refundInput.disabled = false;
        refundInput.value = charge; // Default to full amount
        percentageSpan.textContent = '100%';
        
        // Update selectedItems
        selectedItems.get(itemId).refundAmount = charge;
        selectedItems.get(itemId).percentage = 100;
    } else {
        selectedItems.delete(itemId);
        row.classList.remove('selected-item');
        refundInput.disabled = true;
        refundInput.value = 0;
        percentageSpan.textContent = '0%';
    }
    
    updateSelectedItemsDisplay();
    updateReturnValidation();
}

function handleRefundAmountChange(event) {
    const input = event.target;
    const itemId = input.dataset.itemId;
    const originalCharge = parseFloat(input.dataset.originalCharge) || 0;
    const refundAmount = parseFloat(input.value) || 0;
    const percentage = originalCharge > 0 ? Math.round((refundAmount / originalCharge) * 100) : 0;
    
    const percentageSpan = document.querySelector(`.refund-percentage[data-item-id="${itemId}"]`);
    percentageSpan.textContent = percentage + '%';
    
    if (selectedItems.has(itemId)) {
        selectedItems.get(itemId).refundAmount = refundAmount;
        selectedItems.get(itemId).percentage = percentage;
    }
    
    updateSelectedItemsDisplay();
    updateReturnValidation();
}

function updateSelectedItemsDisplay() {
    const selectedCount = selectedItems.size;
    let totalRefundAmount = 0;
    
    selectedItems.forEach(item => {
        totalRefundAmount += item.refundAmount;
    });
    
    document.getElementById('selectedItemsCount').textContent = selectedCount;
    document.getElementById('totalRefundAmount').value = totalRefundAmount.toFixed(0);
    
    // Update remaining amount
    const remainingAmount = currentPaidAmount - totalRefundAmount;
    document.getElementById('remainingAmount').value = remainingAmount.toFixed(0);
}

// Keyboard navigation for search results
document.addEventListener('keydown', function(e) {
    // Only handle if search results are visible
    if (searchResults.length === 0) return;
    
    const searchContainer = document.getElementById('search-results-container');
    const isSearchFocused = searchContainer.contains(document.activeElement) || 
                           document.activeElement.id === 'invoice_search';
    
    if (!isSearchFocused) return;
    
    switch(e.key) {
        case 'ArrowDown':
            e.preventDefault();
            if (selectedSearchIndex < searchResults.length - 1) {
                selectedSearchIndex++;
                updateSearchSelection();
            }
            break;
            
        case 'ArrowUp':
            e.preventDefault();
            if (selectedSearchIndex > 0) {
                selectedSearchIndex--;
                updateSearchSelection();
            }
            break;
            
        case 'Enter':
            e.preventDefault();
            if (selectedSearchIndex >= 0 && selectedSearchIndex < searchResults.length) {
                const selectedInvoice = searchResults[selectedSearchIndex];
                selectInvoiceFromSearch(selectedInvoice.invoice_id);
            }
            break;
            
        case 'Escape':
            e.preventDefault();
            clearSearchResults();
            document.getElementById('invoice_search').focus();
            break;
    }
});

// Select All / Deselect All buttons
document.getElementById('selectAllBtn').addEventListener('click', function() {
    document.querySelectorAll('.item-selector').forEach(checkbox => {
        if (!checkbox.checked) {
            checkbox.checked = true;
            checkbox.dispatchEvent(new Event('change'));
        }
    });
});

document.getElementById('deselectAllBtn').addEventListener('click', function() {
    document.querySelectorAll('.item-selector').forEach(checkbox => {
        if (checkbox.checked) {
            checkbox.checked = false;
            checkbox.dispatchEvent(new Event('change'));
        }
    });
});

// Select All checkbox
document.getElementById('selectAllCheckbox').addEventListener('change', function() {
    const isChecked = this.checked;
    document.querySelectorAll('.item-selector').forEach(checkbox => {
        checkbox.checked = isChecked;
        checkbox.dispatchEvent(new Event('change'));
    });
});

function updateReturnValidation() {
    const returnReason = document.getElementById('returnReason').value;
    const totalRefundAmount = parseFloat(document.getElementById('totalRefundAmount').value) || 0;
    
    const isValid = selectedItems.size > 0 && totalRefundAmount > 0 && returnReason;
    
    document.getElementById('processReturnBtn').disabled = !isValid;
}

// Handle return reason change
document.getElementById('returnReason').addEventListener('change', function() {
    updateReturnValidation();
});

// Process return
document.getElementById('processReturnBtn').addEventListener('click', function() {
    const returnReason = document.getElementById('returnReason').value;
    const otherReason = document.getElementById('otherReason').value;
    const finalReason = returnReason === 'Other' && otherReason ? otherReason : returnReason;
    
    if (!selectedInvoiceId) {
        alert('Please select an invoice first');
        return;
    }
    
    if (!returnReason) {
        alert('Please select a return reason');
        return;
    }
    
    const totalRefundAmount = parseFloat(document.getElementById('totalRefundAmount').value) || 0;
    if (totalRefundAmount <= 0) {
        alert('Please select items and set refund amounts');
        return;
    }
    
    // Prepare refund details
    const refundDetails = [];
    selectedItems.forEach((item, itemId) => {
        const testItem = testItems.find(t => t.id == itemId);
        refundDetails.push({
            itemId: itemId,
            testName: testItem ? testItem.test_name : 'Unknown',
            originalCharge: item.charge,
            refundAmount: item.refundAmount,
            percentage: item.percentage
        });
    });
    
    // Confirm return
    let confirmMessage = `Are you sure you want to process refund for ${selectedItems.size} items?\n\n`;
    confirmMessage += `Total Refund Amount: ${totalRefundAmount.toFixed(0)}\n\n`;
    confirmMessage += `Selected Items:\n`;
    refundDetails.forEach(item => {
        confirmMessage += `• ${item.testName}: ${item.refundAmount.toFixed(0)} (${item.percentage}%)\n`;
    });
    
    if (!confirm(confirmMessage)) {
        return;
    }
    
    // Process return - replace with actual API call
    alert('Refund processed successfully!');
    
    // Reset form
    document.getElementById('returnReason').value = '';
    document.getElementById('otherReason').value = '';
    document.getElementById('processReturnBtn').disabled = true;
    document.getElementById('invoice_search').value = '';
    clearSearchResults();
    
    // Reset selected items
    selectedItems.clear();
    updateSelectedItemsDisplay();
    
    // Uncheck all checkboxes and reset refund amounts
    document.querySelectorAll('.item-selector').forEach(checkbox => {
        checkbox.checked = false;
    });
    document.querySelectorAll('.refund-amount-input').forEach(input => {
        input.value = 0;
        input.disabled = true;
    });
    document.querySelectorAll('.refund-percentage').forEach(span => {
        span.textContent = '0%';
    });
});

// Reset button
document.getElementById('resetFormBtn').addEventListener('click', function() {
    if (confirm('Are you sure you want to reset all fields?')) {
        // Clear all form fields
        document.getElementById('invoice_search').value = '';
        document.getElementById('patient_name').value = '';
        document.getElementById('gender').value = '';
        document.getElementById('patient_phone').value = '';
        document.getElementById('patient_address').value = '';
        document.getElementById('age_years').value = '';
        document.getElementById('age_months').value = '';
        document.getElementById('age_days').value = '';
        document.getElementById('invoice_date').value = '';
        document.getElementById('total_amount').value = '';
        document.getElementById('paid_amount').value = '';
        document.getElementById('due_amount').value = '';
        document.getElementById('returnReason').value = '';
        document.getElementById('otherReason').value = '';
        document.getElementById('processReturnBtn').disabled = true;
        document.getElementById('returnReason').disabled = true;
        document.getElementById('otherReason').disabled = true;
        
        // Reset selected items
        selectedItems.clear();
        updateSelectedItemsDisplay();
        
        // Clear table
        const tbody = document.querySelector('#testItemsTable tbody');
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center text-muted py-4">
                    <i class="fas fa-info-circle fa-2x mb-2"></i><br>
                    Select an invoice to view test details
                </td>
            </tr>
        `;
        
        clearSearchResults();
        selectedInvoiceId = null;
        currentPaidAmount = 0;
        testItems = [];
    }
});

// Cancel button
document.getElementById('cancelBtn').addEventListener('click', function() {
    if (confirm('Are you sure you want to cancel?')) {
        window.history.back();
    }
});

// Handle Enter key to move to next field
document.addEventListener('DOMContentLoaded', function() {
    // Load default invoices when page loads
    loadDefaultInvoices();
    
    document.querySelectorAll('input, select, textarea').forEach(function(element) {
        element.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                
                const currentTabIndex = parseInt(this.getAttribute('tabindex')) || 0;
                const nextElement = document.querySelector(`[tabindex="${currentTabIndex + 1}"]`);
                
                if (nextElement) {
                    nextElement.focus();
                    
                    if (nextElement.tagName === 'INPUT' && nextElement.type !== 'date') {
                        nextElement.select();
                    }
                }
            }
        });
    });
});

function loadDefaultInvoices() {
    fetch('/admin/diagnostics/invoice-return/default-invoices')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                console.error('Error loading default invoices:', data.error);
                return;
            }
            searchResults = data;
            displaySearchResults(data);
            
            // Update search title to show default results
            document.getElementById('search-title').textContent = 'Recent Invoices';
        })
        .catch(error => {
            console.error('Error loading default invoices:', error);
        });
}
</script>
@endsection
