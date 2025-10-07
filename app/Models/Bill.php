<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'flat_id',
        'bill_category_id',
        'month',
        'amount',
        'due_amount',
        'paid_amount',
        'status',
        'notes',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function flat(): BelongsTo
    {
        return $this->belongsTo(Flat::class);
    }

    public function billCategory(): BelongsTo
    {
        return $this->belongsTo(BillCategory::class);
    }

    public function updateStatus(): void
    {
        $totalAmount = $this->amount + $this->due_amount;

        if ($this->paid_amount >= $totalAmount) {
            $this->status = 'paid';
            $this->paid_at = now();
            $this->due_amount = 0;
        } elseif ($this->paid_amount > 0) {
            $this->status = 'partially_paid';
            $this->due_amount = $totalAmount - $this->paid_amount;
        } else {
            $this->status = 'unpaid';
            $this->due_amount = $totalAmount;
        }

        $this->save();
    }
}