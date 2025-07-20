@extends('admin.layouts.app')

@section('title', 'OPD Invoice')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary">
                    <i class="fas fa-file-invoice me-2"></i> OPD Invoice
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
        <div class="card-body p-0">
            <div class="row g-0">
                <!-- Main Invoice Form -->
                <div class="col-md-7 p-3" style="background-color: #3a7bd5;">
                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-2">
                                <label class="text-white me-2" style="width: 100px;">Receipt No:</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control form-control-sm">
                                    <button class="btn btn-sm btn-light" type="button">Update</button>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <label class="text-white me-2" style="width: 100px;">Reg. No:</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control form-control-sm">
                                    <button class="btn btn-sm btn-success" type="button">New Reg</button>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <label class="text-white me-2" style="width: 100px;">Name:</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Patient Name">
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <label class="text-white me-2" style="width: 100px;">Religion:</label>
                                <select class="form-select form-select-sm">
                                    <option value="Islam">Islam</option>
                                    <option value="Hinduism">Hinduism</option>
                                    <option value="Christianity">Christianity</option>
                                    <option value="Buddhism">Buddhism</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <label class="text-white me-2" style="width: 100px;">Ref. Dr:</label>
                                <input type="text" class="form-control form-control-sm">
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <label class="text-white me-2" style="width: 100px;">Under Dr:</label>
                                <input type="text" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-2">
                                <label class="text-white me-2" style="width: 100px;">Receipt Date:</label>
                                <div class="input-group input-group-sm">
                                    <input type="date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <label class="text-white me-2" style="width: 100px;">Indoor P.ID:</label>
                                <input type="text" class="form-control form-control-sm">
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="row g-2 w-100">
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <label class="text-white me-2">Sex:</label>
                                            <select class="form-select form-select-sm">
                                                <option value="Female">Female</option>
                                                <option value="Male">Male</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="d-flex align-items-center">
                                            <label class="text-white me-2">Age:</label>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control form-control-sm" placeholder="Y" style="width: 30px;">
                                                <input type="text" class="form-control form-control-sm" placeholder="M" style="width: 30px;">
                                                <input type="text" class="form-control form-control-sm" placeholder="D" style="width: 30px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <label class="text-white me-2" style="width: 100px;">Mobile No:</label>
                                <input type="text" class="form-control form-control-sm">
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <label class="text-white me-2" style="width: 100px;">Address:</label>
                                <input type="text" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Service Items Table -->
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered bg-white mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 80px;">Code</th>
                                    <th>Description</th>
                                    <th style="width: 80px;">Charge</th>
                                    <th style="width: 60px;">Unit</th>
                                    <th style="width: 80px;">No Of Unit</th>
                                    <th style="width: 100px;">Total Charge</th>
                                    <th style="width: 60px;">ABD</th>
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
                                        <input type="text" class="form-control form-control-sm border-0 text-end">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm border-0 text-center">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm border-0 text-center" value="1">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm border-0 text-end" readonly>
                                    </td>
                                    <td>
                                        <div class="form-check d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7" class="p-0">
                                        <button class="btn btn-sm btn-light w-100">
                                            <i class="fas fa-plus"></i> Add Item
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Payment Summary -->
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="excludePackage">
                                    <label class="form-check-label text-white" for="excludePackage">Exclude To Package Bill</label>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <label class="text-white me-2" style="width: 100px;">Remarks:</label>
                                <textarea class="form-control form-control-sm" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-2">
                                <label class="text-white me-2" style="width: 100px;">Total Payable:</label>
                                <input type="text" class="form-control form-control-sm text-end" readonly value="0.00">
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <label class="text-white me-2" style="width: 100px;">Vat:</label>
                                <input type="text" class="form-control form-control-sm text-end" value="0.0">
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <label class="text-white me-2" style="width: 100px;">Grand Total:</label>
                                <input type="text" class="form-control form-control-sm text-end" readonly value="0.00">
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <label class="text-white me-2" style="width: 100px;">Less:</label>
                                <input type="text" class="form-control form-control-sm text-end" value="0.0">
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <label class="text-white me-2" style="width: 100px;">Total Payment:</label>
                                <input type="text" class="form-control form-control-sm text-end" value="0.0">
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <label class="text-white me-2" style="width: 100px;">Due:</label>
                                <input type="text" class="form-control form-control-sm text-end" readonly value="0.00">
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-3 gap-2">
                        <button class="btn btn-sm btn-light">
                            <i class="fas fa-print me-1"></i> Re-Print
                        </button>
                        <button class="btn btn-sm btn-light">
                            <i class="fas fa-save me-1"></i> Save
                        </button>
                        <button class="btn btn-sm btn-light">
                            <i class="fas fa-times me-1"></i> Exit
                        </button>
                    </div>
                </div>
                
                <!-- Patient Information List -->
                <div class="col-md-5 p-0">
                    <div class="card h-100 border-0 rounded-0">
                        <div class="card-header bg-primary text-white py-2">
                            <h6 class="mb-0">Patients Information</h6>
                        </div>
                        <div class="card-body p-0" style="height: 600px; overflow-y: auto;">
                            <table class="table table-sm table-hover table-striped mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>PatientId</th>
                                        <th>PatientName</th>
                                        <th>TelephoneNo</th>
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
                                        <td>01734837390</td>
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
                                        <td>NOSMON</td>
                                        <td>01347558472</td>
                                    </tr>
                                    <tr>
                                        <td>R5060854</td>
                                        <td>RUMI ISLAM</td>
                                        <td>01748045271</td>
                                    </tr>
                                    <tr>
                                        <td>R5060853</td>
                                        <td>SUMAIA AKTER</td>
                                        <td>01601993042</td>
                                    </tr>
                                    <tr>
                                        <td>R5060852</td>
                                        <td>POLASH TALUKDAR</td>
                                        <td>01785291127</td>
                                    </tr>
                                    <tr>
                                        <td>R5060851</td>
                                        <td>ABDULLAH AL ADIL</td>
                                        <td>01306647193</td>
                                    </tr>
                                    <tr>
                                        <td>R5060850</td>
                                        <td>AKLIMA</td>
                                        <td>01623761753</td>
                                    </tr>
                                    <tr>
                                        <td>R5060849</td>
                                        <td>MORJINA</td>
                                        <td>01760102938</td>
                                    </tr>
                                    <tr>
                                        <td>R5060848</td>
                                        <td>JAFIA</td>
                                        <td>01712062360</td>
                                    </tr>
                                    <tr>
                                        <td>R5060847</td>
                                        <td>ASHRAFUL</td>
                                        <td>01724544127</td>
                                    </tr>
                                    <tr>
                                        <td>R5060846</td>
                                        <td>HAZRA</td>
                                        <td>01758655140</td>
                                    </tr>
                                    <tr>
                                        <td>R5060845</td>
                                        <td>JUNAKI</td>
                                        <td>01933814031</td>
                                    </tr>
                                </tbody>
                            </table>
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
        // Make rows selectable
        $('.table tbody tr').click(function() {
            $('.table tbody tr').removeClass('table-primary');
            $(this).addClass('table-primary');
        });
        
        // Calculate total charge when charge or quantity changes
        $(document).on('input', '.table input[type="number"], .table input[name="charge"]', function() {
            var row = $(this).closest('tr');
            var charge = parseFloat(row.find('input[name="charge"]').val()) || 0;
            var quantity = parseFloat(row.find('input[type="number"]').val()) || 0;
            
            var total = charge * quantity;
            row.find('input[readonly]').val(total.toFixed(2));
            
            // Recalculate totals
            calculateTotals();
        });
        
        function calculateTotals() {
            var totalPayable = 0;
            $('.table tbody tr').each(function() {
                var total = parseFloat($(this).find('input[readonly]').val()) || 0;
                totalPayable += total;
            });
            
            var vat = parseFloat($('input[name="vat"]').val()) || 0;
            var less = parseFloat($('input[name="less"]').val()) || 0;
            var payment = parseFloat($('input[name="payment"]').val()) || 0;
            
            var grandTotal = totalPayable + vat;
            var due = grandTotal - less - payment;
            
            $('input[name="total_payable"]').val(totalPayable.toFixed(2));
            $('input[name="grand_total"]').val(grandTotal.toFixed(2));
            $('input[name="due"]').val(due.toFixed(2));
        }
    });
</script>
@endsection 