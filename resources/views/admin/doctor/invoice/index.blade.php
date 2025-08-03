@extends('admin.layouts.app')

@section('title', 'Doctor/Consultant Invoice')

@section('styles')
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
                                <h6 class="mb-0">Consultation Details =><span class="text-info"> DT-001 (Daily Ticket No - Each Doctor Starts from 1)</span></h6>  
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
                                            <label class="col-sm-4 col-form-label">Doctor: <span class="text-danger">*</span></label>
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
            resetForm();
        });
        
        // Cancel button
        document.getElementById('cancelBtn').addEventListener('click', function() {
            cancelForm();
        });
        
        // Save & Print button
        document.getElementById('saveInvoiceBtn').addEventListener('click', function() {
            saveConsultantInvoice();
        });
    });
    
    // Function to save the consultant invoice
    function saveConsultantInvoice() {
        // Validate required fields
        const patientId = document.getElementById('patient_id_hidden').value;
        const patientName = document.getElementById('patient_name').value;
        const patientPhone = document.getElementById('patient_phone').value;
        const patientAddress = document.getElementById('patient_address').value;
        const ageYears = document.getElementById('age_years').value;
        const ageMonths = document.getElementById('age_months').value;
        const ageDays = document.getElementById('age_days').value;
        const doctorId = document.querySelector('input[name="doctor_id_hidden"]').value;
        const consultationFee = parseFloat(document.getElementById('consultationFee').value) || 0;
        
        console.log('Validation values:', {
            patientId: patientId,
            patientName: patientName,
            patientPhone: patientPhone,
            doctorId: doctorId,
            consultationFee: consultationFee
        });
        
        // Check if we have patient information (either selected or entered)
        if (!patientName) {
            Livewire.dispatch('showError', { message: 'Please enter patient name' });
            return;
        }
        
        if (!patientPhone) {
            Livewire.dispatch('showError', { message: 'Please enter patient contact' });
            return;
        }
        
        if (!doctorId) {
            Livewire.dispatch('showError', { message: 'Please select a doctor' });
            return;
        }
        
        if (consultationFee <= 0) {
            Livewire.dispatch('showError', { message: 'Please enter a valid consultation fee' });
            return;
        }
        
        // Prepare form data
        const formData = {
            patient_id: patientId || null, // Can be null if no patient selected
            patient_name: patientName,
            patient_phone: patientPhone,
            patient_address: patientAddress,
            patient_age_years: parseInt(ageYears) || null,
            patient_age_months: parseInt(ageMonths) || null,
            patient_age_days: parseInt(ageDays) || null,
            ticket_date: document.querySelector('input[name="ticket_date"]').value,
            ticket_time: document.querySelector('input[name="ticket_time"]').value,
            doctor_id: doctorId,
            patient_type: document.getElementById('patient_type').value,
            consultation_fee: consultationFee,
            paid_amount: parseFloat(document.getElementById('paidAmount').value) || 0,
            referred_by: document.querySelector('input[name="referred_by_hidden"]').value || null,
            remarks: document.querySelector('textarea[name="remarks"]')?.value || null,
            _token: document.querySelector('input[name="_token"]').value
        };
        
        // Disable save button to prevent double submission
        const saveBtn = document.getElementById('saveInvoiceBtn');
        const originalText = saveBtn.innerHTML;
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Saving...';
        
        // Send AJAX request
        fetch('{{ route("admin.doctor.invoice.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success toast with invoice and ticket details
                Livewire.dispatch('showInvoiceSuccess', { 
                    message: data.message,
                    invoiceNo: data.invoice_no,
                    ticketNo: data.ticket_no
                });
                
                // Re-enable save button
                saveBtn.disabled = false;
                saveBtn.innerHTML = originalText;
                
                // Don't redirect automatically - let user decide via toast buttons
                console.log('Invoice created successfully. Toast will stay open for user interaction.');
                
            } else {
                // Show error toast using Livewire
                Livewire.dispatch('showError', { message: 'Error creating invoice: ' + data.message });
                // Re-enable save button
                saveBtn.disabled = false;
                saveBtn.innerHTML = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Show error toast using Livewire
            Livewire.dispatch('showError', { message: 'Network error occurred. Please try again.' });
            // Re-enable save button
            saveBtn.disabled = false;
            saveBtn.innerHTML = originalText;
        });
    }
    
    // Function to calculate due amount
    function calculateDueAmount() {
        const consultationFee = parseFloat(document.getElementById('consultationFee').value) || 0;
        const paidAmount = parseFloat(document.getElementById('paidAmount').value) || 0;
        const dueAmount = consultationFee - paidAmount;
        
        document.getElementById('dueAmount').value = dueAmount.toFixed(2);
    }
    
    // Function to auto-set paid amount when consultation fee changes
    function autoSetPaidAmount() {
        const consultationFee = parseFloat(document.getElementById('consultationFee').value) || 0;
        document.getElementById('paidAmount').value = consultationFee.toFixed(2);
        calculateDueAmount();
    }
    
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
        
        // Doctor selected event
        Livewire.on('doctor-selected', (doctorData) => {
            console.log('Doctor selected:', doctorData);
            
            // Check if we have an array with one element (which contains our object)
            let data = doctorData;
            if (Array.isArray(doctorData) && doctorData.length > 0) {
                data = doctorData[0];
            }
            
            console.log('Processed doctor data:', data);
            
            // Fill hidden doctor ID field
            const doctorIdField = document.querySelector('input[name="doctor_id_hidden"]');
            if (doctorIdField) {
                doctorIdField.value = data.id;
                console.log('Doctor ID field updated:', data.id);
                
                // Fetch current ticket count for this doctor
                fetchDoctorTicketCount(data.id);
            } else {
                console.error('Doctor ID field not found!');
            }
            
            // Update the doctor search field with the selected doctor's code
            // Find the doctor search input field specifically
            const doctorSearchField = document.querySelector('input[wire\\:model="search"]');
            if (doctorSearchField) {
                doctorSearchField.value = data.code || data.name || '';
                console.log('Doctor search field updated:', data.code || data.name);
            }
            
            // Also try to find the doctor search field by looking for the doctor-search component
            const doctorSearchComponent = document.querySelector('[wire\\:id*="doctor-search"] input');
            if (doctorSearchComponent) {
                doctorSearchComponent.value = data.code || data.name || '';
                console.log('Doctor search component updated:', data.code || data.name);
            }
            
            // Test: Log all input fields to see what's available
            console.log('All input fields:', document.querySelectorAll('input'));
        });
        
        // Function to fetch current ticket count for a doctor
        function fetchDoctorTicketCount(doctorId) {
            const today = new Date().toISOString().split('T')[0];
            
            fetch(`/admin/doctor/invoice/doctor-ticket-count?doctor_id=${doctorId}&date=${today}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log(`Doctor ${doctorId} has ${data.ticket_count} tickets today. Next ticket: ${data.next_ticket_number}`);
                    
                    // You can display this information somewhere in the UI if needed
                    // For example, show it near the ticket date/time fields
                    const ticketInfo = document.getElementById('ticketInfo');
                    if (ticketInfo) {
                        ticketInfo.innerHTML = `<small class="text-info">Today's tickets: ${data.ticket_count} | Next: DT-${String(data.next_ticket_number).padStart(3, '0')}</small>`;
                    }
                }
            })
            .catch(error => {
                console.error('Error fetching ticket count:', error);
            });
        }
        
        // PCP selected event
        Livewire.on('pcp-selected', (pcpData) => {
            console.log('PCP selected:', pcpData);
            
            // Check if we have an array with one element (which contains our object)
            let data = pcpData;
            if (Array.isArray(pcpData) && pcpData.length > 0) {
                data = pcpData[0];
            }
            
            console.log('Processed PCP data:', data);
            
            // Fill hidden PCP ID field
            const pcpIdField = document.querySelector('input[name="referred_by_hidden"]');
            if (pcpIdField) {
                pcpIdField.value = data.id;
                console.log('PCP ID field updated:', data.id);
            } else {
                console.error('PCP ID field not found!');
            }
            
            // Update the PCP search field with the selected PCP's code
            const pcpSearchField = document.querySelector('input[wire\\:model="search"]');
            if (pcpSearchField) {
                pcpSearchField.value = data.code || data.name || '';
                console.log('PCP search field updated:', data.code || data.name);
            }
        });
        
        // Update search title when search type changes
        Livewire.on('searchTypeChanged', (type) => {
            const titleElement = document.getElementById('search-title');
            if (titleElement) {
                titleElement.textContent = type + ' Search Results';
            }
        });
        
        // Auto-set paid amount when consultation fee changes
        const consultationFeeInput = document.getElementById('consultationFee');
        if (consultationFeeInput) {
            consultationFeeInput.addEventListener('input', autoSetPaidAmount);
            consultationFeeInput.addEventListener('change', autoSetPaidAmount);
        }
        
        // Calculate due amount when paid amount changes
        const paidAmountInput = document.getElementById('paidAmount');
        if (paidAmountInput) {
            paidAmountInput.addEventListener('input', calculateDueAmount);
            paidAmountInput.addEventListener('change', calculateDueAmount);
        }
        
        // Initial calculation
        calculateDueAmount();
    });

    // Reset form function
    function resetForm() {
        // Show confirmation toast
        Livewire.dispatch('showWarning', { message: 'Are you sure you want to reset the form? All data will be cleared.' });
        
        // Clear all form fields
        document.getElementById('patient_name').value = '';
        document.getElementById('patient_phone').value = '';
        document.getElementById('patient_address').value = '';
        document.getElementById('age_years').value = '';
        document.getElementById('age_months').value = '';
        document.getElementById('age_days').value = '';
        document.getElementById('consultationFee').value = '';
        document.getElementById('paidAmount').value = '';
        document.getElementById('dueAmount').value = '';
        document.getElementById('patient_id_hidden').value = '';
        document.querySelector('input[name="doctor_id_hidden"]').value = '';
        document.querySelector('input[name="referred_by_hidden"]').value = '';
        document.querySelector('textarea[name="remarks"]').value = '';
        
        // Clear search fields
        const doctorSearchField = document.querySelector('input[wire\\:model="search"]');
        if (doctorSearchField) {
            doctorSearchField.value = '';
        }
        
        // Reset patient type to default
        document.getElementById('patient_type').value = 'new';
        
        // Show success toast after reset
        setTimeout(() => {
            Livewire.dispatch('showSuccess', { message: 'Form has been reset successfully! All fields cleared.' });
        }, 1000);
    }

    // Cancel function
    function cancelForm() {
        // Show confirmation toast
        Livewire.dispatch('showWarning', { message: 'Are you sure you want to cancel? All unsaved changes will be lost.' });
        
        // Redirect to dashboard after confirmation
        setTimeout(() => {
            window.location.href = '{{ route("admin.dashboard") }}';
        }, 2000);
    }
</script>
@endsection 