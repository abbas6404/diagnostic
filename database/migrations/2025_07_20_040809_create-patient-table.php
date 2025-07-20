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
            $table->date('reg_date');
            $table->string('name_en')->nullable()->index();
            $table->string('name_bn')->nullable()->index();
            $table->string('father_husband_name_en')->nullable()->index();
            $table->string('address')->nullable();
            // $table->string('upazila_id');
            $table->string('phone')->nullable()->index();
            $table->string('email')->nullable()->index();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('religion')->nullable();
            $table->string('occupation')->nullable();
            $table->decimal('reg_fee', 10, 2)->nullable();
            $table->string('nationality')->nullable();
            $table->string('patient_type')->nullable();
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
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
