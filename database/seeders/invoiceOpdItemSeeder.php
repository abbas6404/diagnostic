<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class invoiceOpdItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //  invoice_id, opd_service_id
        DB::table('invoice_opd_item')->insert([
            'invoice_id' => 1,
            'opd_service_id' => 1,
        ]);
        DB::table('invoice_opd_item')->insert([
            'invoice_id' => 9,
            'opd_service_id' => 2,
        ]);
        DB::table('invoice_opd_item')->insert([
            'invoice_id' => 9,
            'opd_service_id' => 3,
        ]);
        DB::table('invoice_opd_item')->insert([
            'invoice_id' => 9,
            'opd_service_id' => 4,
        ]);
        DB::table('invoice_opd_item')->insert([
            'invoice_id' => 9,
            'opd_service_id' => 5,
        ]);
        DB::table('invoice_opd_item')->insert([
            'invoice_id' => 9,
            'opd_service_id' => 5,
        ]);
        DB::table('invoice_opd_item')->insert([
            'invoice_id' => 9,
            'opd_service_id' => 5,
        ]);
        DB::table('invoice_opd_item')->insert([
            'invoice_id' => 9,
            'opd_service_id' => 5,
        ]);
        DB::table('invoice_opd_item')->insert([
            'invoice_id' => 9,
            'opd_service_id' => 5,
        ]);
        DB::table('invoice_opd_item')->insert([
            'invoice_id' => 9,
            'opd_service_id' => 5,
        ]);
        DB::table('invoice_opd_item')->insert([
            'invoice_id' => 9,
            'opd_service_id' => 5,
        ]);
        DB::table('invoice_opd_item')->insert([
            'invoice_id' => 9,
            'opd_service_id' => 5,
        ]);
        DB::table('invoice_opd_item')->insert([
            'invoice_id' => 9,
            'opd_service_id' => 5,
        ]);
        DB::table('invoice_opd_item')->insert([
            'invoice_id' => 9,
            'opd_service_id' => 5,
        ]);
        DB::table('invoice_opd_item')->insert([
            'invoice_id' => 9,
            'opd_service_id' => 5,
        ]);
        DB::table('invoice_opd_item')->insert([
            'invoice_id' => 9,
            'opd_service_id' => 5,
        ]);

        DB::table('invoice_opd_item')->insert([
            'invoice_id' => 10,
            'opd_service_id' => 1,
        ]);
        DB::table('invoice_opd_item')->insert([
            'invoice_id' => 10,
            'opd_service_id' => 2,
        ]);
        DB::table('invoice_opd_item')->insert([
            'invoice_id' => 10,
            'opd_service_id' => 3,
        ]);
        DB::table('invoice_opd_item')->insert([
            'invoice_id' => 10,
            'opd_service_id' => 4,
        ]);
        DB::table('invoice_opd_item')->insert([
            'invoice_id' => 10,
            'opd_service_id' => 5,
        ]);
        DB::table('invoice_opd_item')->insert([
            'invoice_id' => 11,
            'opd_service_id' => 1,
        ]);
        DB::table('invoice_opd_item')->insert([
            'invoice_id' => 11,
            'opd_service_id' => 2,
        ]);
    }
}
