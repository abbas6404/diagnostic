@extends('admin.layouts.app')

@section('title', 'Patient Registration')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary">
                    <i class="fas fa-user-plus me-2"></i> Patient's Registration
            </h5>
                <button class="btn btn-outline-primary">
                    <i class="fas fa-th-list me-1"></i> Patient List
                </button>
            </div>
        </div>
        <div class="card-body">
            <form action="#" method="POST">
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
                                    <label for="reg_no" class="col-4 col-form-label">Reg. No(#):</label>
                                    <div class="col-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="reg_no" name="reg_no" value="(AUTO)" readonly>
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
                                    <label for="name_english" class="col-2 col-form-label">Name(Eng):</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" id="name_english" name="name_english" required>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Row 3 -->
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <label for="name_bangla" class="col-2 col-form-label">Name(Ban):</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" id="name_bangla" name="name_bangla">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Row 4 -->
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <label for="fathers_husband" class="col-2 col-form-label">F/H Name:</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" id="fathers_husband" name="fathers_husband">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Row 5 -->
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <label for="present_address" class="col-2 col-form-label">Address:</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" id="present_address" name="present_address">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Row 6 -->
                            <div class="col-md-4">
                                <div class="row align-items-center">
                                    <label for="ps" class="col-4 col-form-label">P.S:</label>
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="ps" name="ps">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row align-items-center">
                                    <label for="dist" class="col-4 col-form-label">Dist:</label>
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="dist" name="dist">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row align-items-center">
                                    <label for="division" class="col-4 col-form-label">Division:</label>
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="division" name="division">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Row 7 -->
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="contact_no" class="col-4 col-form-label">Contact:</label>
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="contact_no" name="contact_no">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="email" class="col-4 col-form-label">E-mail:</label>
                                    <div class="col-8">
                                        <input type="email" class="form-control" id="email" name="email">
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
                                        <input type="text" class="form-control" id="dob" name="dob" placeholder="mm/dd/yyyy">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="age" class="col-4 col-form-label">Age:</label>
                                    <div class="col-8">
                                        <div class="row g-1">
                                            <div class="col-4">
                                                <input type="text" class="form-control text-center" id="age_year" name="age_year" placeholder="Y">
                                            </div>
                                            <div class="col-4">
                                                <input type="text" class="form-control text-center" id="age_month" name="age_month" placeholder="M">
                                            </div>
                                            <div class="col-4">
                                                <input type="text" class="form-control text-center" id="age_day" name="age_day" placeholder="D">
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
                                        <select class="form-select" id="gender" name="gender">
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
                            
                            <!-- Row 10 -->
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="religion" class="col-4 col-form-label">Religion:</label>
                                    <div class="col-8">
                                        <select class="form-select" id="religion" name="religion">
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
                                <div class="row align-items-center">
                                    <label for="occupation" class="col-4 col-form-label">Occup:</label>
                                    <div class="col-8">
                                        <select class="form-select" id="occupation" name="occupation">
                                            <option value="N/A">N/A</option>
                                            <option value="Student">Student</option>
                                            <option value="Business">Business</option>
                                            <option value="Service">Service</option>
                                            <option value="Housewife">Housewife</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Row 11 -->
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="registration_fees" class="col-4 col-form-label text-danger">Reg. Fees:</label>
                                    <div class="col-8">
                                        <input type="number" class="form-control" id="registration_fees" name="registration_fees" value="0">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="nationality" class="col-4 col-form-label">Nation:</label>
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="nationality" name="nationality" value="Bangladeshi">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Row 12 -->
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="patient_type" class="col-4 col-form-label">Pat. Type:</label>
                                    <div class="col-8">
                                        <select class="form-select" id="patient_type" name="patient_type">
                                            <option value="General">General</option>
                                            <option value="Emergency">Emergency</option>
                                            <option value="VIP">VIP</option>
                                            <option value="Corporate">Corporate</option>
                                        </select>
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
                                    <!-- Patient 1 -->
                                    <a href="#" class="list-group-item list-group-item-action py-2 px-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="badge bg-primary rounded-pill">P-10045</span>
                                                <div class="fw-medium">Fatima Begum</div>
                                            </div>
                                            
                                            <div class="text-end">
                                                <div class="text-muted small">01712345678</div>
                                                <div class="text-muted small">123 Gulshan Avenue, Dhaka</div>
                                                
                                            </div>
                                           
                                        </div>
                                    </a>
                                    
                                    <!-- Patient 2 -->
                                    <a href="#" class="list-group-item list-group-item-action py-2 px-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="badge bg-primary rounded-pill">P-10044</span>
                                                <div class="fw-medium">Mohammad Rahman</div>
                                                
                                            </div>
                                            <div class="text-end">
                                                <div class="text-muted small">45 Banani DOHS, Dhaka</div>
                                                <div class="text-muted small">01898765432</div>
                                            </div>
                                        </div>
                                    </a>
                                    
                                    <!-- Patient 3 -->
                                    <a href="#" class="list-group-item list-group-item-action py-2 px-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="badge bg-primary rounded-pill">P-10043</span>
                                                <div class="fw-medium">Nusrat Jahan</div>
                                                
                                            </div>
                                            <div class="text-end">
                                                <div class="text-muted small">78 Dhanmondi, Road 5, Dhaka</div>
                                                <div class="text-muted small">01612345678</div>
                                            </div>
                                        </div>
                                    </a>
                                    
                                    <!-- Patient 4 -->
                                    <a href="#" class="list-group-item list-group-item-action py-2 px-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="badge bg-primary rounded-pill">P-10042</span>
                                                <div class="fw-medium">Kamal Hossain</div>
                                                
                                            </div>
                                            <div class="text-end">
                                                <div class="text-muted small">156 Uttara, Sector 7, Dhaka</div>
                                                <div class="text-muted small">01912345678</div>
                                            </div>
                                        </div>
                                    </a>
                                    
                                    <!-- Patient 5 -->
                                    <a href="#" class="list-group-item list-group-item-action py-2 px-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="badge bg-primary rounded-pill">P-10041</span>
                                                <div class="fw-medium">Sabina Yasmin</div>
                                            </div>
                                            <div class="text-end">
                                                <div class="text-muted small">92 Mirpur DOHS, Dhaka</div>
                                                <div class="text-muted small">01812345678</div>
                                            </div>
                                        </div>
                                    </a>
                                    
                                    <!-- Patient 6 -->
                                    <a href="#" class="list-group-item list-group-item-action py-2 px-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="badge bg-primary rounded-pill">P-10040</span>
                                                <div class="fw-medium">Rahim Mia</div>
                                            </div>
                                            <div class="text-end">
                                                <div class="text-muted small">34 Mohakhali, Dhaka</div>
                                                <div class="text-muted small">01512345678</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-success px-4 me-2">
                            <i class="fas fa-save me-1"></i> Save
                        </button>
                        <button type="button" class="btn btn-warning px-4 me-2">
                            <i class="fas fa-edit me-1"></i> Update
                        </button>
                        <a href="#" class="btn btn-secondary px-4">
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
        // This is just for design demonstration
        // No actual functionality implemented
        
        // For visual feedback only
        $('.btn').click(function(e) {
            e.preventDefault();
            // Just visual feedback
        });
    });
</script>
@endsection 