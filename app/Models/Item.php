<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'code',
        'barcode',
        'unit',
        'stock',
        'min_stock',
        'item_type',
    ];

    // Item type constants
    const TYPE_TOOLS = 'tools';
    const TYPE_MATERIALS = 'materials';
    const TYPE_EQUIPMENT = 'equipment';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            // Auto-generate code if not provided
            if (empty($item->code)) {
                $lastItem = static::orderBy('id', 'desc')->first();
                $nextNumber = $lastItem ? $lastItem->id + 1 : 1;
                $item->code = 'ITM-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function stockMutations(): HasMany
    {
        return $this->hasMany(StockMutation::class);
    }

    public function materialRequestItems(): HasMany
    {
        return $this->hasMany(MaterialRequestItem::class);
    }

    // Helpers
    public function isTools(): bool
    {
        return $this->item_type === self::TYPE_TOOLS;
    }

    public function isMaterials(): bool
    {
        return $this->item_type === self::TYPE_MATERIALS;
    }

    public function isEquipment(): bool
    {
        return $this->item_type === self::TYPE_EQUIPMENT;
    }

    public function isLowStock(): bool
    {
        return $this->stock <= $this->min_stock;
    }

    public function getItemTypeLabelAttribute(): string
    {
        return match($this->item_type) {
            self::TYPE_TOOLS => 'Alat',
            self::TYPE_MATERIALS => 'Bahan',
            self::TYPE_EQUIPMENT => 'Perangkat',
            default => 'Lainnya',
        };
    }
}
