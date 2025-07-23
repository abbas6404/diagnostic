@extends('admin.layouts.app')

@section('title', 'OPD Invoice')

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
        background-color: rgba(0,123,255,0.1);
    }
    .search-item.selected {
        background-color: rgba(0,123,255,0.2);
    }
    
    /* Position the search results properly */
    .col-sm-8 {
        position: relative;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary">
                    <i class="fas fa-file-invoice me-2"></i> OPD Invoice
                </h5>
                <div>
                    <a href="{{ route('admin.patients.index') }}" class="btn btn-sm btn-outline-secondary me-2">
                        <i class="fas fa-list me-1"></i> Patient List
                    </a>
                    
                    <button class="btn btn-sm btn-primary" id="newInvoiceBtn">
                        <i class="fas fa-plus-circle me-1"></i> New Invoice
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Invoice Form -->
            <form id="invoiceForm" method="POST" action="{{ route('admin.opd.invoice.store') }}">
                @csrf
                <!-- Display validation errors if any -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <!-- Display success message if any -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
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
                                            <label class="col-sm-4 col-form-label">Receipt No:</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" name="receipt_no" id="receipt_no" tabindex="1">
                                                    <button class="btn btn-sm btn-outline-secondary" type="button" tabindex="-1"><i class="fas fa-sync-alt"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Patient ID:</label>
                                            <div class="col-sm-8">
                                                @livewire('patient-search')
                                                <input type="hidden" name="patient_id_hidden" id="patient_id_hidden">
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Name:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" name="name_en" id="patient_name" tabindex="2">
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Age:</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" placeholder="Y" style="width: 30%;" name="age_years" id="age_years" tabindex="3">
                                                    <input type="text" class="form-control form-control-sm" placeholder="M" style="width: 30%;" name="age_months" id="age_months" tabindex="4">
                                                    <input type="text" class="form-control form-control-sm" placeholder="D" style="width: 30%;" name="age_days" id="age_days" tabindex="5">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Sex:</label>
                                            <div class="col-sm-8">
                                                <select class="form-select form-select-sm" name="gender" id="gender" tabindex="6">
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Religion:</label>
                                            <div class="col-sm-8">
                                                <select class="form-select form-select-sm" name="religion" id="religion" tabindex="7">
                                                    <option value="Islam">Islam</option>
                                                    <option value="Hinduism">Hinduism</option>
                                                    <option value="Christianity">Christianity</option>
                                                    <option value="Buddhism">Buddhism</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Date:</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <input type="date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" name="invoice_date" tabindex="8">
                                                    <button class="btn btn-sm btn-outline-secondary" type="button" tabindex="-1"><i class="fas fa-calendar"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Indoor P.ID:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" name="indoor_patient_id" tabindex="9">
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Mobile No:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" name="phone" id="patient_phone" tabindex="10">
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Address:</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control form-control-sm" rows="2" name="address" id="patient_address" tabindex="11"></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Ref. By:</label>
                                            <div class="col-sm-8">
                                                @livewire('pcp-search')
                                                <input type="hidden" name="referred_by_hidden" id="referred_by_hidden">
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Under Dr:</label>
                                            <div class="col-sm-8">
                                                @livewire('doctor-search')
                                                <input type="hidden" name="doctor_id_hidden" id="doctor_id_hidden">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Service Items Table -->
                        <div class="card border mt-3">
                            <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0"><i class="fas fa-clipboard-list me-1"></i>Service Items</h6>
                                <div>
                                    <input type="text" class="form-control form-control-sm" placeholder="Search Service (Code or Name)" tabindex="13" id="serviceSearchInput">
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered mb-0" id="serviceItemsTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 80px;">Code</th>
                                                <th>Description</th>
                                                <th style="width: 100px;">Charge</th>
                                                <th style="width: 80px;">Unit</th>
                                                <th style="width: 80px;">Quantity</th>
                                                <th style="width: 100px;">Total</th>
                                                <th style="width: 40px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Service items will be added here dynamically -->
                                        </tbody>
                                        <tfoot class="table-light">
                                            <tr>
                                                <td colspan="5" class="text-end fw-bold">Subtotal:</td>
                                                <td colspan="2">
                                                    <input type="text" class="form-control form-control-sm" id="subtotalAmount" value="0.00" readonly>
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
                                <h6 class="mb-0"><i class="fas fa-search me-1"></i> <span id="search-title">Search Results</span></h6>
                            </div>
                            <div class="card-body p-0" style="height: 250px; overflow-y: auto;" id="search-results-body">
                                @livewire('search-results')
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
                                        <input type="text" class="form-control form-control-sm text-end fw-bold" id="totalAmount" readonly value="0.00">
                                    </div>
                                </div>
                                
                                <div class="row mb-2">
                                    <label class="col-sm-5 col-form-label">VAT (%)</label>
                                    <div class="col-sm-7">
                                        <div class="input-group input-group-sm">
                                            <input type="number" class="form-control text-end" id="vatPercent" min="0" max="100" value="0" tabindex="20">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mb-2">
                                    <label class="col-sm-5 col-form-label">VAT Amount</label>
                                    <div class="col-sm-7">
                                        <input type="number" class="form-control form-control-sm text-end" id="vatAmount" value="0.00" step="0.01" min="0" tabindex="21">
                                    </div>
                                </div>
                                
                                <div class="row mb-2">
                                    <label class="col-sm-5 col-form-label">Discount (%)</label>
                                    <div class="col-sm-7">
                                        <div class="input-group input-group-sm">
                                            <input type="number" class="form-control text-end" id="discountPercent" min="0" max="100" value="0" tabindex="22">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mb-2">
                                    <label class="col-sm-5 col-form-label">Discount Amount</label>
                                    <div class="col-sm-7">
                                        <input type="number" class="form-control form-control-sm text-end" id="discountAmount" value="0.00" step="0.01" min="0" tabindex="23">
                                    </div>
                                </div>
                                
                                <div class="row mb-2">
                                    <label class="col-sm-5 col-form-label fw-bold">Net Payable</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control form-control-sm text-end fw-bold bg-light" id="netPayable" readonly value="0.00">
                                    </div>
                                </div>
                                
                                <div class="row mb-2">
                                    <label class="col-sm-5 col-form-label">Paid Amount</label>
                                    <div class="col-sm-7">
                                        <input type="number" class="form-control form-control-sm text-end" id="paidAmount" value="0.00" step="0.01" min="0" tabindex="24">
                                    </div>
                                </div>
                                
                                <div class="row mb-2">
                                    <label class="col-sm-5 col-form-label text-danger fw-bold">Due Amount</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control form-control-sm text-end fw-bold text-danger" id="dueAmount" readonly value="0.00">
                                    </div>
                                </div>
                                
                                <div class="row mb-2">
                                    <label class="col-sm-5 col-form-label">Remarks:</label>
                                    <div class="col-sm-7">
                                        <textarea class="form-control form-control-sm" rows="2" name="remarks" tabindex="25"></textarea>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-center gap-2 mt-4">
                                    <button type="submit" class="btn btn-success" id="saveInvoiceBtn" tabindex="26">
                                        <i class="fas fa-save me-1"></i> Save & Print
                                    </button>
                                    <button type="button" class="btn btn-primary" id="resetFormBtn" tabindex="27">
                                        <i class="fas fa-sync-alt me-1"></i> Reset
                                    </button>
                                    <button type="button" class="btn btn-danger" id="cancelBtn" tabindex="28">
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
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Define the calculateServiceItemTotal function globally
        window.calculateServiceItemTotal = function() {
            const rows = document.querySelectorAll('#serviceItemsTable tbody tr');
            let subtotal = 0;
            
            rows.forEach(row => {
                const charge = parseFloat(row.querySelector('.service-charge').value) || 0;
                const qty = parseInt(row.querySelector('.service-qty').value) || 1;
                const total = charge * qty;
                
                row.querySelector('.service-total').value = total.toFixed(2);
                subtotal += total;
            });
            
            document.getElementById('subtotalAmount').value = subtotal.toFixed(2);
            document.getElementById('totalAmount').value = subtotal.toFixed(2);
            
            calculateNetPayable();
        };
        
        // Handle Enter key to move to next field
        document.querySelectorAll('input, select, textarea').forEach(function(element) {
            element.addEventListener('keydown', function(e) {
                // If Enter key is pressed
                if (e.key === 'Enter') {
                    e.preventDefault(); // Prevent form submission
                    
                    // Get the tabindex of the current element
                    const currentTabIndex = parseInt(this.getAttribute('tabindex')) || 0;
                    
                    // Find the next element with a higher tabindex
                    const nextElement = document.querySelector(`[tabindex="${currentTabIndex + 1}"]`);
                    
                    // Focus the next element if found
                    if (nextElement) {
                        nextElement.focus();
                        
                        // If it's an input, select all text for easy replacement
                        if (nextElement.tagName === 'INPUT' && nextElement.type !== 'date') {
                            nextElement.select();
                        }
                    }
                }
            });
        });
        
        // Function to calculate net payable amount
        function calculateNetPayable() {
            const totalAmount = parseFloat(document.getElementById('totalAmount').value) || 0;
            const vatAmount = parseFloat(document.getElementById('vatAmount').value) || 0;
            const discountAmount = parseFloat(document.getElementById('discountAmount').value) || 0;
            const netPayable = Math.max(0, totalAmount + vatAmount - discountAmount);
            const paidAmount = parseFloat(document.getElementById('paidAmount').value) || 0;
            const dueAmount = Math.max(0, netPayable - paidAmount);
            
            document.getElementById('netPayable').value = netPayable.toFixed(2);
            document.getElementById('dueAmount').value = dueAmount.toFixed(2);
        }
        
        // Function to remove a service row
        window.removeServiceRow = function(rowId) {
            const row = document.getElementById(rowId);
            if (row) {
                row.remove();
                window.calculateServiceItemTotal();
            }
        };
        
        // Add event listeners for VAT percentage
        document.getElementById('vatPercent').addEventListener('input', function() {
            const percent = parseFloat(this.value) || 0;
            const totalAmount = parseFloat(document.getElementById('totalAmount').value) || 0;
            const vatAmount = (totalAmount * percent / 100).toFixed(2);
            
            document.getElementById('vatAmount').value = vatAmount;
            calculateNetPayable();
        });
        
        // Add event listeners for VAT amount
        document.getElementById('vatAmount').addEventListener('input', function() {
            const vatAmount = parseFloat(this.value) || 0;
            const totalAmount = parseFloat(document.getElementById('totalAmount').value) || 0;
            
            if (totalAmount > 0) {
                const percent = (vatAmount * 100 / totalAmount).toFixed(2);
                document.getElementById('vatPercent').value = percent;
            } else {
                document.getElementById('vatPercent').value = 0;
            }
            
            calculateNetPayable();
        });
        
        // Add event listeners for discount percentage
        document.getElementById('discountPercent').addEventListener('input', function() {
            const percent = parseFloat(this.value) || 0;
            const totalAmount = parseFloat(document.getElementById('totalAmount').value) || 0;
            const discountAmount = (totalAmount * percent / 100).toFixed(2);
            
            document.getElementById('discountAmount').value = discountAmount;
            calculateNetPayable();
        });
        
        // Add event listeners for discount amount
        document.getElementById('discountAmount').addEventListener('input', function() {
            const discountAmount = parseFloat(this.value) || 0;
            const totalAmount = parseFloat(document.getElementById('totalAmount').value) || 0;
            
            if (totalAmount > 0) {
                const percent = (discountAmount * 100 / totalAmount).toFixed(2);
                document.getElementById('discountPercent').value = percent;
            } else {
                document.getElementById('discountPercent').value = 0;
            }
            
            calculateNetPayable();
        });
        
        // Add event listener for paid amount
        const paidAmountInput = document.getElementById('paidAmount');
        paidAmountInput.addEventListener('input', function() {
            calculateNetPayable();
        });
        
        // Add Enter key handling for paid amount to focus the save button
        paidAmountInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('saveInvoiceBtn').focus();
            }
        });
        
        // Save button - add Enter key handling
        const saveInvoiceBtn = document.getElementById('saveInvoiceBtn');
        saveInvoiceBtn.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('invoiceForm').submit();
            }
        });
        
        saveInvoiceBtn.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('invoiceForm').submit();
        });
        
        // Reset form button
        document.getElementById('resetFormBtn').addEventListener('click', function() {
            window.location.reload();
        });
        
        // Cancel button
        document.getElementById('cancelBtn').addEventListener('click', function() {
            window.location.href = "{{ route('admin.dashboard') }}";
        });
        
        // Mock implementation for service search
        document.getElementById('serviceSearchInput').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                
                // Mock service selection
                if (this.value.trim() !== '') {
                    addServiceRow({
                        id: Date.now(),
                        code: 'S-' + Math.floor(Math.random() * 1000),
                        name: this.value,
                        charge: Math.floor(Math.random() * 1000) + 100,
                        unit: 'Pcs'
                    });
                    
                    this.value = '';
                }
            }
        });
        
        // Function to add a service row
        function addServiceRow(service) {
            // Generate a unique ID for this row
            const rowId = 'service-row-' + service.id;
            
            // Create the row HTML
            const rowHtml = `
                <tr id="${rowId}">
                    <td>
                        <input type="text" class="form-control form-control-sm service-code" value="${service.code}" readonly>
                        <input type="hidden" name="service_ids[]" value="${service.id}">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm service-name" value="${service.name}" readonly>
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm service-charge" value="${service.charge}" step="0.01" min="0">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm service-unit" value="${service.unit}" readonly>
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm service-qty" value="1" min="1">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm service-total" value="${service.charge}" readonly>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger remove-service-btn" onclick="removeServiceRow('${rowId}')">
                            <i class="fas fa-times"></i>
                        </button>
                    </td>
                </tr>
            `;
            
            // Append the row to the table
            const tbody = document.querySelector('#serviceItemsTable tbody');
            tbody.insertAdjacentHTML('beforeend', rowHtml);
            
            // Add event listeners to the new row
            const newRow = document.getElementById(rowId);
            newRow.querySelector('.service-charge').addEventListener('input', window.calculateServiceItemTotal);
            newRow.querySelector('.service-qty').addEventListener('input', window.calculateServiceItemTotal);
            
            // Calculate totals
            window.calculateServiceItemTotal();
        }
        
        // Direct DOM manipulation for patient fields
        document.addEventListener('livewire:init', () => {
            // Patient selected event
            Livewire.on('fill-patient-fields', (patientData) => {
                let data = patientData;
                if (Array.isArray(patientData) && patientData.length > 0) {
                    data = patientData[0];
                }
                
                document.getElementById('patient_id_hidden').value = data.id;
                
                const nameField = document.getElementById('patient_name');
                if (nameField) nameField.value = data.name || '';
                
                const ageYearsField = document.getElementById('age_years');
                if (ageYearsField) ageYearsField.value = parseInt(data.age_years || 0);
                
                const ageMonthsField = document.getElementById('age_months');
                if (ageMonthsField) ageMonthsField.value = parseInt(data.age_months || 0);
                
                const ageDaysField = document.getElementById('age_days');
                if (ageDaysField) ageDaysField.value = parseInt(data.age_days || 0);
                
                const contactField = document.getElementById('patient_phone');
                if (contactField) contactField.value = data.phone || '';
                
                const addressField = document.getElementById('patient_address');
                if (addressField) addressField.value = data.address || '';
            });
            
            // Doctor selected event
            Livewire.on('doctor-selected', (doctorData) => {
                document.getElementById('doctor_id_hidden').value = doctorData.id;
            });
            
            // PCP selected event
            Livewire.on('pcp-selected', (pcpData) => {
                document.getElementById('referred_by_hidden').value = pcpData.id;
            });
            
            // Update search title when search type changes
            Livewire.on('searchTypeChanged', (type) => {
                const titleElement = document.getElementById('search-title');
                if (titleElement) {
                    titleElement.textContent = type + ' Search Results';
                }
            });
        });
    });
</script>
@endsection 