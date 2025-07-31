<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabTestParameter extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'lab_test_id',
        'name_description',
        'default_result',
        'unit',
        'normal_value',
        'sort_order',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'lab_test_id' => 'integer',
        'sort_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
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
     * Get the user who created this parameter.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this parameter.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope a query to only include active parameters.
     */
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    /**
     * Scope a query to filter by lab test.
     */
    public function scopeForLabTest($query, $labTestId)
    {
        return $query->where('lab_test_id', $labTestId);
    }

    /**
     * Get the status attribute.
     */
    public function getStatusAttribute()
    {
        return $this->deleted_at ? 'Deleted' : 'Active';
    }

    /**
     * Get the status badge attribute.
     */
    public function getStatusBadgeAttribute()
    {
        return $this->deleted_at 
            ? '<span class="badge bg-danger">Deleted</span>'
            : '<span class="badge bg-success">Active</span>';
    }
}
