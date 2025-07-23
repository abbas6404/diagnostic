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
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique()->index(); //Invoice No (INV-yymmdd-001)
            $table->unsignedBigInteger('patient_id')->index(); //Patient
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->decimal('total_amount', 10, 2)->default(0); //Total Amount
            $table->decimal('paid_amount', 10, 2)->default(0); //Paid Amount
            $table->decimal('due_amount', 10, 2)->default(0); //Due Amount
            $table->decimal('discount_amount', 10, 2)->default(0); //Discount Amount
            $table->decimal('discount_percentage', 10, 2)->default(0); //Discount Percentage    
            $table->decimal('payable_amount', 10, 2)->default(0); //Payable Amount
            $table->date('invoice_date')->nullable()->index(); //Invoice Date
            $table->string('invoice_type')->nullable()->index(); //consultant,lab,pharmacy,opd,ipd
            $table->unsignedBigInteger('consultant_ticket_id')->nullable()->index(); //Consultant Ticket ID
            $table->foreign('consultant_ticket_id')->references('id')->on('consultant_tickets')->onDelete('cascade');
            $table->string('payment_method')->nullable(); //Payment Method
            $table->unsignedBigInteger('created_by')->nullable()->index(); //Created By
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->nullable(); //Updated By
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps(); //Created At, Updated At  
            $table->softDeletes(); //Deleted At
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice');
    }
};
