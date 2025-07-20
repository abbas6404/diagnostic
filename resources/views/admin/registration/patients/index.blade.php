@extends('admin.layouts.app')

@section('title', 'Patient List')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary">
                    <i class="fas fa-users me-2"></i> Patient List
                </h5>
                <a href="#" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-1"></i> New Patient
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Search and Filter Section -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search patients by name, ID, phone or address...">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex gap-2 justify-content-end">
                        <select class="form-select" style="max-width: 150px;">
                            <option value="">All Types</option>
                            <option value="General">General</option>
                            <option value="Emergency">Emergency</option>
                            <option value="VIP">VIP</option>
                            <option value="Corporate">Corporate</option>
                        </select>
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-download"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="exportDropdown">
                                <li><a class="dropdown-item" href="#"><i class="far fa-file-excel me-2"></i>Export Excel</a></li>
                                <li><a class="dropdown-item" href="#"><i class="far fa-file-pdf me-2"></i>Export PDF</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-print me-2"></i>Print</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Patients Table -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th style="width: 100px;">Patient ID</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th>Gender</th>
                            <th>Age</th>
                            <th>Type</th>
                            <th style="width: 150px;">Registered</th>
                            <th style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Patient 1 -->
                        <tr>
                            <td>1</td>
                            <td>P-10045</td>
                            <td>Fatima Begum</td>
                            <td>01712345678</td>
                            <td>123 Gulshan Avenue, Dhaka</td>
                            <td>Female</td>
                            <td>34y 2m</td>
                            <td><span class="badge bg-primary">General</span></td>
                            <td>26 Jun 2023</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="#" class="btn btn-info" title="View"><i class="fas fa-eye"></i></a>
                                    <a href="#" class="btn btn-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="btn btn-danger" title="Delete"><i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        <!-- Patient 2 -->
                        <tr>
                            <td>2</td>
                            <td>P-10044</td>
                            <td>Mohammad Rahman</td>
                            <td>01898765432</td>
                            <td>45 Banani DOHS, Dhaka</td>
                            <td>Male</td>
                            <td>45y 0m</td>
                            <td><span class="badge bg-warning text-dark">VIP</span></td>
                            <td>25 Jun 2023</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="#" class="btn btn-info" title="View"><i class="fas fa-eye"></i></a>
                                    <a href="#" class="btn btn-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="btn btn-danger" title="Delete"><i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        <!-- Patient 3 -->
                        <tr>
                            <td>3</td>
                            <td>P-10043</td>
                            <td>Nusrat Jahan</td>
                            <td>01612345678</td>
                            <td>78 Dhanmondi, Road 5, Dhaka</td>
                            <td>Female</td>
                            <td>28y 5m</td>
                            <td><span class="badge bg-primary">General</span></td>
                            <td>24 Jun 2023</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="#" class="btn btn-info" title="View"><i class="fas fa-eye"></i></a>
                                    <a href="#" class="btn btn-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="btn btn-danger" title="Delete"><i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        <!-- Patient 4 -->
                        <tr>
                            <td>4</td>
                            <td>P-10042</td>
                            <td>Kamal Hossain</td>
                            <td>01912345678</td>
                            <td>156 Uttara, Sector 7, Dhaka</td>
                            <td>Male</td>
                            <td>52y 8m</td>
                            <td><span class="badge bg-danger">Emergency</span></td>
                            <td>23 Jun 2023</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="#" class="btn btn-info" title="View"><i class="fas fa-eye"></i></a>
                                    <a href="#" class="btn btn-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="btn btn-danger" title="Delete"><i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        <!-- Patient 5 -->
                        <tr>
                            <td>5</td>
                            <td>P-10041</td>
                            <td>Sabina Yasmin</td>
                            <td>01812345678</td>
                            <td>92 Mirpur DOHS, Dhaka</td>
                            <td>Female</td>
                            <td>39y 3m</td>
                            <td><span class="badge bg-primary">General</span></td>
                            <td>22 Jun 2023</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="#" class="btn btn-info" title="View"><i class="fas fa-eye"></i></a>
                                    <a href="#" class="btn btn-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="btn btn-danger" title="Delete"><i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        <!-- Patient 6 -->
                        <tr>
                            <td>6</td>
                            <td>P-10040</td>
                            <td>Rahim Mia</td>
                            <td>01512345678</td>
                            <td>34 Mohakhali, Dhaka</td>
                            <td>Male</td>
                            <td>62y 1m</td>
                            <td><span class="badge bg-info">Corporate</span></td>
                            <td>21 Jun 2023</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="#" class="btn btn-info" title="View"><i class="fas fa-eye"></i></a>
                                    <a href="#" class="btn btn-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="btn btn-danger" title="Delete"><i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        <!-- Patient 7 -->
                        <tr>
                            <td>7</td>
                            <td>P-10039</td>
                            <td>Taslima Akter</td>
                            <td>01712987654</td>
                            <td>45 Bashundhara R/A, Block C, Dhaka</td>
                            <td>Female</td>
                            <td>27y 9m</td>
                            <td><span class="badge bg-primary">General</span></td>
                            <td>20 Jun 2023</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="#" class="btn btn-info" title="View"><i class="fas fa-eye"></i></a>
                                    <a href="#" class="btn btn-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="btn btn-danger" title="Delete"><i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        <!-- Patient 8 -->
                        <tr>
                            <td>8</td>
                            <td>P-10038</td>
                            <td>Abdul Karim</td>
                            <td>01912876543</td>
                            <td>23 Khilgaon, Dhaka</td>
                            <td>Male</td>
                            <td>55y 4m</td>
                            <td><span class="badge bg-primary">General</span></td>
                            <td>19 Jun 2023</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="#" class="btn btn-info" title="View"><i class="fas fa-eye"></i></a>
                                    <a href="#" class="btn btn-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="btn btn-danger" title="Delete"><i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <span class="text-muted">Showing 1 to 8 of 145 entries</span>
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        
        // This is just for design demonstration
        // No actual functionality implemented
    });
</script>
@endsection 