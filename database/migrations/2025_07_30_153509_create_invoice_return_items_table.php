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
        Schema::create('invoice_return_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_return_id')->index();
            $table->foreign('invoice_return_id')->references('id')->on('invoice_returns')->onDelete('cascade');
            $table->unsignedBigInteger('lab_test_order_id')->nullable()->index(); // For lab test returns
            $table->foreign('lab_test_order_id')->references('id')->on('lab_test_orders')->onDelete('cascade');
            $table->unsignedBigInteger('opd_service_id')->nullable()->index(); // For OPD service returns
            $table->foreign('opd_service_id')->references('id')->on('opd_services')->onDelete('cascade');
            $table->unsignedBigInteger('consultant_ticket_id')->nullable()->index(); // For consultant service returns
            $table->foreign('consultant_ticket_id')->references('id')->on('consultant_tickets')->onDelete('cascade');
            $table->string('item_type')->nullable(); // lab_test, opd_service, consultant_service
            $table->string('item_name')->nullable(); // Name of the item being returned
            $table->decimal('original_amount', 10, 2)->default(0);
            $table->decimal('return_amount', 10, 2)->default(0);
            $table->decimal('refund_amount', 10, 2)->default(0);
            
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
        Schema::dropIfExists('invoice_return_items');
    }
};
