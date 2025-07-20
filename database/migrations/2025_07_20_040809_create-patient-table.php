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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('patient_id')->unique()->index();
            $table->string('reg_date');
            $table->string('name_en')->nullable()->index();
            $table->string('name_bn')->nullable()->index();
            $table->string('father_husband_name_en')->nullable()->index();
            $table->string('address')->nullable();
            // $table->string('upazila_id');
            $table->string('phone')->nullable()->index();
            $table->string('email')->nullable()->index();
            $table->string('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('religion')->nullable();
            $table->string('occupation')->nullable();
            $table->string('reg_fee')->nullable();
            $table->string('nationality')->nullable();
            $table->string('patient_type')->nullable();
            $table->string('created_by')->nullable()->index();
            $table->string('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
