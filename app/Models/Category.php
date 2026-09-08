<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model implements TranslatableContract
{
    use Translatable, HasFactory;

    public string $translationForeignKey = 'category_id';
    public array $translatedAttributes = ['name', 'description'];
    public string $translationModel = CategoryTranslation::class;

    protected static function booted(): void
    {
        static::deleting(function (Category $category) {
            $category->translations()->delete();
        });
    }

    protected $fillable = [
        'slug',
        'image',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        if (Storage::disk('public')->exists($this->image)) {
            return Storage::disk('public')->url($this->image);
        }

        if (Storage::disk('public')->exists("categories/{$this->image}")) {
            return Storage::disk('public')->url("categories/{$this->image}");
        }

        return null;
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function activeProducts(): HasMany
    {
        return $this->hasMany(Product::class)->where('is_active', true);
    }
}
