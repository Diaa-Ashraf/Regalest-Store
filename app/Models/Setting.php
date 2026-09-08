<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'group',
        'key',
        'value',
        'type',
        'description',
    ];

    /**
     * Get casted value based on type
     */
    public function getFormattedValueAttribute(): mixed
    {
        return match ($this->type) {
            'boolean' => filter_var($this->value, FILTER_VALIDATE_BOOLEAN),
            'number' => is_numeric($this->value) ? (str_contains($this->value, '.') ? (float)$this->value : (int)$this->value) : 0,
            'json' => json_decode($this->value, true) ?? [],
            'image' => $this->value ? (Storage::disk('public')->exists($this->value) ? Storage::disk('public')->url($this->value) : asset($this->value)) : null,
            default => $this->value,
        };
    }
}
