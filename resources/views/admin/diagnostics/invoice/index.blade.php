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
                    <a href="{{ route('admin.patients.index') }}" class="btn btn-sm btn-outline-secondary me-2">
                        <i class="fas fa-list me-1"></i> Patient List
                    </a>
                    <button class="btn btn-sm btn-outline-primary me-2" onclick="window.print()">
                        <i class="fas fa-print me-1"></i> Print
                    </button>
                    <button class="btn btn-sm btn-primary" id="newInvoiceBtn">
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
                                        <label class="col-sm-4 col-form-label">Invoice No:</label>
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
                        <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"><i class="fas fa-vial me-1"></i> Test Items</h6>
                            <div>
                                <button class="btn btn-sm btn-outline-success" id="addTestBtn">
                                    <i class="fas fa-plus me-1"></i> Add Test
                                </button>
                                <button class="btn btn-sm btn-outline-primary ms-1" data-bs-toggle="modal" data-bs-target="#testCatalogModal">
                                    <i class="fas fa-list me-1"></i> Test Catalog
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0" id="testItemsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 80px;">Code</th>
                                            <th>Particulars</th>
                                            <th style="width: 100px;">Charge</th>
                                            <th style="width: 120px;">Delivery Date</th>
                                            <th style="width: 80px;">Quantity</th>
                                            <th style="width: 100px;">Total</th>
                                            <th style="width: 40px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="test-item-row">
                                            <td>
                                                <input type="text" class="form-control form-control-sm test-code" placeholder="Code">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm test-name" placeholder="Test name">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm test-charge" value="0.00" step="0.01" min="0">
                                            </td>
                                            <td>
                                                <input type="date" class="form-control form-control-sm test-delivery" value="{{ date('Y-m-d') }}">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm test-qty" value="1" min="1">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm test-total" value="0.00" readonly>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-link text-danger p-0 remove-test"><i class="fas fa-times"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <td colspan="5" class="text-end fw-bold">Subtotal:</td>
                                            <td colspan="2">
                                                <input type="text" class="form-control form-control-sm" id="subtotalAmount" value="0.00" readonly>
                                            </td>
                                        </tr>
                                    </tfoot>
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
                        <div class="card-header bg-primary text-white py-2 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"><i class="fas fa-users me-1"></i> Recent Patients</h6>
                            <div class="input-group input-group-sm" style="width: 180px;">
                                <input type="text" class="form-control" placeholder="Search patients..." id="patientSearch">
                                <button class="btn btn-light" type="button"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <div class="card-body p-0" style="height: 400px; overflow-y: auto;">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th>Patient ID</th>
                                        <th>Patient Name</th>
                                        <th>Contact</th>
                                        <th class="text-center" style="width: 40px;"></th>
                                    </tr>
                                </thead>
                                <tbody id="patientList">
                                    <tr class="patient-row" data-id="R5060859" data-name="KEYA MONI" data-phone="01762775151" data-address="Dhaka, Bangladesh">
                                        <td>R5060859</td>
                                        <td>KEYA MONI</td>
                                        <td>01762775151</td>
                                        <td class="text-center"><button class="btn btn-sm btn-link p-0 select-patient"><i class="fas fa-check-circle text-success"></i></button></td>
                                    </tr>
                                    <tr class="patient-row" data-id="R5060858" data-name="CHINA" data-phone="01734827390" data-address="Chittagong, Bangladesh">
                                        <td>R5060858</td>
                                        <td>CHINA</td>
                                        <td>01734827390</td>
                                        <td class="text-center"><button class="btn btn-sm btn-link p-0 select-patient"><i class="fas fa-check-circle text-success"></i></button></td>
                                    </tr>
                                    <tr class="patient-row" data-id="R5060857" data-name="RINA" data-phone="01409116041" data-address="Sylhet, Bangladesh">
                                        <td>R5060857</td>
                                        <td>RINA</td>
                                        <td>01409116041</td>
                                        <td class="text-center"><button class="btn btn-sm btn-link p-0 select-patient"><i class="fas fa-check-circle text-success"></i></button></td>
                                    </tr>
                                    <tr class="patient-row" data-id="R5060856" data-name="ASMA UL HUSNA" data-phone="01407823067" data-address="Rajshahi, Bangladesh">
                                        <td>R5060856</td>
                                        <td>ASMA UL HUSNA</td>
                                        <td>01407823067</td>
                                        <td class="text-center"><button class="btn btn-sm btn-link p-0 select-patient"><i class="fas fa-check-circle text-success"></i></button></td>
                                    </tr>
                                    <tr class="patient-row" data-id="R5060855" data-name="HOSMON" data-phone="01347558472" data-address="Khulna, Bangladesh">
                                        <td>R5060855</td>
                                        <td>HOSMON</td>
                                        <td>01347558472</td>
                                        <td class="text-center"><button class="btn btn-sm btn-link p-0 select-patient"><i class="fas fa-check-circle text-success"></i></button></td>
                                    </tr>
                                    <tr class="patient-row" data-id="R5060854" data-name="RUMI ISLAM" data-phone="01749345271" data-address="Barisal, Bangladesh">
                                        <td>R5060854</td>
                                        <td>RUMI ISLAM</td>
                                        <td>01749345271</td>
                                        <td class="text-center"><button class="btn btn-sm btn-link p-0 select-patient"><i class="fas fa-check-circle text-success"></i></button></td>
                                    </tr>
                                    <tr class="patient-row" data-id="R5060853" data-name="KUMAR AKTER" data-phone="01601623045" data-address="Comilla, Bangladesh">
                                        <td>R5060853</td>
                                        <td>KUMAR AKTER</td>
                                        <td>01601623045</td>
                                        <td class="text-center"><button class="btn btn-sm btn-link p-0 select-patient"><i class="fas fa-check-circle text-success"></i></button></td>
                                    </tr>
                                    <tr class="patient-row" data-id="R5060852" data-name="PULASH TALUKDAR" data-phone="01785839127" data-address="Rangpur, Bangladesh">
                                        <td>R5060852</td>
                                        <td>PULASH TALUKDAR</td>
                                        <td>01785839127</td>
                                        <td class="text-center"><button class="btn btn-sm btn-link p-0 select-patient"><i class="fas fa-check-circle text-success"></i></button></td>
                                    </tr>
                                    <tr class="patient-row" data-id="R5060851" data-name="ABDULLAH AL ADIL" data-phone="01366847193" data-address="Dhaka, Bangladesh">
                                        <td>R5060851</td>
                                        <td>ABDULLAH AL ADIL</td>
                                        <td>01366847193</td>
                                        <td class="text-center"><button class="btn btn-sm btn-link p-0 select-patient"><i class="fas fa-check-circle text-success"></i></button></td>
                                    </tr>
                                    <tr class="patient-row" data-id="R5060850" data-name="AKLIMA" data-phone="01623761793" data-address="Mymensingh, Bangladesh">
                                        <td>R5060850</td>
                                        <td>AKLIMA</td>
                                        <td>01623761793</td>
                                        <td class="text-center"><button class="btn btn-sm btn-link p-0 select-patient"><i class="fas fa-check-circle text-success"></i></button></td>
                                    </tr>
                                    <tr class="patient-row" data-id="R5060849" data-name="MOSHINA" data-phone="01760102338" data-address="Noakhali, Bangladesh">
                                        <td>R5060849</td>
                                        <td>MOSHINA</td>
                                        <td>01760102338</td>
                                        <td class="text-center"><button class="btn btn-sm btn-link p-0 select-patient"><i class="fas fa-check-circle text-success"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer bg-light py-2 d-flex justify-content-between align-items-center">
                            <span class="small text-muted">Showing 11 patients</span>
                            <button class="btn btn-sm btn-outline-primary" id="loadMorePatients">
                                <i class="fas fa-sync-alt me-1"></i> Load More
                            </button>
                        </div>
                    </div>

                    <!-- Invoice Summary -->
                    <div class="card border">
                        <div class="card-header bg-primary text-white py-2">
                            <h6 class="mb-0"><i class="fas fa-file-invoice-dollar me-1"></i> Invoice Summary</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label">Total Amount</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control form-control-sm text-end fw-bold" id="totalAmount" readonly value="0.00">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label">Discount (%)</label>
                                <div class="col-sm-7">
                                    <div class="input-group input-group-sm">
                                        <input type="number" class="form-control text-end" id="discountPercent" min="0" max="100" value="0">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label">Discount Amount</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control form-control-sm text-end" id="discountAmount" value="0.00" step="0.01" min="0">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label fw-bold">Net Payable</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control form-control-sm text-end fw-bold bg-light" id="netPayable" readonly value="0.00">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label">Paid Amount</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control form-control-sm text-end" id="paidAmount" value="0.00" step="0.01" min="0">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-5 col-form-label text-danger fw-bold">Due Amount</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control form-control-sm text-end fw-bold text-danger" id="dueAmount" readonly value="0.00">
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-sm-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="withoutVaccination">
                                        <label class="form-check-label" for="withoutVaccination">
                                            Without Vaccatainer
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="printReceipt" checked>
                                        <label class="form-check-label" for="printReceipt">
                                            Print Receipt
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-12">
                                    <label class="form-label small">Payment Method</label>
                                    <div class="d-flex gap-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="paymentMethod" id="paymentCash" value="cash" checked>
                                            <label class="form-check-label" for="paymentCash">Cash</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="paymentMethod" id="paymentCard" value="card">
                                            <label class="form-check-label" for="paymentCard">Card</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="paymentMethod" id="paymentMobile" value="mobile">
                                            <label class="form-check-label" for="paymentMobile">Mobile Banking</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-center gap-2 mt-4">
                                <button class="btn btn-success" id="saveInvoiceBtn">
                                    <i class="fas fa-save me-1"></i> Save & Print
                                </button>
                                <button class="btn btn-primary" id="resetFormBtn">
                                    <i class="fas fa-sync-alt me-1"></i> Reset
                                </button>
                                <button class="btn btn-danger" id="cancelBtn">
                                    <i class="fas fa-times me-1"></i> Cancel
                                </button>
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
        var tooltipTriggerList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        
        // Patient search functionality
        $("#patientSearch").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#patientList tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        
        // Select patient functionality
        $(".select-patient").on("click", function() {
            var row = $(this).closest("tr");
            var patientId = row.data("id");
            var patientName = row.data("name");
            var patientPhone = row.data("phone");
            var patientAddress = row.data("address");
            
            // Fill patient details in the form
            $("#patient_id").val(patientId);
            $("input[name='name_en']").val(patientName);
            $("input[name='phone']").val(patientPhone);
            $("input[name='address']").val(patientAddress);
            
            // Highlight the selected patient
            $(".patient-row").removeClass("table-primary");
            row.addClass("table-primary");
        });
        
        // Add new test item row
        $("#addTestBtn").on("click", function() {
            var newRow = $(".test-item-row:first").clone();
            newRow.find("input").val("");
            newRow.find(".test-qty").val(1);
            newRow.find(".test-charge").val(0);
            newRow.find(".test-total").val(0);
            newRow.find(".test-delivery").val(new Date().toISOString().split('T')[0]);
            $("#testItemsTable tbody").append(newRow);
            updateTotals();
        });
        
        // Remove test item row
        $(document).on("click", ".remove-test", function() {
            if ($("#testItemsTable tbody tr").length > 1) {
                $(this).closest("tr").remove();
                updateTotals();
            } else {
                alert("Cannot remove the last test item row.");
            }
        });
        
        // Calculate row total when charge or quantity changes
        $(document).on("change", ".test-charge, .test-qty", function() {
            var row = $(this).closest("tr");
            var charge = parseFloat(row.find(".test-charge").val()) || 0;
            var qty = parseInt(row.find(".test-qty").val()) || 0;
            var total = charge * qty;
            row.find(".test-total").val(total.toFixed(2));
            updateTotals();
        });
        
        // Update discount amount when percentage changes
        $("#discountPercent").on("change", function() {
            var percent = parseFloat($(this).val()) || 0;
            var totalAmount = parseFloat($("#totalAmount").val()) || 0;
            var discountAmount = totalAmount * (percent / 100);
            $("#discountAmount").val(discountAmount.toFixed(2));
            updateNetPayable();
        });
        
        // Update discount percentage when amount changes
        $("#discountAmount").on("change", function() {
            var amount = parseFloat($(this).val()) || 0;
            var totalAmount = parseFloat($("#totalAmount").val()) || 0;
            var percent = totalAmount > 0 ? (amount / totalAmount) * 100 : 0;
            $("#discountPercent").val(percent.toFixed(1));
            updateNetPayable();
        });
        
        // Update due amount when paid amount changes
        $("#paidAmount").on("change", function() {
            updateDueAmount();
        });
        
        // Calculate all totals
        function updateTotals() {
            var subtotal = 0;
            
            // Calculate subtotal from all test items
            $(".test-total").each(function() {
                subtotal += parseFloat($(this).val()) || 0;
            });
            
            // Update subtotal field
            $("#subtotalAmount").val(subtotal.toFixed(2));
            $("#totalAmount").val(subtotal.toFixed(2));
            
            // Recalculate discount
            var percent = parseFloat($("#discountPercent").val()) || 0;
            var discountAmount = subtotal * (percent / 100);
            $("#discountAmount").val(discountAmount.toFixed(2));
            
            // Update net payable and due
            updateNetPayable();
        }
        
        // Calculate net payable amount
        function updateNetPayable() {
            var totalAmount = parseFloat($("#totalAmount").val()) || 0;
            var discountAmount = parseFloat($("#discountAmount").val()) || 0;
            var netPayable = totalAmount - discountAmount;
            
            // Ensure net payable is not negative
            netPayable = Math.max(0, netPayable);
            $("#netPayable").val(netPayable.toFixed(2));
            
            // Update due amount
            updateDueAmount();
        }
        
        // Calculate due amount
        function updateDueAmount() {
            var netPayable = parseFloat($("#netPayable").val()) || 0;
            var paidAmount = parseFloat($("#paidAmount").val()) || 0;
            var dueAmount = netPayable - paidAmount;
            
            // Ensure due amount is not negative
            dueAmount = Math.max(0, dueAmount);
            $("#dueAmount").val(dueAmount.toFixed(2));
            
            // Highlight due amount if positive
            if (dueAmount > 0) {
                $("#dueAmount").addClass("text-danger");
            } else {
                $("#dueAmount").removeClass("text-danger");
            }
        }
        
        // Reset form button
        $("#resetFormBtn").on("click", function() {
            if (confirm("Are you sure you want to reset the form? All entered data will be cleared.")) {
                // Clear patient information
                $("input[name='patient_id']").val("");
                $("input[name='name_en']").val("");
                $("input[name='phone']").val("");
                $("input[name='address']").val("");
                
                // Reset test items table to a single empty row
                $("#testItemsTable tbody tr:not(:first)").remove();
                $("#testItemsTable tbody tr:first input").val("");
                $("#testItemsTable tbody tr:first .test-qty").val(1);
                $("#testItemsTable tbody tr:first .test-delivery").val(new Date().toISOString().split('T')[0]);
                
                // Reset totals
                $("#subtotalAmount").val("0.00");
                $("#totalAmount").val("0.00");
                $("#discountPercent").val(0);
                $("#discountAmount").val("0.00");
                $("#netPayable").val("0.00");
                $("#paidAmount").val("0.00");
                $("#dueAmount").val("0.00");
                
                // Reset patient selection highlight
                $(".patient-row").removeClass("table-primary");
            }
        });
        
        // Save invoice button
        $("#saveInvoiceBtn").on("click", function() {
            // Validate form
            if (!$("input[name='name_en']").val()) {
                alert("Please select a patient or enter patient name.");
                return;
            }
            
            if (!$(".test-name").filter(function() { return $(this).val() !== ""; }).length) {
                alert("Please add at least one test item.");
                return;
            }
            
            // Show success message
            alert("Invoice saved successfully!");
            
            // Here you would normally submit the form to the server
            // For demonstration purposes, we're just showing an alert
        });
        
        // Cancel button
        $("#cancelBtn").on("click", function() {
            if (confirm("Are you sure you want to cancel? All entered data will be lost.")) {
                window.location.href = "{{ route('admin.patients.index') }}";
            }
        });
    });
</script>
@endsection 