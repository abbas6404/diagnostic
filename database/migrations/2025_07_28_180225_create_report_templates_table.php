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
        Schema::create('report_templates', function (Blueprint $table) {
            $table->id();
            $table->string('template_type')->default('lab_report'); // lab_report, invoice, receipt, etc.
            $table->unsignedBigInteger('lab_test_id')->nullable(); // lab test id (for lab reports)
            $table->string('template_name', 100); // name of the template (e.g., "opd_invoice", "diagnostic_invoice", "cbc_report")
            $table->string('file_path', 255); // path to the template file in the public/report_templates folder (e.g. public/report_templates/template_name.pdf)
            $table->unsignedBigInteger('uploaded_by')->nullable(); // user id of the user who uploaded the template
            $table->enum('status', ['active', 'inactive'])->default('active'); // status of the template
            $table->timestamps();
            
            $table->foreign('lab_test_id')->references('id')->on('lab_tests')->onDelete('cascade');
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_templates');
    }
};
