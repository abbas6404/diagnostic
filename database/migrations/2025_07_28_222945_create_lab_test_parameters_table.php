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
        Schema::create('lab_test_parameters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lab_test_id')->index();
            $table->string('parameter_key')->index(); // e.g., "hemoglobin", "wbc_count", "platelet_count"
            $table->string('parameter_name'); // e.g., "Hemoglobin", "WBC Count", "Platelet Count"
            $table->string('unit')->nullable(); // e.g., "gm/dl", "/cmm", "mg/dl"
            $table->string('reference_range')->nullable(); // e.g., "12-18 gm/dl", "4000-11000 /cmm"
            $table->string('status')->default('active'); // active, inactive
            $table->timestamps();
            
            $table->foreign('lab_test_id')->references('id')->on('lab_tests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_test_parameters');
    }
};
