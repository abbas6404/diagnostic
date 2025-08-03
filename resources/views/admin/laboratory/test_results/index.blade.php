@extends('admin.layouts.app')

@section('title', 'Laboratory Test Results')

@section('styles')
<link href="{{ asset('css/admin-layout.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary">
                    <i class="fas fa-vial me-2"></i> Laboratory Test Results
            </h5>
                <div>
                    <button class="btn btn-sm btn-outline-secondary me-2">
                        <i class="fas fa-print me-1"></i> Print Report
                    </button>
                    <button class="btn btn-sm btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> New Test Result
                    </button>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <!-- Search and Filter Section -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search by Patient ID, Name or Test ID...">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex gap-2 justify-content-end">
                        <select class="form-select" style="max-width: 150px;">
                            <option value="">All Tests</option>
                            <option value="Hematology">Hematology</option>
                            <option value="Biochemistry">Biochemistry</option>
                            <option value="Microbiology">Microbiology</option>
                            <option value="Pathology">Pathology</option>
                            <option value="Radiology">Radiology</option>
                        </select>
                        <select class="form-select" style="max-width: 150px;">
                            <option value="">All Status</option>
                            <option value="Pending">Pending</option>
                            <option value="Processing">Processing</option>
                            <option value="Completed">Completed</option>
                            <option value="Verified">Verified</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Main Content Area -->
            <div class="row">
                <!-- Left Column - Test List -->
                <div class="col-md-4">
                    <div class="card border mb-4">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0">Pending Test Results</h6>
                        </div>
                        <div class="card-body p-0" style="height: 600px; overflow-y: auto;">
                            <div class="list-group list-group-flush">
                                <a href="#" class="list-group-item list-group-item-action active">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">CBC - Complete Blood Count</h6>
                                        <small>Today</small>
                                    </div>
                                    <div class="d-flex w-100 justify-content-between">
                                        <p class="mb-1">Patient: Ahmed Hossain (P-10045)</p>
                                        <span class="badge bg-warning">Processing</span>
                                    </div>
                                    <small>Test ID: LAB-CBC-23060045</small>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Liver Function Test (LFT)</h6>
                                        <small>Today</small>
                                    </div>
                                    <div class="d-flex w-100 justify-content-between">
                                        <p class="mb-1">Patient: Fatima Begum (P-10044)</p>
                                        <span class="badge bg-info">Pending</span>
                                    </div>
                                    <small>Test ID: LAB-LFT-23060044</small>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Thyroid Function Test</h6>
                                        <small>Yesterday</small>
                                    </div>
                                    <div class="d-flex w-100 justify-content-between">
                                        <p class="mb-1">Patient: Mohammad Rahman (P-10043)</p>
                                        <span class="badge bg-success">Completed</span>
                                    </div>
                                    <small>Test ID: LAB-TFT-23060043</small>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Lipid Profile</h6>
                                        <small>Yesterday</small>
                                    </div>
                                    <div class="d-flex w-100 justify-content-between">
                                        <p class="mb-1">Patient: Nusrat Jahan (P-10042)</p>
                                        <span class="badge bg-success">Completed</span>
                                    </div>
                                    <small>Test ID: LAB-LIP-23060042</small>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Blood Culture</h6>
                                        <small>2 days ago</small>
                                    </div>
                                    <div class="d-flex w-100 justify-content-between">
                                        <p class="mb-1">Patient: Kamal Hossain (P-10041)</p>
                                        <span class="badge bg-primary">Verified</span>
                                    </div>
                                    <small>Test ID: LAB-BC-23060041</small>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Urine R/E</h6>
                                        <small>2 days ago</small>
                                    </div>
                                    <div class="d-flex w-100 justify-content-between">
                                        <p class="mb-1">Patient: Sabina Yasmin (P-10040)</p>
                                        <span class="badge bg-primary">Verified</span>
                                    </div>
                                    <small>Test ID: LAB-URE-23060040</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column - Test Result Entry Form -->
                <div class="col-md-8">
                    <div class="card border">
                        <div class="card-header bg-light py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Test Result Entry</h6>
                                <div>
                                    <span class="badge bg-warning">Processing</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Patient Information -->
                            <div class="patient-info-box p-3 mb-4 rounded">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Patient ID:</strong> P-10045</p>
                                        <p class="mb-1"><strong>Patient Name:</strong> Ahmed Hossain</p>
                                        <p class="mb-1"><strong>Age/Sex:</strong> 42 Years / Male</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Test ID:</strong> LAB-CBC-23060045</p>
                                        <p class="mb-1"><strong>Sample Collected:</strong> 26/06/2023 09:15 AM</p>
                                        <p class="mb-1"><strong>Referring Doctor:</strong> Dr. Kamrul Alam</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Test Results Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 40%">Test Parameter</th>
                                            <th style="width: 20%">Result</th>
                                            <th style="width: 20%">Normal Range</th>
                                            <th style="width: 20%">Unit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Complete Blood Count Group -->
                                        <tr class="test-group-header">
                                            <td colspan="4">Complete Blood Count (CBC)</td>
                                        </tr>
                                        
                                        <!-- Hemoglobin Subgroup -->
                                        <tr>
                                            <td>Hemoglobin (Hb)</td>
                                            <td>
                                                <input type="text" class="result-value-input" value="13.5">
                                            </td>
                                            <td><span class="normal-range">Male: 13.0-17.0<br>Female: 12.0-15.0</span></td>
                                            <td>g/dL</td>
                                        </tr>
                                        
                                        <!-- RBC Parameters -->
                                        <tr class="test-subgroup-header">
                                            <td colspan="4">RBC Parameters</td>
                                        </tr>
                                        <tr>
                                            <td>RBC Count</td>
                                            <td>
                                                <input type="text" class="result-value-input" value="5.2">
                                            </td>
                                            <td><span class="normal-range">4.5-5.5</span></td>
                                            <td>x10^6/μL</td>
                                        </tr>
                                        <tr>
                                            <td>Hematocrit (HCT)</td>
                                            <td>
                                                <input type="text" class="result-value-input" value="42">
                                            </td>
                                            <td><span class="normal-range">Male: 40-50<br>Female: 36-46</span></td>
                                            <td>%</td>
                                        </tr>
                                        <tr>
                                            <td>MCV</td>
                                            <td>
                                                <input type="text" class="result-value-input" value="88">
                                            </td>
                                            <td><span class="normal-range">80-100</span></td>
                                            <td>fL</td>
                                        </tr>
                                        <tr>
                                            <td>MCH</td>
                                            <td>
                                                <input type="text" class="result-value-input" value="28">
                                            </td>
                                            <td><span class="normal-range">27-34</span></td>
                                            <td>pg</td>
                                        </tr>
                                        <tr>
                                            <td>MCHC</td>
                                            <td>
                                                <input type="text" class="result-value-input" value="33">
                                            </td>
                                            <td><span class="normal-range">32-36</span></td>
                                            <td>g/dL</td>
                                        </tr>
                                        <tr>
                                            <td>RDW</td>
                                            <td>
                                                <input type="text" class="result-value-input abnormal-result" value="16.5">
                                            </td>
                                            <td><span class="normal-range">11.5-14.5</span></td>
                                            <td>%</td>
                                        </tr>
                                        
                                        <!-- WBC Parameters -->
                                        <tr class="test-subgroup-header">
                                            <td colspan="4">WBC Parameters</td>
                                        </tr>
                                        <tr>
                                            <td>WBC Count</td>
                                            <td>
                                                <input type="text" class="result-value-input" value="7.5">
                                            </td>
                                            <td><span class="normal-range">4.0-11.0</span></td>
                                            <td>x10^3/μL</td>
                                        </tr>
                                        <tr>
                                            <td>Neutrophils</td>
                                            <td>
                                                <input type="text" class="result-value-input" value="65">
                                            </td>
                                            <td><span class="normal-range">40-75</span></td>
                                            <td>%</td>
                                        </tr>
                                        <tr>
                                            <td>Lymphocytes</td>
                                            <td>
                                                <input type="text" class="result-value-input" value="28">
                                            </td>
                                            <td><span class="normal-range">20-45</span></td>
                                            <td>%</td>
                                        </tr>
                                        <tr>
                                            <td>Monocytes</td>
                                            <td>
                                                <input type="text" class="result-value-input" value="5">
                                            </td>
                                            <td><span class="normal-range">2-10</span></td>
                                            <td>%</td>
                                        </tr>
                                        <tr>
                                            <td>Eosinophils</td>
                                            <td>
                                                <input type="text" class="result-value-input" value="2">
                                            </td>
                                            <td><span class="normal-range">1-6</span></td>
                                            <td>%</td>
                                        </tr>
                                        <tr>
                                            <td>Basophils</td>
                                            <td>
                                                <input type="text" class="result-value-input" value="0">
                                            </td>
                                            <td><span class="normal-range">0-1</span></td>
                                            <td>%</td>
                                        </tr>
                                        
                                        <!-- Platelet Parameters -->
                                        <tr class="test-subgroup-header">
                                            <td colspan="4">Platelet Parameters</td>
                                        </tr>
                                        <tr>
                                            <td>Platelet Count</td>
                                            <td>
                                                <input type="text" class="result-value-input" value="250">
                                            </td>
                                            <td><span class="normal-range">150-450</span></td>
                                            <td>x10^3/μL</td>
                                        </tr>
                                        <tr>
                                            <td>MPV</td>
                                            <td>
                                                <input type="text" class="result-value-input" value="10.2">
                                            </td>
                                            <td><span class="normal-range">7.5-11.5</span></td>
                                            <td>fL</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Comments Section -->
                            <div class="form-group mt-3">
                                <label for="comments" class="form-label"><strong>Comments/Interpretation:</strong></label>
                                <textarea class="form-control" id="comments" rows="3" placeholder="Add any comments or interpretation of results here...">RDW is slightly elevated, which may indicate anisocytosis. Otherwise, all parameters are within normal range.</textarea>
                            </div>
                            
                            <!-- Pathologist Section -->
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pathologist" class="form-label"><strong>Pathologist:</strong></label>
                                        <select class="form-select" id="pathologist">
                                            <option value="">Select Pathologist</option>
                                            <option value="1" selected>Dr. Nasreen Ahmed</option>
                                            <option value="2">Dr. Kamal Hossain</option>
                                            <option value="3">Dr. Fatima Begum</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="technician" class="form-label"><strong>Lab Technician:</strong></label>
                                        <select class="form-select" id="technician">
                                            <option value="">Select Technician</option>
                                            <option value="1">Md. Rahim</option>
                                            <option value="2" selected>Nusrat Jahan</option>
                                            <option value="3">Abdul Karim</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="card-footer report-actions">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <button class="btn btn-outline-secondary me-2">
                                        <i class="fas fa-times me-1"></i> Cancel
                                    </button>
                                    <button class="btn btn-info me-2">
                                        <i class="fas fa-save me-1"></i> Save Draft
                                    </button>
                                </div>
                                <div>
                                    <button class="btn btn-success me-2">
                                        <i class="fas fa-check-circle me-1"></i> Complete
                                    </button>
                                    <button class="btn btn-primary">
                                        <i class="fas fa-print me-1"></i> Save & Print
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-footer bg-white py-2">
            <div class="d-flex justify-content-between align-items-center small text-muted">
                <span>SQL Based - HospMDB</span>
                <span>User: A AHMED</span>
                <span>{{ date('d/m/Y h:i A') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Highlight abnormal results
        $('.result-value-input').on('input', function() {
            var value = parseFloat($(this).val());
            var row = $(this).closest('tr');
            var normalRange = row.find('.normal-range').text();
            
            // Extract numeric ranges from the normal range text
            var matches = normalRange.match(/(\d+\.?\d*)-(\d+\.?\d*)/);
            
            if (matches && matches.length >= 3) {
                var min = parseFloat(matches[1]);
                var max = parseFloat(matches[2]);
                
                if (value < min || value > max) {
                    $(this).addClass('abnormal-result');
                } else {
                    $(this).removeClass('abnormal-result');
                }
            }
        });
        
        // Test list item click handler
        $('.list-group-item').click(function(e) {
            e.preventDefault();
            $('.list-group-item').removeClass('active');
            $(this).addClass('active');
            
            // Here you would typically load the selected test data
            // For demonstration purposes, we'll just show an alert
            // var testId = $(this).find('small').text().split(': ')[1];
            // alert('Loading test: ' + testId);
        });
    });
</script>
@endsection 