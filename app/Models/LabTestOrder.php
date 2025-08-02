<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabTestOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'invoice_id',
        'lab_test_id',
        'patient_id',
        'referred_by',
        'quantity',
        'unit_price',
        'total_price',
        'discount_percentage',
        'discount_amount',
        'final_price',
        'status',
        'order_date',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'invoice_id' => 'integer',
        'lab_test_id' => 'integer',
        'patient_id' => 'integer',
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'final_price' => 'decimal:2',
        'order_date' => 'date',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the invoice that owns the order.
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get the lab test that owns the order.
     */
    public function labTest()
    {
        return $this->belongsTo(LabTest::class);
    }

    /**
     * Get the patient that owns the order.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the results for this order.
     */
    public function results()
    {
        return $this->hasMany(LabTestResult::class);
    }

    /**
     * Get the lab test results for this order.
     */
    public function labTestResults()
    {
        return $this->hasMany(LabTestResult::class, 'lab_test_order_id');
    }

    /**
     * Get the user who created the order.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who updated the order.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the doctor who referred this test.
     */
    public function referredBy()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    /**
     * Scope a query to only include pending orders.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include completed orders.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include cancelled orders.
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Get the status attribute.
     */
    public function getStatusAttribute($value)
    {
        return $value ?? 'pending';
    }

    /**
     * Get the status badge attribute.
     */
    public function getStatusBadgeAttribute()
    {
        $status = $this->status;
        $badgeClass = match($status) {
            'pending' => 'bg-warning',
            'completed' => 'bg-success',
            'cancelled' => 'bg-danger',
            'processing' => 'bg-info',
            default => 'bg-secondary'
        };
        
        return '<span class="badge ' . $badgeClass . '">' . ucfirst($status) . '</span>';
    }
} 