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
                                        <input type="date" class="form-control" id="reg_date" name="reg_date" value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="patient_id" class="col-4 col-form-label">Reg. No(#):</label>
                                    <div class="col-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="patient_id" name="patient_id" value="(AUTO)" readonly>
                                            <button class="btn btn-success" type="button">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Row 2 -->
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <label for="name_en" class="col-2 col-form-label">Name(Eng): <span class="text-danger">*</span></label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" id="name_en" name="name_en" placeholder="Name (English)" required>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Row 5 -->
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <label for="address" class="col-2 col-form-label">Address:</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" id="address" name="address" placeholder="Present Address">
                                    </div>
                                </div>
                            </div>
                            

                    
                            
                            <!-- Row 7 -->
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="phone" class="col-4 col-form-label">Contact: <span class="text-danger">*</span></label>
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Contact No" required>
                                    </div>
                                </div>
                            </div>
                           
                            
                            <!-- Row 8 -->
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="original_dob" name="original_dob">
                                            <label class="form-check-label text-success" for="original_dob">
                                                Original DOB
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <input type="date" class="form-control" id="dob" name="dob">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="age" class="col-4 col-form-label">Age:</label>
                                    <div class="col-8">
                                        <div class="row g-1">
                                            <div class="col-4">
                                                <input type="number" class="form-control text-center" id="age_year" name="age_year" placeholder="Y" min="0" max="150">
                                            </div>
                                            <div class="col-4">
                                                <input type="number" class="form-control text-center" id="age_month" name="age_month" placeholder="M" min="0" max="12">
                                            </div>
                                            <div class="col-4">
                                                <input type="number" class="form-control text-center" id="age_day" name="age_day" placeholder="D" min="0" max="31">
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
                                        <select class="form-select" id="gender" name="gender">
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
                                        <select class="form-select" id="blood_group" name="blood_group">
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
                                        <input type="number" class="form-control" id="reg_fee" name="reg_fee" value="0">
                                    </div>
                                </div>
                            </div>
                            
                            
                     
                        </div>
                    </div>
                    
                    <!-- Right Column - Patient List -->
                    <div class="col-lg-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-primary py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 text-white">
                                        <i class="fas fa-users me-1"></i> Recent Patients
                                    </h6>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">
                                    @forelse($recentPatients as $patient)
                                    <a href="{{ route('admin.patients.show', $patient->id) }}" class="list-group-item list-group-item-action py-2 px-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="badge bg-primary rounded-pill">{{ $patient->patient_id }}</span>
                                                <div class="fw-medium">{{ $patient->name_en }}</div>
                                            </div>
                                            <div class="text-end">
                                                <div class="text-muted small">{{ $patient->phone ?? 'No Phone' }}</div>
                                                <div class="text-muted small">{{ Str::limit($patient->address, 30) ?? 'No Address' }}</div>
                                            </div>
                                        </div>
                                    </a>
                                    @empty
                                    <div class="list-group-item py-3">
                                        <p class="mb-0 text-center text-muted">No patients found</p>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-success px-4 me-2">
                            <i class="fas fa-save me-1"></i> Save
                        </button>
                       
                        <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary px-4">
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
    $(document).ready(function() {
        // Date picker initialization
        $('#dob').on('change', function() {
            // Calculate age based on DOB
            if($(this).val()) {
                calculateAgeFromDOB($(this).val());
            }
        });
        
        // Age to DOB calculation
        $('#age_year, #age_month, #age_day').on('change', function() {
            if($('#original_dob').prop('checked')) {
                return; // Don't override original DOB
            }
            
            calculateDOBFromAge();
        });
        
        // Calculate DOB from age inputs
        function calculateDOBFromAge() {
            var years = parseInt($('#age_year').val()) || 0;
            var months = parseInt($('#age_month').val()) || 0;
            var days = parseInt($('#age_day').val()) || 0;
            
            if(years > 0 || months > 0 || days > 0) {
                var today = new Date();
                today.setFullYear(today.getFullYear() - years);
                today.setMonth(today.getMonth() - months);
                today.setDate(today.getDate() - days);
                
                var yyyy = today.getFullYear();
                var mm = String(today.getMonth() + 1).padStart(2, '0');
                var dd = String(today.getDate()).padStart(2, '0');
                
                $('#dob').val(yyyy + '-' + mm + '-' + dd);
            }
        }
        
        // Calculate age from DOB
        function calculateAgeFromDOB(dobString) {
            var dob = new Date(dobString);
            var today = new Date();
            var age = today.getFullYear() - dob.getFullYear();
            var m = today.getMonth() - dob.getMonth();
            var d = today.getDate() - dob.getDate();
            
            if (m < 0 || (m === 0 && d < 0)) {
                age--;
                m += 12;
            }
            
            if (d < 0) {
                m--;
                var lastMonth = new Date(today.getFullYear(), today.getMonth(), 0);
                d += lastMonth.getDate();
            }
            
            $('#age_year').val(age);
            $('#age_month').val(m);
            $('#age_day').val(d);
        }
        
        // Form submission handling
        $('form').on('submit', function(e) {
            // If DOB is empty but age is provided, calculate DOB
            if(!$('#dob').val() && ($('#age_year').val() || $('#age_month').val() || $('#age_day').val())) {
                calculateDOBFromAge();
            }
        });
    });
</script>
@endsection 