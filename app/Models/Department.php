<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

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
            default => 'bg-secondary'
        };
        
        return '<span class="badge ' . $badgeClass . '">' . ucfirst($status) . '</span>';
    }
} 