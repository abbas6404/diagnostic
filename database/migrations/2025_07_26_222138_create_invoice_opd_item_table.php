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
        Schema::create('invoice_opd_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id')->index();   
            $table->foreign('invoice_id')->references('id')->on('invoice');
            $table->unsignedBigInteger('opd_service_id')->index();   
            $table->foreign('opd_service_id')->references('id')->on('opd_services');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_opd_item');
    }
};
