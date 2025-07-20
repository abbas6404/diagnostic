@extends('admin.layouts.app')

@section('title', 'OPD Due Collection')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary">
                    <i class="fas fa-hand-holding-usd me-2"></i> OPD Due Collection
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
        <div class="card-body p-0">
            <div class="row g-0">
                <!-- Main Collection Form -->
                <div class="col-md-7 p-3" style="background-color: #3a7bd5;">
                    <div class="mb-4">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-2">
                                    <label class="text-white me-2" style="width: 120px;">Transaction No:</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control form-control-sm" placeholder="Auto" readonly>
                                        <button class="btn btn-sm btn-light" type="button"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <label class="text-white me-2" style="width: 120px;">Invoice No:</label>
                                    <input type="text" class="form-control form-control-sm">
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <label class="text-white me-2" style="width: 120px;">Due Amount:</label>
                                    <input type="text" class="form-control form-control-sm text-end">
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <label class="text-white me-2" style="width: 120px;">Discount Amount:</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control form-control-sm text-end">
                                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown"></button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#">5%</a></li>
                                            <li><a class="dropdown-item" href="#">10%</a></li>
                                            <li><a class="dropdown-item" href="#">15%</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <label class="text-white me-2" style="width: 120px;">Less Amount:</label>
                                    <input type="text" class="form-control form-control-sm text-end">
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <label class="text-white me-2" style="width: 120px;">Receive Due Amt:</label>
                                    <input type="text" class="form-control form-control-sm text-end">
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <label class="text-white me-2" style="width: 120px;">Rest Due Amount:</label>
                                    <input type="text" class="form-control form-control-sm text-end" value="0.0" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-2">
                                    <label class="text-white me-2" style="width: 120px;">Paid Date:</label>
                                    <div class="input-group input-group-sm">
                                        <input type="date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}">
                                        <button class="btn btn-sm btn-light" type="button"><i class="fas fa-calendar"></i></button>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <label class="text-white me-2" style="width: 120px;">Invoice Date:</label>
                                    <div class="input-group input-group-sm">
                                        <input type="date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}">
                                        <button class="btn btn-sm btn-light" type="button"><i class="fas fa-calendar"></i></button>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <label class="text-white me-2" style="width: 120px;">From:</label>
                                    <select class="form-select form-select-sm">
                                        <option value="">Select</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Card">Card</option>
                                        <option value="Mobile Banking">Mobile Banking</option>
                                        <option value="Bank Transfer">Bank Transfer</option>
                                    </select>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <label class="text-white me-2" style="width: 120px;">Remarks:</label>
                                    <textarea class="form-control form-control-sm" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-4 gap-2">
                        <button class="btn btn-sm btn-light">
                            <i class="fas fa-print me-1"></i> Re-Print
                        </button>
                        <button class="btn btn-sm btn-light">
                            <i class="fas fa-save me-1"></i> Save And Print
                        </button>
                        <button class="btn btn-sm btn-light">
                            <i class="fas fa-times me-1"></i> Exit
                        </button>
                    </div>
                </div>
                
                <!-- Due Invoices List -->
                <div class="col-md-5 p-0">
                    <div class="card h-100 border-0 rounded-0">
                        <div class="card-header bg-primary text-white py-2">
                            <h6 class="mb-0">Due Invoices</h6>
                        </div>
                        <div class="card-body p-0" style="height: 400px; overflow-y: auto;">
                            <table class="table table-sm table-hover table-striped mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Inv.No</th>
                                        <th>Inv.Date</th>
                                        <th>PatientName</th>
                                        <th class="text-end">Due</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>OPD24110136</td>
                                        <td>28/11/2024</td>
                                        <td>FORIDA BEGUM</td>
                                        <td class="text-end">100</td>
                                    </tr>
                                    <tr>
                                        <td>OPD24070045</td>
                                        <td>03/07/2024</td>
                                        <td>NUR MOHAMMAD</td>
                                        <td class="text-end">100</td>
                                    </tr>
                                    <tr>
                                        <td>OPD24070005</td>
                                        <td>01/07/2024</td>
                                        <td>SHAJIA</td>
                                        <td class="text-end">300</td>
                                    </tr>
                                    <tr>
                                        <td>OPD24050001</td>
                                        <td>25/05/2024</td>
                                        <td>SADIA</td>
                                        <td class="text-end">100</td>
                                    </tr>
                                    <tr>
                                        <td>OPD24050062</td>
                                        <td>14/05/2024</td>
                                        <td>DR. KAMRUL ALAM KHAN</td>
                                        <td class="text-end">300</td>
                                    </tr>
                                    <tr>
                                        <td>OPD24040021</td>
                                        <td>07/04/2024</td>
                                        <td>ABU BOKDR SIDDIK</td>
                                        <td class="text-end">200</td>
                                    </tr>
                                    <tr>
                                        <td>OPD23120107</td>
                                        <td>22/12/2023</td>
                                        <td>NISHI</td>
                                        <td class="text-end">300</td>
                                    </tr>
                                    <tr>
                                        <td>OPD23100054</td>
                                        <td>14/10/2023</td>
                                        <td>RAIDA</td>
                                        <td class="text-end">400</td>
                                    </tr>
                                    <tr>
                                        <td>OPD23090073</td>
                                        <td>18/09/2023</td>
                                        <td>MOHOSHIN</td>
                                        <td class="text-end">300</td>
                                    </tr>
                                    <tr>
                                        <td>OPD23090041</td>
                                        <td>11/09/2023</td>
                                        <td>ALEYA</td>
                                        <td class="text-end">300</td>
                                    </tr>
                                    <tr>
                                        <td>OPD23060070</td>
                                        <td>25/06/2023</td>
                                        <td>SALMA</td>
                                        <td class="text-end">300</td>
                                    </tr>
                                    <tr>
                                        <td>OPD23010014</td>
                                        <td>04/01/2023</td>
                                        <td>RASHID</td>
                                        <td class="text-end">300</td>
                                    </tr>
                                    <tr>
                                        <td>OPD22100017</td>
                                        <td>12/10/2022</td>
                                        <td>JAHIRUL FERDOUS</td>
                                        <td class="text-end">300</td>
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
            
            // Here you would typically load the selected invoice details
            // For demonstration purposes, we'll just show an alert
            // var invoiceNo = $(this).find('td:first').text();
            // alert('Selected invoice: ' + invoiceNo);
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