@extends('admin.layouts.app')

@section('title', 'Invoice Return')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary">
                    <i class="fas fa-file-invoice me-2"></i> Invoice Return
                </h5>
                <div>
                    <button class="btn btn-sm btn-outline-secondary me-2">
                        <i class="fas fa-print me-1"></i> Print
                    </button>
                    <button class="btn btn-sm btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> New Return
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <!-- Return Form -->
            <div class="p-3" >
                <div class="row g-2">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <label class="me-2">Date</label>
                            <div class="input-group input-group-sm">
                                <input type="date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}">
                                <button class="btn btn-sm btn-light" type="button"><i class="fas fa-calendar"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <label class="me-2">Slip No</label>
                            <input type="text" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <label class="me-2">Indoor Patient ID</label>
                            <input type="text" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <label class="me-2">Dept</label>
                            <select class="form-select form-select-sm">
                                <option value="">Select Department</option>
                                <option value="OPD">OPD</option>
                                <option value="IPD">IPD</option>
                                <option value="Emergency">Emergency</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row g-2 mt-2">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <label class="me-2">Reg. No</label>
                            <input type="text" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="d-flex align-items-center">
                            <label class="me-2">Name</label>
                            <input type="text" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex align-items-center">
                            <label class="me-2">Age</label>
                            <input type="text" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex align-items-center">
                            <label class="me-2">Sex</label>
                            <select class="form-select form-select-sm">
                                <option value="Female">Female</option>
                                <option value="Male">Male</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row g-2 mt-2">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <label class="me-2">Ref. By</label>
                            <input type="text" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <label class="me-2">Cons. Dr.</label>
                            <input type="text" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="row g-2 mt-2">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <label class="me-2">Patient Address</label>
                            <input type="text" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <label class="me-2">Contact No</label>
                            <input type="text" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="row g-2 mt-2">
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="ihcCode">
                                <label class="form-check-label" for="ihcCode">IHC Code</label>
                            </div>
                            <input type="text" class="form-control form-control-sm ms-2">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="table-responsive">
                <table class="table table-sm table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;">Code</th>
                            <th>Particulars</th>
                            <th style="width: 100px;">Charge</th>
                            <th style="width: 120px;">Will Return?</th>
                            <th style="width: 80px;">Quantity</th>
                            <th style="width: 100px;">Total</th>
                        </tr>
                    </thead>
                    <tbody style="height: 200px; overflow-y: auto;">
                        <tr>
                            <td>
                                <input type="text" class="form-control form-control-sm border-0">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm border-0">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm border-0">
                            </td>
                            <td>
                                <select class="form-select form-select-sm border-0">
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" class="form-control form-control-sm border-0" value="1">
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm border-0" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="p-0">
                                <button class="btn btn-sm btn-light w-100">
                                    <i class="fas fa-plus"></i> Add Item
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Return Summary -->
            <div class="p-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <label>Code</label>
                                <input type="text" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-6">
                                <label>Description</label>
                                <input type="text" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-2">
                                <label>Qty</label>
                                <input type="number" class="form-control form-control-sm" value="1">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Charge</label>
                                <input type="text" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-4">
                                <label>Less</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control form-control-sm">
                                    <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown"></button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#">10%</a></li>
                                        <li><a class="dropdown-item" href="#">20%</a></li>
                                        <li><a class="dropdown-item" href="#">Custom</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>From</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control form-control-sm">
                                    <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown"></button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#">Cash</a></li>
                                        <li><a class="dropdown-item" href="#">Card</a></li>
                                        <li><a class="dropdown-item" href="#">Bank</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label>Delivery Date</label>
                                <input type="date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-8">
                                <label>Remarks</label>
                                <input type="text" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light text-dark h-100">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <label class="col-sm-5 col-form-label">Total Cancel Amt</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control form-control-sm text-end" readonly value="0.00">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-sm-5 col-form-label">Cash Return Amt</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control form-control-sm text-end" value="0.00">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-sm-5 col-form-label">Total Tk.</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control form-control-sm text-end" readonly value="0.00">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-sm-5 col-form-label">Grand Total</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control form-control-sm text-end" readonly value="0.00">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-sm-5 col-form-label">Total Less</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control form-control-sm text-end" value="0.00">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-sm-5 col-form-label">Net Payable</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control form-control-sm text-end" readonly value="0.00">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-sm-5 col-form-label">Advance</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control form-control-sm text-end" value="0.00">
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <label class="col-sm-5 col-form-label">Due</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control form-control-sm text-end" readonly value="0.00">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between">
                <div class="small text-muted">SQL Based - HospMDB</div>
                <div class="small text-muted">User Name - A AHMED</div>
                <div class="small text-muted">{{ date('d/m/Y') }} {{ date('h:i A') }}</div>
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