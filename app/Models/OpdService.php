<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OpdService extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'department_id',
        'name',
        'description',
        'charge'
    ];

    protected $casts = [
        'charge' => 'decimal:2',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
} 