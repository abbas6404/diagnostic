<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CollectionKit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pcode',
        'name',
        'color',
        'charge',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'charge' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Relationships
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function labTests()
    {
        return $this->belongsToMany(LabTest::class, 'lab_test_collection_kit', 'collection_kit_id', 'lab_test_id');
    }

    // Accessors
    public function getStatusAttribute($value)
    {
        return $value ?? 'active';
    }

    public function getStatusBadgeAttribute()
    {
        $status = $this->status;
        $badgeClass = match($status) {
            'active' => 'bg-success',
            'inactive' => 'bg-danger',
            'group_test' => 'bg-warning',
            default => 'bg-secondary'
        };
        
        return '<span class="badge ' . $badgeClass . '">' . ucfirst($status) . '</span>';
    }

    public function getFormattedChargeAttribute()
    {
        return '৳' . number_format($this->charge, 2);
    }

    public function getCreatedByNameAttribute()
    {
        return $this->createdBy()->first()?->name ?? 'System';
    }

    public function getUpdatedByNameAttribute()
    {
        return $this->updatedBy()->first()?->name ?? 'System';
    }
} 