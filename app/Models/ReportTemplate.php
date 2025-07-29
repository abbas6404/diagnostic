<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_type',
        'lab_test_id',
        'template_name',
        'description',
        'file_path',
        'uploaded_by',
        'status'
    ];

    protected $casts = [
        'lab_test_id' => 'integer',
        'uploaded_by' => 'integer',
    ];

    /**
     * Get the lab test that owns the template.
     */
    public function labTest()
    {
        return $this->belongsTo(LabTest::class);
    }

    /**
     * Get the user who uploaded the template.
     */
    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Scope a query to only include active templates.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to filter by template type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('template_type', $type);
    }

    /**
     * Scope a query to only include lab report templates.
     */
    public function scopeLabReports($query)
    {
        return $query->where('template_type', 'lab_report');
    }

    /**
     * Scope a query to only include OPD invoice templates.
     */
    public function scopeOpdInvoices($query)
    {
        return $query->where('template_type', 'opd_invoice');
    }

    /**
     * Scope a query to only include diagnostic invoice templates.
     */
    public function scopeDiagnosticInvoices($query)
    {
        return $query->where('template_type', 'diagnostic_invoice');
    }

    /**
     * Scope a query to only include consultant invoice templates.
     */
    public function scopeConsultantInvoices($query)
    {
        return $query->where('template_type', 'consultant_invoice');
    }
}
