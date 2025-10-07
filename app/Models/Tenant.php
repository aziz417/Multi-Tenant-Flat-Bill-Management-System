<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'flat_id',
        'building_id',
        'name',
        'email',
        'phone',
        'nid_number',
        'move_in_date',
        'move_out_date',
        'status',
    ];

    protected $casts = [
        'move_in_date' => 'date',
        'move_out_date' => 'date',
    ];

    public function flat(): BelongsTo
    {
        return $this->belongsTo(Flat::class);
    }

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }
}