<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnostics Invoice - {{ $invoice->invoice_no ?? 'DIA-001' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            background: #fff;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
        }
        
        .header {
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            margin-bottom: 5px;
        }
        
        .company-info {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        
        .company-details h1 {
            color: #000;
            font-size: 24px;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .company-details p {
            margin: 2px 0;
            color: #333;
        }
        
        .invoice-info {
            text-align: right;
        }
        
        .invoice-info h2 {
            color: #000;
            font-size: 18px;
            margin-bottom: 10px;
            font-weight: bold;
        }
        
        .section-title {
            font-weight: bold;
            color: #000;
            margin-bottom: 15px;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
            text-transform: uppercase;
        }
        
        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .info-row {
             
            padding: 3px 0;
        }
        
        .info-label {
            font-weight: bold;
            color: #000;
        }
        
        .info-value {
            color: #000;
        }
        
        .patient-info, .diagnostics-info {
           
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #000;
        }
        
        .tests-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            border: 1px solid #000;
        }
        
        .tests-table th {
            background: #666;
            color: #fff;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        
        .tests-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #ccc;
        }
        
        .tests-table tr:nth-child(even) {
            background: #f9f9f9;
        }
        
        .tests-table tr:last-child td {
            border-bottom: none;
        }
        
        .test-type-header {
            background: #888;
            color: #fff;
            padding: 8px 10px;
            font-weight: bold;
            text-align: center;
        }
        
        .payment-summary {
            margin-top: 20px;
            border: 1px solid #000;
            border-radius: 5px;
        }
        
        .payment-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 15px;
            border-bottom: 1px solid #ccc;
        }
        
        .payment-row:last-child {
            border-bottom: none;
            font-weight: bold;
            background: #f0f0f0;
            color: #000;
        }
        
        .payment-header {
            background: #666;
            color: #fff;
            padding: 12px 15px;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #000;
            text-align: center;
            color: #333;
            font-size: 11px;
        }
        
        @media print {
            body {
                font-size: 12px;
                color: #000;
                background: #fff;
            }
            
            .invoice-container {
                padding: 10px;
            }
            
            .tests-table th {
                background: #000 !important;
                color: #fff !important;
            }
            
            .test-type-header {
                background: #333 !important;
                color: #fff !important;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div class="company-info">
                <div class="company-details">
                    <h1>SARKER HEALTH COMPLEX</h1>
                    <p>Address: 123 Medical Center Road, Dhaka-1200</p>
                    <p>Phone: +880-2-955-1234 | Email: info@sarkerhealth.com</p>
                    <p>Website: www.sarkerhealth.com</p>
                </div>
                <div class="invoice-info">
                    <h2>DIAGNOSTICS INVOICE</h2>
                    <p><strong>Invoice No:</strong> {{ $invoice->invoice_no ?? 'DIA-001' }}</p>
                    <p><strong>Date:</strong> {{ $invoice->invoice_date ?? date('d/m/Y') }}</p>
                    <p><strong>Time:</strong> {{ date('H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Patient and Diagnostics Details -->
        <div class="details-grid">
            <div class="patient-info">
                <div class="section-title">PATIENT INFORMATION</div>
                <div class="info-row">
                    <span class="info-label">Patient ID:</span>
                    <span class="info-value">{{ $patient->patient_id ?? 'P-001' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Name:</span>
                    <span class="info-value">{{ $patient->name ?? 'John Doe' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Age:</span>
                    <span class="info-value">
                        @if(($patient->age_years ?? 0) > 0 || ($patient->age_months ?? 0) > 0 || ($patient->age_days ?? 0) > 0)
                            @if(($patient->age_years ?? 0) > 0)
                                {{ $patient->age_years }} year{{ ($patient->age_years ?? 0) > 1 ? 's' : '' }}
                            @endif
                            @if(($patient->age_months ?? 0) > 0)
                                {{ ($patient->age_years ?? 0) > 0 ? ' ' : '' }}{{ $patient->age_months }} month{{ ($patient->age_months ?? 0) > 1 ? 's' : '' }}
                            @endif
                            @if(($patient->age_days ?? 0) > 0)
                                {{ (($patient->age_years ?? 0) > 0 || ($patient->age_months ?? 0) > 0) ? ' ' : '' }}{{ $patient->age_days }} day{{ ($patient->age_days ?? 0) > 1 ? 's' : '' }}
                            @endif
                        @else
                            N/A
                        @endif
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Gender:</span>
                    <span class="info-value">{{ $patient->gender ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Contact:</span>
                    <span class="info-value">{{ $patient->phone ?? '+880-1XXX-XXXXXX' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Address:</span>
                    <span class="info-value">{{ $patient->address ?? 'Dhaka, Bangladesh' }}</span>
                </div>
            </div>

            <div class="diagnostics-info">
                <div class="section-title">DIAGNOSTICS INFORMATION</div>
                <div class="info-row">
                    <span class="info-label">Invoice Date:</span>
                    <span class="info-value">{{ $invoice->invoice_date ?? date('d/m/Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Invoice Type:</span>
                    <span class="info-value">Diagnostics</span>
                </div>
                @if(isset($departmentSerials) && count($departmentSerials) > 0)
                <div class="info-row">
                    <span class="info-label">Department Serials:</span>
                    <span class="info-value">
                        @foreach($departmentSerials as $deptId => $deptInfo)
                            {{ $deptInfo['department_name'] }}: {{ $deptInfo['serial_number'] }}{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    </span>
                </div>
                @endif
                @if(isset($invoice->remarks) && !empty($invoice->remarks))
                <div class="info-row">
                    <span class="info-label">Remarks:</span>
                    <span class="info-value">{{ $invoice->remarks }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Tests and Collection Kits Table -->
        <table class="tests-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Department</th>
                    <th>Delivery Date</th>
                    <th>Charge</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @if(count($labTests) > 0)
                <tr>
                    <td colspan="7" class="test-type-header">LABORATORY TESTS</td>
                </tr>
                @foreach($labTests as $test)
                <tr>
                    <td>{{ $test->name }}</td>
                    <td>{{ $test->code }}</td>
                    <td>{{ $test->department_name ?? 'N/A' }}</td>
                    <td>{{ date('d/m/Y', strtotime($test->delivery_date)) }}</td>
                    <td>৳{{ number_format($test->charge, 2) }}</td>
                    <td>{{ $test->quantity }}</td>
                    <td><strong>৳{{ number_format($test->total, 2) }}</strong></td>
                </tr>
                @endforeach
                @endif

                @if(count($collectionKits) > 0)
                <tr>
                    <td colspan="7" class="test-type-header">COLLECTION KITS</td>
                </tr>
                @foreach($collectionKits as $kit)
                <tr>
                    <td>{{ $kit->name }}</td>
                    <td>{{ $kit->code }}</td>
                    <td>-</td>
                    <td>-</td>
                    <td>৳{{ number_format($kit->charge, 2) }}</td>
                    <td>{{ $kit->quantity }}</td>
                    <td><strong>৳{{ number_format($kit->total, 2) }}</strong></td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>

        <!-- Payment Summary -->
        <div class="payment-summary">
            <div class="payment-header">PAYMENT SUMMARY</div>
            <div class="payment-row">
                <span>Total Amount:</span>
                <span>৳{{ number_format($invoice->total_amount ?? 0, 2) }}</span>
            </div>
            <div class="payment-row">
                <span>Discount:</span>
                <span>৳{{ number_format($invoice->discount_amount ?? 0, 2) }}</span>
            </div>
            <div class="payment-row">
                <span>Payable Amount:</span>
                <span>৳{{ number_format($invoice->payable_amount ?? 0, 2) }}</span>
            </div>
            <div class="payment-row">
                <span>Paid Amount:</span>
                <span>৳{{ number_format($invoice->paid_amount ?? 0, 2) }}</span>
            </div>
            <div class="payment-row">
                <span>Due Amount:</span>
                <span>৳{{ number_format($invoice->due_amount ?? 0, 2) }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Thank you for choosing SARKER HEALTH COMPLEX</strong></p>
            <p>For any queries, please contact us at +880-2-955-1234 or email at info@sarkerhealth.com</p>
        </div>
    </div>
</body>
</html> 