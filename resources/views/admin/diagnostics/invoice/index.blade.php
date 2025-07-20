@extends('admin.layouts.app')

@section('title', 'Diagnostics Invoice')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary">
                    <i class="fas fa-file-invoice me-2"></i> Diagnostics Invoice
            </h5>
                <div>
                    <button class="btn btn-sm btn-outline-secondary me-2">
                        <i class="fas fa-print me-1"></i> Print
                    </button>
                    <button class="btn btn-sm btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> New Invoice
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Invoice Form -->
            <div class="row mb-4">
                <!-- Left Column -->
                <div class="col-md-7">
                    <div class="card border">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0">Invoice Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Date:</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}">
                                                <button class="btn btn-sm btn-outline-secondary" type="button"><i class="fas fa-calendar"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Slip No:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" value="INV-{{ date('Ymd') }}-001">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Patient ID:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" placeholder="P-00000">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Reg. No:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" placeholder="R0000000">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Name:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Ref. By:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Dr. Ticket:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm" placeholder="DT-00000">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">ID Ticket:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Cons. Dr:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Age:</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" placeholder="Y" style="width: 30%;">
                                                <input type="text" class="form-control form-control-sm" placeholder="M" style="width: 30%;">
                                                <input type="text" class="form-control form-control-sm" placeholder="D" style="width: 30%;">
                                                <button class="btn btn-sm btn-outline-secondary" type="button">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-4 col-form-label">Sex:</label>
                                        <div class="col-sm-8">
                                            <select class="form-select form-select-sm">
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-2 col-form-label">Address:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-2 col-form-label">Contact:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control form-control-sm">
                                </div>
                                <label class="col-sm-2 col-form-label">ICD Code:</label>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm">
                                        <button class="btn btn-sm btn-outline-secondary" type="button"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="excludePackage">
                                        <label class="form-check-label" for="excludePackage">Exclude Package Bill</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Test Items Table -->
                    <div class="card border mt-3">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0">Test Items</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 80px;">Code</th>
                                            <th>Particulars</th>
                                            <th style="width: 100px;">Charge</th>
                                            <th style="width: 120px;">Delivery Date</th>
                                            <th style="width: 80px;">Quantity</th>
                                            <th style="width: 100px;">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
                                                <input type="date" class="form-control form-control-sm border-0">
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
                        </div>
                    </div>

                    <!-- Return Section -->
                    <div class="card border mt-3">
                        <div class="card-header bg-light py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Return</h6>
                                <button class="btn btn-sm btn-outline-secondary">Re-Print</button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 80px;">Code</th>
                                            <th>Description</th>
                                            <th style="width: 60px;">Qty</th>
                                            <th style="width: 100px;">Charge</th>
                                            <th style="width: 100px;">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control form-control-sm border-0">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm border-0">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm border-0" value="1">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm border-0">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm border-0" readonly>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row g-2 p-2">
                                <div class="col-md-4">
                                    <select class="form-select form-select-sm">
                                        <option>Less</option>
                                        <option>Discount</option>
                                        <option>Return</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-select form-select-sm">
                                        <option>From</option>
                                        <option>Cash</option>
                                        <option>Card</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-select form-select-sm">
                                        <option>All</option>
                                        <option>Selected</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row g-2 p-2">
                                <div class="col-md-4">
                                    <label class="form-label small">Delivery Dt</label>
                                    <input type="date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label small">Remarks</label>
                                    <input type="text" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-5">
                    <!-- Patient Information -->
                    <div class="card border mb-3">
                        <div class="card-header bg-primary text-white py-2">
                            <h6 class="mb-0">Patients Information</h6>
                        </div>
                        <div class="card-body p-0" style="height: 400px; overflow-y: auto;">
                            <table class="table table-sm table-hover table-striped mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Patient ID</th>
                                        <th>Patient Name</th>
                                        <th>Telephone</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>R5060859</td>
                                        <td>KEYA MONI</td>
                                        <td>01762775151</td>
                                    </tr>
                                    <tr>
                                        <td>R5060858</td>
                                        <td>CHINA</td>
                                        <td>01734827390</td>
                                    </tr>
                                    <tr>
                                        <td>R5060857</td>
                                        <td>RINA</td>
                                        <td>01409116041</td>
                                    </tr>
                                    <tr>
                                        <td>R5060856</td>
                                        <td>ASMA UL HUSNA</td>
                                        <td>01407823067</td>
                                    </tr>
                                    <tr>
                                        <td>R5060855</td>
                                        <td>HOSMON</td>
                                        <td>01347558472</td>
                                    </tr>
                                    <tr>
                                        <td>R5060854</td>
                                        <td>RUMI ISLAM</td>
                                        <td>01749345271</td>
                                    </tr>
                                    <tr>
                                        <td>R5060853</td>
                                        <td>KUMAR AKTER</td>
                                        <td>01601623045</td>
                                    </tr>
                                    <tr>
                                        <td>R5060852</td>
                                        <td>PULASH TALUKDAR</td>
                                        <td>01785839127</td>
                                    </tr>
                                    <tr>
                                        <td>R5060851</td>
                                        <td>ABDULLAH AL ADIL</td>
                                        <td>01366847193</td>
                                    </tr>
                                    <tr>
                                        <td>R5060850</td>
                                        <td>AKLIMA</td>
                                        <td>01623761793</td>
                                    </tr>
                                    <tr>
                                        <td>R5060849</td>
                                        <td>MOSHINA</td>
                                        <td>01760102338</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Invoice Summary -->
                    <div class="card border">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0">Invoice Summary</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label">Total Tk.</label>
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
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="withoutVaccination">
                                <label class="form-check-label" for="withoutVaccination">
                                    Without Vaccatainer And CCC
                                </label>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button class="btn btn-primary me-2">Save</button>
                                <button class="btn btn-success me-2">Refresh</button>
                                <button class="btn btn-danger">Exit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-white">
            <div class="row small text-muted">
                <div class="col-md-4">SQL Based - HospMDB</div>
                <div class="col-md-4">User Name - A AHMED</div>
                <div class="col-md-4 text-end">{{ date('d/m/Y') }} {{ date('h:i A') }}</div>
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