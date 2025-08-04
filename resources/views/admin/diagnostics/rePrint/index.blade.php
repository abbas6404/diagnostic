@extends('admin.layouts.app')

@section('title', 'Re-Print')

@section('styles')
@endsection

@section('content')
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
                    
                    <button class="btn btn-sm btn-primary" id="newPrintBtn">
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
                                            <input type="text" class="form-control form-control-sm" id="invoice_search" placeholder="Enter invoice number, patient name, or phone..." tabindex="1">
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
                                            <input type="text" class="form-control form-control-sm text-end" id="total_amount" readonly tabindex="10">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Paid Amount:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm text-end" id="paid_amount" readonly tabindex="11">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Due Amount:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm text-end text-danger" id="due_amount" readonly tabindex="12">
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
                                <i class="fas fa-vial me-1"></i>Lab Test Items

                            </h6>
                            <div>
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="resetFormBtn">
                                    <i class="fas fa-undo me-1"></i> Reset
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0" id="testItemsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 80px;">Code</th>
                                            <th>Test Name</th>
                                            <th style="width: 80px;" class="text-end">Charge</th>
                                            <th style="width: 100px;" class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Lab Tests Section -->
                                        <tr class="table-info">
                                            <td colspan="4" class="fw-bold">
                                                <i class="fas fa-vial me-1"></i> Lab Tests
                                            </td>
                                        </tr>
                                        <tbody id="labTestsBody">
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">
                                                    <i class="fas fa-info-circle fa-2x mb-2"></i><br>
                                                    Select an invoice to view test details
                                                </td>
                                            </tr>
                                        </tbody>
                                        
                                        <!-- Collection Kits Section -->
                                        <tr class="table-warning">
                                            <td colspan="4" class="fw-bold">
                                                <i class="fas fa-box me-1"></i> Collection Kits
                                            </td>
                                        </tr>
                                        <tbody id="collectionKitsBody">
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">
                                                    <i class="fas fa-info-circle fa-2x mb-2"></i><br>
                                                    Collection kits will appear here
                                                </td>
                                            </tr>
                                        </tbody>
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
                        <div class="card-header bg-primary text-white py-2">
                            <h6 class="mb-0">
                                <i class="fas fa-search me-1"></i> <span id="search-title">Search Results</span>

                            </h6>
                        </div>
                        <div class="card-body p-0" style="height: 250px; overflow-y: auto;" id="search-results-body">
                            <div class="p-3 text-center text-muted">
                                <i class="fas fa-search fa-2x mb-2"></i><br>
                                Search for invoices to re-print
                            </div>
                        </div>
                        <div class="card-footer py-1">

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
                                    <input type="text" class="form-control form-control-sm text-end fw-bold" id="invoiceTotal" readonly value="0.00">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label">Paid Amount</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control form-control-sm text-end fw-bold text-success" id="paidAmount" readonly value="0.00">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label">Due Amount</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control form-control-sm text-end fw-bold text-danger" id="dueAmount" readonly value="0.00">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label">Print Type</label>
                                <div class="col-sm-7">
                                    <select class="form-select form-select-sm" id="printType">
                                        <option value="full_invoice">Full Invoice</option>
                                        <option value="receipt">Receipt Only</option>
                                        <option value="lab_report">Lab Report</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label">Copies</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control form-control-sm" id="printCopies" value="1" min="1" max="10">
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-center gap-2 mt-4">
                                <button class="btn btn-success" id="printInvoiceBtn">
                                    <i class="fas fa-print me-1"></i> Print Invoice
                                </button>
                                <button class="btn btn-primary" id="resetFormBtn2">
                                    <i class="fas fa-sync-alt me-1"></i> Reset
                                </button>
                                <button class="btn btn-danger" id="cancelBtn">
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
    // Global variables
    let searchResults = [];
    let selectedInvoiceId = null;
    let currentPaidAmount = 0;
    let testItems = [];
    let selectedItems = new Map();
    let selectedSearchIndex = -1;

    // Load default invoices when page loads
    document.addEventListener('DOMContentLoaded', function() {
        loadDefaultInvoices();
        document.getElementById('invoice_search').focus();
    });

    // Search functionality
    let searchTimeout;
    document.getElementById('invoice_search').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        
        if (query.length === 0) {
            loadDefaultInvoices();
            return;
        }
        
        searchTimeout = setTimeout(() => {
            searchInvoices(query);
        }, 300);
    });



    function loadDefaultInvoices() {
        fetch('/admin/diagnostics/reprint/default-invoices')
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    searchResults = data.invoices;
                    displaySearchResults(data.invoices);
                    document.getElementById('search-title').textContent = 'Recent Invoices';
                }
            })
            .catch(error => {
                console.error('Error loading default invoices:', error);
            });
    }

    function searchInvoices(query) {
        fetch(`/admin/diagnostics/reprint/search?query=${encodeURIComponent(query)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    searchResults = data.invoices;
                    displaySearchResults(data.invoices);
                    document.getElementById('search-title').textContent = `Search Results for '${query}'`;
                }
            })
            .catch(error => {
                console.error('Error searching invoices:', error);
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
            const triangleIndicator = '<div class="triangle-indicator"></div>';
            
            const invoiceId = invoice.invoice_id || invoice.id;
            
            html += `
                <tr class="${rowClass}" data-index="${index}" onclick="selectInvoiceFromSearch(${invoiceId})" style="cursor: pointer;">
                    <td class="fw-bold">${triangleIndicator}${invoice.invoice_no}</td>
                    <td>${invoice.patient_name || 'N/A'}</td>
                    <td class="text-end">${Number(invoice.total_amount).toFixed(0)}</td>
                    <td class="text-end text-success">${Number(invoice.paid_amount).toFixed(0)}</td>
                    <td class="text-end text-danger">${Number(invoice.due_amount).toFixed(0)}</td>
                </tr>
            `;
        });
        
        html += '</tbody></table></div>';
        container.innerHTML = html;
        
        if (selectedSearchIndex === -1 && results.length > 0) {
            selectedSearchIndex = 0;
            updateSearchSelection();
        }
    }

    function navigateSearchResults(direction) {
        if (searchResults.length === 0) return;
        
        if (direction === 'down') {
            if (selectedSearchIndex < searchResults.length - 1) {
                selectedSearchIndex++;
            }
        } else {
            if (selectedSearchIndex > 0) {
                selectedSearchIndex--;
            } else {
                selectedSearchIndex = 0;
            }
        }
        
        updateSearchSelection();
    }

    function updateSearchSelection() {
        document.querySelectorAll('.search-item').forEach(item => {
            item.classList.remove('selected');
        });
        
        if (selectedSearchIndex >= 0 && selectedSearchIndex < searchResults.length) {
            const selectedRow = document.querySelector(`[data-index="${selectedSearchIndex}"]`);
            if (selectedRow) {
                selectedRow.classList.add('selected');
                selectedRow.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                
                // Update triangle indicators
                document.querySelectorAll('.triangle-indicator').forEach(triangle => {
                    triangle.style.visibility = 'hidden';
                });
                
                const selectedTriangle = selectedRow.querySelector('.triangle-indicator');
                if (selectedTriangle) {
                    selectedTriangle.style.visibility = 'visible';
                }
            }
        }
    }

    function selectCurrentSearchResult() {
        if (selectedSearchIndex >= 0 && selectedSearchIndex < searchResults.length) {
            const selectedInvoice = searchResults[selectedSearchIndex];
            const invoiceId = selectedInvoice.invoice_id || selectedInvoice.id;
            selectInvoiceFromSearch(invoiceId);
            
            // Focus on print type after selection
            setTimeout(() => {
                document.getElementById('printType').focus();
            }, 100);
        }
    }

    function selectInvoiceFromSearch(invoiceId) {
        const numericInvoiceId = parseInt(invoiceId);
        
        fetch(`/admin/diagnostics/reprint/invoice/${numericInvoiceId}/details`)
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
                
                selectedInvoiceId = numericInvoiceId;
                populateInvoiceData(data.invoice);
                updateTestItemsTable(data.lab_test_items);
                
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
                Search for invoices to re-print
            </div>
        `;
        searchResults = [];
        selectedSearchIndex = -1;

        document.getElementById('search-title').textContent = 'Search Results';
    }

    function populateInvoiceData(invoice) {
        document.getElementById('patient_name').value = invoice.patient_name || '';
        document.getElementById('gender').value = invoice.gender || '';
        document.getElementById('patient_phone').value = invoice.patient_phone || '';
        document.getElementById('patient_address').value = invoice.patient_address || '';
        
        if (invoice.age_years !== undefined) {
            document.getElementById('age_years').value = invoice.age_years || '';
            document.getElementById('age_months').value = invoice.age_months || '';
            document.getElementById('age_days').value = invoice.age_days || '';
        }
        
        document.getElementById('invoice_date').value = invoice.invoice_date || '';
        document.getElementById('total_amount').value = Number(invoice.total_amount || 0).toFixed(0);
        document.getElementById('paid_amount').value = Number(invoice.paid_amount || 0).toFixed(0);
        document.getElementById('due_amount').value = Number(invoice.due_amount || 0).toFixed(0);
        
        currentPaidAmount = parseFloat(invoice.paid_amount || 0);
        updateInvoiceSummary();
        updatePrintValidation();
    }

    function updateTestItemsTable(testItems) {
        this.testItems = testItems || [];
        const labTestsBody = document.getElementById('labTestsBody');
        const collectionKitsBody = document.getElementById('collectionKitsBody');

        labTestsBody.innerHTML = '';
        collectionKitsBody.innerHTML = '';

        if (testItems && testItems.length > 0) {
            testItems.forEach(item => {
                const row = document.createElement('tr');
                row.className = 'item-print-row';
                row.dataset.itemId = item.id;
                
                // Add collection kit class if it's a collection kit
                if (item.is_collection_kit) {
                    row.classList.add('collection-kit-row');
                }
                
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
                
                // Handle collection kit display with color
                let testNameDisplay = item.test_name || '';
                if (item.is_collection_kit && item.color) {
                    let cssColor = item.color;
                    switch(item.color.toLowerCase()) {
                        case 'red': cssColor = '#dc3545'; break;
                        case 'lavender': cssColor = '#e6e6fa'; break;
                        case 'light blue': cssColor = '#add8e6'; break;
                        case 'gray': cssColor = '#808080'; break;
                        case 'green': cssColor = '#28a745'; break;
                        default: cssColor = item.color;
                    }
                    const textColor = (cssColor === '#e6e6fa' || cssColor === '#add8e6') ? '#000' : '#fff';
                    testNameDisplay = `
                        <div class="d-flex align-items-center">
                            <span class="me-2">${item.test_name}</span>
                            <span class="badge" style="background-color: ${cssColor}; color: ${textColor};">${item.color}</span>
                        </div>
                    `;
                }
                
                row.innerHTML = `
                    <td class="fw-bold">${item.code || ''}</td>
                    <td>${testNameDisplay}</td>
                    <td class="text-end">৳${Number(item.charge || 0).toFixed(0)}</td>
                    <td class="text-center">${statusBadge}</td>
                `;
                
                // Determine which section to append
                if (item.is_collection_kit) {
                    collectionKitsBody.appendChild(row);
                } else {
                    labTestsBody.appendChild(row);
                }
            });
        } else {
            labTestsBody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        <i class="fas fa-info-circle fa-2x mb-2"></i><br>
                        No lab test items found for this invoice
                    </td>
                </tr>
            `;
            collectionKitsBody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        <i class="fas fa-info-circle fa-2x mb-2"></i><br>
                        No collection kits found for this invoice
                    </td>
                </tr>
            `;
        }
    }





    function updateInvoiceSummary() {
        // Update invoice summary fields
        document.getElementById('invoiceTotal').value = currentPaidAmount.toFixed(0);
        document.getElementById('paidAmount').value = currentPaidAmount.toFixed(0);
        document.getElementById('dueAmount').value = '0.00';
    }

    function updatePrintValidation() {
        const printType = document.getElementById('printType');
        const printCopies = document.getElementById('printCopies');
        const printInvoiceBtn = document.getElementById('printInvoiceBtn');
        
        // Enable print functionality when invoice is selected
        if (selectedInvoiceId) {
            printType.disabled = false;
            printCopies.disabled = false;
                printInvoiceBtn.disabled = false;
        } else {
            printType.disabled = true;
            printCopies.disabled = true;
            printInvoiceBtn.disabled = true;
        }
    }

    // Print type change handler
    document.getElementById('printType').addEventListener('change', function() {
        // Print button is always enabled when invoice is selected
    });

    // Print invoice button
    document.getElementById('printInvoiceBtn').addEventListener('click', function() {
        const printType = document.getElementById('printType').value;
        const printCopies = document.getElementById('printCopies').value;
        
        if (!selectedInvoiceId) {
            alert('Please select an invoice first');
            return;
        }
        
        printInvoice(printType, printCopies);
    });

    function printInvoice(printType, copies) {
        fetch('/admin/diagnostics/reprint/print', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                invoice_id: selectedInvoiceId,
                print_type: printType,
                copies: copies
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Print job sent successfully!');
                if (data.print_url) {
                    window.open(data.print_url, '_blank');
                }
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error printing invoice:', error);
            alert('Error sending print job');
        });
    }



    // Reset buttons
    document.getElementById('resetFormBtn').addEventListener('click', resetForm);
    document.getElementById('resetFormBtn2').addEventListener('click', resetForm);

    function resetForm() {
        if (confirm('Are you sure you want to reset all fields?')) {
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
            document.getElementById('printType').value = 'full_invoice';
            document.getElementById('printCopies').value = '1';
            document.getElementById('printInvoiceBtn').disabled = true;
            document.getElementById('printType').disabled = true;
            document.getElementById('printCopies').disabled = true;
            
            // Reset invoice summary
            document.getElementById('invoiceTotal').value = '0.00';
            document.getElementById('paidAmount').value = '0.00';
            document.getElementById('dueAmount').value = '0.00';
            
            const labTestsBody = document.getElementById('labTestsBody');
            const collectionKitsBody = document.getElementById('collectionKitsBody');
            labTestsBody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        <i class="fas fa-info-circle fa-2x mb-2"></i><br>
                        Select an invoice to view test details
                    </td>
                </tr>
            `;
            collectionKitsBody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        <i class="fas fa-info-circle fa-2x mb-2"></i><br>
                        Collection kits will appear here
                    </td>
                </tr>
            `;
            
            clearSearchResults();
            selectedInvoiceId = null;
            currentPaidAmount = 0;
            testItems = [];
        }
    }
</script>