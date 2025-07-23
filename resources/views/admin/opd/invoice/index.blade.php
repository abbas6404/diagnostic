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
                        <i class="fas fa-list me-1"></i> OPD Patient List
                    </a>
                    
                    <button class="btn btn-sm btn-primary" id="newInvoiceBtn">
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
                                        <label class="col-sm-4 col-form-label">Contact:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" name="phone" id="patient_phone" tabindex="7">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Address:</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control form-control-sm" rows="2" name="address" id="patient_address" tabindex="8"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Date:</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" name="invoice_date" tabindex="9">
                                                <button class="btn btn-sm btn-outline-secondary" type="button" tabindex="-1"><i class="fas fa-calendar"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Dr. Ticket:</label>
                                        <div class="col-sm-8">
                                            @livewire('ticket-search')
                                            <input type="hidden" name="ticket_id_hidden" id="ticket_id_hidden">
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Cons. Dr:</label>
                                        <div class="col-sm-8">
                                            @livewire('doctor-search')
                                            <input type="hidden" name="doctor_id_hidden" id="doctor_id_hidden">
                                </div>
                            </div>

                            <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Ref. By:</label>
                                        <div class="col-sm-8">
                                            @livewire('pcp-search')
                                            <input type="hidden" name="referred_by_hidden" id="referred_by_hidden">
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                            </div>
                        
                       
                        
                        </div>
                    </div>

                    <!-- Test Items Table -->
                    <div class="card border mt-3">
                        <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"><i class="fas fa-stethoscope me-1"></i>OPD Service Items</h6>
                            <div>
                                @livewire('opd-service-search')
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0" id="testItemsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 80px;">Code</th>
                                            <th>Service Name</th>
                                            <th style="width: 100px;">Charge</th>
                                            <th style="width: 120px;">Service Date</th>
                                            <th style="width: 80px;">Quantity</th>
                                            <th style="width: 100px;">Total</th>
                                            <th style="width: 40px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                        {{-- in there will be the test items all items will be added here --}}
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
                                <label class="col-sm-5 col-form-label">Discount (%)</label>
                                <div class="col-sm-7">
                                    <div class="input-group input-group-sm">
                                        <input type="number" class="form-control text-end" id="discountPercent" min="0" max="100" value="0" tabindex="20">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label">Discount Amount</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control form-control-sm text-end" id="discountAmount" value="0.00" step="0.01" min="0" tabindex="21">
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
                                    <input type="number" class="form-control form-control-sm text-end" id="paidAmount" value="0.00" step="0.01" min="0" tabindex="22">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label text-danger fw-bold">Due Amount</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control form-control-sm text-end fw-bold text-danger" id="dueAmount" readonly value="0.00">
                                </div>
                            </div>
                            
                 
                     
                            
                            <div class="d-flex justify-content-center gap-2 mt-4">
                                <button class="btn btn-success" id="saveInvoiceBtn" tabindex="23">
                                    <i class="fas fa-save me-1"></i> Save & Print
                                </button>
                                <button class="btn btn-primary" id="resetFormBtn" tabindex="24">
                                    <i class="fas fa-sync-alt me-1"></i> Reset
                                </button>
                                <button class="btn btn-danger" id="cancelBtn" tabindex="25">
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
    document.addEventListener('DOMContentLoaded', function() {
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
        
        // Handle arrow key navigation in search results
        document.addEventListener('keydown', function(e) {
            // Only handle arrow keys if we have search results
            if ((e.key === 'ArrowDown' || e.key === 'ArrowUp') && document.querySelector('.search-item')) {
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
            }
        });
        
        // Test item calculation
        const testItemsTable = document.getElementById('testItemsTable');
        
        function calculateTestItemTotal() {
            const rows = testItemsTable.querySelectorAll('tbody tr');
            let subtotal = 0;
            
            rows.forEach(row => {
                const charge = parseFloat(row.querySelector('.test-charge').value) || 0;
                const qty = parseInt(row.querySelector('.test-qty').value) || 1;
                const total = charge * qty;
                
                row.querySelector('.test-total').value = total.toFixed(2);
                subtotal += total;
            });
            
            document.getElementById('subtotalAmount').value = subtotal.toFixed(2);
            document.getElementById('totalAmount').value = subtotal.toFixed(2);
            
            calculateNetPayable();
        }
        
        function calculateNetPayable() {
            const totalAmount = parseFloat(document.getElementById('totalAmount').value) || 0;
            const discountAmount = parseFloat(document.getElementById('discountAmount').value) || 0;
            const netPayable = Math.max(0, totalAmount - discountAmount);
            const paidAmount = parseFloat(document.getElementById('paidAmount').value) || 0;
            const dueAmount = Math.max(0, netPayable - paidAmount);
            
            document.getElementById('netPayable').value = netPayable.toFixed(2);
            document.getElementById('dueAmount').value = dueAmount.toFixed(2);
        }
        
        // Define the calculateTestItemTotal function globally so it can be accessed anywhere
        window.calculateTestItemTotal = function() {
            const rows = testItemsTable.querySelectorAll('tbody tr');
            let subtotal = 0;
            
            rows.forEach(row => {
                const charge = parseFloat(row.querySelector('.test-charge').value) || 0;
                const qty = parseInt(row.querySelector('.test-qty').value) || 1;
                const total = charge * qty;
                
                row.querySelector('.test-total').value = total.toFixed(2);
                subtotal += total;
            });
            
            document.getElementById('subtotalAmount').value = subtotal.toFixed(2);
            document.getElementById('totalAmount').value = subtotal.toFixed(2);
            
            calculateNetPayable();
        }
        
        // Add event listeners for test item calculations
        testItemsTable.addEventListener('input', function(e) {
            if (e.target.classList.contains('test-charge') || e.target.classList.contains('test-qty')) {
                calculateTestItemTotal();
            }
        });
        
        // Discount percentage change
        document.getElementById('discountPercent').addEventListener('input', function() {
            const percent = parseFloat(this.value) || 0;
            const totalAmount = parseFloat(document.getElementById('totalAmount').value) || 0;
            const discountAmount = (totalAmount * percent / 100).toFixed(2);
            
            document.getElementById('discountAmount').value = discountAmount;
            calculateNetPayable();
        });
        
        // Discount amount change
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
        
        // Paid amount change
        document.getElementById('paidAmount').addEventListener('input', function() {
            calculateNetPayable();
        });
        
        // Reset form button
        document.getElementById('resetFormBtn').addEventListener('click', function() {
            // Reset form here
            // For now, just reload the page
            window.location.reload();
        });
        
        // Cancel button
        document.getElementById('cancelBtn').addEventListener('click', function() {
            window.location.href = "{{ route('admin.dashboard') }}";
        });
    });
    
    // Direct DOM manipulation for patient fields
    document.addEventListener('livewire:init', () => {
        // Patient selected event
        Livewire.on('fill-patient-fields', (patientData) => {
            console.log('Raw patient data:', patientData);
            
            // Check if we have an array with one element (which contains our object)
            let data = patientData;
            if (Array.isArray(patientData) && patientData.length > 0) {
                data = patientData[0];
            }
            
            console.log('Processed patient data:', data);
            
            // Fill hidden patient ID field
            document.getElementById('patient_id_hidden').value = data.id;
            
            // Fill patient name field
            const nameField = document.getElementById('patient_name');
            if (nameField) {
                nameField.value = data.name || '';
            }
            
            // Fill age fields
            const ageYearsField = document.getElementById('age_years');
            if (ageYearsField) {
                ageYearsField.value = parseInt(data.age_years || 0);
            }
            
            const ageMonthsField = document.getElementById('age_months');
            if (ageMonthsField) {
                ageMonthsField.value = parseInt(data.age_months || 0);
            }
            
            const ageDaysField = document.getElementById('age_days');
            if (ageDaysField) {
                ageDaysField.value = parseInt(data.age_days || 0);
            }
            
            // Fill patient phone field
            const contactField = document.getElementById('patient_phone');
            if (contactField) {
                contactField.value = data.phone || '';
            }
            
            // Fill patient address field
            const addressField = document.getElementById('patient_address');
            if (addressField) {
                addressField.value = data.address || '';
            }
        });
        
        // Doctor selected event
        Livewire.on('doctor-selected', (doctorData) => {
            console.log('Doctor selected:', doctorData);
            document.getElementById('doctor_id_hidden').value = doctorData.id;
        });
        
        // PCP selected event
        Livewire.on('pcp-selected', (pcpData) => {
            console.log('PCP selected:', pcpData);
            document.getElementById('referred_by_hidden').value = pcpData.id;
        });
        
        // Ticket selected event
        Livewire.on('fill-ticket-fields', (ticketData) => {
            console.log('Ticket selected:', ticketData);
            
            // Fill hidden ticket ID field
            document.getElementById('ticket_id_hidden').value = ticketData.id;
            
            // If there's a doctor name, try to find the doctor search field and fill it
            if (ticketData.doctorName) {
                const doctorSearchInput = document.querySelector('input[wire\\:model\\.live\\.debounce\\.300ms="search"][placeholder*="Doctor"]');
                if (doctorSearchInput) {
                    // This will trigger the Livewire property update
                    doctorSearchInput.value = ticketData.doctorName;
                    doctorSearchInput.dispatchEvent(new Event('input', { bubbles: true }));
                }
            }
            
            // If there's a doctor fee, fill the consultation fee field
            if (ticketData.doctorFee) {
                const consultationFeeInput = document.getElementById('consultationFee');
                if (consultationFeeInput) {
                    consultationFeeInput.value = ticketData.doctorFee;
                    consultationFeeInput.dispatchEvent(new Event('input', { bubbles: true }));
                }
            }
        });
        
        // OPD Service selected event
        Livewire.on('opd-service-selected', (testData) => {
            console.log('OPD service selected:', testData);
            
            // Get the testData from the first element if it's an array
            let data = testData;
            if (Array.isArray(testData) && testData.length > 0) {
                data = testData[0];
            }
            
            // Access properties directly with fallbacks
            console.log('Data object:', data);
            
            // Generate a unique ID for this row
            const rowId = 'test-row-' + Date.now();
            
            // Get tomorrow's date in YYYY-MM-DD format
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            const deliveryDate = tomorrow.toISOString().split('T')[0];
            
            // Extract values from the object
            const id = data.id || '';
            const code = data.code || '';
            const serviceName = data.service_name || '';
            const charge = parseFloat(data.charge || 0).toFixed(2);
            
            // Log the extracted values for debugging
            console.log('Extracted id:', id);
            console.log('Extracted code:', code);
            console.log('Extracted name:', serviceName);
            console.log('Extracted charge:', charge);
            
            // Create the row HTML with form fields
            const rowHtml = `
                <tr id="${rowId}">
                    <td>
                        <input type="text" class="form-control form-control-sm test-code" value="${code}" readonly>
                        <input type="hidden" name="test_ids[]" value="${id}">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm test-name" value="${serviceName}" readonly>
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm test-charge" value="${charge}" step="0.01" min="0">
                    </td>
                    <td>
                        <input type="date" class="form-control form-control-sm test-delivery-date" value="${deliveryDate}">
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-sm test-qty" value="1" min="1">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm test-total" value="${charge}" readonly>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger remove-test-btn" onclick="removeTestRow('${rowId}')">
                            <i class="fas fa-times"></i>
                        </button>
                    </td>
                </tr>
            `;
            
            // Append the row to the table
            const tbody = document.querySelector('#testItemsTable tbody');
            tbody.insertAdjacentHTML('beforeend', rowHtml);
            
            // Calculate totals using the global function
            window.calculateTestItemTotal();
            
            // Clear the search input to make it ready for the next search
            const opdServiceSearchInput = document.querySelector('input[wire\\:model\\.live\\.debounce\\.300ms="search"][placeholder*="Service"]');
            if (opdServiceSearchInput) {
                opdServiceSearchInput.value = '';
                opdServiceSearchInput.dispatchEvent(new Event('input', { bubbles: true }));
                opdServiceSearchInput.focus();
            }
        });
        
        // Update search title when search type changes
        Livewire.on('searchTypeChanged', (type) => {
            const titleElement = document.getElementById('search-title');
            if (titleElement) {
                titleElement.textContent = type + ' Search Results';
            }
        });
    });
    
    // Function to remove a test row
    function removeTestRow(rowId) {
        const row = document.getElementById(rowId);
        if (row) {
            row.remove();
            window.calculateTestItemTotal();
        }
    }
</script>
@endsection 