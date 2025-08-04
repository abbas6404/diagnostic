@extends('admin.layouts.app')

@section('title', 'Edit Patient')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary">
                    <i class="fas fa-user-edit me-2"></i> Edit Patient
                </h5>
                <div>
                    <a href="{{ route('admin.patients.show', $patient->id) }}" class="btn btn-info btn-sm me-2">
                        <i class="fas fa-eye me-1"></i> View
                    </a>
                    <a href="{{ route('admin.patients.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <form action="{{ route('admin.patients.update', $patient->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Left Column - Patient Registration Form -->
                    <div class="col-lg-7">
                        <div class="row gx-3 gy-2">
                            <!-- Row 1 -->
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="reg_date" class="col-4 col-form-label">Reg. Date:</label>
                                    <div class="col-8">
                                        <input type="date" class="form-control" id="reg_date" name="reg_date" value="{{ old('reg_date', $patient->reg_date) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="patient_id" class="col-4 col-form-label">Reg. No(#):</label>
                                    <div class="col-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="patient_id" value="{{ $patient->patient_id }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Row 2 -->
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <label for="name" class="col-2 col-form-label">Name: <span class="text-danger">*</span></label>
                                    <div class="col-10">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $patient->name) }}" placeholder="Name" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Row 5 -->
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <label for="address" class="col-2 col-form-label">Address:</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $patient->address) }}" placeholder="Present Address">
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Row 7 -->
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="phone" class="col-4 col-form-label">Contact: <span class="text-danger">*</span></label>
                                    <div class="col-8">
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $patient->phone) }}" placeholder="Contact No" required>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="email" class="col-4 col-form-label">E-mail:</label>
                                    <div class="col-8">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $patient->email) }}" placeholder="E-mail">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                                        <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob" name="dob" value="{{ old('dob', $patient->dob) }}">
                                        @error('dob')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="age" class="col-4 col-form-label">Age:</label>
                                    <div class="col-8">
                                        <div class="row g-1">
                                            <div class="col-4">
                                                <input type="number" class="form-control text-center" id="age_year" name="age_year" placeholder="Y" min="0" max="150" value="{{ isset($ageData['age_year']) ? $ageData['age_year'] : '' }}">
                                            </div>
                                            <div class="col-4">
                                                <input type="number" class="form-control text-center" id="age_month" name="age_month" placeholder="M" min="0" max="12" value="{{ isset($ageData['age_month']) ? $ageData['age_month'] : '' }}">
                                            </div>
                                            <div class="col-4">
                                                <input type="number" class="form-control text-center" id="age_day" name="age_day" placeholder="D" min="0" max="31" value="{{ isset($ageData['age_day']) ? $ageData['age_day'] : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Row 9 -->
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="gender" class="col-4 col-form-label">Gender:</label>
                                    <div class="col-8">
                                        <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                            <option value="">-- Select Gender --</option>
                                            <option value="Female" {{ old('gender', $patient->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                            <option value="Male" {{ old('gender', $patient->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Other" {{ old('gender', $patient->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="blood_group" class="col-4 col-form-label">Blood:</label>
                                    <div class="col-8">
                                        <select class="form-select @error('blood_group') is-invalid @enderror" id="blood_group" name="blood_group">
                                            <option value="">-- Select Blood Group --</option>
                                            <option value="A+" {{ old('blood_group', $patient->blood_group) == 'A+' ? 'selected' : '' }}>A+ (ve)</option>
                                            <option value="A-" {{ old('blood_group', $patient->blood_group) == 'A-' ? 'selected' : '' }}>A- (ve)</option>
                                            <option value="B+" {{ old('blood_group', $patient->blood_group) == 'B+' ? 'selected' : '' }}>B+ (ve)</option>
                                            <option value="B-" {{ old('blood_group', $patient->blood_group) == 'B-' ? 'selected' : '' }}>B- (ve)</option>
                                            <option value="AB+" {{ old('blood_group', $patient->blood_group) == 'AB+' ? 'selected' : '' }}>AB+ (ve)</option>
                                            <option value="AB-" {{ old('blood_group', $patient->blood_group) == 'AB-' ? 'selected' : '' }}>AB- (ve)</option>
                                            <option value="O+" {{ old('blood_group', $patient->blood_group) == 'O+' ? 'selected' : '' }}>O+ (ve)</option>
                                            <option value="O-" {{ old('blood_group', $patient->blood_group) == 'O-' ? 'selected' : '' }}>O- (ve)</option>
                                        </select>
                                        @error('blood_group')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Row 10 -->
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="religion" class="col-4 col-form-label">Religion:</label>
                                    <div class="col-8">
                                        <select class="form-select @error('religion') is-invalid @enderror" id="religion" name="religion">
                                            <option value="">-- Select Religion --</option>
                                            <option value="Islam" {{ old('religion', $patient->religion) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                            <option value="Hinduism" {{ old('religion', $patient->religion) == 'Hinduism' ? 'selected' : '' }}>Hinduism</option>
                                            <option value="Christianity" {{ old('religion', $patient->religion) == 'Christianity' ? 'selected' : '' }}>Christianity</option>
                                            <option value="Buddhism" {{ old('religion', $patient->religion) == 'Buddhism' ? 'selected' : '' }}>Buddhism</option>
                                            <option value="Other" {{ old('religion', $patient->religion) == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('religion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="occupation" class="col-4 col-form-label">Occup:</label>
                                    <div class="col-8">
                                        <select class="form-select @error('occupation') is-invalid @enderror" id="occupation" name="occupation">
                                            <option value="">-- Select Occupation --</option>
                                            <option value="N/A" {{ old('occupation', $patient->occupation) == 'N/A' ? 'selected' : '' }}>N/A</option>
                                            <option value="Student" {{ old('occupation', $patient->occupation) == 'Student' ? 'selected' : '' }}>Student</option>
                                            <option value="Business" {{ old('occupation', $patient->occupation) == 'Business' ? 'selected' : '' }}>Business</option>
                                            <option value="Service" {{ old('occupation', $patient->occupation) == 'Service' ? 'selected' : '' }}>Service</option>
                                            <option value="Housewife" {{ old('occupation', $patient->occupation) == 'Housewife' ? 'selected' : '' }}>Housewife</option>
                                            <option value="Other" {{ old('occupation', $patient->occupation) == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('occupation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Row 11 -->
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="reg_fee" class="col-4 col-form-label text-danger">Reg. Fees:</label>
                                    <div class="col-8">
                                        <input type="number" class="form-control @error('reg_fee') is-invalid @enderror" id="reg_fee" name="reg_fee" value="{{ old('reg_fee', $patient->reg_fee) }}">
                                        @error('reg_fee')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="nationality" class="col-4 col-form-label">Nation:</label>
                                    <div class="col-8">
                                        <input type="text" class="form-control @error('nationality') is-invalid @enderror" id="nationality" name="nationality" value="{{ old('nationality', $patient->nationality) }}">
                                        @error('nationality')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Row 12 -->
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="patient_type" class="col-4 col-form-label">Pat. Type:</label>
                                    <div class="col-8">
                                        <select class="form-select @error('patient_type') is-invalid @enderror" id="patient_type" name="patient_type">
                                            <option value="">-- Select Patient Type --</option>
                                            <option value="General" {{ old('patient_type', $patient->patient_type) == 'General' ? 'selected' : '' }}>General</option>
                                            <option value="Emergency" {{ old('patient_type', $patient->patient_type) == 'Emergency' ? 'selected' : '' }}>Emergency</option>
                                            <option value="VIP" {{ old('patient_type', $patient->patient_type) == 'VIP' ? 'selected' : '' }}>VIP</option>
                                            <option value="Corporate" {{ old('patient_type', $patient->patient_type) == 'Corporate' ? 'selected' : '' }}>Corporate</option>
                                        </select>
                                        @error('patient_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Patient Info -->
                    <div class="col-lg-5">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-primary py-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 text-white">
                                        <i class="fas fa-info-circle me-1"></i> Patient Information
                                    </h6>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="patient-avatar bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; border-radius: 50%; font-size: 24px; font-weight: bold;">
                                        {{ strtoupper(substr($patient->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $patient->name }}</h6>
                                        <p class="text-muted mb-0">{{ $patient->patient_id }}</p>
                                    </div>
                                </div>
                                
                                <hr>
                                
                                <div class="mb-3">
                                    <h6 class="fw-bold">Registration Date</h6>
                                    <p>{{ date('d M Y', strtotime($patient->reg_date)) }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <h6 class="fw-bold">Contact Information</h6>
                                    <p class="mb-1">
                                        <i class="fas fa-phone-alt me-2 text-muted"></i> {{ $patient->phone ?? 'N/A' }}
                                    </p>
                                    <p class="mb-1">
                                        <i class="fas fa-envelope me-2 text-muted"></i> {{ $patient->email ?? 'N/A' }}
                                    </p>
                                    <p class="mb-0">
                                        <i class="fas fa-map-marker-alt me-2 text-muted"></i> {{ $patient->address ?? 'N/A' }}
                                    </p>
                                </div>
                                
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i> You are currently editing this patient's information.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-success px-4 me-2">
                            <i class="fas fa-save me-1"></i> Update Patient
                        </button>
                        <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary px-4">
                            <i class="fas fa-times me-1"></i> Cancel
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
        // Calculate age based on DOB
        function calculateAgeFromDOB(dobString) {
            if (!dobString) return;
            
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
            
            if (m < 0) {
                m += 12;
                age--;
            }
            
            $('#age_year').val(age);
            $('#age_month').val(m);
            $('#age_day').val(d);
        }
        
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
        
        // Calculate age on page load if DOB is present
        if($('#dob').val()) {
            calculateAgeFromDOB($('#dob').val());
        }
        
        // Calculate age when DOB changes
        $('#dob').on('change', function() {
            if($(this).val()) {
                calculateAgeFromDOB($(this).val());
            } else {
                // Clear age fields if DOB is cleared
                $('#age_year').val('');
                $('#age_month').val('');
                $('#age_day').val('');
            }
        });
        
        // Age to DOB calculation
        $('#age_year, #age_month, #age_day').on('change', function() {
            if($('#original_dob').prop('checked')) {
                return; // Don't override original DOB
            }
            
            calculateDOBFromAge();
        });
        
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