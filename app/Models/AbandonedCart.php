<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class AbandonedCart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'cart_data',
        'total_amount',
        'item_count',
        'customer_name',
        'customer_phone',
        'customer_email',
        'is_recovered',
        'last_activity_at',
    ];

    protected $casts = [
        'cart_data' => 'array',
        'total_amount' => 'decimal:2',
        'item_count' => 'integer',
        'is_recovered' => 'boolean',
        'last_activity_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUnrecovered(Builder $query): Builder
    {
        return $query->where('is_recovered', false);
    }

    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderBy('last_activity_at', 'desc');
    }
}
