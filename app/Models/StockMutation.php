<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMutation extends Model
{
    protected $fillable = [
        'item_id',
        'type',
        'qty',
        'stock_before',
        'stock_after',
        'reference_type',
        'reference_id',
        'reason',
        'created_by',
    ];

    // Type constants
    const TYPE_IN = 'in';
    const TYPE_OUT = 'out';
    const TYPE_ADJUST = 'adjust';
    const TYPE_DAMAGED = 'damaged';
    const TYPE_LOST = 'lost';

    // Relationships
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Helper to create mutation
    public static function record(Item $item, string $type, int $qty, ?string $reason = null, ?string $referenceType = null, ?int $referenceId = null): self
    {
        $stockBefore = $item->stock;
        
        // Update item stock based on type
        if (in_array($type, [self::TYPE_IN])) {
            $item->increment('stock', $qty);
        } elseif (in_array($type, [self::TYPE_OUT, self::TYPE_DAMAGED, self::TYPE_LOST])) {
            $item->decrement('stock', $qty);
        } elseif ($type === self::TYPE_ADJUST) {
            $item->stock = $item->stock + $qty; // qty can be negative for adjustment
            $item->save();
        }

        return self::create([
            'item_id' => $item->id,
            'type' => $type,
            'qty' => abs($qty),
            'stock_before' => $stockBefore,
            'stock_after' => $item->fresh()->stock,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'reason' => $reason,
            'created_by' => auth()->id(),
        ]);
    }

    // Scopes
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeForItem($query, int $itemId)
    {
        return $query->where('item_id', $itemId);
    }

    // Helpers
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            self::TYPE_IN => 'Masuk',
            self::TYPE_OUT => 'Keluar',
            self::TYPE_ADJUST => 'Penyesuaian',
            self::TYPE_DAMAGED => 'Rusak',
            self::TYPE_LOST => 'Hilang',
            default => 'Unknown',
        };
    }

    public function getTypeBadgeAttribute(): string
    {
        return match($this->type) {
            self::TYPE_IN => 'success',
            self::TYPE_OUT => 'warning',
            self::TYPE_ADJUST => 'info',
            self::TYPE_DAMAGED => 'danger',
            self::TYPE_LOST => 'dark',
            default => 'secondary',
        };
    }
}
