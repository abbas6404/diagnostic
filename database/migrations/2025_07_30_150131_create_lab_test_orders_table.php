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
        Schema::create('lab_test_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->unique()->index(); // LAB-yymmdd-001
            $table->unsignedBigInteger('invoice_id')->index();
            $table->foreign('invoice_id')->references('id')->on('invoice')->onDelete('cascade');
            $table->unsignedBigInteger('lab_test_id')->index();
            $table->foreign('lab_test_id')->references('id')->on('lab_tests')->onDelete('cascade');
            $table->unsignedBigInteger('patient_id')->index();
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->unsignedBigInteger('referred_by')->nullable()->index(); // Doctor who referred
            $table->foreign('referred_by')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('charge', 10, 2)->default(0);
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending')->index();
            $table->date('collection_date')->nullable();
            $table->time('collection_time')->nullable();
            $table->string('sample_type')->nullable(); // Blood, Urine, etc.
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('lab_test_orders');
    }
}; 