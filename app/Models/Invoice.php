<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'invoice';

    protected $fillable = [
        'invoice_no',
        'patient_id',
        'total_amount',
        'payable_amount',
        'paid_amount',
        'due_amount',
        'discount_amount',
        'discount_percentage',
        'invoice_date',
        'invoice_type',
        'payment_method',
        'created_by',
        'updated_by',
        'remarks'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'payable_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'invoice_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the patient that owns the invoice.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the lab test orders for the invoice.
     */
    public function labTestOrders()
    {
        return $this->hasMany(LabTestOrder::class, 'invoice_id');
    }

    /**
     * Get the user who created the invoice.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who updated the invoice.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope a query to only include diagnostic invoices.
     */
    public function scopeDiagnostic($query)
    {
        return $query->where('invoice_type', 'dia');
    }

    /**
     * Scope a query to only include paid invoices.
     */
    public function scopePaid($query)
    {
        return $query->where('due_amount', 0);
    }

    /**
     * Scope a query to only include unpaid invoices.
     */
    public function scopeUnpaid($query)
    {
        return $query->where('due_amount', '>', 0);
    }
}