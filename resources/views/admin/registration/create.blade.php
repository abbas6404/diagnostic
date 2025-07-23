@extends('admin.layouts.app')

@section('title', 'Patient Registration')

@php
use Illuminate\Support\Str;
@endphp

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary">
                    <i class="fas fa-user-plus me-2"></i> Patient's Registration
            </h5>
                <a href="{{ route('admin.patients.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-th-list me-1"></i> Patient List
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.patients.store') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- Left Column - Patient Registration Form -->
                    <div class="col-lg-8">
                        <div class="row gx-3 gy-2">
                            <!-- Row 1 -->
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="reg_date" class="col-4 col-form-label">Reg. Date:</label>
                                    <div class="col-8">
                                        <input type="date" class="form-control" id="reg_date" name="reg_date" value="{{ date('Y-m-d') }}" tabindex="2">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="patient_id" class="col-4 col-form-label">Reg. No(#):</label>
                                    <div class="col-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="patient_id" name="patient_id" value="(AUTO)" readonly tabindex="-1">
                                            <button class="btn btn-success" type="button" tabindex="-1">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           <!-- search -->
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <label for="patient-search" class="col-2 col-form-label">Search: </label>
                                    <div class="col-10">
                                        @livewire('patient-search')
                                        <input type="hidden" id="patient_id_hidden" name="patient_id_hidden">
                                    </div>
                                </div>
                            </div>
                            <!-- Row 2 -->
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <label for="name_en" class="col-2 col-form-label">Name(Eng): <span class="text-danger">*</span></label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" id="name_en" name="name_en" placeholder="Name (English)" required tabindex="3">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Row 5 -->
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <label for="address" class="col-2 col-form-label">Address:</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" id="address" name="address" placeholder="Present Address" tabindex="4">
                                    </div>
                                </div>
                            </div>
                            

                    
                            
                            <!-- Row 7 -->
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="phone" class="col-4 col-form-label">Contact: <span class="text-danger">*</span></label>
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Contact No" required tabindex="5">
                                    </div>
                                </div>
                            </div>
                           
                            
                            <!-- Row 8 -->
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="original_dob" name="original_dob" tabindex="6">
                                            <label class="form-check-label text-success" for="original_dob">
                                                Original DOB
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <input type="date" class="form-control" id="dob" name="dob" tabindex="7">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="age" class="col-4 col-form-label">Age:</label>
                                    <div class="col-8">
                                        <div class="row g-1">
                                            <div class="col-4">
                                                <input type="number" class="form-control text-center" id="age_year" name="age_year" placeholder="Y" min="0" max="150" tabindex="8">
                                            </div>
                                            <div class="col-4">
                                                <input type="number" class="form-control text-center" id="age_month" name="age_month" placeholder="M" min="0" max="12" tabindex="9">
                                            </div>
                                            <div class="col-4">
                                                <input type="number" class="form-control text-center" id="age_day" name="age_day" placeholder="D" min="0" max="31" tabindex="10">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Row 9 -->
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="gender" class="col-4 col-form-label">Sex:</label>
                                    <div class="col-8">
                                        <select class="form-select" id="gender" name="gender" tabindex="11">
                                            <option value="">-- Select Sex --</option>
                                            <option value="Female">Female</option>
                                            <option value="Male">Male</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="blood_group" class="col-4 col-form-label">Blood:</label>
                                    <div class="col-8">
                                        <select class="form-select" id="blood_group" name="blood_group" tabindex="12">
                                            <option value="">-- Select Blood Group --</option>
                                            <option value="A+">A+ (ve)</option>
                                            <option value="A-">A- (ve)</option>
                                            <option value="B+">B+ (ve)</option>
                                            <option value="B-">B- (ve)</option>
                                            <option value="AB+">AB+ (ve)</option>
                                            <option value="AB-">AB- (ve)</option>
                                            <option value="O+">O+ (ve)</option>
                                            <option value="O-">O- (ve)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
             
                            
                            <!-- Row 11 -->
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="reg_fee" class="col-4 col-form-label text-danger">Reg. Fees:</label>
                                    <div class="col-8">
                                        <input type="number" class="form-control" id="reg_fee" name="reg_fee" value="0" tabindex="13">
                                    </div>
                                </div>
                            </div>
                            
                            
                     
                        </div>
                    </div>
                    
                    <!-- Right Column - Patient List -->
                    <div class="col-lg-4">
                        <!-- Search Results Area -->
                        <div class="card border mb-3" id="search-results-container">
                            <div class="card-header bg-primary text-white py-2">
                                <h6 class="mb-0"><i class="fas fa-search me-1"></i> <span id="search-title">Search Results</span></h6>
                            </div>
                            <div class="card-body p-0" style="height: 400px; overflow-y: auto;" id="search-results-body">
                                @livewire('search-results')
                            </div>
                        </div>
                    </div>
                   
                </div>

                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-success px-4 me-2" tabindex="14">
                            <i class="fas fa-save me-1"></i> Save
                        </button>
                       
                        <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary px-4" tabindex="15">
                            <i class="fas fa-times me-1"></i> Exit
                        </a>
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
                        if (nextElement.tagName === 'INPUT' && nextElement.type !== 'date' && nextElement.type !== 'checkbox') {
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
        
        // Handle DOB and Age calculations
        const dobInput = document.getElementById('dob');
        const ageYearInput = document.getElementById('age_year');
        const ageMonthInput = document.getElementById('age_month');
        const ageDayInput = document.getElementById('age_day');
        
        // Calculate age from DOB
        dobInput.addEventListener('change', function() {
            if (this.value) {
                const dob = new Date(this.value);
                const today = new Date();
                
                let years = today.getFullYear() - dob.getFullYear();
                let months = today.getMonth() - dob.getMonth();
                let days = today.getDate() - dob.getDate();
                
                if (months < 0 || (months === 0 && days < 0)) {
                    years--;
                    months += 12;
                }
                
                if (days < 0) {
                    const monthDays = new Date(today.getFullYear(), today.getMonth(), 0).getDate();
                    days += monthDays;
                    months--;
                }
                
                ageYearInput.value = years;
                ageMonthInput.value = months;
                ageDayInput.value = days;
            }
        });
        
        // Calculate DOB from age
        function calculateDOB() {
            const years = parseInt(ageYearInput.value) || 0;
            const months = parseInt(ageMonthInput.value) || 0;
            const days = parseInt(ageDayInput.value) || 0;
            
            if (years > 0 || months > 0 || days > 0) {
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                
                let dob = new Date(today);
                dob.setFullYear(today.getFullYear() - years);
                dob.setMonth(today.getMonth() - months);
                dob.setDate(today.getDate() - days);
                
                // Format date as YYYY-MM-DD
                const year = dob.getFullYear();
                const month = String(dob.getMonth() + 1).padStart(2, '0');
                const day = String(dob.getDate()).padStart(2, '0');
                
                dobInput.value = `${year}-${month}-${day}`;
            }
        }
        
        ageYearInput.addEventListener('change', calculateDOB);
        ageMonthInput.addEventListener('change', calculateDOB);
        ageDayInput.addEventListener('change', calculateDOB);
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
            const nameField = document.getElementById('name_en');
            if (nameField) {
                nameField.value = data.name || '';
            }
            
            // Fill patient phone field
            const phoneField = document.getElementById('phone');
            if (phoneField) {
                phoneField.value = data.phone || '';
            }
            
            // Fill patient address field
            const addressField = document.getElementById('address');
            if (addressField) {
                addressField.value = data.address || '';
            }
            
            // Fill age fields
            const ageYearField = document.getElementById('age_year');
            if (ageYearField) {
                ageYearField.value = parseInt(data.age_years || 0);
            }
            
            const ageMonthField = document.getElementById('age_month');
            if (ageMonthField) {
                ageMonthField.value = parseInt(data.age_months || 0);
            }
            
            const ageDayField = document.getElementById('age_day');
            if (ageDayField) {
                ageDayField.value = parseInt(data.age_days || 0);
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