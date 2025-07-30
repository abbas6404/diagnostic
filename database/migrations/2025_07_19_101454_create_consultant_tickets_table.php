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
            $table->string('ticket_no')->nullable()->index(); //Ticket No (string every day per doctor from 1 to 999)
            $table->string('ticket_status')->nullable()->index(); //Pending,Completed,Cancelled
            $table->string('ticket_date')->nullable()->index(); //Ticket Date
            $table->string('ticket_time')->nullable()->index(); //Ticket Time
          
            $table->unsignedBigInteger('invoice_id')->nullable()->index(); //Invoice ID
            $table->foreign('invoice_id')->references('id')->on('invoice')->onDelete('cascade');
            $table->unsignedBigInteger('referred_by')->nullable()->index(); //PCP
            $table->foreign('referred_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('patient_id')->index();
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->string('patient_type')->nullable()->index(); //new,old
            $table->unsignedBigInteger('doctor_id')->nullable()->index(); //Doctor
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
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
