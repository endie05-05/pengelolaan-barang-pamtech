<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialRequestItem extends Model
{
    protected $fillable = [
        'material_request_id',
        'item_id',
        'qty_requested',
        'qty_out',
        'qty_used',
        'qty_returned',
        'qty_damaged',
        'qty_lost',
        'condition_out',
        'condition_in',
        'notes',
        'photo_path',
    ];

    // Relationships
    public function materialRequest(): BelongsTo
    {
        return $this->belongsTo(MaterialRequest::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    // Helpers
    public function hasDiscrepancy(): bool
    {
        // Check if qty_out != qty_used + qty_returned + qty_damaged + qty_lost
        $total = $this->qty_used + $this->qty_returned + $this->qty_damaged + $this->qty_lost;
        return $this->qty_out > 0 && $total !== $this->qty_out;
    }

    public function getDiscrepancyAttribute(): int
    {
        $total = $this->qty_used + $this->qty_returned + $this->qty_damaged + $this->qty_lost;
        return $this->qty_out - $total;
    }

    public function isReconciled(): bool
    {
        return !$this->hasDiscrepancy();
    }

    // For Tools: should be returned
    public function isToolReturned(): bool
    {
        if ($this->item && $this->item->item_type === 'tools') {
            return $this->qty_returned === $this->qty_out || $this->qty_damaged === $this->qty_out;
        }
        return true;
    }
}
