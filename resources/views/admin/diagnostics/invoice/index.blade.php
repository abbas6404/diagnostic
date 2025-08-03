@extends('admin.layouts.app')

@section('title', 'Diagnostics Invoice')

@section('styles')
<link href="{{ asset('css/admin-layout.css') }}" rel="stylesheet">
@endsection

@section('content')
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
                            <h6 class="mb-0"><i class="fas fa-vial me-1"></i>Lab Tests & Collection Kits</h6>
                            <div>
                                @livewire('lab-test-search')
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0" id="testItemsTable">
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
                                        <tr class="table-info">
                                            <td colspan="7" class="fw-bold">
                                                <i class="fas fa-vial me-1"></i> Lab Tests
                                            </td>
                                        </tr>
                                        <tbody id="labTestsBody">
                                            {{-- Lab tests will be added here --}}
                                        </tbody>
                                        
                                        <!-- Collection Kits Section -->
                                        <tr class="table-warning">
                                            <td colspan="7" class="fw-bold">
                                                <i class="fas fa-box me-1"></i> Collection Kits
                                            </td>
                                        </tr>
                                        <tbody id="collectionKitsBody">
                                            {{-- Collection kits will be added here --}}
                                        </tbody>
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
            // Get all rows from both lab tests and collection kits sections
            const labTestRows = document.querySelectorAll('#labTestsBody tr');
            const collectionKitRows = document.querySelectorAll('#collectionKitsBody tr');
            let subtotal = 0;
            
            // Calculate totals for lab test rows
            labTestRows.forEach(row => {
                const chargeInput = row.querySelector('.test-charge');
                const qtyInput = row.querySelector('.test-qty');
                const totalInput = row.querySelector('.test-total');
                
                if (chargeInput && qtyInput && totalInput) {
                    const charge = parseFloat(chargeInput.value) || 0;
                    const qty = parseInt(qtyInput.value) || 1;
                    const total = charge * qty;
                    
                    totalInput.value = total.toFixed(2);
                    subtotal += total;
                }
            });
            
            // Calculate totals for collection kit rows
            collectionKitRows.forEach(row => {
                const chargeInput = row.querySelector('.test-charge');
                const qtyInput = row.querySelector('.test-qty');
                const totalInput = row.querySelector('.test-total');
                
                if (chargeInput && qtyInput && totalInput) {
                    const charge = parseFloat(chargeInput.value) || 0;
                    const qty = parseInt(qtyInput.value) || 1;
                    const total = charge * qty;
                    
                    totalInput.value = total.toFixed(2);
                    subtotal += total;
                }
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
        
        // Also add event listeners to the specific sections
        document.addEventListener('input', function(e) {
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
        
        // Lab Test selected event
        Livewire.on('lab-test-selected', (testData) => {
            console.log('Lab test selected:', testData);
            
            // Get the testData from the first element if it's an array
            let data = testData;
            if (Array.isArray(testData) && testData.length > 0) {
                data = testData[0];
            }
            
            // Access properties directly with fallbacks
            console.log('Data object:', data);
            console.log('Collection kits:', data.collection_kits);
            console.log('Collection kits type:', typeof data.collection_kits);
            console.log('Collection kits length:', data.collection_kits ? data.collection_kits.length : 'undefined');
            
            // Extract values from the object
            const id = data.id || '';
            const code = data.code || '';
            const testName = data.test_name || '';
            const charge = parseFloat(data.charge || 0).toFixed(2);
            const collectionKits = data.collection_kits || [];
            
            // Log the extracted values for debugging
            console.log('Extracted id:', id);
            console.log('Extracted code:', code);
            console.log('Extracted name:', testName);
            console.log('Extracted charge:', charge);
            console.log('Collection kits:', collectionKits);
            
            // Check if this test already exists in the table
            const existingTestRow = document.querySelector(`input[name="test_ids[]"][value="${id}"]`);
            if (existingTestRow) {
                // Test already exists, update quantity
                const row = existingTestRow.closest('tr');
                const qtyInput = row.querySelector('.test-qty');
                const currentQty = parseInt(qtyInput.value) || 1;
                qtyInput.value = currentQty + 1;
                
                // Trigger calculation
                window.calculateTestItemTotal();
                
                console.log('Updated quantity for existing test:', testName);
            } else {
                // Test doesn't exist, add new row
                const rowId = 'test-row-' + Date.now();
                
                // Get tomorrow's date in YYYY-MM-DD format
                const tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                const deliveryDate = tomorrow.toISOString().split('T')[0];
                
                // Create the row HTML with form fields
                const rowHtml = `
                    <tr id="${rowId}">
                        <td>
                            <input type="text" class="form-control form-control-sm test-code" value="${code}" readonly>
                            <input type="hidden" name="test_ids[]" value="${id}">
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm test-name" value="${testName}" readonly>
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
                const labTestsBody = document.querySelector('#labTestsBody');
                labTestsBody.insertAdjacentHTML('beforeend', rowHtml);
                
                // Add collection kits if they exist
                if (collectionKits.length > 0) {
                    console.log('Adding collection kits:', collectionKits);
                    collectionKits.forEach((kit, index) => {
                        console.log('Processing kit:', kit);
                        // Check if this kit is already added (to prevent duplicates)
                        const kitCode = kit.pcode || kit.name;
                        const existingKit = document.querySelector(`tr.collection-kit-row[data-kit-id="${kit.id}"]`);
                        if (!existingKit) {
                            console.log('Adding new kit:', kit.name);
                            const kitRowId = 'kit-row-' + Date.now() + '-' + index;
                            const kitCharge = parseFloat(kit.kit_charge || 0).toFixed(2);
                            const kitColor = kit.color || '';
                            
                            // Create color display - only show if color exists
                            let colorDisplay = '';
                            if (kitColor && kitColor.trim() !== '') {
                                // Convert color names to CSS color values
                                let cssColor = kitColor;
                                switch(kitColor.toLowerCase()) {
                                    case 'red':
                                        cssColor = '#dc3545';
                                        break;
                                    case 'lavender':
                                        cssColor = '#e6e6fa';
                                        break;
                                    case 'light blue':
                                        cssColor = '#add8e6';
                                        break;
                                    case 'gray':
                                        cssColor = '#808080';
                                        break;
                                    case 'green':
                                        cssColor = '#28a745';
                                        break;
                                    default:
                                        cssColor = kitColor;
                                }
                                
                                // Use white text for dark colors, black for light colors
                                const textColor = (cssColor === '#e6e6fa' || cssColor === '#add8e6') ? '#000' : '#fff';
                                
                                colorDisplay = `<span class="badge" style="background-color: ${cssColor}; color: ${textColor}; margin-left: 5px;">${kitColor}</span>`;
                            }
                            
                            const kitRowHtml = `
                                <tr id="${kitRowId}" class="collection-kit-row" data-kit-id="${kit.id}">
                                    <td>
                                        <input type="text" class="form-control form-control-sm" value="${kitCode}" readonly data-kit-id="${kit.id}">
                                        <input type="hidden" name="kit_ids[]" value="${kit.id}">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="me-2">${kit.name}</span>
                                            ${colorDisplay}
                                        </div>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm test-charge" value="${kitCharge}" step="0.01" min="0">
                                    </td>
                                    <td>
                                        <span class="text-muted">-</span>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm test-qty" value="1" min="1">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm test-total" value="${kitCharge}" readonly>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger remove-test-btn" onclick="removeTestRow('${kitRowId}')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                            
                            const collectionKitsBody = document.querySelector('#collectionKitsBody');
                            collectionKitsBody.insertAdjacentHTML('beforeend', kitRowHtml);
                        } else {
                            console.log('Kit already exists:', kit.name);
                        }
                    });
                } else {
                    console.log('No collection kits found for this test');
                }
                
                // Calculate totals using the global function
                window.calculateTestItemTotal();
            }
            
            // Clear the search input to make it ready for the next search
            const labTestSearchInput = document.querySelector('input[wire\\:model\\.live\\.debounce\\.300ms="search"][placeholder*="Test"]');
            if (labTestSearchInput) {
                labTestSearchInput.value = '';
                // Trigger Livewire update
                labTestSearchInput.dispatchEvent(new Event('input', { bubbles: true }));
                // Also trigger keyup event to ensure Livewire picks up the change
                labTestSearchInput.dispatchEvent(new Event('keyup', { bubbles: true }));
                // Focus back to the search input
                setTimeout(() => {
                    labTestSearchInput.focus();
                }, 100);
            }
            
            // Trigger Livewire to clear search results instead of manipulating DOM directly
            Livewire.dispatch('clear-search-results');
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