<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BillCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'house_owner_id',
        'name',
        'description',
    ];

    public function houseOwner(): BelongsTo
    {
        return $this->belongsTo(HouseOwner::class);
    }

    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class);
    }
}