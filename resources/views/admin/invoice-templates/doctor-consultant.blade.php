<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor/Consultant Invoice - {{ $invoice->invoice_no ?? 'INV-001' }}</title>
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
            color: #333;
            background: #fff;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
        }
        
        .header {
            border-bottom: 2px solid #007bff;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .company-info {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        

        
        .company-details h1 {
            color: #007bff;
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .company-details p {
            margin: 2px 0;
            color: #666;
        }
        
        .invoice-info {
            text-align: right;
        }
        
        .invoice-info h2 {
            color: #007bff;
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .consultation-details {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #007bff;
        }
        
        .section-title {
            font-weight: bold;
            color: #007bff;
            margin-bottom: 15px;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 5px;
        }
        
        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
            padding: 5px 0;
            border-bottom: 1px solid #f1f3f4;
        }
        
        .info-label {
            font-weight: bold;
            color: #555;
        }
        
        .info-value {
            color: #333;
        }
        
        .patient-info, .consultation-info {
            background: white;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #e9ecef;
        }
        
        .payment-summary {
            margin-top: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }
        
        .payment-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 15px;
            border-bottom: 1px solid #f1f3f4;
        }
        
        .payment-row:last-child {
            border-bottom: none;
            font-weight: bold;
            background: #e3f2fd;
            color: #1976d2;
        }
        
        .payment-header {
            background: #007bff;
            color: white;
            padding: 12px 15px;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            color: #666;
            font-size: 11px;
        }
        
        .signature-section {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }
        
        .signature-box {
            text-align: center;
            width: 45%;
        }
        
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 40px;
            padding-top: 5px;
        }
        
        .ticket-info {
            background: #e3f2fd;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            border-left: 4px solid #2196f3;
        }
        
        @media print {
            body {
                font-size: 12px;
            }
            
            .invoice-container {
                padding: 10px;
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
                    <h2>DOCTOR/CONSULTANT INVOICE</h2>
                    <p><strong>Invoice No:</strong> {{ $invoice->invoice_no ?? 'INV-001' }}</p>
                    <p><strong>Date:</strong> {{ $invoice->invoice_date ?? date('d/m/Y') }}</p>
                    <p><strong>Time:</strong> {{ date('H:i') }}</p>
                </div>
            </div>
        </div>

      

        <!-- Patient and Consultation Details -->
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
                    <span class="info-label">Contact:</span>
                    <span class="info-value">{{ $patient->phone ?? '+880-1XXX-XXXXXX' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Patient Type:</span>
                    <span class="info-value">{{ ucfirst($patient->patient_type ?? 'new') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Address:</span>
                    <span class="info-value">{{ $patient->address ?? 'Dhaka, Bangladesh' }}</span>
                </div>
            </div>

            <div class="consultation-info">
                <div class="section-title">CONSULTATION INFORMATION</div>
                <div class="info-row">
                    <span class="info-label">Consultation Date:</span>
                    <span class="info-value">{{ $ticket->ticket_date ?? date('d/m/Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Consultation Time:</span>
                    <span class="info-value">{{ $ticket->ticket_time ?? date('H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Doctor:</span>
                    <span class="info-value">{{ $doctor->name ?? 'Dr. Smith' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Ticket No:</span>
                    <span class="info-value">{{ $ticket->ticket_no ?? 'DT-001' }}</span>
                </div>
                @if(isset($patient->referred_by))
                <div class="info-row">
                    <span class="info-label">Referred By:</span>
                    <span class="info-value">{{ $patient->referred_by ?? 'N/A' }}</span>
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

        <!-- Payment Summary -->
        <div class="payment-summary">
            <div class="payment-header">PAYMENT SUMMARY</div>
            <div class="payment-row">
                <span>Consultation Fee:</span>
                <span>৳{{ number_format($invoice->total_amount ?? 500, 2) }}</span>
            </div>
            <div class="payment-row">
                <span>Discount:</span>
                <span>৳{{ number_format($invoice->discount_amount ?? 0, 2) }}</span>
            </div>
            <div class="payment-row">
                <span>Payable Amount:</span>
                <span>৳{{ number_format($invoice->payable_amount ?? 500, 2) }}</span>
            </div>
            <div class="payment-row">
                <span>Paid Amount:</span>
                <span>৳{{ number_format($invoice->paid_amount ?? 500, 2) }}</span>
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