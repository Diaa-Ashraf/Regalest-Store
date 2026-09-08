<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsappClick extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'click_type',
        'source_page',
        'order_data',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'order_data' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
