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
        Schema::create('lab_test_collection_kit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lab_test_id');
            $table->foreign('lab_test_id')->references('id')->on('lab_tests')->onDelete('cascade');
            $table->unsignedBigInteger('collection_kit_id');
            $table->foreign('collection_kit_id')->references('id')->on('collection_kits')->onDelete('cascade');
            $table->timestamps();
            
            // Ensure unique combinations
            $table->unique(['lab_test_id', 'collection_kit_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_test_collection_kit');
    }
};
