<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Container extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'container_id';
    
    public $incrementing = false;
    
    protected $keyType = 'string';

    protected $fillable = [
        'container_id',
        'waste_type',
        'weight_kg',
        'status',
    ];

    public function trackingLogs(): HasMany
    {
        return $this->hasMany(TrackingLog::class, 'container_id', 'container_id');
    }
}