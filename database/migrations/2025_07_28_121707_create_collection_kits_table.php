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
        Schema::create('collection_kits', function (Blueprint $table) {
            $table->id();
            $table->string('pcode')->unique()->index(); // Product Code like "CK-001"
            $table->string('name')->index(); // Kit name like "Needle", "Semen Container", etc.
            $table->string('color')->nullable(); // Color of the kit
            $table->decimal('charge', 10, 2)->default(0); // Cost per kit

            $table->string('status')->default('active'); // active, inactive, group_test
            $table->unsignedBigInteger('created_by')->nullable()->index(); // created by user id
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->nullable(); // updated by user id
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collection_kits');
    }
};
