<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateItem extends Model
{
    protected $fillable = [
        'project_template_id',
        'item_id',
        'default_qty',
    ];

    public function template()
    {
        return $this->belongsTo(ProjectTemplate::class, 'project_template_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
