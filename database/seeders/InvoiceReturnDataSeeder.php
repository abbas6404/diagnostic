<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InvoiceReturnDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing patients and lab tests
        $patients = DB::table('patients')->pluck('id')->toArray();
        $labTests = DB::table('lab_tests')->pluck('id')->toArray();
        
        if (empty($patients) || empty($labTests)) {
            $this->command->error('No patients or lab tests found. Please run PatientSeeder and LabTestSeeder first.');
            return;
        }
        
        // Create diagnostics invoices with payments
        $diagnosticsInvoices = [
            [
                'invoice_no' => 'DIA-250731-001',
                'patient_id' => $patients[array_rand($patients)],
                'total_amount' => 3500,
                'payable_amount' => 3500,
                'paid_amount' => 2500,
                'due_amount' => 1000,
                'discount_amount' => 0,
                'discount_percentage' => 0,
                'invoice_date' => '2025-01-25',
                'invoice_type' => 'dia',
                'payment_method' => 'Cash',
                'created_by' => 1,
                'remarks' => 'Diagnostics Lab Tests',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'invoice_no' => 'DIA-250731-002',
                'patient_id' => $patients[array_rand($patients)],
                'total_amount' => 4200,
                'payable_amount' => 4200,
                'paid_amount' => 4200,
                'due_amount' => 0,
                'discount_amount' => 0,
                'discount_percentage' => 0,
                'invoice_date' => '2025-01-24',
                'invoice_type' => 'dia',
                'payment_method' => 'Card',
                'created_by' => 1,
                'remarks' => 'Diagnostics Lab Tests',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'invoice_no' => 'DIA-250731-003',
                'patient_id' => $patients[array_rand($patients)],
                'total_amount' => 2800,
                'payable_amount' => 2800,
                'paid_amount' => 1800,
                'due_amount' => 1000,
                'discount_amount' => 0,
                'discount_percentage' => 0,
                'invoice_date' => '2025-01-23',
                'invoice_type' => 'dia',
                'payment_method' => 'Cash',
                'created_by' => 1,
                'remarks' => 'Diagnostics Lab Tests',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'invoice_no' => 'DIA-250731-004',
                'patient_id' => $patients[array_rand($patients)],
                'total_amount' => 5500,
                'payable_amount' => 5500,
                'paid_amount' => 4000,
                'due_amount' => 1500,
                'discount_amount' => 0,
                'discount_percentage' => 0,
                'invoice_date' => '2025-01-22',
                'invoice_type' => 'dia',
                'payment_method' => 'Cash',
                'created_by' => 1,
                'remarks' => 'Diagnostics Lab Tests',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'invoice_no' => 'DIA-250731-005',
                'patient_id' => $patients[array_rand($patients)],
                'total_amount' => 3200,
                'payable_amount' => 3200,
                'paid_amount' => 3200,
                'due_amount' => 0,
                'discount_amount' => 0,
                'discount_percentage' => 0,
                'invoice_date' => '2025-01-21',
                'invoice_type' => 'dia',
                'payment_method' => 'Card',
                'created_by' => 1,
                'remarks' => 'Diagnostics Lab Tests',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'invoice_no' => 'DIA-250731-006',
                'patient_id' => $patients[array_rand($patients)],
                'total_amount' => 4800,
                'payable_amount' => 4800,
                'paid_amount' => 3000,
                'due_amount' => 1800,
                'discount_amount' => 0,
                'discount_percentage' => 0,
                'invoice_date' => '2025-01-20',
                'invoice_type' => 'dia',
                'payment_method' => 'Cash',
                'created_by' => 1,
                'remarks' => 'Diagnostics Lab Tests',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'invoice_no' => 'DIA-250731-007',
                'patient_id' => $patients[array_rand($patients)],
                'total_amount' => 3900,
                'payable_amount' => 3900,
                'paid_amount' => 3900,
                'due_amount' => 0,
                'discount_amount' => 0,
                'discount_percentage' => 0,
                'invoice_date' => '2025-01-19',
                'invoice_type' => 'dia',
                'payment_method' => 'Card',
                'created_by' => 1,
                'remarks' => 'Diagnostics Lab Tests',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'invoice_no' => 'DIA-250731-008',
                'patient_id' => $patients[array_rand($patients)],
                'total_amount' => 2600,
                'payable_amount' => 2600,
                'paid_amount' => 1600,
                'due_amount' => 1000,
                'discount_amount' => 0,
                'discount_percentage' => 0,
                'invoice_date' => '2025-01-18',
                'invoice_type' => 'dia',
                'payment_method' => 'Cash',
                'created_by' => 1,
                'remarks' => 'Diagnostics Lab Tests',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        
        // Insert diagnostics invoices
        $orderCounter = 1;
        foreach ($diagnosticsInvoices as $invoice) {
            $invoiceId = DB::table('invoice')->insertGetId($invoice);
            
            // Create lab test orders for each invoice
            $numTests = rand(2, 4); // 2-4 tests per invoice
            $selectedTests = array_rand($labTests, $numTests);
            
            if (!is_array($selectedTests)) {
                $selectedTests = [$selectedTests];
            }
            
            foreach ($selectedTests as $testIndex) {
                $labTestId = $labTests[$testIndex];
                $charge = rand(300, 800); // Random charge between 300-800
                $status = ['pending', 'completed', 'cancelled'][rand(0, 2)];
                
                DB::table('lab_test_orders')->insert([
                    'order_no' => 'LAB-250731-' . str_pad($orderCounter, 3, '0', STR_PAD_LEFT),
                    'invoice_id' => $invoiceId,
                    'lab_test_id' => $labTestId,
                    'patient_id' => $invoice['patient_id'],
                    'referred_by' => 1,
                    'charge' => $charge,
                    'status' => $status,
                    'collection_date' => '2025-07-31',
                    'collection_time' => '09:00:00',
                    'sample_type' => 'Blood',
                    'created_by' => 1,
                    'updated_by' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                
                $orderCounter++;
            }
        }
        
        $this->command->info('Invoice Return dummy data seeded successfully!');
        $this->command->info('Created ' . count($diagnosticsInvoices) . ' diagnostics invoices with lab test items.');
    }
} 