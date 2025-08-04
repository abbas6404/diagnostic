<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'name_en',
        'name_bn',
        'phone',
        'email',
        'dob',
        'gender',
        'blood_group',
        'address',
        'emergency_contact',
        'emergency_phone',
        'reg_date',
        'reg_fee',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'dob' => 'date',
        'reg_date' => 'date',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the lab test orders for this patient.
     */
    public function labTestOrders()
    {
        return $this->hasMany(LabTestOrder::class);
    }

    /**
     * Get the lab test results for this patient.
     */
    public function labTestResults()
    {
        return $this->hasManyThrough(LabTestResult::class, LabTestOrder::class);
    }

    /**
     * Get the invoices for this patient.
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the user who created the patient.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who updated the patient.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope a query to only include active patients.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include inactive patients.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Get the status attribute.
     */
    public function getStatusAttribute($value)
    {
        return $value ?? 'active';
    }

    /**
     * Get the status badge attribute.
     */
    public function getStatusBadgeAttribute()
    {
        $status = $this->status;
        $badgeClass = match($status) {
            'active' => 'bg-success',
            'inactive' => 'bg-danger',
            'pending' => 'bg-warning',
            default => 'bg-secondary'
        };
        
        return '<span class="badge ' . $badgeClass . '">' . ucfirst($status) . '</span>';
    }

    /**
     * Get the age attribute.
     */
    public function getAgeAttribute()
    {
        if (!$this->dob) {
            return null;
        }
        
        // Ensure DOB is not in the future
        if ($this->dob->isFuture()) {
            return 0;
        }
        
        // Calculate age and ensure it's non-negative
        $age = $this->dob->age;
        return max(0, $age);
    }

    /**
     * Get the age in years.
     */
    public function getAgeYearAttribute()
    {
        if (!$this->dob) {
            return 0;
        }
        
        // Ensure DOB is not in the future
        if ($this->dob->isFuture()) {
            return 0;
        }
        
        $years = now()->diffInYears($this->dob);
        return max(0, $years);
    }

    /**
     * Get the age in months.
     */
    public function getAgeMonthAttribute()
    {
        if (!$this->dob) {
            return 0;
        }
        
        // Ensure DOB is not in the future
        if ($this->dob->isFuture()) {
            return 0;
        }
        
        $months = now()->diffInMonths($this->dob) % 12;
        return max(0, $months);
    }

    /**
     * Get the age in days.
     */
    public function getAgeDayAttribute()
    {
        if (!$this->dob) {
            return 0;
        }
        
        // Ensure DOB is not in the future
        if ($this->dob->isFuture()) {
            return 0;
        }
        
        $days = now()->diffInDays($this->dob) % 30;
        return max(0, $days);
    }

    /**
     * Get the full name attribute.
     */
    public function getFullNameAttribute()
    {
        return $this->name_en ?? $this->name_bn ?? 'Unknown';
    }
} 