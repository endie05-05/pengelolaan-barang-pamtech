<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateItem extends Model
{
    protected $fillable = [
        'template_id',
        'item_id',
        'default_quantity',
    ];

    public function template()
    {
        return $this->belongsTo(ProjectTemplate::class, 'template_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
