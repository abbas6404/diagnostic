<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lab_test_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->index();
            $table->unsignedBigInteger('lab_test_id')->index();
            $table->unsignedBigInteger('lab_test_parameter_id')->index();
            $table->string('result_value'); // The actual test result value
            $table->text('remarks')->nullable(); // Additional notes about the result
            $table->unsignedBigInteger('lab_incharge_id')->nullable(); // User who performed the test
            $table->unsignedBigInteger('doctor_report_id')->nullable(); // User who verified the result
            $table->unsignedBigInteger('verified_by')->nullable(); // User who verified the result

            $table->timestamp('verified_at')->nullable();
            $table->timestamp('tested_at')->nullable();
            $table->string('status')->default('pending'); // pending, tested, verified, reported, cancelled
            $table->timestamps();
            
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('lab_test_id')->references('id')->on('lab_tests')->onDelete('cascade');
            $table->foreign('lab_test_parameter_id')->references('id')->on('lab_test_parameters')->onDelete('cascade');
            $table->foreign('lab_incharge_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('doctor_report_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_test_results');
    }
};
