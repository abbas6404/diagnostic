@extends('admin.layouts.app')

@section('title', 'Due Collection')

@section('styles')
<style>
    .due-collection-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ef 100%);
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
    
    .due-collection-header {
        background: linear-gradient(90deg, #3a7bd5 0%, #2b5db0 100%);
        color: white;
        border-radius: 8px 8px 0 0;
        padding: 12px 20px;
    }
    
    .form-section {
        background-color: #fff;
        border-radius: 6px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 15px;
    }
    
    .form-section-title {
        background-color: #f0f4f8;
        padding: 8px 15px;
        border-radius: 6px 6px 0 0;
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.9rem;
    }
    
    .due-table {
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .due-table thead th {
        background-color: #e9ecef;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    .due-table tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }
    
    .due-table tbody tr:hover {
        background-color: #e9f5ff;
    }
    
    .due-table tbody tr.selected {
        background-color: #d4edda;
    }
    
    .action-button {
        border-radius: 4px;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .action-button:hover {
        transform: translateY(-1px);
    }
    
    .amount-field {
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
        border-radius: 4px;
        text-align: right;
        font-weight: 500;
    }
    
    .amount-field:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary">
                    <i class="fas fa-hand-holding-usd me-2"></i> Diagnostics Due Collection
            </h5>
                <div>
                    <button class="btn btn-sm btn-outline-secondary me-2">
                        <i class="fas fa-print me-1"></i> Print
                    </button>
                    <button class="btn btn-sm btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> New Collection
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Left Column - Payment Form -->
                <div class="col-md-7">
                    <div class="card border">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0">Invoice Payment Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="row mb-2">
                                        <label class="col-sm-5 col-form-label">Transaction No:</label>
                                        <div class="col-sm-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" placeholder="Auto" readonly>
                                                <button class="btn btn-sm btn-outline-secondary" type="button"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-5 col-form-label">Invoice No:</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-5 col-form-label">Due Amount:</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control form-control-sm text-end">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-5 col-form-label">Discount Amount:</label>
                                        <div class="col-sm-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm text-end">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"></button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#">5%</a></li>
                                                    <li><a class="dropdown-item" href="#">10%</a></li>
                                                    <li><a class="dropdown-item" href="#">15%</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-5 col-form-label">Less Amount:</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control form-control-sm text-end">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row mb-2">
                                        <label class="col-sm-5 col-form-label">Paid Date:</label>
                                        <div class="col-sm-7">
                                            <div class="input-group">
                                                <input type="date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}">
                                                <button class="btn btn-sm btn-outline-secondary" type="button"><i class="fas fa-calendar"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-5 col-form-label">Invoice Date:</label>
                                        <div class="col-sm-7">
                                            <div class="input-group">
                                                <input type="date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}">
                                                <button class="btn btn-sm btn-outline-secondary" type="button"><i class="fas fa-calendar"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-5 col-form-label">From:</label>
                                        <div class="col-sm-7">
                                            <select class="form-select form-select-sm">
                                                <option value="">Select</option>
                                                <option value="Cash">Cash</option>
                                                <option value="Card">Card</option>
                                                <option value="Mobile Banking">Mobile Banking</option>
                                                <option value="Bank Transfer">Bank Transfer</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-5 col-form-label">Receive Due:</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control form-control-sm text-end">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-sm-5 col-form-label">Rest Due:</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control form-control-sm text-end" value="0.0" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-sm-2 col-form-label">Remarks:</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control form-control-sm" rows="1"></textarea>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-3 gap-2">
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-print me-1"></i> Re-Print
                                </button>
                                <button class="btn btn-sm btn-success">
                                    <i class="fas fa-save me-1"></i> Save And Print
                                </button>
                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-times me-1"></i> Exit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Due Invoices List -->
                <div class="col-md-5">
                    <div class="card border">
                        <div class="card-header bg-primary text-white py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Due Invoices</h6>
                                <div class="input-group input-group-sm" style="width: 200px;">
                                    <input type="text" class="form-control form-control-sm" placeholder="Search...">
                                    <button class="btn btn-sm btn-light" type="button">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0" style="height: 400px; overflow-y: auto;">
                            <table class="table table-sm table-hover table-striped mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Inv.No</th>
                                        <th>Inv.Date</th>
                                        <th>Patient Name</th>
                                        <th class="text-end">Due</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>DIAG2506240</td>
                                        <td>26/06/2023</td>
                                        <td>ABDULLAH</td>
                                        <td class="text-end">910</td>
                                    </tr>
                                    <tr>
                                        <td>DIAG2506239</td>
                                        <td>26/06/2023</td>
                                        <td>NUSRAT</td>
                                        <td class="text-end">230</td>
                                    </tr>
                                    <tr>
                                        <td>DIAG2506238</td>
                                        <td>26/06/2023</td>
                                        <td>RUMI ISLAM</td>
                                        <td class="text-end">520</td>
                                    </tr>
                                    <tr>
                                        <td>DIAG2506237</td>
                                        <td>25/06/2023</td>
                                        <td>MINA SHAHA</td>
                                        <td class="text-end">170</td>
                                    </tr>
                                    <tr>
                                        <td>DIAG2506236</td>
                                        <td>25/06/2023</td>
                                        <td>SUMAIA AKTER</td>
                                        <td class="text-end">70</td>
                                    </tr>
                                    <tr>
                                        <td>DIAG2506235</td>
                                        <td>25/06/2023</td>
                                        <td>MORSINA</td>
                                        <td class="text-end">410</td>
                                    </tr>
                                    <tr>
                                        <td>DIAG2506231</td>
                                        <td>25/06/2023</td>
                                        <td>SULTANA BEGUM</td>
                                        <td class="text-end">30</td>
                                    </tr>
                                    <tr>
                                        <td>DIAG2506230</td>
                                        <td>25/06/2023</td>
                                        <td>HAZRA</td>
                                        <td class="text-end">700</td>
                                    </tr>
                                    <tr>
                                        <td>DIAG2506228</td>
                                        <td>25/06/2023</td>
                                        <td>JAFIA</td>
                                        <td class="text-end">2980</td>
                                    </tr>
                                    <tr>
                                        <td>DIAG2506227</td>
                                        <td>25/06/2023</td>
                                        <td>KAMAL ANSARY</td>
                                        <td class="text-end">650</td>
                                    </tr>
                                    <tr>
                                        <td>DIAG2506226</td>
                                        <td>25/06/2023</td>
                                        <td>ASHRAFUL</td>
                                        <td class="text-end">700</td>
                                    </tr>
                                    <tr>
                                        <td>DIAG2506225</td>
                                        <td>24/06/2023</td>
                                        <td>HAFEZA</td>
                                        <td class="text-end">300</td>
                                    </tr>
                                    <tr>
                                        <td>DIAG2506221</td>
                                        <td>24/06/2023</td>
                                        <td>SHOHDUL</td>
                                        <td class="text-end">210</td>
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
        
        // Calculate rest due amount when receive amount changes
        $('input[name="receive_due"]').on('input', function() {
            var dueAmount = parseFloat($('input[name="due_amount"]').val()) || 0;
            var receiveAmount = parseFloat($(this).val()) || 0;
            var lessAmount = parseFloat($('input[name="less_amount"]').val()) || 0;
            var discountAmount = parseFloat($('input[name="discount_amount"]').val()) || 0;
            
            var restDue = dueAmount - receiveAmount - lessAmount - discountAmount;
            $('input[name="rest_due"]').val(restDue.toFixed(2));
        });
    });
</script>
@endsection 