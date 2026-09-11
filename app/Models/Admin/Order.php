<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Order extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_SHIPPED = 'shipped';
    public const STATUS_DELIVERED = 'delivered';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'client_id',
        'total_price',
        'status',
        'address',
        'phone',
        'payment_method',
        'notes',
        'cancel_reason',
        'currency',
        'exchange_rate',
        'confirmed_at',
        'shipped_at',
        'delivered_at',
        'cancelled_at',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'exchange_rate' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeDelivered(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_DELIVERED);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNotIn('status', [self::STATUS_CANCELLED, self::STATUS_DELIVERED]);
    }

    public function getFormattedTotalAttribute(): string
    {
        return '$' . number_format($this->total_price, 2);
    }

    public function getCustomerDisplayNameAttribute(): string
    {
        if (!empty($this->customer_name)) {
            return $this->customer_name;
        }

        if ($this->user && !empty($this->user->name)) {
            return $this->user->name;
        }

        return __('طلب مباشر (زائر)');
    }
}
