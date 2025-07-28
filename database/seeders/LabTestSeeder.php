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
            ['code' => 'BT-001', 'name' => 'CBC', 'description' => 'Complete Blood Count', 'charge' => '500'],
            ['code' => 'BT-002', 'name' => 'BT, CT', 'description' => 'Bleeding Time, Clotting Time', 'charge' => '400'],
            ['code' => 'BT-003', 'name' => 'PBF', 'description' => 'Peripheral Blood Film', 'charge' => '600'],
            ['code' => 'BT-004', 'name' => 'Prothrombin Time', 'description' => 'Prothrombin Time Test', 'charge' => '1200'],
            ['code' => 'BT-005', 'name' => 'Widal test', 'description' => 'Widal Test', 'charge' => '700'],
            ['code' => 'BT-006', 'name' => 'ASO / RA', 'description' => 'Anti-Streptolysin O / Rheumatoid Arthritis', 'charge' => '800'],
            ['code' => 'BT-007', 'name' => 'CRP', 'description' => 'C-Reactive Protein', 'charge' => '800'],
            ['code' => 'BT-008', 'name' => 'TPHA', 'description' => 'Treponema Pallidum Hemagglutination Assay', 'charge' => '800'],
            ['code' => 'BT-009', 'name' => 'VDRL', 'description' => 'Venereal Disease Research Laboratory', 'charge' => '600'],
            ['code' => 'BT-010', 'name' => 'Blood Group & Rh Factor', 'description' => 'Blood Group and Rh Factor Test', 'charge' => '100'],
            ['code' => 'BT-011', 'name' => 'ICT for Dengue', 'description' => 'ICT for Dengue (IgE + IgM + NS1)', 'charge' => '900'],
            ['code' => 'BT-012', 'name' => 'ICT for Chikungunyia', 'description' => 'ICT for Chikungunyia', 'charge' => '900'],
            ['code' => 'BT-013', 'name' => 'ICT for TB', 'description' => 'ICT for Tuberculosis', 'charge' => '800'],
            ['code' => 'BT-014', 'name' => 'ICT for MP / Kala-azor', 'description' => 'ICT for Malaria Parasite / Kala-azar', 'charge' => '800'],
            ['code' => 'BT-015', 'name' => 'ICT for H. Pylori', 'description' => 'ICT for Helicobacter Pylori', 'charge' => '1200'],
            ['code' => 'BT-016', 'name' => 'Anti-HCV', 'description' => 'Anti-Hepatitis C Virus', 'charge' => '1200'],
            ['code' => 'BT-017', 'name' => 'Hbs Ag', 'description' => 'Hepatitis B Surface Antigen', 'charge' => '500'],
            ['code' => 'BT-018', 'name' => 'Hbs Ag (Elisa)', 'description' => 'Hepatitis B Surface Antigen (Elisa)', 'charge' => '1300'],
            ['code' => 'BT-019', 'name' => 'S. Troponin I', 'description' => 'Serum Troponin I', 'charge' => '1000'],
            ['code' => 'BT-020', 'name' => 'Total IgE / IgM', 'description' => 'Total Immunoglobulin E / M', 'charge' => '1200'],
            ['code' => 'BT-021', 'name' => 'β-hcg', 'description' => 'Beta Human Chorionic Gonadotropin', 'charge' => '1500'],
            ['code' => 'BT-022', 'name' => 'S. HEV', 'description' => 'Serum Hepatitis E Virus', 'charge' => '1200'],
            ['code' => 'BT-023', 'name' => 'S. PSA', 'description' => 'Serum Prostate Specific Antigen', 'charge' => '1400'],
            ['code' => 'BT-024', 'name' => 'APTT', 'description' => 'Activated Partial Thromboplastin Time', 'charge' => '1400'],
            ['code' => 'BT-025', 'name' => 'HBA1c', 'description' => 'Glycated Hemoglobin', 'charge' => '1200'],
            ['code' => 'BT-026', 'name' => 'S. Total Protein', 'description' => 'Serum Total Protein', 'charge' => '1200'],
            ['code' => 'BT-027', 'name' => 'Fasting Blood Sugar', 'description' => 'Fasting Blood Sugar Test', 'charge' => '150'],
            ['code' => 'BT-028', 'name' => 'Random Blood Sugar', 'description' => 'Random Blood Sugar Test', 'charge' => '150'],
            ['code' => 'BT-029', 'name' => '2 hrs ABF / 75gm Glucose', 'description' => '2 Hours After Breakfast / 75gm Glucose', 'charge' => '250'],
            ['code' => 'BT-030', 'name' => 'OGTT', 'description' => 'Oral Glucose Tolerance Test', 'charge' => '350'],
            ['code' => 'BT-031', 'name' => 'SGOT / SGPT', 'description' => 'Serum Glutamic Oxaloacetic Transaminase / Serum Glutamic Pyruvic Transaminase', 'charge' => '600'],
            ['code' => 'BT-032', 'name' => 'S. Bilirubin Total', 'description' => 'Serum Total Bilirubin', 'charge' => '500'],
            ['code' => 'BT-033', 'name' => 'S. Bilirubin Direct / Indirect', 'description' => 'Serum Direct / Indirect Bilirubin', 'charge' => '800'],
            ['code' => 'BT-034', 'name' => 'S. Uric Acid', 'description' => 'Serum Uric Acid', 'charge' => '600'],
            ['code' => 'BT-035', 'name' => 'S. Acid Phosphate / S. Alk. Phosphate', 'description' => 'Serum Acid Phosphatase / Alkaline Phosphatase', 'charge' => '1000'],
            ['code' => 'BT-036', 'name' => 'S. Amylase', 'description' => 'Serum Amylase', 'charge' => '1200'],
            ['code' => 'BT-037', 'name' => 'Lipid Profile', 'description' => 'Lipid Profile Test', 'charge' => '1400'],
            ['code' => 'BT-038', 'name' => 'S. Urea', 'description' => 'Serum Urea', 'charge' => '600'],
            ['code' => 'BT-039', 'name' => 'S. Creatinine', 'description' => 'Serum Creatinine', 'charge' => '500'],
            ['code' => 'BT-040', 'name' => 'S. BUN', 'description' => 'Serum Blood Urea Nitrogen', 'charge' => '500'],
            ['code' => 'BT-041', 'name' => 'S. Calcium', 'description' => 'Serum Calcium', 'charge' => '1200'],
            ['code' => 'BT-042', 'name' => 'S. Albumin', 'description' => 'Serum Albumin', 'charge' => '700'],
            ['code' => 'BT-043', 'name' => 'Electrolytes', 'description' => 'Electrolytes Test', 'charge' => '1200'],
            ['code' => 'BT-044', 'name' => 'S. Lipase', 'description' => 'Serum Lipase', 'charge' => '1500'],
            ['code' => 'BT-045', 'name' => 'Vitamin D', 'description' => 'Vitamin D Test', 'charge' => '3500'],
            ['code' => 'BT-046', 'name' => 'CK-MB', 'description' => 'Creatine Kinase-MB', 'charge' => '1800'],
            ['code' => 'BT-047', 'name' => 'Ca 19-9', 'description' => 'Cancer Antigen 19-9', 'charge' => '2000'],
            ['code' => 'BT-048', 'name' => 'Ca 125', 'description' => 'Cancer Antigen 125', 'charge' => '2500'],
            ['code' => 'BT-049', 'name' => 'S. Electroporosis', 'description' => 'Serum Electrophoresis', 'charge' => '2500'],
            ['code' => 'BT-050', 'name' => 'HLA-B27', 'description' => 'Human Leukocyte Antigen B27', 'charge' => '6000'],
            ['code' => 'BT-051', 'name' => 'Anti-CCP', 'description' => 'Anti-Cyclic Citrullinated Peptide', 'charge' => '3000'],
            ['code' => 'BT-052', 'name' => 'T3 / T4 / TSH', 'description' => 'Triiodothyronine / Thyroxine / Thyroid Stimulating Hormone', 'charge' => '1000'],
            ['code' => 'BT-053', 'name' => 'FT3 / FT4 / FSH / LH', 'description' => 'Free T3 / Free T4 / Follicle Stimulating Hormone / Luteinizing Hormone', 'charge' => '1500'],
            ['code' => 'BT-054', 'name' => 'S. Prolactin / Testosterone', 'description' => 'Serum Prolactin / Testosterone', 'charge' => '1500'],
            ['code' => 'BT-055', 'name' => 'Ferritin', 'description' => 'Ferritin Test', 'charge' => '2000'],
            ['code' => 'BT-056', 'name' => 'D-Dimer', 'description' => 'D-Dimer Test', 'charge' => '2000'],
            ['code' => 'BT-057', 'name' => 'MT (Montux Test)', 'description' => 'Montux Test', 'charge' => '600'],
            ['code' => 'BT-058', 'name' => 'Semen Analysis', 'description' => 'Semen Analysis', 'charge' => '1500'],
            ['code' => 'BT-059', 'name' => 'P. S for Gram Stain / HVS for Gram Stain', 'description' => 'Prostatic Secretion / High Vaginal Swab for Gram Stain', 'charge' => '1200'],
        ];

        // Microbiology (C/S) Department Tests (department_id: 2)
        $microbiologyTests = [
            ['code' => 'MC-001', 'name' => 'Blood for C/S', 'description' => 'Blood for Culture and Sensitivity', 'charge' => '2000'],
            ['code' => 'MC-002', 'name' => 'Pus for C/S', 'description' => 'Pus for Culture and Sensitivity', 'charge' => '1000'],
            ['code' => 'MC-003', 'name' => 'Swab for C/S', 'description' => 'Swab for Culture and Sensitivity', 'charge' => '1000'],
            ['code' => 'MC-004', 'name' => 'Urine for C/S', 'description' => 'Urine for Culture and Sensitivity', 'charge' => '1000'],
            ['code' => 'MC-005', 'name' => 'Stool for C/S', 'description' => 'Stool for Culture and Sensitivity', 'charge' => '1000'],
            ['code' => 'MC-006', 'name' => 'Discharge fluid C/S', 'description' => 'Discharge fluid for Culture and Sensitivity', 'charge' => '1000'],
        ];

        // Histopathology / Cytology Test Department (department_id: 3)
        $histopathologyTests = [
            ['code' => 'HP-001', 'name' => 'FNAC (Single Site)', 'description' => 'Fine Needle Aspiration Cytology (Single Site)', 'charge' => '2000'],
            ['code' => 'HP-002', 'name' => 'FNAC (Double site)', 'description' => 'Fine Needle Aspiration Cytology (Double Site)', 'charge' => '3500'],
            ['code' => 'HP-003', 'name' => 'USG Guided FNAC', 'description' => 'Ultrasound Guided Fine Needle Aspiration Cytology', 'charge' => '4500'],
        ];

        // URINE Department Tests (department_id: 5)
        $urineTests = [
            ['code' => 'UR-001', 'name' => 'Urine for R/M/E', 'description' => 'Urine for Routine Microscopic Examination', 'charge' => '500'],
            ['code' => 'UR-002', 'name' => 'Urine Analysis', 'description' => 'Urine Analysis', 'charge' => '500'],
            ['code' => 'UR-003', 'name' => 'Urine for CUS', 'description' => 'Urine for Culture and Sensitivity', 'charge' => '400'],
            ['code' => 'UR-004', 'name' => 'Urine for pregnancy Test', 'description' => 'Urine for Pregnancy Test', 'charge' => '200'],
            ['code' => 'UR-005', 'name' => 'Dope Test (ICT)', 'description' => 'Dope Test (ICT)', 'charge' => '1500'],
        ];

        // X-RAY Department Tests (department_id: 6)
        $xrayTests = [
            ['code' => 'XR-001', 'name' => 'X-Ray Chest P/A View / Lateral View', 'description' => 'X-Ray Chest Posterior-Anterior / Lateral View', 'charge' => '600'],
            ['code' => 'XR-002', 'name' => 'X-Ray KUB Region', 'description' => 'X-Ray Kidney, Ureter, Bladder Region', 'charge' => '600'],
            ['code' => 'XR-003', 'name' => 'X-Ray Abdomen in E/P', 'description' => 'X-Ray Abdomen in Erect/Prone', 'charge' => '600'],
            ['code' => 'XR-004', 'name' => 'X-Ray PNS (O.M View)', 'description' => 'X-Ray Paranasal Sinuses (Occipitomental View)', 'charge' => '800'],
            ['code' => 'XR-005', 'name' => 'X-Ray PNS B/View', 'description' => 'X-Ray Paranasal Sinuses Both Views', 'charge' => '1200'],
            ['code' => 'XR-006', 'name' => 'X-Ray Skull B/View', 'description' => 'X-Ray Skull Both Views', 'charge' => '1200'],
            ['code' => 'XR-007', 'name' => 'X-Ray Mastoids Twins View', 'description' => 'X-Ray Mastoids Twins View', 'charge' => '1200'],
            ['code' => 'XR-008', 'name' => 'X-Ray Nasopharynx L/View', 'description' => 'X-Ray Nasopharynx Lateral View', 'charge' => '800'],
            ['code' => 'XR-009', 'name' => 'X-Ray Mandible L/View', 'description' => 'X-Ray Mandible Lateral View', 'charge' => '800'],
            ['code' => 'XR-010', 'name' => 'X-Ray Neck / Nose B/View', 'description' => 'X-Ray Neck / Nose Both Views', 'charge' => '1200'],
            ['code' => 'XR-011', 'name' => 'X-Ray Cervical Spine B/ View', 'description' => 'X-Ray Cervical Spine Both Views', 'charge' => '1000'],
            ['code' => 'XR-012', 'name' => 'X-Ray Dorsal Spine B/ View', 'description' => 'X-Ray Dorsal Spine Both Views', 'charge' => '1000'],
            ['code' => 'XR-013', 'name' => 'X-Ray Lumber Spine B/ View', 'description' => 'X-Ray Lumbar Spine Both Views', 'charge' => '1000'],
            ['code' => 'XR-014', 'name' => 'X-Ray Lumbo Sacral Spine B/ View', 'description' => 'X-Ray Lumbo Sacral Spine Both Views', 'charge' => '1000'],
            ['code' => 'XR-015', 'name' => 'X-Ray Hip Joint B/ View', 'description' => 'X-Ray Hip Joint Both Views', 'charge' => '1200'],
            ['code' => 'XR-016', 'name' => 'X-Ray Wrist Joint/ Elbow Joint B/ View', 'description' => 'X-Ray Wrist Joint/ Elbow Joint Both Views', 'charge' => '800'],
            ['code' => 'XR-017', 'name' => 'X-Ray Arm / Forearm B/ View', 'description' => 'X-Ray Arm / Forearm Both Views', 'charge' => '800'],
            ['code' => 'XR-018', 'name' => 'X-Ray Humorous B/ View', 'description' => 'X-Ray Humerus Both Views', 'charge' => '800'],
            ['code' => 'XR-019', 'name' => 'X-Ray Hand B/ View', 'description' => 'X-Ray Hand Both Views', 'charge' => '800'],
            ['code' => 'XR-020', 'name' => 'X-Ray Shoulder Joint B/ View', 'description' => 'X-Ray Shoulder Joint Both Views', 'charge' => '1200'],
            ['code' => 'XR-021', 'name' => 'X-Ray Ankle Joint / Knee Joint B/V', 'description' => 'X-Ray Ankle Joint / Knee Joint Both Views', 'charge' => '1200'],
            ['code' => 'XR-022', 'name' => 'X-Ray Leg / Thigh B/V', 'description' => 'X-Ray Leg / Thigh Both Views', 'charge' => '1200'],
            ['code' => 'XR-023', 'name' => 'X-Ray Soft Tissue of Neck', 'description' => 'X-Ray Soft Tissue of Neck', 'charge' => '700'],
            ['code' => 'XR-024', 'name' => 'X-Ray Ba-meal Stomach & Duodenum', 'description' => 'X-Ray Barium Meal Stomach & Duodenum', 'charge' => '2500'],
            ['code' => 'XR-025', 'name' => 'X-Ray Ba-swallow of Oesophagus', 'description' => 'X-Ray Barium Swallow of Oesophagus', 'charge' => '2500'],
            ['code' => 'XR-026', 'name' => 'X-Ray Ba-Meal Follow Through', 'description' => 'X-Ray Barium Meal Follow Through', 'charge' => '4000'],
            ['code' => 'XR-027', 'name' => 'X-Ray Ba-Enema of Large Gut', 'description' => 'X-Ray Barium Enema of Large Gut', 'charge' => '4000'],
            ['code' => 'XR-028', 'name' => 'X-Ray Fistulogram / Sinogram', 'description' => 'X-Ray Fistulogram / Sinogram', 'charge' => '4000'],
            ['code' => 'XR-029', 'name' => 'X-Ray Styloid Process B/V', 'description' => 'X-Ray Styloid Process Both Views', 'charge' => '1200'],
            ['code' => 'XR-030', 'name' => 'X-Ray IVU without Medicine', 'description' => 'X-Ray Intravenous Urogram without Medicine', 'charge' => '4500'],
            ['code' => 'XR-031', 'name' => 'X-Ray Cystogram without Medicine', 'description' => 'X-Ray Cystogram without Medicine', 'charge' => '3500'],
            ['code' => 'XR-032', 'name' => 'X-Ray Retrograde Cystourethrogram', 'description' => 'X-Ray Retrograde Cystourethrogram', 'charge' => '3500'],
            ['code' => 'XR-033', 'name' => 'X-Ray Urethrogram without Medicine', 'description' => 'X-Ray Urethrogram without Medicine', 'charge' => '3500'],
        ];

        // ULTRASONOGRAM Department Tests (department_id: 7)
        $ultrasonogramTests = [
            ['code' => 'US-001', 'name' => 'Whole Abdomen', 'description' => 'Whole Abdomen Ultrasonogram', 'charge' => '1500'],
            ['code' => 'US-002', 'name' => 'HBS / Upper Abdomen', 'description' => 'Hepatobiliary System / Upper Abdomen', 'charge' => '1200'],
            ['code' => 'US-003', 'name' => 'KUB Region', 'description' => 'Kidney, Ureter, Bladder Region', 'charge' => '1200'],
            ['code' => 'US-004', 'name' => 'Lower Abdomen / Pelvic Organs', 'description' => 'Lower Abdomen / Pelvic Organs', 'charge' => '1200'],
            ['code' => 'US-005', 'name' => 'Pregnancy Profile / Uterus & Adnexa', 'description' => 'Pregnancy Profile / Uterus & Adnexa', 'charge' => '1000'],
            ['code' => 'US-006', 'name' => 'Thyroid Gland', 'description' => 'Thyroid Gland Ultrasonogram', 'charge' => '2400'],
            ['code' => 'US-007', 'name' => 'Both Breast', 'description' => 'Both Breast Ultrasonogram', 'charge' => '2400'],
            ['code' => 'US-008', 'name' => 'Right / Left Breast (Single)', 'description' => 'Right / Left Breast (Single)', 'charge' => '1500'],
            ['code' => 'US-009', 'name' => 'Testis / Scrotum', 'description' => 'Testis / Scrotum Ultrasonogram', 'charge' => '2500'],
            ['code' => 'US-010', 'name' => 'KUB + Prostate + PVR', 'description' => 'KUB + Prostate + Post Void Residual', 'charge' => '1500'],
            ['code' => 'US-011', 'name' => 'TVS', 'description' => 'Transvaginal Sonography', 'charge' => '2000'],
            ['code' => 'US-012', 'name' => 'Soft Tissue', 'description' => 'Soft Tissue Ultrasonogram', 'charge' => '3000'],
            ['code' => 'US-013', 'name' => 'Doppler study of Lymph', 'description' => 'Doppler study of Lymph', 'charge' => '3000'],
        ];

        // Endoscopy/Colonoscopy Department Tests (department_id: 8)
        $endoscopyTests = [
            ['code' => 'EN-001', 'name' => 'Endoscopy', 'description' => 'Endoscopy', 'charge' => '2000'],
            ['code' => 'EN-002', 'name' => 'Colonoscopy', 'description' => 'Colonoscopy', 'charge' => '5000'],
            ['code' => 'EN-003', 'name' => 'Short Colonoscopy', 'description' => 'Short Colonoscopy', 'charge' => '4000'],
            ['code' => 'EN-004', 'name' => 'Proctoscopy', 'description' => 'Proctoscopy', 'charge' => '2000'],
            ['code' => 'EN-005', 'name' => 'Polypectomy', 'description' => 'Polypectomy', 'charge' => '13000'],
        ];

        // ECG Department Tests (department_id: 9)
        $ecgTests = [
            ['code' => 'EC-001', 'name' => 'ECG (12+ ch)', 'description' => 'Electrocardiogram (12+ channels)', 'charge' => '500'],
            ['code' => 'EC-002', 'name' => 'ECG (6 ch)', 'description' => 'Electrocardiogram (6 channels)', 'charge' => '400'],
            ['code' => 'EC-003', 'name' => 'ECG (3 ch)', 'description' => 'Electrocardiogram (3 channels)', 'charge' => '300'],
        ];

        // ECHO Cardiogram Department Tests (department_id: 10)
        $echoTests = [
            ['code' => 'ECH-001', 'name' => 'Echocardiogram', 'description' => 'Echocardiogram', 'charge' => '2500'],
            ['code' => 'ECH-002', 'name' => 'Echocardiogram (Child)', 'description' => 'Echocardiogram (Child)', 'charge' => '3000'],
            ['code' => 'ECH-003', 'name' => 'ETT', 'description' => 'Exercise Tolerance Test', 'charge' => '2500'],
        ];

        // MRI / CT Scan Department Tests (department_id: 4)
        $mriCtTests = [
            ['code' => 'MRI-001', 'name' => 'MRI of Brain', 'description' => 'Magnetic Resonance Imaging of Brain', 'charge' => '6500'],
            ['code' => 'MRI-002', 'name' => 'MRI of Chest', 'description' => 'Magnetic Resonance Imaging of Chest', 'charge' => '7500'],
            ['code' => 'MRI-003', 'name' => 'MRI of Spine', 'description' => 'Magnetic Resonance Imaging of Spine', 'charge' => '10000'],
            ['code' => 'MRI-004', 'name' => 'MRI of Whole Abdomen', 'description' => 'Magnetic Resonance Imaging of Whole Abdomen', 'charge' => '15000'],
            ['code' => 'CT-001', 'name' => 'CT Scan of Brain', 'description' => 'Computed Tomography Scan of Brain', 'charge' => '3000'],
            ['code' => 'CT-002', 'name' => 'CT Scan of Chest Screening', 'description' => 'Computed Tomography Scan of Chest Screening', 'charge' => '5000'],
            ['code' => 'CT-003', 'name' => 'CT Scan of Whole Abdomen', 'description' => 'Computed Tomography Scan of Whole Abdomen', 'charge' => '12000'],
            ['code' => 'CT-004', 'name' => 'CT Scan of KUB Region', 'description' => 'Computed Tomography Scan of KUB Region', 'charge' => '12000'],
        ];

        // Stool Tests (department_id: 5 - URINE department, but these are stool tests)
        $stoolTests = [
            ['code' => 'ST-001', 'name' => 'Stool for R/M/E', 'description' => 'Stool for Routine Microscopic Examination', 'charge' => '500'],
            ['code' => 'ST-002', 'name' => 'Stool OBT/Reducing Substance', 'description' => 'Stool Occult Blood Test/Reducing Substance', 'charge' => '600'],
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
                'name' => $test['name'],
                'description' => $test['description'],
                'charge' => $test['charge'],
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
}
