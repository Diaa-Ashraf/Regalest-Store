<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'discount_percent',
        'original_price',
        'deal_price',
        'badge_text',
        'is_active',
        'starts_at',
        'ends_at',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'original_price' => 'decimal:2',
        'deal_price' => 'decimal:2',
    ];

    /**
     * Get the product for this deal
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope for active deals
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', now());
            });
    }

    /**
     * Scope to order by sort_order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc');
    }

    /**
     * Get formatted original price
     */
    public function getFormattedOriginalPriceAttribute()
    {
        return number_format($this->original_price, 2);
    }

    /**
     * Get formatted deal price
     */
    public function getFormattedDealPriceAttribute()
    {
        return number_format($this->deal_price, 2);
    }

    /**
     * Check if deal is currently valid
     */
    public function getIsValidAttribute()
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();
        
        if ($this->starts_at && $this->starts_at > $now) {
            return false;
        }

        if ($this->ends_at && $this->ends_at < $now) {
            return false;
        }

        return true;
    }
}
