<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabTestParameter extends Model
{
    use HasFactory;

    protected $fillable = [
        'lab_test_id',
        'parameter_key',
        'parameter_name',
        'unit',
        'reference_range',
        'status'
    ];

    protected $casts = [
        'lab_test_id' => 'integer',
    ];

    /**
     * Get the lab test that owns the parameter.
     */
    public function labTest()
    {
        return $this->belongsTo(LabTest::class);
    }

    /**
     * Get the results for this parameter.
     */
    public function results()
    {
        return $this->hasMany(LabTestResult::class);
    }

    /**
     * Scope a query to only include active parameters.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to filter by lab test.
     */
    public function scopeForLabTest($query, $labTestId)
    {
        return $query->where('lab_test_id', $labTestId);
    }
}
