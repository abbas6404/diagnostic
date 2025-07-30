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
        Schema::create('invoice_returns', function (Blueprint $table) {
            $table->id();
            $table->string('return_no')->unique()->index(); // RET-yymmdd-001
            $table->unsignedBigInteger('invoice_id')->index();
            $table->foreign('invoice_id')->references('id')->on('invoice')->onDelete('cascade');
            $table->unsignedBigInteger('patient_id')->index();
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->enum('return_type', ['full', 'partial', 'item_specific'])->default('full')->index();
            $table->decimal('return_amount', 10, 2)->default(0);
           
            
            $table->text('return_reason')->nullable();
            $table->text('admin_remarks')->nullable();
            $table->date('return_date')->nullable();
            $table->time('return_time')->nullable();
            $table->unsignedBigInteger('returned_by')->nullable()->index(); // Who initiated return
            $table->foreign('returned_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('approved_by')->nullable()->index(); // Who approved return
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('processed_by')->nullable()->index(); // Who processed refund
            $table->foreign('processed_by')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('invoice_returns');
    }
};
