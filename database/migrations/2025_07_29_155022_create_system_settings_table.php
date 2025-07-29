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
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->index();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, integer, boolean, json, array
            $table->string('group')->default('general'); // general, prefix, system, maintenance
            $table->text('description')->nullable();
            $table->boolean('is_public')->default(false); // whether this setting can be viewed by non-admins
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['group', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
