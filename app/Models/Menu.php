<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $fillable = [
        'menu_date',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'menu_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function menuItems(): HasMany
    {
        return $this->hasMany(MenuItem::class)->orderBy('display_order');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * The single menu currently shown on the public homepage, or null if
     * none has been activated yet (the public view handles that gracefully).
     */
    public static function currentlyActive(): ?self
    {
        return static::active()->first();
    }

    /**
     * Deactivates every other menu so only this one is ever active at once.
     */
    public function activateExclusively(): void
    {
        static::where('id', '!=', $this->id)->update(['is_active' => false]);
        $this->update(['is_active' => true]);
    }
}
