<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Report - Print</title>
    <style>
        @media print {
            body {
                margin: 0;
                padding: 20px;
                font-family: Arial, sans-serif;
                font-size: 12px;
                line-height: 1.4;
            }
            
            .no-print {
                display: none !important;
            }
            
            .page-break {
                page-break-before: always;
            }
            
            .header {
                text-align: center;
                margin-bottom: 20px;
                border-bottom: 2px solid #333;
                padding-bottom: 10px;
            }
            
            .hospital-info {
                margin-bottom: 15px;
            }
            
            .patient-info {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 15px;
                margin-bottom: 20px;
                border: 1px solid #ddd;
                padding: 15px;
            }
            
            .info-group {
                margin-bottom: 8px;
            }
            
            .info-label {
                font-weight: bold;
                color: #333;
            }
            
            .info-value {
                color: #666;
            }
            
            .test-results {
                margin-top: 20px;
            }
            
            .test-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 15px;
            }
            
            .test-table th,
            .test-table td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }
            
            .test-table th {
                background-color: #f5f5f5;
                font-weight: bold;
            }
            
            .footer {
                margin-top: 30px;
                display: grid;
                grid-template-columns: 1fr 1fr 1fr;
                gap: 20px;
            }
            
            .signature-box {
                border-top: 1px solid #333;
                padding-top: 10px;
                text-align: center;
            }
            
            .signature-line {
                border-top: 1px solid #333;
                margin-top: 40px;
                width: 200px;
                display: inline-block;
            }
            
            .remarks {
                margin-top: 20px;
                padding: 10px;
                border: 1px solid #ddd;
                background-color: #f9f9f9;
            }
        }
        
        /* Screen styles for preview */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        
        .hospital-info {
            margin-bottom: 15px;
        }
        
        .patient-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 15px;
        }
        
        .info-group {
            margin-bottom: 8px;
        }
        
        .info-label {
            font-weight: bold;
            color: #333;
        }
        
        .info-value {
            color: #666;
        }
        
        .test-results {
            margin-top: 20px;
        }
        
        .test-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        .test-table th,
        .test-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        .test-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 30px;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
        }
        
        .signature-box {
            border-top: 1px solid #333;
            padding-top: 10px;
            text-align: center;
        }
        
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 40px;
            width: 200px;
            display: inline-block;
        }
        
        .remarks {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }
        
        .print-buttons {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
        
        .print-buttons button {
            margin-left: 10px;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .btn-print {
            background-color: #007bff;
            color: white;
        }
        
        .btn-back {
            background-color: #6c757d;
            color: white;
        }
        
        @media print {
            .print-buttons {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="print-buttons no-print">
        <button class="btn-print" onclick="window.print()">
            <i class="fas fa-print"></i> Print Report
        </button>
        <button class="btn-back" onclick="window.history.back()">
            <i class="fas fa-arrow-left"></i> Back
        </button>
    </div>

    <div class="header">
        <h2>HOSPITAL DIAGNOSTIC MANAGEMENT SYSTEM</h2>
        <div class="hospital-info">
            <h3>LABORATORY REPORT</h3>
            <p>Report Date: {{ date('d/m/Y') }}</p>
        </div>
    </div>

    @if(isset($reportData))
    <div class="patient-info">
        <div class="info-group">
            <span class="info-label">Patient Name:</span>
            <span class="info-value">{{ $reportData['patient_name'] ?? 'N/A' }}</span>
        </div>
        <div class="info-group">
            <span class="info-label">Patient ID:</span>
            <span class="info-value">{{ $reportData['patient_id'] ?? 'N/A' }}</span>
        </div>
        <div class="info-group">
            <span class="info-label">Age:</span>
            <span class="info-value">{{ $reportData['patient_age'] ?? 'N/A' }} years</span>
        </div>
        <div class="info-group">
            <span class="info-label">Sex:</span>
            <span class="info-value">{{ ucfirst($reportData['patient_sex'] ?? 'N/A') }}</span>
        </div>
        <div class="info-group">
            <span class="info-label">Invoice No:</span>
            <span class="info-value">{{ $reportData['invoice_no'] ?? 'N/A' }}</span>
        </div>
        <div class="info-group">
            <span class="info-label">Report Date:</span>
            <span class="info-value">{{ $reportData['report_date'] ?? date('d/m/Y') }}</span>
        </div>
        <div class="info-group">
            <span class="info-label">Doctor:</span>
            <span class="info-value">{{ $reportData['doctor_name'] ?? 'N/A' }}</span>
        </div>
        <div class="info-group">
            <span class="info-label">Department:</span>
            <span class="info-value">{{ $reportData['department'] ?? 'N/A' }}</span>
        </div>
    </div>

    <div class="test-results">
        <h4>TEST RESULTS</h4>
        <table class="test-table">
            <thead>
                <tr>
                    <th>Test Name</th>
                    <th>Result</th>
                    <th>Unit</th>
                    <th>Normal Range</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($reportData['test_results']))
                    @foreach($reportData['test_results'] as $test)
                    <tr>
                        <td>{{ $test['test_name'] ?? 'N/A' }}</td>
                        <td>{{ $test['result'] ?? 'N/A' }}</td>
                        <td>{{ $test['unit'] ?? 'N/A' }}</td>
                        <td>{{ $test['normal_range'] ?? 'N/A' }}</td>
                        <td>
                            @if(isset($test['status']))
                                <span style="color: {{ $test['status'] == 'Normal' ? 'green' : 'red' }};">
                                    {{ $test['status'] }}
                                </span>
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" style="text-align: center;">No test results available</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    @if(isset($reportData['remarks']) && !empty($reportData['remarks']))
    <div class="remarks">
        <strong>Remarks:</strong><br>
        {{ $reportData['remarks'] }}
    </div>
    @endif

    <div class="footer">
        <div class="signature-box">
            <p><strong>Incharge</strong></p>
            <div class="signature-line"></div>
            <p>{{ $reportData['incharge_name'] ?? 'N/A' }}</p>
        </div>
        <div class="signature-box">
            <p><strong>Checked By</strong></p>
            <div class="signature-line"></div>
            <p>{{ $reportData['checked_by_name'] ?? 'N/A' }}</p>
        </div>
        <div class="signature-box">
            <p><strong>Authorized</strong></p>
            <div class="signature-line"></div>
            <p>{{ $reportData['doctor_name'] ?? 'N/A' }}</p>
        </div>
    </div>
    @else
    <div style="text-align: center; margin-top: 50px;">
        <h3>No Report Data Available</h3>
        <p>Please select a valid report to print.</p>
    </div>
    @endif

    <script>
        // Auto-print when page loads (optional)
        // window.onload = function() {
        //     window.print();
        // }
    </script>
</body>
</html> 