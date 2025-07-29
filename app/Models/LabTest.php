<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabTest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'department_id',
        'name',
        'description',
        'charge',
        'created_by',
        'updated_by',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'charge' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function collectionKits()
    {
        return $this->belongsToMany(CollectionKit::class, 'lab_test_collection_kit', 'lab_test_id', 'collection_kit_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getStatusAttribute()
    {
        return $this->deleted_at ? 'Deleted' : 'Active';
    }

    public function getStatusBadgeAttribute()
    {
        return $this->deleted_at 
            ? '<span class="badge bg-danger">Deleted</span>'
            : '<span class="badge bg-success">Active</span>';
    }

    public function getFormattedChargeAttribute()
    {
        return '৳' . number_format($this->charge, 2);
    }
} 