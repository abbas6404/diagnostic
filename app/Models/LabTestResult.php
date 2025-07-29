<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabTestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'lab_test_id',
        'lab_test_parameter_id',
        'result_value',
        'remarks',
        'lab_incharge_id',
        'doctor_report_id',
        'verified_by',
        'verified_at',
        'tested_at',
        'status'
    ];

    protected $casts = [
        'patient_id' => 'integer',
        'lab_test_id' => 'integer',
        'lab_test_parameter_id' => 'integer',
        'lab_incharge_id' => 'integer',
        'doctor_report_id' => 'integer',
        'verified_by' => 'integer',
        'verified_at' => 'datetime',
        'tested_at' => 'datetime',
    ];

    /**
     * Get the patient that owns the result.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the lab test that owns the result.
     */
    public function labTest()
    {
        return $this->belongsTo(LabTest::class);
    }

    /**
     * Get the parameter that owns the result.
     */
    public function parameter()
    {
        return $this->belongsTo(LabTestParameter::class, 'lab_test_parameter_id');
    }

    /**
     * Get the lab incharge who performed the test.
     */
    public function labIncharge()
    {
        return $this->belongsTo(User::class, 'lab_incharge_id');
    }

    /**
     * Get the doctor who reported the result.
     */
    public function doctorReport()
    {
        return $this->belongsTo(User::class, 'doctor_report_id');
    }

    /**
     * Get the user who verified the result.
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
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
