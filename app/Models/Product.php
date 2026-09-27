<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image_path',
        'is_available',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'is_available' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class);
    }

    /**
     * Public URL for the stored image, or null if none has been uploaded yet
     * (views fall back to the placeholder treatment already built in).
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? Storage::disk('public')->url($this->image_path) : null;
    }

    /**
     * Formatted for display: "280,000" — thousands-separated, still Latin
     * digits here. Blade applies Persian numeral conversion at render time
     * (see resources/views partials) so this stays a plain, testable value.
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price);
    }
}
