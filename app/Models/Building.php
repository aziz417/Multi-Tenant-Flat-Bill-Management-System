<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Building extends Model
{
    use HasFactory;

    protected $fillable = [
        'house_owner_id',
        'name',
        'address',
        'description',
        'total_floors',
    ];

    public function houseOwner(): BelongsTo
    {
        return $this->belongsTo(HouseOwner::class);
    }

    public function flats(): HasMany
    {
        return $this->hasMany(Flat::class);
    }

    public function tenants(): HasMany
    {
        return $this->hasMany(Tenant::class);
    }
}