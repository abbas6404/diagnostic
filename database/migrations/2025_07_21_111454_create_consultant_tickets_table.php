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
        Schema::create('consultant_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_no')->unique()->index();
            $table->string('ticket_status')->nullable()->index();
            $table->string('ticket_date')->nullable()->index();
            $table->string('ticket_time')->nullable()->index();
            $table->string('doctor_fee')->nullable()->index();
            $table->unsignedBigInteger('patient_id')->index();
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->string('patient_type')->nullable()->index(); //new,old
            $table->unsignedBigInteger('doctor_id')->index();
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('invoice_id')->index();
            $table->foreign('invoice_id')->references('id')->on('invoice')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultant_tickets');
    }
};
