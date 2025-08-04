<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Due Collection Receipt - {{ $collection->collection_no ?? 'COL-001' }}</title>
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
        
        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
        }
        
        .header {
            border-bottom: 2px solid #28a745;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .company-info {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        
        .company-details h1 {
            color: #28a745;
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .company-details p {
            margin: 2px 0;
            color: #666;
        }
        
        .receipt-info {
            text-align: right;
        }
        
        .receipt-info h2 {
            color: #28a745;
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .collection-details {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #28a745;
        }
        
        .section-title {
            font-weight: bold;
            color: #28a745;
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
        
        .patient-info, .collection-info {
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
            background: #d4edda;
            color: #155724;
        }
        
        .payment-header {
            background: #28a745;
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
        
        .invoice-info {
            background: #e3f2fd;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            border-left: 4px solid #2196f3;
        }
        
        .status-paid {
            background: #d4edda;
            color: #155724;
            padding: 5px 10px;
            border-radius: 3px;
            font-weight: bold;
            display: inline-block;
        }
        
        @media print {
            body {
                font-size: 12px;
            }
            
            .receipt-container {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- Header -->
        <div class="header">
            <div class="company-info">
                <div class="company-details">
                    <h1>SARKER HEALTH COMPLEX</h1>
                    <p>Address: 123 Medical Center Road, Dhaka-1200</p>
                    <p>Phone: +880-2-955-1234 | Email: info@sarkerhealth.com</p>
                    <p>Website: www.sarkerhealth.com</p>
                </div>
                <div class="receipt-info">
                    <h2>DUE COLLECTION RECEIPT</h2>
                    <p><strong>Collection No:</strong> {{ $collection->collection_no ?? 'COL-001' }}</p>
                    <p><strong>Date:</strong> {{ $collection->collection_date ?? date('d/m/Y') }}</p>
                    <p><strong>Time:</strong> {{ $collection->collection_time ?? date('H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Invoice Information -->
        <div class="invoice-info">
            <div class="section-title">INVOICE INFORMATION</div>
            <div class="info-row">
                <span class="info-label">Invoice No:</span>
                <span class="info-value">{{ $invoice->invoice_no ?? 'INV-001' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Invoice Date:</span>
                <span class="info-value">{{ $invoice->invoice_date ?? date('d/m/Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Invoice Type:</span>
                <span class="info-value">{{ ucfirst($invoice->invoice_type ?? 'consultant') }}</span>
            </div>
        </div>

        <!-- Patient and Collection Details -->
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
                    <span class="info-label">Address:</span>
                    <span class="info-value">{{ $patient->address ?? 'Dhaka, Bangladesh' }}</span>
                </div>
            </div>

            <div class="collection-info">
                <div class="section-title">COLLECTION INFORMATION</div>
                <div class="info-row">
                    <span class="info-label">Collection Date:</span>
                    <span class="info-value">{{ $collection->collection_date ?? date('d/m/Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Collection Time:</span>
                    <span class="info-value">{{ $collection->collection_time ?? date('H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Collected By:</span>
                    <span class="info-value">{{ $collector->name ?? 'Admin User' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Collection Status:</span>
                    <span class="info-value">
                        <span class="status-paid">PAID</span>
                    </span>
                </div>
                @if(isset($collection->remarks) && !empty($collection->remarks))
                <div class="info-row">
                    <span class="info-label">Remarks:</span>
                    <span class="info-value">{{ $collection->remarks }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Payment Summary -->
        <div class="payment-summary">
            <div class="payment-header">PAYMENT SUMMARY</div>
            <div class="payment-row">
                <span>Invoice Total Amount:</span>
                <span>৳{{ number_format($invoice->total_amount ?? 0, 2) }}</span>
            </div>
            <div class="payment-row">
                <span>Previously Paid:</span>
                <span>৳{{ number_format(($invoice->paid_amount ?? 0) - ($collection->collection_amount ?? 0), 2) }}</span>
            </div>
            <div class="payment-row">
                <span>Due Before Collection:</span>
                <span>৳{{ number_format($collection->due_before_collection ?? 0, 2) }}</span>
            </div>
            <div class="payment-row">
                <span>Collection Amount:</span>
                <span>৳{{ number_format($collection->collection_amount ?? 0, 2) }}</span>
            </div>
            <div class="payment-row">
                <span>Due After Collection:</span>
                <span>৳{{ number_format($collection->due_after_collection ?? 0, 2) }}</span>
            </div>
        </div>

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line"></div>
                <p>Patient's Signature</p>
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>
                <p>Authorized Signature</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Thank you for your payment at SARKER HEALTH COMPLEX</strong></p>
            <p>For any queries, please contact us at +880-2-955-1234 or email at info@sarkerhealth.com</p>
            <p><strong>This is a computer generated receipt. No signature required.</strong></p>
        </div>
    </div>
</body>
</html> 