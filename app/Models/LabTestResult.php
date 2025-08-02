<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabTestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'lab_test_order_id',
        'lab_test_parameter_id',
        'result_value',
        'remarks',
        'status',
        'report_date',
        'incharge_by',
        'checked_by',
        'referred_by',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'lab_test_order_id' => 'integer',
        'lab_test_parameter_id' => 'integer',
        'incharge_by' => 'integer',
        'checked_by' => 'integer',
        'referred_by' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'report_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the lab test order that owns the result.
     */
    public function labTestOrder()
    {
        return $this->belongsTo(LabTestOrder::class);
    }

    /**
     * Get the lab test through the order.
     */
    public function labTest()
    {
        return $this->hasOneThrough(LabTest::class, LabTestOrder::class, 'id', 'id', 'lab_test_order_id', 'lab_test_id');
    }

    /**
     * Get the patient through the order.
     */
    public function patient()
    {
        return $this->hasOneThrough(Patient::class, LabTestOrder::class, 'id', 'id', 'lab_test_order_id', 'patient_id');
    }

    /**
     * Get the parameter that owns the result.
     */
    public function parameter()
    {
        return $this->belongsTo(LabTestParameter::class, 'lab_test_parameter_id');
    }

    /**
     * Get the first checker.
     */
    public function checkedBy()
    {
        return $this->belongsTo(User::class, 'checked_by');
    }

    /**
     * Get the incharge.
     */
    public function inchargeBy()
    {
        return $this->belongsTo(User::class, 'incharge_by');
    }

    /**
     * Get the referred by.
     */
    public function referredBy()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    /**
     * Get the user who created the result.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who updated the result.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope a query to only include pending results.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include tested results.
     */
    public function scopeTested($query)
    {
        return $query->where('status', 'tested');
    }

    /**
     * Scope a query to only include verified results.
     */
    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    /**
     * Scope a query to only include reported results.
     */
    public function scopeReported($query)
    {
        return $query->where('status', 'reported');
    }

    /**
     * Scope a query to filter by patient.
     */
    public function scopeForPatient($query, $patientId)
    {
        return $query->where('patient_id', $patientId);
    }

    /**
     * Scope a query to filter by lab test.
     */
    public function scopeForLabTest($query, $labTestId)
    {
        return $query->where('lab_test_id', $labTestId);
    }
}
