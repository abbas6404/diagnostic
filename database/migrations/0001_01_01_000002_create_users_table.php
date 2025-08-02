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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable()->index(); //Code (DR-001)
            $table->string('name'); //Name
            $table->string('description')->nullable(); //Description
            $table->string('email')->unique()->index(); //Email
            $table->timestamp('email_verified_at')->nullable(); //Email Verified At
            $table->string('password'); //Password
          
            

            $table->string('phone')->unique()->index()->nullable(); //Phone
            $table->string('address')->nullable(); //Address
            $table->string('city')->nullable(); //City
            $table->string('state')->nullable(); //State
            $table->string('zip')->nullable(); //Zip
            $table->string('country')->nullable(); //Country
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active'); //Status
            
            $table->string('profile_photo_path')->nullable(); //Profile Photo Path
            $table->unsignedBigInteger('department_id')->nullable(); //Department ID    
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade'); //Department ID 
            
            $table->rememberToken(); //Remember Token
            $table->timestamps(); //Created At, Updated At
            $table->softDeletes(); //Deleted At
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
