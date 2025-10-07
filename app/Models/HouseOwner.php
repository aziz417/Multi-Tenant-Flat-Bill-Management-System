<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class HouseOwner extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function buildings(): HasMany
    {
        return $this->hasMany(Building::class);
    }

    public function billCategories(): HasMany
    {
        return $this->hasMany(BillCategory::class);
    }

    public function flats(): HasManyThrough
    {
        return $this->hasManyThrough(Flat::class, Building::class);
    }
}