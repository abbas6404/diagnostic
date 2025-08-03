@extends('admin.layouts.app')

@section('title', 'Lab Equipment')

@section('styles')
<link href="{{ asset('css/admin-layout.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary">
                    <i class="fas fa-microscope me-2"></i> Lab Equipment Management
            </h5>
                <div>
                    <button class="btn btn-sm btn-outline-secondary me-2">
                        <i class="fas fa-file-excel me-1"></i> Export
                    </button>
                    <button class="btn btn-sm btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> Add Equipment
                    </button>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <!-- Search and Filter Section -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search equipment by name, ID, or category...">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex gap-2 justify-content-end">
                        <select class="form-select" style="max-width: 150px;">
                            <option value="">All Categories</option>
                            <option value="Analyzer">Analyzers</option>
                            <option value="Microscope">Microscopes</option>
                            <option value="Centrifuge">Centrifuges</option>
                            <option value="Incubator">Incubators</option>
                            <option value="Other">Other</option>
                        </select>
                        <select class="form-select" style="max-width: 150px;">
                            <option value="">All Status</option>
                            <option value="Operational">Operational</option>
                            <option value="Maintenance">Maintenance</option>
                            <option value="Calibration">Calibration</option>
                            <option value="Out of Order">Out of Order</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Alerts Section -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="maintenance-alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-tools fa-2x me-3"></i>
                            <div>
                                <h6 class="mb-1">Maintenance Required</h6>
                                <p class="mb-0">3 equipment items require scheduled maintenance</p>
                            </div>
                            <a href="#" class="btn btn-sm btn-warning ms-auto">View All</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="calibration-alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-balance-scale fa-2x me-3"></i>
                            <div>
                                <h6 class="mb-1">Calibration Due</h6>
                                <p class="mb-0">2 equipment items require calibration this week</p>
                            </div>
                            <a href="#" class="btn btn-sm btn-info ms-auto text-white">View All</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Equipment Grid View -->
            <div class="row mb-4">
                <div class="col-12 mb-3">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary active">
                            <i class="fas fa-th-large"></i> Grid
                        </button>
                        <button type="button" class="btn btn-outline-primary">
                            <i class="fas fa-list"></i> List
                        </button>
                    </div>
                </div>
                
                <!-- Equipment Cards -->
                <div class="col-md-3 mb-4">
                    <div class="card equipment-card shadow-sm">
                        <img src="https://via.placeholder.com/300x200?text=Hematology+Analyzer" class="equipment-img" alt="Hematology Analyzer">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="card-title mb-0">Hematology Analyzer</h6>
                                <span class="badge bg-success">Operational</span>
                            </div>
                            <p class="card-text small text-muted mb-2">Model: Sysmex XN-1000</p>
                            <p class="card-text small text-muted mb-3">ID: EQ-HEM-001</p>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-sm btn-outline-primary">Details</button>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-history"></i> Log
                                </button>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between small text-muted">
                                <span>Last Maintenance: 15/05/2023</span>
                                <span>Next: 15/08/2023</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="card equipment-card shadow-sm">
                        <img src="https://via.placeholder.com/300x200?text=Chemistry+Analyzer" class="equipment-img" alt="Chemistry Analyzer">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="card-title mb-0">Chemistry Analyzer</h6>
                                <span class="badge bg-warning">Maintenance</span>
                            </div>
                            <p class="card-text small text-muted mb-2">Model: Cobas c311</p>
                            <p class="card-text small text-muted mb-3">ID: EQ-CHEM-002</p>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-sm btn-outline-primary">Details</button>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-history"></i> Log
                                </button>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between small text-muted">
                                <span>Last Maintenance: 10/06/2023</span>
                                <span class="text-danger">Due Today</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="card equipment-card shadow-sm">
                        <img src="https://via.placeholder.com/300x200?text=Microscope" class="equipment-img" alt="Microscope">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="card-title mb-0">Binocular Microscope</h6>
                                <span class="badge bg-info">Calibration</span>
                            </div>
                            <p class="card-text small text-muted mb-2">Model: Olympus CX43</p>
                            <p class="card-text small text-muted mb-3">ID: EQ-MIC-003</p>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-sm btn-outline-primary">Details</button>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-history"></i> Log
                                </button>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between small text-muted">
                                <span>Last Calibration: 01/06/2023</span>
                                <span class="text-warning">Due in 2 days</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="card equipment-card shadow-sm">
                        <img src="https://via.placeholder.com/300x200?text=Centrifuge" class="equipment-img" alt="Centrifuge">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="card-title mb-0">Laboratory Centrifuge</h6>
                                <span class="badge bg-danger">Out of Order</span>
                            </div>
                            <p class="card-text small text-muted mb-2">Model: Thermo Scientific</p>
                            <p class="card-text small text-muted mb-3">ID: EQ-CEN-004</p>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-sm btn-outline-primary">Details</button>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-history"></i> Log
                                </button>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between small text-muted">
                                <span>Issue: Motor failure</span>
                                <span>Reported: 20/06/2023</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="card equipment-card shadow-sm">
                        <img src="https://via.placeholder.com/300x200?text=Incubator" class="equipment-img" alt="Incubator">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="card-title mb-0">Laboratory Incubator</h6>
                                <span class="badge bg-success">Operational</span>
                            </div>
                            <p class="card-text small text-muted mb-2">Model: Memmert INB200</p>
                            <p class="card-text small text-muted mb-3">ID: EQ-INC-005</p>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-sm btn-outline-primary">Details</button>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-history"></i> Log
                                </button>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between small text-muted">
                                <span>Last Maintenance: 05/06/2023</span>
                                <span>Next: 05/09/2023</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="card equipment-card shadow-sm">
                        <img src="https://via.placeholder.com/300x200?text=Electrolyte+Analyzer" class="equipment-img" alt="Electrolyte Analyzer">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="card-title mb-0">Electrolyte Analyzer</h6>
                                <span class="badge bg-success">Operational</span>
                            </div>
                            <p class="card-text small text-muted mb-2">Model: Roche 9180</p>
                            <p class="card-text small text-muted mb-3">ID: EQ-ELE-006</p>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-sm btn-outline-primary">Details</button>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-history"></i> Log
                                </button>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between small text-muted">
                                <span>Last Maintenance: 12/06/2023</span>
                                <span>Next: 12/09/2023</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="card equipment-card shadow-sm">
                        <img src="https://via.placeholder.com/300x200?text=Coagulation+Analyzer" class="equipment-img" alt="Coagulation Analyzer">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="card-title mb-0">Coagulation Analyzer</h6>
                                <span class="badge bg-warning">Maintenance</span>
                            </div>
                            <p class="card-text small text-muted mb-2">Model: Sysmex CA-600</p>
                            <p class="card-text small text-muted mb-3">ID: EQ-COA-007</p>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-sm btn-outline-primary">Details</button>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-history"></i> Log
                                </button>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between small text-muted">
                                <span>Last Maintenance: 02/05/2023</span>
                                <span class="text-danger">Overdue</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="card equipment-card shadow-sm">
                        <img src="https://via.placeholder.com/300x200?text=PCR+Machine" class="equipment-img" alt="PCR Machine">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="card-title mb-0">PCR Machine</h6>
                                <span class="badge bg-success">Operational</span>
                            </div>
                            <p class="card-text small text-muted mb-2">Model: Bio-Rad CFX96</p>
                            <p class="card-text small text-muted mb-3">ID: EQ-PCR-008</p>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-sm btn-outline-primary">Details</button>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-history"></i> Log
                                </button>
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between small text-muted">
                                <span>Last Maintenance: 10/06/2023</span>
                                <span>Next: 10/09/2023</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pagination -->
            <div class="row">
                <div class="col-12">
                    <nav aria-label="Equipment pagination">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
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
    
    <!-- Equipment Details Modal -->
    <div class="modal fade" id="equipmentDetailsModal" tabindex="-1" aria-labelledby="equipmentDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="equipmentDetailsModalLabel">Equipment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="https://via.placeholder.com/300x300?text=Hematology+Analyzer" class="img-fluid rounded mb-3" alt="Equipment Image">
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-edit me-1"></i> Edit Details
                                </button>
                                <button class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-tools me-1"></i> Schedule Maintenance
                                </button>
                                <button class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-balance-scale me-1"></i> Schedule Calibration
                                </button>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 35%">Equipment Name</th>
                                        <td>Hematology Analyzer</td>
                                    </tr>
                                    <tr>
                                        <th>Equipment ID</th>
                                        <td>EQ-HEM-001</td>
                                    </tr>
                                    <tr>
                                        <th>Model</th>
                                        <td>Sysmex XN-1000</td>
                                    </tr>
                                    <tr>
                                        <th>Serial Number</th>
                                        <td>SYS-XN1-12345678</td>
                                    </tr>
                                    <tr>
                                        <th>Manufacturer</th>
                                        <td>Sysmex Corporation</td>
                                    </tr>
                                    <tr>
                                        <th>Purchase Date</th>
                                        <td>15/01/2020</td>
                                    </tr>
                                    <tr>
                                        <th>Warranty Until</th>
                                        <td>15/01/2025</td>
                                    </tr>
                                    <tr>
                                        <th>Location</th>
                                        <td>Main Laboratory, Room 102</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td><span class="badge bg-success">Operational</span></td>
                                    </tr>
                                    <tr>
                                        <th>Last Maintenance</th>
                                        <td>15/05/2023</td>
                                    </tr>
                                    <tr>
                                        <th>Next Maintenance</th>
                                        <td>15/08/2023</td>
                                    </tr>
                                    <tr>
                                        <th>Last Calibration</th>
                                        <td>01/06/2023</td>
                                    </tr>
                                    <tr>
                                        <th>Next Calibration</th>
                                        <td>01/09/2023</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6>Maintenance History</h6>
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Performed By</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>15/05/2023</td>
                                        <td>Preventive Maintenance</td>
                                        <td>Sysmex Technician</td>
                                        <td>Routine quarterly maintenance</td>
                                    </tr>
                                    <tr>
                                        <td>15/02/2023</td>
                                        <td>Preventive Maintenance</td>
                                        <td>Sysmex Technician</td>
                                        <td>Routine quarterly maintenance</td>
                                    </tr>
                                    <tr>
                                        <td>10/01/2023</td>
                                        <td>Repair</td>
                                        <td>Sysmex Technician</td>
                                        <td>Replaced sample probe</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Equipment card click handler
        $('.btn-outline-primary').click(function(e) {
            e.preventDefault();
            $('#equipmentDetailsModal').modal('show');
        });
        
        // View toggle handler
        $('.btn-group .btn').click(function() {
            $('.btn-group .btn').removeClass('active');
            $(this).addClass('active');
        });
    });
</script>
@endsection 