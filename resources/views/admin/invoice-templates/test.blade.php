<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f5f5f5;
        }
        .invoice {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }
        .invoice-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin: 20px 0;
        }
        .section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }
        .section-title {
            font-weight: bold;
            color: #007bff;
            margin-bottom: 15px;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 5px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
        }
        .payment-summary {
            margin-top: 30px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
        }
        .payment-header {
            background: #007bff;
            color: white;
            padding: 15px;
            font-weight: bold;
        }
        .payment-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 15px;
            border-bottom: 1px solid #f1f3f4;
        }
        .payment-row:last-child {
            background: #e3f2fd;
            font-weight: bold;
            color: #1976d2;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="invoice">
        <div class="header">
            <div class="company-name">SARKER HEALTH COMPLEX</div>
            <p>123 Medical Center Road, Dhaka-1200</p>
            <p>Phone: +880-2-955-1234 | Email: info@sarkerhealth.com</p>
            <h2>INVOICE</h2>
        </div>

        <div class="invoice-details">
            <div class="section">
                <div class="section-title">Patient Information</div>
                <div class="info-row">
                    <span><strong>Patient ID:</strong></span>
                    <span>P-001</span>
                </div>
                <div class="info-row">
                    <span><strong>Name:</strong></span>
                    <span>John Doe</span>
                </div>
                <div class="info-row">
                    <span><strong>Age:</strong></span>
                    <span>25 years</span>
                </div>
                <div class="info-row">
                    <span><strong>Phone:</strong></span>
                    <span>+880-1XXX-XXXXXX</span>
                </div>
                <div class="info-row">
                    <span><strong>Address:</strong></span>
                    <span>Dhaka, Bangladesh</span>
                </div>
            </div>

            <div class="section">
                <div class="section-title">Invoice Information</div>
                <div class="info-row">
                    <span><strong>Invoice No:</strong></span>
                    <span>INV-001</span>
                </div>
                <div class="info-row">
                    <span><strong>Date:</strong></span>
                    <span>{{ date('d/m/Y') }}</span>
                </div>
                <div class="info-row">
                    <span><strong>Time:</strong></span>
                    <span>{{ date('H:i') }}</span>
                </div>
                <div class="info-row">
                    <span><strong>Doctor:</strong></span>
                    <span>Dr. Smith</span>
                </div>
                <div class="info-row">
                    <span><strong>Ticket No:</strong></span>
                    <span>DT-001</span>
                </div>
            </div>
        </div>

        <div class="payment-summary">
            <div class="payment-header">Payment Summary</div>
            <div class="payment-row">
                <span>Consultation Fee:</span>
                <span>৳500.00</span>
            </div>
            <div class="payment-row">
                <span>Discount:</span>
                <span>৳0.00</span>
            </div>
            <div class="payment-row">
                <span>Payable Amount:</span>
                <span>৳500.00</span>
            </div>
            <div class="payment-row">
                <span>Paid Amount:</span>
                <span>৳500.00</span>
            </div>
            <div class="payment-row">
                <span>Due Amount:</span>
                <span>৳0.00</span>
            </div>
        </div>

        <div class="footer">
            <p><strong>Thank you for choosing SARKER HEALTH COMPLEX</strong></p>
            <p>For any queries, please contact us at +880-2-955-1234</p>
            <p>This is a test invoice template.</p>
        </div>
    </div>
</body>
</html> 