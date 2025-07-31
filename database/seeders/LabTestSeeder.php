<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // PATHOLOGY Department Tests (department_id: 1)
        $pathologyTests = [
            ['code' => 'BT-001', 'name' => 'CBC', 'charge' => '500'],
            ['code' => 'BT-002', 'name' => 'BT, CT', 'charge' => '400'],
            ['code' => 'BT-003', 'name' => 'PBF', 'charge' => '600'],
            ['code' => 'BT-004', 'name' => 'Prothrombin Time', 'charge' => '1200'],
            ['code' => 'BT-005', 'name' => 'Widal test', 'charge' => '700'],
            ['code' => 'BT-006', 'name' => 'ASO / RA', 'charge' => '800'],
            ['code' => 'BT-007', 'name' => 'CRP', 'charge' => '800'],
            ['code' => 'BT-008', 'name' => 'TPHA', 'charge' => '800'],
            ['code' => 'BT-009', 'name' => 'VDRL', 'charge' => '600'],
            ['code' => 'BT-010', 'name' => 'Blood Group & Rh Factor', 'charge' => '100'],
            ['code' => 'BT-011', 'name' => 'ICT for Dengue', 'charge' => '900'],
            ['code' => 'BT-012', 'name' => 'ICT for Chikungunyia', 'charge' => '900'],
            ['code' => 'BT-013', 'name' => 'ICT for TB', 'charge' => '800'],
            ['code' => 'BT-014', 'name' => 'ICT for MP / Kala-azor', 'charge' => '800'],
            ['code' => 'BT-015', 'name' => 'ICT for H. Pylori', 'charge' => '1200'],
            ['code' => 'BT-016', 'name' => 'Anti-HCV', 'charge' => '1200'],
            ['code' => 'BT-017', 'name' => 'Hbs Ag', 'charge' => '500'],
            ['code' => 'BT-018', 'name' => 'Hbs Ag (Elisa)', 'charge' => '1300'],
            ['code' => 'BT-019', 'name' => 'S. Troponin I', 'charge' => '1000'],
            ['code' => 'BT-020', 'name' => 'Total IgE / IgM', 'charge' => '1200'],
            ['code' => 'BT-021', 'name' => 'β-hcg', 'charge' => '1500'],
            ['code' => 'BT-022', 'name' => 'S. HEV', 'charge' => '1200'],
            ['code' => 'BT-023', 'name' => 'S. PSA', 'charge' => '1400'],
            ['code' => 'BT-024', 'name' => 'APTT', 'charge' => '1400'],
            ['code' => 'BT-025', 'name' => 'HBA1c', 'charge' => '1200'],
            ['code' => 'BT-026', 'name' => 'S. Total Protein', 'charge' => '1200'],
            ['code' => 'BT-027', 'name' => 'Fasting Blood Sugar', 'charge' => '150'],
            ['code' => 'BT-028', 'name' => 'Random Blood Sugar', 'charge' => '150'],
            ['code' => 'BT-029', 'name' => '2 hrs ABF / 75gm Glucose', 'charge' => '250'],
            ['code' => 'BT-030', 'name' => 'OGTT', 'charge' => '350'],
            ['code' => 'BT-031', 'name' => 'SGOT / SGPT', 'charge' => '600'],
            ['code' => 'BT-032', 'name' => 'S. Bilirubin Total', 'charge' => '500'],
            ['code' => 'BT-033', 'name' => 'S. Bilirubin Direct / Indirect', 'charge' => '800'],
            ['code' => 'BT-034', 'name' => 'S. Uric Acid', 'charge' => '600'],
            ['code' => 'BT-035', 'name' => 'S. Acid Phosphate / S. Alk. Phosphate', 'charge' => '1000'],
            ['code' => 'BT-036', 'name' => 'S. Amylase', 'charge' => '1200'],
            ['code' => 'BT-037', 'name' => 'Lipid Profile', 'charge' => '1400'],
            ['code' => 'BT-038', 'name' => 'S. Urea', 'charge' => '600'],
            ['code' => 'BT-039', 'name' => 'S. Creatinine', 'charge' => '500'],
            ['code' => 'BT-040', 'name' => 'S. BUN', 'charge' => '500'],
            ['code' => 'BT-041', 'name' => 'S. Calcium', 'charge' => '1200'],
            ['code' => 'BT-042', 'name' => 'S. Albumin', 'charge' => '700'],
            ['code' => 'BT-043', 'name' => 'Electrolytes', 'charge' => '1200'],
            ['code' => 'BT-044', 'name' => 'S. Lipase', 'charge' => '1500'],
            ['code' => 'BT-045', 'name' => 'Vitamin D', 'charge' => '3500'],
            ['code' => 'BT-046', 'name' => 'CK-MB', 'charge' => '1800'],
            ['code' => 'BT-047', 'name' => 'Ca 19-9', 'charge' => '2000'],
            ['code' => 'BT-048', 'name' => 'Ca 125', 'charge' => '2500'],
            ['code' => 'BT-049', 'name' => 'S. Electroporosis', 'charge' => '2500'],
            ['code' => 'BT-050', 'name' => 'HLA-B27', 'charge' => '6000'],
            ['code' => 'BT-051', 'name' => 'Anti-CCP', 'charge' => '3000'],
            ['code' => 'BT-052', 'name' => 'T3 / T4 / TSH', 'charge' => '1000'],
            ['code' => 'BT-053', 'name' => 'FT3 / FT4 / FSH / LH', 'charge' => '1500'],
            ['code' => 'BT-054', 'name' => 'S. Prolactin / Testosterone', 'charge' => '1500'],
            ['code' => 'BT-055', 'name' => 'Ferritin', 'charge' => '2000'],
            ['code' => 'BT-056', 'name' => 'D-Dimer', 'charge' => '2000'],
            ['code' => 'BT-057', 'name' => 'MT (Montux Test)', 'charge' => '600'],
            ['code' => 'BT-058', 'name' => 'Semen Analysis', 'charge' => '1500'],
            ['code' => 'BT-059', 'name' => 'P. S for Gram Stain / HVS for Gram Stain', 'charge' => '1200'],
        ];

        // Microbiology (C/S) Department Tests (department_id: 2)
        $microbiologyTests = [
            ['code' => 'MC-001', 'name' => 'Blood for C/S', 'charge' => '2000'],
            ['code' => 'MC-002', 'name' => 'Pus for C/S', 'charge' => '1000'],
            ['code' => 'MC-003', 'name' => 'Swab for C/S', 'charge' => '1000'],
            ['code' => 'MC-004', 'name' => 'Urine for C/S', 'charge' => '1000'],
            ['code' => 'MC-005', 'name' => 'Stool for C/S', 'charge' => '1000'],
            ['code' => 'MC-006', 'name' => 'Discharge fluid C/S', 'charge' => '1000'],
        ];

        // Histopathology / Cytology Test Department (department_id: 3)
        $histopathologyTests = [
            ['code' => 'HP-001', 'name' => 'FNAC (Single Site)', 'charge' => '2000'],
            ['code' => 'HP-002', 'name' => 'FNAC (Double site)', 'charge' => '3500'],
            ['code' => 'HP-003', 'name' => 'USG Guided FNAC', 'charge' => '4500'],
        ];

        // URINE Department Tests (department_id: 5)
        $urineTests = [
            ['code' => 'UR-001', 'name' => 'Urine for R/M/E', 'charge' => '500'],
            ['code' => 'UR-002', 'name' => 'Urine Analysis', 'charge' => '500'],
            ['code' => 'UR-003', 'name' => 'Urine for CUS', 'charge' => '400'],
            ['code' => 'UR-004', 'name' => 'Urine for Culture', 'charge' => '400'],
            ['code' => 'UR-005', 'name' => 'Urine for Pregnancy Test', 'charge' => '400'],
            ['code' => 'UR-006', 'name' => 'Urine for Albumin', 'charge' => '400'],
            ['code' => 'UR-007', 'name' => 'Urine for Sugar', 'charge' => '400'],
            ['code' => 'UR-008', 'name' => 'Urine for Ketone', 'charge' => '400'],
            ['code' => 'UR-009', 'name' => 'Urine for Bile Salt', 'charge' => '400'],
            ['code' => 'UR-010', 'name' => 'Urine for Bile Pigment', 'charge' => '400'],
            ['code' => 'UR-011', 'name' => 'Urine for Urobilinogen', 'charge' => '400'],
            ['code' => 'UR-012', 'name' => 'Urine for Nitrite', 'charge' => '400'],
            ['code' => 'UR-013', 'name' => 'Urine for Leukocyte', 'charge' => '400'],
            ['code' => 'UR-014', 'name' => 'Urine for Blood', 'charge' => '400'],
            ['code' => 'UR-015', 'name' => 'Urine for Specific Gravity', 'charge' => '400'],
            ['code' => 'UR-016', 'name' => 'Urine for pH', 'charge' => '400'],
            ['code' => 'UR-017', 'name' => 'Urine for Color', 'charge' => '400'],
            ['code' => 'UR-018', 'name' => 'Urine for Appearance', 'charge' => '400'],
            ['code' => 'UR-019', 'name' => 'Urine for Cast', 'charge' => '400'],
            ['code' => 'UR-020', 'name' => 'Urine for Crystal', 'charge' => '400'],
            ['code' => 'UR-021', 'name' => 'Urine for Epithelial Cell', 'charge' => '400'],
            ['code' => 'UR-022', 'name' => 'Urine for RBC', 'charge' => '400'],
            ['code' => 'UR-023', 'name' => 'Urine for WBC', 'charge' => '400'],
            ['code' => 'UR-024', 'name' => 'Urine for Bacteria', 'charge' => '400'],
            ['code' => 'UR-025', 'name' => 'Urine for Yeast', 'charge' => '400'],
            ['code' => 'UR-026', 'name' => 'Urine for Parasite', 'charge' => '400'],
            ['code' => 'UR-027', 'name' => 'Urine for Fat', 'charge' => '400'],
            ['code' => 'UR-028', 'name' => 'Urine for Mucus', 'charge' => '400'],
            ['code' => 'UR-029', 'name' => 'Urine for Sperm', 'charge' => '400'],
            ['code' => 'UR-030', 'name' => 'Urine for Chyle', 'charge' => '400'],
        ];

        // X-RAY Department Tests (department_id: 6)
        $xrayTests = [
            ['code' => 'XR-001', 'name' => 'Chest X-Ray (PA View)', 'charge' => '300'],
            ['code' => 'XR-002', 'name' => 'Chest X-Ray (AP View)', 'charge' => '300'],
            ['code' => 'XR-003', 'name' => 'Chest X-Ray (Lateral View)', 'charge' => '300'],
            ['code' => 'XR-004', 'name' => 'Chest X-Ray (Oblique View)', 'charge' => '300'],
            ['code' => 'XR-005', 'name' => 'Chest X-Ray (Decubitus View)', 'charge' => '300'],
            ['code' => 'XR-006', 'name' => 'Chest X-Ray (Lordotic View)', 'charge' => '300'],
            ['code' => 'XR-007', 'name' => 'Chest X-Ray (Expiratory View)', 'charge' => '300'],
            ['code' => 'XR-008', 'name' => 'Chest X-Ray (Inspiratory View)', 'charge' => '300'],
            ['code' => 'XR-009', 'name' => 'Chest X-Ray (PA + Lateral)', 'charge' => '500'],
            ['code' => 'XR-010', 'name' => 'Chest X-Ray (PA + Lateral + Oblique)', 'charge' => '700'],
            ['code' => 'XR-011', 'name' => 'Chest X-Ray (PA + Lateral + Oblique + Decubitus)', 'charge' => '900'],
            ['code' => 'XR-012', 'name' => 'Chest X-Ray (PA + Lateral + Oblique + Decubitus + Lordotic)', 'charge' => '1100'],
            ['code' => 'XR-013', 'name' => 'Chest X-Ray (PA + Lateral + Oblique + Decubitus + Lordotic + Expiratory)', 'charge' => '1300'],
            ['code' => 'XR-014', 'name' => 'Chest X-Ray (PA + Lateral + Oblique + Decubitus + Lordotic + Expiratory + Inspiratory)', 'charge' => '1500'],
            ['code' => 'XR-015', 'name' => 'Chest X-Ray (PA + Lateral + Oblique + Decubitus + Lordotic + Expiratory + Inspiratory + PA)', 'charge' => '1700'],
            ['code' => 'XR-016', 'name' => 'Chest X-Ray (PA + Lateral + Oblique + Decubitus + Lordotic + Expiratory + Inspiratory + PA + Lateral)', 'charge' => '1900'],
            ['code' => 'XR-017', 'name' => 'Chest X-Ray (PA + Lateral + Oblique + Decubitus + Lordotic + Expiratory + Inspiratory + PA + Lateral + Oblique)', 'charge' => '2100'],
            ['code' => 'XR-018', 'name' => 'Chest X-Ray (PA + Lateral + Oblique + Decubitus + Lordotic + Expiratory + Inspiratory + PA + Lateral + Oblique + Decubitus)', 'charge' => '2300'],
            ['code' => 'XR-019', 'name' => 'Chest X-Ray (PA + Lateral + Oblique + Decubitus + Lordotic + Expiratory + Inspiratory + PA + Lateral + Oblique + Decubitus + Lordotic)', 'charge' => '2500'],
            ['code' => 'XR-020', 'name' => 'Chest X-Ray (PA + Lateral + Oblique + Decubitus + Lordotic + Expiratory + Inspiratory + PA + Lateral + Oblique + Decubitus + Lordotic + Expiratory)', 'charge' => '2700'],
        ];

        // ULTRASONOGRAM Department Tests (department_id: 7)
        $ultrasonogramTests = [
            ['code' => 'US-001', 'name' => 'Whole Abdomen', 'charge' => '2000'],
            ['code' => 'US-002', 'name' => 'KUB Region', 'charge' => '1500'],
            ['code' => 'US-003', 'name' => 'Pelvis', 'charge' => '1500'],
            ['code' => 'US-004', 'name' => 'Pregnancy (USG)', 'charge' => '1500'],
            ['code' => 'US-005', 'name' => 'Echo Cardiogram', 'charge' => '2500'],
            ['code' => 'US-006', 'name' => 'Thyroid Gland', 'charge' => '2400'],
            ['code' => 'US-007', 'name' => 'Both Breast', 'charge' => '2400'],
            ['code' => 'US-008', 'name' => 'Right / Left Breast (Single)', 'charge' => '1500'],
            ['code' => 'US-009', 'name' => 'Testis / Scrotum', 'charge' => '2500'],
            ['code' => 'US-010', 'name' => 'KUB + Prostate + PVR', 'charge' => '1500'],
            ['code' => 'US-011', 'name' => 'TVS', 'charge' => '2000'],
            ['code' => 'US-012', 'name' => 'Soft Tissue', 'charge' => '3000'],
            ['code' => 'US-013', 'name' => 'Doppler study of Lymph', 'charge' => '3000'],
        ];

        // Endoscopy/Colonoscopy Department Tests (department_id: 8)
        $endoscopyTests = [
            ['code' => 'EN-001', 'name' => 'Endoscopy', 'charge' => '2000'],
            ['code' => 'EN-002', 'name' => 'Colonoscopy', 'charge' => '5000'],
            ['code' => 'EN-003', 'name' => 'Short Colonoscopy', 'charge' => '4000'],
            ['code' => 'EN-004', 'name' => 'Proctoscopy', 'charge' => '2000'],
            ['code' => 'EN-005', 'name' => 'Polypectomy', 'charge' => '13000'],
        ];

        // ECG Department Tests (department_id: 9)
        $ecgTests = [
            ['code' => 'EC-001', 'name' => 'ECG (12+ ch)', 'charge' => '500'],
            ['code' => 'EC-002', 'name' => 'ECG (6 ch)', 'charge' => '400'],
            ['code' => 'EC-003', 'name' => 'ECG (3 ch)', 'charge' => '300'],
        ];

        // ECHO Cardiogram Department Tests (department_id: 10)
        $echoTests = [
            ['code' => 'ECH-001', 'name' => 'Echocardiogram', 'charge' => '2500'],
            ['code' => 'ECH-002', 'name' => 'Echocardiogram (Child)', 'charge' => '3000'],
            ['code' => 'ECH-003', 'name' => 'ETT', 'charge' => '2500'],
        ];

        // MRI / CT Scan Department Tests (department_id: 4)
        $mriCtTests = [
            ['code' => 'MRI-001', 'name' => 'MRI of Brain', 'charge' => '6500'],
            ['code' => 'MRI-002', 'name' => 'MRI of Chest', 'charge' => '7500'],
            ['code' => 'MRI-003', 'name' => 'MRI of Spine', 'charge' => '10000'],
            ['code' => 'MRI-004', 'name' => 'MRI of Whole Abdomen', 'charge' => '15000'],
            ['code' => 'CT-001', 'name' => 'CT Scan of Brain', 'charge' => '3000'],
            ['code' => 'CT-002', 'name' => 'CT Scan of Chest Screening', 'charge' => '5000'],
            ['code' => 'CT-003', 'name' => 'CT Scan of Whole Abdomen', 'charge' => '12000'],
            ['code' => 'CT-004', 'name' => 'CT Scan of KUB Region', 'charge' => '12000'],
        ];

        // Stool Tests (department_id: 5 - URINE department, but these are stool tests)
        $stoolTests = [
            ['code' => 'ST-001', 'name' => 'Stool for R/M/E', 'charge' => '500'],
            ['code' => 'ST-002', 'name' => 'Stool OBT/Reducing Substance', 'charge' => '600'],
        ];

        // Insert all tests
        $allTests = array_merge(
            $pathologyTests,
            $microbiologyTests,
            $histopathologyTests,
            $urineTests,
            $xrayTests,
            $ultrasonogramTests,
            $endoscopyTests,
            $ecgTests,
            $echoTests,
            $mriCtTests,
            $stoolTests
        );

        $id = 1;
        foreach ($allTests as $test) {
            DB::table('lab_tests')->insert([
                'id' => $id++,
                'code' => $test['code'],
                'department_id' => $this->getDepartmentId($test['code']),
                'category_id' => $this->getCategoryId($test['code']),
                'name' => $test['name'],
                'charge' => $test['charge'],
                'created_by' => 1,
                'updated_by' => 1,
            ]);
        }
    }

    private function getDepartmentId($code)
    {
        $prefix = substr($code, 0, 2);
        switch ($prefix) {
            case 'BT': return 1; // PATHOLOGY
            case 'MC': return 2; // Microbiology (C/S)
            case 'HP': return 3; // Histopathology / Cytology Test
            case 'MRI':
            case 'CT': return 4; // MRI / CT Scan
            case 'UR': return 5; // URINE
            case 'XR': return 6; // X-RAY
            case 'US': return 7; // ULTRASONOGRAM
            case 'EN': return 8; // Endoscopy/Colonoscopy
            case 'EC': return 9; // ECG
            case 'ECH': return 10; // ECHO Cardiogram
            case 'ST': return 5; // Stool tests (using URINE department)
            default: return 1; // Default to PATHOLOGY
        }
    }

    private function getCategoryId($code)
    {
        $prefix = substr($code, 0, 2);
        switch ($prefix) {
            case 'BT':
                // Blood tests - assign to appropriate categories
                if (in_array($code, ['BT-001'])) return 1; // Blood Tests (CBC)
                if (in_array($code, ['BT-027', 'BT-028', 'BT-025'])) return 2; // Biochemistry (Diabetes)
                if (in_array($code, ['BT-031', 'BT-032', 'BT-033'])) return 2; // Biochemistry (Liver)
                if (in_array($code, ['BT-038', 'BT-039'])) return 2; // Biochemistry (Kidney)
                if (in_array($code, ['BT-037'])) return 2; // Biochemistry (Lipid)
                if (in_array($code, ['BT-052', 'BT-053', 'BT-054'])) return 7; // Hormone Tests
                if (in_array($code, ['BT-019', 'BT-046'])) return 9; // Cardiac Markers
                if (in_array($code, ['BT-047', 'BT-048'])) return 8; // Tumor Markers
                if (in_array($code, ['BT-004', 'BT-024'])) return 11; // Coagulation Tests
                if (in_array($code, ['BT-043'])) return 12; // Electrolytes
                if (in_array($code, ['BT-005', 'BT-006', 'BT-007', 'BT-008', 'BT-009', 'BT-011', 'BT-012', 'BT-013', 'BT-014', 'BT-015', 'BT-016', 'BT-017', 'BT-018', 'BT-022'])) return 10; // Infectious Diseases
                if (in_array($code, ['BT-010'])) return 1; // Blood Tests (Blood Group)
                if (in_array($code, ['BT-021'])) return 7; // Hormone Tests (Pregnancy)
                if (in_array($code, ['BT-023'])) return 8; // Tumor Markers (PSA)
                if (in_array($code, ['BT-058'])) return 7; // Hormone Tests (Semen)
                return 1; // Default to Blood Tests
            case 'MC': return 4; // Microbiology
            case 'HP': return 5; // Histopathology
            case 'UR': return 6; // Urine Analysis
            case 'ST': return 6; // Stool tests (using Urine Analysis category)
            case 'XR': return null; // X-Ray (no specific category)
            case 'US': return null; // Ultrasonogram (no specific category)
            case 'EN': return null; // Endoscopy (no specific category)
            case 'EC': return 9; // Cardiac Markers
            case 'ECH': return 9; // Cardiac Markers
            case 'MRI':
            case 'CT': return null; // Imaging (no specific category)
            default: return null;
        }
    }
}
