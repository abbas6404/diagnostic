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
            $table->unsignedBigInteger('lab_test_order_id')->index();
            $table->foreign('lab_test_order_id')->references('id')->on('lab_test_orders')->onDelete('cascade');
            $table->unsignedBigInteger('lab_test_parameter_id')->index();
            $table->foreign('lab_test_parameter_id')->references('id')->on('lab_test_parameters')->onDelete('cascade');
            $table->string('result_value')->nullable();
            $table->text('remarks')->nullable();
            $table->enum('status', ['pending', 'tested', 'verified', 'reported', 'completed'])->default('pending');
            $table->date('report_date')->nullable();
            $table->unsignedBigInteger('incharge_by')->nullable()->index();
            $table->foreign('incharge_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('checked_by')->nullable()->index();
            $table->foreign('checked_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('referred_by')->nullable()->index();
            $table->foreign('referred_by')->references('id')->on('users')->onDelete('cascade');
        
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
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