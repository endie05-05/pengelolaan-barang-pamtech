<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];

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
}
