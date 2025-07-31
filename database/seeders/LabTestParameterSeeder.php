<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabTestParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get lab test IDs
        $labTests = DB::table('lab_tests')->get()->keyBy('code');
        
        // CBC Parameters
        $this->seedCBCParameters($labTests['BT-001']->id);
        
        // Lipid Profile Parameters
        $this->seedLipidProfileParameters($labTests['BT-037']->id);
        
        // Liver Function Parameters
        $this->seedLiverFunctionParameters($labTests['BT-031']->id);
        
        // Kidney Function Parameters
        $this->seedKidneyFunctionParameters($labTests['BT-038']->id);
        $this->seedKidneyFunctionParameters($labTests['BT-039']->id);
        
        // Thyroid Function Parameters
        $this->seedThyroidFunctionParameters($labTests['BT-052']->id);
        
        // Diabetes Parameters
        $this->seedDiabetesParameters($labTests['BT-027']->id);
        $this->seedDiabetesParameters($labTests['BT-028']->id);
        $this->seedDiabetesParameters($labTests['BT-025']->id);
        
        // Cardiac Markers
        $this->seedCardiacMarkers($labTests['BT-019']->id);
        $this->seedCardiacMarkers($labTests['BT-046']->id);
        
        // Tumor Markers
        $this->seedTumorMarkers($labTests['BT-047']->id);
        $this->seedTumorMarkers($labTests['BT-048']->id);
        
        // Urine Analysis Parameters
        $this->seedUrineAnalysisParameters($labTests['UR-001']->id);
        
        // Blood Group Parameters
        $this->seedBloodGroupParameters($labTests['BT-010']->id);
        
        // Pregnancy Test Parameters
        $this->seedPregnancyTestParameters($labTests['BT-021']->id);
        
        // PSA Parameters
        $this->seedPSAParameters($labTests['BT-023']->id);
        
        // Semen Analysis Parameters
        $this->seedSemenAnalysisParameters($labTests['BT-058']->id);

        $this->command->info('Lab Test Parameters seeded successfully!');
    }

    private function seedCBCParameters($labTestId)
    {
        $parameters = [
            ['name_description' => 'Hemoglobin (Hb)', 'unit' => 'g/dL', 'normal_value' => '12-16', 'sort_order' => 1],
            ['name_description' => 'Red Blood Cells (RBC)', 'unit' => 'million/μL', 'normal_value' => '4.5-5.5', 'sort_order' => 2],
            ['name_description' => 'White Blood Cells (WBC)', 'unit' => 'cells/μL', 'normal_value' => '4000-11000', 'sort_order' => 3],
            ['name_description' => 'Platelets', 'unit' => 'cells/μL', 'normal_value' => '150000-450000', 'sort_order' => 4],
            ['name_description' => 'Hematocrit (HCT)', 'unit' => '%', 'normal_value' => '36-46', 'sort_order' => 5],
            ['name_description' => 'Mean Corpuscular Volume (MCV)', 'unit' => 'fL', 'normal_value' => '80-100', 'sort_order' => 6],
            ['name_description' => 'Mean Corpuscular Hemoglobin (MCH)', 'unit' => 'pg', 'normal_value' => '27-32', 'sort_order' => 7],
            ['name_description' => 'Mean Corpuscular Hemoglobin Concentration (MCHC)', 'unit' => '%', 'normal_value' => '32-36', 'sort_order' => 8],
            ['name_description' => 'Red Cell Distribution Width (RDW)', 'unit' => '%', 'normal_value' => '11.5-14.5', 'sort_order' => 9],
            ['name_description' => 'Neutrophils', 'unit' => '%', 'normal_value' => '40-70', 'sort_order' => 10],
            ['name_description' => 'Lymphocytes', 'unit' => '%', 'normal_value' => '20-40', 'sort_order' => 11],
            ['name_description' => 'Monocytes', 'unit' => '%', 'normal_value' => '2-8', 'sort_order' => 12],
            ['name_description' => 'Eosinophils', 'unit' => '%', 'normal_value' => '1-4', 'sort_order' => 13],
            ['name_description' => 'Basophils', 'unit' => '%', 'normal_value' => '0-1', 'sort_order' => 14],
        ];

        $this->insertParameters($labTestId, $parameters);
    }

    private function seedLipidProfileParameters($labTestId)
    {
        $parameters = [
            ['name_description' => 'Total Cholesterol', 'unit' => 'mg/dL', 'normal_value' => '<200', 'sort_order' => 1],
            ['name_description' => 'HDL Cholesterol', 'unit' => 'mg/dL', 'normal_value' => '>40', 'sort_order' => 2],
            ['name_description' => 'LDL Cholesterol', 'unit' => 'mg/dL', 'normal_value' => '<100', 'sort_order' => 3],
            ['name_description' => 'Triglycerides', 'unit' => 'mg/dL', 'normal_value' => '<150', 'sort_order' => 4],
            ['name_description' => 'VLDL Cholesterol', 'unit' => 'mg/dL', 'normal_value' => '5-40', 'sort_order' => 5],
            ['name_description' => 'Cholesterol/HDL Ratio', 'unit' => '', 'normal_value' => '<5', 'sort_order' => 6],
        ];

        $this->insertParameters($labTestId, $parameters);
    }

    private function seedLiverFunctionParameters($labTestId)
    {
        $parameters = [
            ['name_description' => 'SGOT (AST)', 'unit' => 'U/L', 'normal_value' => '8-40', 'sort_order' => 1],
            ['name_description' => 'SGPT (ALT)', 'unit' => 'U/L', 'normal_value' => '7-56', 'sort_order' => 2],
            ['name_description' => 'Alkaline Phosphatase', 'unit' => 'U/L', 'normal_value' => '44-147', 'sort_order' => 3],
            ['name_description' => 'Total Bilirubin', 'unit' => 'mg/dL', 'normal_value' => '0.3-1.2', 'sort_order' => 4],
            ['name_description' => 'Direct Bilirubin', 'unit' => 'mg/dL', 'normal_value' => '0.1-0.3', 'sort_order' => 5],
            ['name_description' => 'Indirect Bilirubin', 'unit' => 'mg/dL', 'normal_value' => '0.2-0.9', 'sort_order' => 6],
            ['name_description' => 'Total Protein', 'unit' => 'g/dL', 'normal_value' => '6.0-8.3', 'sort_order' => 7],
            ['name_description' => 'Albumin', 'unit' => 'g/dL', 'normal_value' => '3.4-5.4', 'sort_order' => 8],
            ['name_description' => 'Globulin', 'unit' => 'g/dL', 'normal_value' => '2.0-3.5', 'sort_order' => 9],
            ['name_description' => 'A/G Ratio', 'unit' => '', 'normal_value' => '1.1-2.2', 'sort_order' => 10],
        ];

        $this->insertParameters($labTestId, $parameters);
    }

    private function seedKidneyFunctionParameters($labTestId)
    {
        $parameters = [
            ['name_description' => 'Urea', 'unit' => 'mg/dL', 'normal_value' => '7-20', 'sort_order' => 1],
            ['name_description' => 'Creatinine', 'unit' => 'mg/dL', 'normal_value' => '0.6-1.2', 'sort_order' => 2],
            ['name_description' => 'Uric Acid', 'unit' => 'mg/dL', 'normal_value' => '3.4-7.0', 'sort_order' => 3],
            ['name_description' => 'BUN', 'unit' => 'mg/dL', 'normal_value' => '6-20', 'sort_order' => 4],
            ['name_description' => 'BUN/Creatinine Ratio', 'unit' => '', 'normal_value' => '10-20', 'sort_order' => 5],
        ];

        $this->insertParameters($labTestId, $parameters);
    }

    private function seedThyroidFunctionParameters($labTestId)
    {
        $parameters = [
            ['name_description' => 'T3 (Triiodothyronine)', 'unit' => 'ng/dL', 'normal_value' => '80-200', 'sort_order' => 1],
            ['name_description' => 'T4 (Thyroxine)', 'unit' => 'μg/dL', 'normal_value' => '4.5-12.0', 'sort_order' => 2],
            ['name_description' => 'TSH (Thyroid Stimulating Hormone)', 'unit' => 'μIU/mL', 'normal_value' => '0.4-4.0', 'sort_order' => 3],
        ];

        $this->insertParameters($labTestId, $parameters);
    }

    private function seedDiabetesParameters($labTestId)
    {
        $parameters = [
            ['name_description' => 'Glucose', 'unit' => 'mg/dL', 'normal_value' => '70-100', 'sort_order' => 1],
            ['name_description' => 'HbA1c', 'unit' => '%', 'normal_value' => '<5.7', 'sort_order' => 2],
        ];

        $this->insertParameters($labTestId, $parameters);
    }

    private function seedCardiacMarkers($labTestId)
    {
        $parameters = [
            ['name_description' => 'Troponin I', 'unit' => 'ng/mL', 'normal_value' => '<0.04', 'sort_order' => 1],
            ['name_description' => 'CK-MB', 'unit' => 'ng/mL', 'normal_value' => '<5.0', 'sort_order' => 2],
        ];

        $this->insertParameters($labTestId, $parameters);
    }

    private function seedTumorMarkers($labTestId)
    {
        $parameters = [
            ['name_description' => 'CA 19-9', 'unit' => 'U/mL', 'normal_value' => '<37', 'sort_order' => 1],
            ['name_description' => 'CA 125', 'unit' => 'U/mL', 'normal_value' => '<35', 'sort_order' => 2],
        ];

        $this->insertParameters($labTestId, $parameters);
    }

    private function seedUrineAnalysisParameters($labTestId)
    {
        $parameters = [
            ['name_description' => 'Color', 'unit' => '', 'normal_value' => 'Pale Yellow', 'sort_order' => 1],
            ['name_description' => 'Appearance', 'unit' => '', 'normal_value' => 'Clear', 'sort_order' => 2],
            ['name_description' => 'Specific Gravity', 'unit' => '', 'normal_value' => '1.005-1.030', 'sort_order' => 3],
            ['name_description' => 'pH', 'unit' => '', 'normal_value' => '4.5-8.0', 'sort_order' => 4],
            ['name_description' => 'Protein', 'unit' => '', 'normal_value' => 'Negative', 'sort_order' => 5],
            ['name_description' => 'Glucose', 'unit' => '', 'normal_value' => 'Negative', 'sort_order' => 6],
            ['name_description' => 'Ketones', 'unit' => '', 'normal_value' => 'Negative', 'sort_order' => 7],
            ['name_description' => 'Blood', 'unit' => '', 'normal_value' => 'Negative', 'sort_order' => 8],
            ['name_description' => 'Leukocytes', 'unit' => '', 'normal_value' => 'Negative', 'sort_order' => 9],
            ['name_description' => 'Nitrites', 'unit' => '', 'normal_value' => 'Negative', 'sort_order' => 10],
            ['name_description' => 'RBCs', 'unit' => '/HPF', 'normal_value' => '0-3', 'sort_order' => 11],
            ['name_description' => 'WBCs', 'unit' => '/HPF', 'normal_value' => '0-5', 'sort_order' => 12],
            ['name_description' => 'Epithelial Cells', 'unit' => '/HPF', 'normal_value' => '0-5', 'sort_order' => 13],
            ['name_description' => 'Casts', 'unit' => '/LPF', 'normal_value' => '0-2', 'sort_order' => 14],
            ['name_description' => 'Crystals', 'unit' => '', 'normal_value' => 'None', 'sort_order' => 15],
        ];

        $this->insertParameters($labTestId, $parameters);
    }

    private function seedBloodGroupParameters($labTestId)
    {
        $parameters = [
            ['name_description' => 'Blood Group', 'unit' => '', 'normal_value' => 'A/B/AB/O', 'sort_order' => 1],
            ['name_description' => 'Rh Factor', 'unit' => '', 'normal_value' => 'Positive/Negative', 'sort_order' => 2],
        ];

        $this->insertParameters($labTestId, $parameters);
    }

    private function seedPregnancyTestParameters($labTestId)
    {
        $parameters = [
            ['name_description' => 'β-hCG', 'unit' => 'mIU/mL', 'normal_value' => '<5 (Non-pregnant)', 'sort_order' => 1],
        ];

        $this->insertParameters($labTestId, $parameters);
    }

    private function seedPSAParameters($labTestId)
    {
        $parameters = [
            ['name_description' => 'PSA Total', 'unit' => 'ng/mL', 'normal_value' => '<4.0', 'sort_order' => 1],
            ['name_description' => 'PSA Free', 'unit' => 'ng/mL', 'normal_value' => '<1.0', 'sort_order' => 2],
            ['name_description' => 'Free/Total PSA Ratio', 'unit' => '%', 'normal_value' => '>25', 'sort_order' => 3],
        ];

        $this->insertParameters($labTestId, $parameters);
    }

    private function seedSemenAnalysisParameters($labTestId)
    {
        $parameters = [
            ['name_description' => 'Volume', 'unit' => 'mL', 'normal_value' => '1.5-6.0', 'sort_order' => 1],
            ['name_description' => 'pH', 'unit' => '', 'normal_value' => '7.2-8.0', 'sort_order' => 2],
            ['name_description' => 'Liquefaction Time', 'unit' => 'minutes', 'normal_value' => '<60', 'sort_order' => 3],
            ['name_description' => 'Sperm Count', 'unit' => 'million/mL', 'normal_value' => '>15', 'sort_order' => 4],
            ['name_description' => 'Total Motility', 'unit' => '%', 'normal_value' => '>40', 'sort_order' => 5],
            ['name_description' => 'Progressive Motility', 'unit' => '%', 'normal_value' => '>32', 'sort_order' => 6],
            ['name_description' => 'Morphology', 'unit' => '%', 'normal_value' => '>4', 'sort_order' => 7],
            ['name_description' => 'Vitality', 'unit' => '%', 'normal_value' => '>58', 'sort_order' => 8],
            ['name_description' => 'WBCs', 'unit' => 'million/mL', 'normal_value' => '<1', 'sort_order' => 9],
        ];

        $this->insertParameters($labTestId, $parameters);
    }

    private function insertParameters($labTestId, $parameters)
    {
        foreach ($parameters as $parameter) {
            $parameter['lab_test_id'] = $labTestId;
            $parameter['created_by'] = 1;
            $parameter['updated_by'] = 1;
            
            DB::table('lab_test_parameters')->insert($parameter);
        }
    }
} 