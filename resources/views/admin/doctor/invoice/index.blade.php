@extends('admin.layouts.app')

@section('title', 'Doctor/Consultant Invoice')

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
                    <i class="fas fa-user-md me-2"></i> Doctor/Consultant Invoice
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
            <form id="consultantInvoiceForm" action="{{ route('admin.doctor.invoice.store') }}" method="POST">
                @csrf
                <div class="row mb-4">
                    <!-- Left Column -->
                    <div class="col-md-7">
                        <div class="card border">
                            <div class="card-header bg-light py-2">
                                <h6 class="mb-0">Consultation Details =><span class="text-info"> DT-YYMMDD (Daily Ticket No)</span></h6>  
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
                                            <label class="col-sm-4 col-form-label">Name: <span class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" name="name_en" id="patient_name" required tabindex="2">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Age:</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm" id="age_years" name="age_years" placeholder="Y" style="width: 30%;" tabindex="3">
                                                    <input type="text" class="form-control form-control-sm" id="age_months" name="age_months" placeholder="M" style="width: 30%;" tabindex="4">
                                                    <input type="text" class="form-control form-control-sm" id="age_days" name="age_days" placeholder="D" style="width: 30%;" tabindex="5">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Contact: <span class="text-danger">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" name="phone" id="patient_phone" required tabindex="6">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Patient Type:</label>
                                            <div class="col-sm-8">
                                                <select class="form-select form-select-sm" id="patient_type" name="patient_type" required tabindex="7">
                                                    <option selected value="new">New</option>
                                                    <option value="old">Old</option>
                                                    <option value="follow_up">Follow-up</option>
                                                    <option value="pcp">PCP (Referral)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-sm-2 col-form-label">Address:</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control form-control-sm" name="address" id="patient_address" rows="2" tabindex="8"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Date:</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <input type="date" class="form-control form-control-sm" name="ticket_date" value="{{ date('Y-m-d') }}" required tabindex="9">
                                                    <button class="btn btn-sm btn-outline-secondary" type="button" tabindex="-1"><i class="fas fa-calendar"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Time:</label>
                                            <div class="col-sm-8">
                                                <input type="time" class="form-control form-control-sm" name="ticket_time" value="{{ date('H:i') }}" required tabindex="10">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Doctor:</label>
                                            <div class="col-sm-8">
                                                @livewire('doctor-search')
                                                <input type="hidden" name="doctor_id_hidden">
                                            </div>
                                        </div>
                                             <!-- PCP Referral Section -->
                                        <div class="row mb-2">
                                            <label class="col-sm-4 col-form-label">Ref:</label>
                                            <div class="col-sm-8">
                                                @livewire('pcp-search')
                                                <input type="hidden" name="referred_by_hidden">
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <label class="col-sm-2 col-form-label">Remarks:</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control form-control-sm" name="remarks" rows="3" tabindex="13"></textarea>
                                            </div>
                                        </div>
                                        
                                       
                                        
                                    </div>
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
                        <h6 class="mb-0"><i class="fas fa-file-invoice-dollar me-1"></i> Payment Summary</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <label class="col-sm-5 col-form-label">Consultation Fee</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control form-control-sm text-end fw-bold" id="consultationFee" name="consultation_fee" value="0.00" tabindex="14">
                            </div>
                        </div>
                       
                        <div class="row mb-2">
                            <label class="col-sm-5 col-form-label">Paid Amount</label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control form-control-sm text-end" id="paidAmount" name="paid_amount" value="0.00" step="0.01" min="0" tabindex="15">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label class="col-sm-5 col-form-label text-danger fw-bold">Due Amount</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control form-control-sm text-end fw-bold text-danger" id="dueAmount" readonly value="0.00" tabindex="-1">
                            </div>
                        </div>
                        
                        <!-- Payment Method section removed -->
                        <input type="hidden" name="payment_method" value="cash">
                        
                        <div class="d-flex justify-content-center gap-2 mt-4">
                            <button type="submit" class="btn btn-success" id="saveInvoiceBtn" tabindex="16">
                                <i class="fas fa-save me-1"></i> Save & Print
                            </button>
                            <button type="button" class="btn btn-primary" id="resetFormBtn" tabindex="17">
                                <i class="fas fa-sync-alt me-1"></i> Reset
                            </button>
                            <button type="button" class="btn btn-danger" id="cancelBtn" tabindex="18">
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
                        if (nextElement.tagName === 'INPUT' && nextElement.type !== 'date' && nextElement.type !== 'time') {
                            nextElement.select();
                        }
                    }
                }
            });
        });
        
        // Calculate due amount when consultation fee or paid amount changes
        document.getElementById('consultationFee').addEventListener('input', updateDueAmount);
        document.getElementById('paidAmount').addEventListener('input', updateDueAmount);
        
        function updateDueAmount() {
            const fee = parseFloat(document.getElementById('consultationFee').value) || 0;
            const paid = parseFloat(document.getElementById('paidAmount').value) || 0;
            const due = Math.max(0, fee - paid);
            document.getElementById('dueAmount').value = due.toFixed(2);
        }
        
        // Reset form button
        document.getElementById('resetFormBtn').addEventListener('click', function() {
            document.getElementById('consultantInvoiceForm').reset();
            updateDueAmount();
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
            
            // Fill patient name field - make sure this exists
            const nameField = document.getElementById('patient_name');
            if (nameField) {
                nameField.value = data.name || '';
            }
            
            // Fill patient age fields
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
            
            // Fill patient phone field - make sure this exists
            const phoneField = document.getElementById('patient_phone');
            if (phoneField) {
                phoneField.value = data.phone || '';
            }
            
            // Fill patient address field - make sure this exists
            const addressField = document.getElementById('patient_address');
            if (addressField) {
                addressField.value = data.address || '';
            }
            
            // Set patient type to old since we're selecting an existing patient
            const patientTypeField = document.getElementById('patient_type');
            if (patientTypeField) {
                patientTypeField.value = 'old';
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
</script>
@endsection 