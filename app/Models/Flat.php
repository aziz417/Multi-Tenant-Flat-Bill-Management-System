<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Flat extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_id',
        'flat_number',
        'floor_number',
        'flat_owner_name',
        'flat_owner_phone',
        'flat_owner_email',
        'bedrooms',
        'monthly_rent',
        'status',
    ];

    protected $casts = [
        'monthly_rent' => 'decimal:2',
    ];

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function tenant(): HasOne
    {
        return $this->hasOne(Tenant::class)->where('status', 'active');
    }

    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class);
    }

    public function getTotalDueAttribute(): float
    {
        return $this->bills()
            ->whereIn('status', ['unpaid', 'partially_paid'])
            ->sum('due_amount');
    }
}