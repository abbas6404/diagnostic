@extends('admin.layouts.app')

@section('title', 'Sample Collection')

@section('styles')
<style>
    .sample-status-pending {
        color: #ffc107;
    }
    
    .sample-status-collected {
        color: #28a745;
    }
    
    .sample-status-rejected {
        color: #dc3545;
    }
    
    .sample-type-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
    }
    
    .sample-type-blood {
        background-color: #ffebee;
        color: #b71c1c;
    }
    
    .sample-type-urine {
        background-color: #fff8e1;
        color: #ff8f00;
    }
    
    .sample-type-stool {
        background-color: #efebe9;
        color: #4e342e;
    }
    
    .sample-type-swab {
        background-color: #e8f5e9;
        color: #2e7d32;
    }
    
    .sample-type-fluid {
        background-color: #e3f2fd;
        color: #0d47a1;
    }
    
    .sample-type-tissue {
        background-color: #f3e5f5;
        color: #6a1b9a;
    }
    
    .collection-instructions {
        background-color: #f8f9fa;
        border-left: 4px solid #17a2b8;
        padding: 1rem;
    }
    
    .barcode-container {
        border: 1px dashed #ced4da;
        padding: 0.5rem;
        text-align: center;
        background-color: #f8f9fa;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary">
                    <i class="fas fa-syringe me-2"></i> Sample Collection
            </h5>
                <div>
                    <button class="btn btn-sm btn-outline-secondary me-2">
                        <i class="fas fa-print me-1"></i> Print Labels
                    </button>
                    <button class="btn btn-sm btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> New Collection
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
                            <option value="">All Samples</option>
                            <option value="Blood">Blood</option>
                            <option value="Urine">Urine</option>
                            <option value="Stool">Stool</option>
                            <option value="Swab">Swab</option>
                            <option value="Fluid">Body Fluid</option>
                            <option value="Tissue">Tissue</option>
                        </select>
                        <select class="form-select" style="max-width: 150px;">
                            <option value="">All Status</option>
                            <option value="Pending">Pending</option>
                            <option value="Collected">Collected</option>
                            <option value="Rejected">Rejected</option>
                            <option value="Processing">Processing</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Main Content Area -->
            <div class="row">
                <!-- Left Column - Sample List -->
                <div class="col-md-7">
                    <div class="card border mb-4">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0">Pending Sample Collections</h6>
                        </div>
                        <div class="card-body p-0" style="height: 600px; overflow-y: auto;">
                            <div class="list-group list-group-flush">
                                <a href="#" class="list-group-item list-group-item-action active">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">
                                            <span class="sample-type-badge sample-type-blood">Blood</span>
                                            Complete Blood Count (CBC)
                                        </h6>
                                        <small>Today, 10:30 AM</small>
                                    </div>
                                    <div class="d-flex w-100 justify-content-between">
                                        <p class="mb-1">Patient: Ahmed Hossain (P-10045)</p>
                                        <span class="badge bg-warning">Pending</span>
                                    </div>
                                    <small>Test ID: LAB-CBC-23060045</small>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">
                                            <span class="sample-type-badge sample-type-blood">Blood</span>
                                            Liver Function Test (LFT)
                                        </h6>
                                        <small>Today, 11:15 AM</small>
                                    </div>
                                    <div class="d-flex w-100 justify-content-between">
                                        <p class="mb-1">Patient: Fatima Begum (P-10044)</p>
                                        <span class="badge bg-warning">Pending</span>
                                    </div>
                                    <small>Test ID: LAB-LFT-23060044</small>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">
                                            <span class="sample-type-badge sample-type-urine">Urine</span>
                                            Urine R/E
                                        </h6>
                                        <small>Today, 11:30 AM</small>
                                    </div>
                                    <div class="d-flex w-100 justify-content-between">
                                        <p class="mb-1">Patient: Nusrat Jahan (P-10042)</p>
                                        <span class="badge bg-warning">Pending</span>
                                    </div>
                                    <small>Test ID: LAB-URE-23060042</small>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">
                                            <span class="sample-type-badge sample-type-blood">Blood</span>
                                            Thyroid Function Test
                                        </h6>
                                        <small>Today, 12:00 PM</small>
                                    </div>
                                    <div class="d-flex w-100 justify-content-between">
                                        <p class="mb-1">Patient: Mohammad Rahman (P-10043)</p>
                                        <span class="badge bg-success">Collected</span>
                                    </div>
                                    <small>Test ID: LAB-TFT-23060043</small>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">
                                            <span class="sample-type-badge sample-type-stool">Stool</span>
                                            Stool R/E
                                        </h6>
                                        <small>Today, 12:15 PM</small>
                                    </div>
                                    <div class="d-flex w-100 justify-content-between">
                                        <p class="mb-1">Patient: Kamal Hossain (P-10041)</p>
                                        <span class="badge bg-danger">Rejected</span>
                                    </div>
                                    <small>Test ID: LAB-SRE-23060041</small>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">
                                            <span class="sample-type-badge sample-type-swab">Swab</span>
                                            Throat Culture
                                        </h6>
                                        <small>Today, 01:30 PM</small>
                                    </div>
                                    <div class="d-flex w-100 justify-content-between">
                                        <p class="mb-1">Patient: Sabina Yasmin (P-10040)</p>
                                        <span class="badge bg-warning">Pending</span>
                                    </div>
                                    <small>Test ID: LAB-TC-23060040</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column - Sample Collection Form -->
                <div class="col-md-5">
                    <div class="card border">
                        <div class="card-header bg-light py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Sample Collection Details</h6>
                                <span class="badge bg-warning">Pending</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Patient Information -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Patient ID:</strong> P-10045</p>
                                    <p class="mb-1"><strong>Patient Name:</strong> Ahmed Hossain</p>
                                    <p class="mb-1"><strong>Age/Sex:</strong> 42 Years / Male</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Test ID:</strong> LAB-CBC-23060045</p>
                                    <p class="mb-1"><strong>Requested:</strong> 26/06/2023 09:15 AM</p>
                                    <p class="mb-1"><strong>Referring Doctor:</strong> Dr. Kamrul Alam</p>
                                </div>
                            </div>
                            
                            <!-- Barcode Section -->
                            <div class="barcode-container mb-3">
                                <p class="mb-1">Sample ID: LAB-S-23060045</p>
                                <img src="https://via.placeholder.com/250x60?text=Barcode" alt="Sample Barcode" class="img-fluid">
                                <p class="mb-0 small text-muted">Print this barcode and attach to sample container</p>
                            </div>
                            
                            <!-- Collection Instructions -->
                            <div class="collection-instructions mb-3">
                                <h6 class="mb-2">Collection Instructions:</h6>
                                <ul class="mb-0">
                                    <li>Collect 5ml venous blood in EDTA tube (purple top)</li>
                                    <li>Ensure patient is properly identified</li>
                                    <li>Label tube immediately after collection</li>
                                    <li>Do not shake the tube vigorously</li>
                                    <li>Transport to lab within 2 hours</li>
                                </ul>
                            </div>
                            
                            <!-- Collection Form -->
                            <form>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Sample Type</label>
                                        <select class="form-select">
                                            <option selected>Blood - EDTA</option>
                                            <option>Blood - Plain</option>
                                            <option>Blood - Heparin</option>
                                            <option>Blood - Citrate</option>
                                            <option>Blood - Fluoride</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Collection Date & Time</label>
                                        <input type="datetime-local" class="form-control" value="{{ date('Y-m-d\TH:i') }}">
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Collected By</label>
                                        <select class="form-select">
                                            <option selected>Nusrat Jahan</option>
                                            <option>Abdul Karim</option>
                                            <option>Fatima Begum</option>
                                            <option>Mohammad Ali</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Sample Quantity</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" value="5">
                                            <span class="input-group-text">ml</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Notes/Observations</label>
                                    <textarea class="form-control" rows="3" placeholder="Enter any notes or observations about the sample collection..."></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="sampleQuality">
                                        <label class="form-check-label" for="sampleQuality">
                                            Sample quality is adequate for testing
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <button type="button" class="btn btn-outline-danger me-2">
                                            <i class="fas fa-times-circle me-1"></i> Reject Sample
                                        </button>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-outline-secondary me-2">
                                            <i class="fas fa-print me-1"></i> Print Label
                                        </button>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-check-circle me-1"></i> Confirm Collection
                                        </button>
                                    </div>
                                </div>
                            </form>
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
        // Sample list item click handler
        $('.list-group-item').click(function(e) {
            e.preventDefault();
            $('.list-group-item').removeClass('active');
            $(this).addClass('active');
            
            // Here you would typically load the selected sample data
            // For demonstration purposes, we'll just show an alert
            // var testId = $(this).find('small').text().split(': ')[1];
            // alert('Loading sample: ' + testId);
        });
        
        // Reject sample button handler
        $('.btn-outline-danger').click(function() {
            $('#rejectModal').modal('show');
        });
    });
</script>
@endsection 