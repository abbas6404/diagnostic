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
        Schema::create('opd_services', function (Blueprint $table) {
            $table->id();
            $table->string('code')->index()->unique();  
            $table->unsignedBigInteger('department_id')->index();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->string('name')->index();
            $table->string('description')->nullable();
            $table->decimal('charge', 10, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opd_services');
    }
}; 