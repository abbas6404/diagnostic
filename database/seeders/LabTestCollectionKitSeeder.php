<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabTestCollectionKitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get collection kits
        $bloodKits = DB::table('collection_kits')
            ->whereIn('name', ['Needle', 'Red', 'LAVENDER', 'Light Blue', 'Gray', 'Green', 'MS Needle 22g', 'MS Needle 23g', 'Universal Holder', 'RED-IMMU'])
            ->pluck('id')
            ->toArray();

        $urineKits = DB::table('collection_kits')
            ->where('name', 'Urine Container')
            ->pluck('id')
            ->toArray();

        $stoolKits = DB::table('collection_kits')
            ->where('name', 'Stool Container')
            ->pluck('id')
            ->toArray();

        $sputumKits = DB::table('collection_kits')
            ->where('name', 'Sputum Container')
            ->pluck('id')
            ->toArray();

        $semenKits = DB::table('collection_kits')
            ->where('name', 'Semen Container')
            ->pluck('id')
            ->toArray();

        $tissueKits = DB::table('collection_kits')
            ->where('name', 'TISSUE')
            ->pluck('id')
            ->toArray();

        $swabKits = DB::table('collection_kits')
            ->where('name', 'Stick')
            ->pluck('id')
            ->toArray();

        $specimenKits = DB::table('collection_kits')
            ->where('name', 'Specimen Container')
            ->pluck('id')
            ->toArray();

        // Blood tests (PATHOLOGY department - BT-001 to BT-059)
        $bloodTests = DB::table('lab_tests')
            ->where('code', 'like', 'BT-%')
            ->pluck('id')
            ->toArray();

        // Urine tests (URINE department - UR-001 to UR-005)
        $urineTests = DB::table('lab_tests')
            ->where('code', 'like', 'UR-%')
            ->pluck('id')
            ->toArray();

        // Stool tests (ST-001 to ST-002)
        $stoolTests = DB::table('lab_tests')
            ->where('code', 'like', 'ST-%')
            ->pluck('id')
            ->toArray();

        // Semen analysis (BT-058)
        $semenTests = DB::table('lab_tests')
            ->where('code', 'BT-058')
            ->pluck('id')
            ->toArray();

        // Microbiology tests that might need swabs (MC-003)
        $swabTests = DB::table('lab_tests')
            ->where('code', 'MC-003')
            ->pluck('id')
            ->toArray();

        // Histopathology tests (HP-001 to HP-003)
        $tissueTests = DB::table('lab_tests')
            ->where('code', 'like', 'HP-%')
            ->pluck('id')
            ->toArray();

        // Microbiology tests that need specimen containers (MC-001, MC-002, MC-004, MC-005, MC-006)
        $specimenTests = DB::table('lab_tests')
            ->whereIn('code', ['MC-001', 'MC-002', 'MC-004', 'MC-005', 'MC-006'])
            ->pluck('id')
            ->toArray();

        // Link blood tests with blood collection kits
        foreach ($bloodTests as $testId) {
            foreach ($bloodKits as $kitId) {
                DB::table('lab_test_collection_kit')->insert([
                    'lab_test_id' => $testId,
                    'collection_kit_id' => $kitId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Link urine tests with urine collection kits
        foreach ($urineTests as $testId) {
            foreach ($urineKits as $kitId) {
                DB::table('lab_test_collection_kit')->insert([
                    'lab_test_id' => $testId,
                    'collection_kit_id' => $kitId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Link stool tests with stool collection kits
        foreach ($stoolTests as $testId) {
            foreach ($stoolKits as $kitId) {
                DB::table('lab_test_collection_kit')->insert([
                    'lab_test_id' => $testId,
                    'collection_kit_id' => $kitId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Link semen tests with semen collection kits
        foreach ($semenTests as $testId) {
            foreach ($semenKits as $kitId) {
                DB::table('lab_test_collection_kit')->insert([
                    'lab_test_id' => $testId,
                    'collection_kit_id' => $kitId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Link swab tests with swab collection kits
        foreach ($swabTests as $testId) {
            foreach ($swabKits as $kitId) {
                DB::table('lab_test_collection_kit')->insert([
                    'lab_test_id' => $testId,
                    'collection_kit_id' => $kitId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Link tissue tests with tissue collection kits
        foreach ($tissueTests as $testId) {
            foreach ($tissueKits as $kitId) {
                DB::table('lab_test_collection_kit')->insert([
                    'lab_test_id' => $testId,
                    'collection_kit_id' => $kitId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Link specimen tests with specimen collection kits
        foreach ($specimenTests as $testId) {
            foreach ($specimenKits as $kitId) {
                DB::table('lab_test_collection_kit')->insert([
                    'lab_test_id' => $testId,
                    'collection_kit_id' => $kitId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
