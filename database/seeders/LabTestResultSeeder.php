<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabTestResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing lab test orders
        $labTestOrders = DB::table('lab_test_orders')->get();
        
        if ($labTestOrders->isEmpty()) {
            $this->command->info('No lab test orders found. Creating sample orders first...');
            $this->createSampleOrders();
            $labTestOrders = DB::table('lab_test_orders')->get();
        }

        // Get lab test parameters
        $parameters = DB::table('lab_test_parameters')->get()->keyBy('id');
        
        foreach ($labTestOrders as $order) {
            // Get parameters for this test
            $testParameters = DB::table('lab_test_parameters')
                ->where('lab_test_id', $order->lab_test_id)
                ->get();

            foreach ($testParameters as $parameter) {
                $this->createResult($order, $parameter);
            }
        }

        $this->command->info('Lab Test Results seeded successfully!');
    }

    private function createSampleOrders()
    {
        // Get some patients and invoices
        $patients = DB::table('patients')->limit(5)->get();
        $invoices = DB::table('invoice')->limit(5)->get();
        $labTests = DB::table('lab_tests')->limit(10)->get();
        $users = DB::table('users')->limit(3)->get();

        if ($patients->isEmpty() || $invoices->isEmpty() || $labTests->isEmpty()) {
            $this->command->warn('Not enough data to create sample orders. Skipping...');
            return;
        }

        $orderCounter = 1;
        foreach ($patients as $patient) {
            foreach ($invoices as $invoice) {
                foreach ($labTests as $labTest) {
                    DB::table('lab_test_orders')->insert([
                        'order_no' => 'LAB-' . date('ymd') . '-' . str_pad($orderCounter, 3, '0', STR_PAD_LEFT),
                        'invoice_id' => $invoice->id,
                        'lab_test_id' => $labTest->id,
                        'patient_id' => $patient->id,
                        'referred_by' => $users->random()->id,
                        'charge' => $labTest->charge,
                        'status' => $this->getRandomStatus(),
                        'collection_date' => now()->subDays(rand(1, 30)),
                        'collection_time' => now()->format('H:i:s'),
                        'sample_type' => $this->getSampleType($labTest->name),
                        'remarks' => $this->getRandomRemarks(),
                        'created_by' => $users->random()->id,
                        'updated_by' => $users->random()->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $orderCounter++;
                }
            }
        }
    }

    private function createResult($order, $parameter)
    {
        $resultValue = $this->generateResultValue($parameter);
        $status = $this->getResultStatus($resultValue, $parameter);
        
        DB::table('lab_test_results')->insert([
            'lab_test_order_id' => $order->id,
            'lab_test_parameter_id' => $parameter->id,
            'result_value' => $resultValue,
            'remarks' => $this->getResultRemarks($status, $parameter),
            'report_date' => now(),
            'checked_by' => 1, // Admin user    
            'incharge_by' => rand(1, 3), // Random second checker incharge
            'referred_by' => rand(1, 3), // Random second checker referred  
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function generateResultValue($parameter)
    {
        $name = strtolower($parameter->name_description);
        $normalValue = $parameter->normal_value;
        $unit = $parameter->unit;

        // Generate realistic values based on parameter type
        if (str_contains($name, 'hemoglobin') || str_contains($name, 'hb')) {
            return rand(10, 18) . '.' . rand(0, 9) . ' ' . $unit;
        }
        
        if (str_contains($name, 'rbc')) {
            return rand(4, 6) . '.' . rand(0, 9) . ' ' . $unit;
        }
        
        if (str_contains($name, 'wbc')) {
            return rand(4000, 12000) . ' ' . $unit;
        }
        
        if (str_contains($name, 'platelets')) {
            return rand(150000, 450000) . ' ' . $unit;
        }
        
        if (str_contains($name, 'glucose')) {
            return rand(70, 140) . ' ' . $unit;
        }
        
        if (str_contains($name, 'cholesterol')) {
            return rand(150, 250) . ' ' . $unit;
        }
        
        if (str_contains($name, 'triglycerides')) {
            return rand(50, 200) . ' ' . $unit;
        }
        
        if (str_contains($name, 'urea')) {
            return rand(7, 25) . ' ' . $unit;
        }
        
        if (str_contains($name, 'creatinine')) {
            return rand(6, 15) . ' ' . $unit;
        }
        
        if (str_contains($name, 'bilirubin')) {
            return rand(3, 12) . ' ' . $unit;
        }
        
        if (str_contains($name, 'sgpt') || str_contains($name, 'sgot')) {
            return rand(8, 50) . ' ' . $unit;
        }
        
        if (str_contains($name, 'tsh')) {
            return rand(1, 5) . '.' . rand(0, 9) . ' ' . $unit;
        }
        
        if (str_contains($name, 't3') || str_contains($name, 't4')) {
            return rand(80, 200) . ' ' . $unit;
        }
        
        if (str_contains($name, 'psa')) {
            return rand(1, 8) . '.' . rand(0, 9) . ' ' . $unit;
        }
        
        if (str_contains($name, 'blood group')) {
            $groups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
            return $groups[array_rand($groups)];
        }
        
        if (str_contains($name, 'rh factor')) {
            return rand(0, 1) ? 'Positive' : 'Negative';
        }
        
        if (str_contains($name, 'color') || str_contains($name, 'appearance')) {
            $options = ['Normal', 'Clear', 'Pale Yellow', 'Yellow', 'Cloudy'];
            return $options[array_rand($options)];
        }
        
        if (str_contains($name, 'protein') || str_contains($name, 'glucose') || str_contains($name, 'ketones') || str_contains($name, 'blood')) {
            return rand(0, 1) ? 'Negative' : 'Trace';
        }
        
        if (str_contains($name, 'ph')) {
            return rand(45, 80) / 10 . ' ' . $unit;
        }
        
        if (str_contains($name, 'specific gravity')) {
            return '1.' . rand(10, 30) . ' ' . $unit;
        }
        
        // Default fallback
        return rand(1, 100) . ' ' . $unit;
    }

    private function getResultStatus($value, $parameter)
    {
        $name = strtolower($parameter->name_description);
        $normalValue = $parameter->normal_value;
        
        // Simple logic to determine if result is normal, high, or low
        if (str_contains($name, 'hemoglobin') || str_contains($name, 'hb')) {
            $value = (float) $value;
            if ($value < 12) return 'low';
            if ($value > 16) return 'high';
            return 'normal';
        }
        
        if (str_contains($name, 'glucose')) {
            $value = (float) $value;
            if ($value < 70) return 'low';
            if ($value > 100) return 'high';
            return 'normal';
        }
        
        if (str_contains($name, 'cholesterol')) {
            $value = (float) $value;
            if ($value > 200) return 'high';
            return 'normal';
        }
        
        if (str_contains($name, 'negative')) {
            return 'normal';
        }
        
        return 'normal'; // Default to normal
    }

    private function getResultRemarks($status, $parameter)
    {
        $name = strtolower($parameter->name_description);
        
        if ($status === 'normal') {
            return 'Result within normal range';
        }
        
        if ($status === 'high') {
            if (str_contains($name, 'glucose')) {
                return 'Elevated glucose levels. Recommend follow-up with physician.';
            }
            if (str_contains($name, 'cholesterol')) {
                return 'Elevated cholesterol. Consider lifestyle modifications.';
            }
            return 'Result above normal range. Clinical correlation recommended.';
        }
        
        if ($status === 'low') {
            if (str_contains($name, 'hemoglobin')) {
                return 'Low hemoglobin. Consider iron supplementation.';
            }
            if (str_contains($name, 'glucose')) {
                return 'Low glucose levels. Monitor for hypoglycemia.';
            }
            return 'Result below normal range. Clinical correlation recommended.';
        }
        
        return 'Result requires clinical interpretation.';
    }

    private function getRandomStatus()
    {
        $statuses = ['pending', 'in_progress', 'completed', 'cancelled'];
        $weights = [20, 30, 45, 5]; // More completed results
        return $statuses[array_rand($statuses)];
    }

    private function getSampleType($testName)
    {
        $name = strtolower($testName);
        
        if (str_contains($name, 'blood') || str_contains($name, 'cbc') || str_contains($name, 'serum')) {
            return 'Blood';
        }
        
        if (str_contains($name, 'urine')) {
            return 'Urine';
        }
        
        if (str_contains($name, 'stool')) {
            return 'Stool';
        }
        
        if (str_contains($name, 'semen')) {
            return 'Semen';
        }
        
        if (str_contains($name, 'pus') || str_contains($name, 'swab')) {
            return 'Swab';
        }
        
        return 'Blood'; // Default
    }

    private function getRandomRemarks()
    {
        $remarks = [
            'Sample collected as per protocol',
            'Patient fasting for 12 hours',
            'Sample collected in morning',
            'Patient advised to avoid strenuous exercise',
            'Sample collected under sterile conditions',
            'Patient reported no recent medications',
            'Sample collected after proper preparation',
            'Patient followed pre-test instructions',
            'Sample collected in appropriate container',
            'Patient reported no recent infections'
        ];
        
        return $remarks[array_rand($remarks)];
    }
} 