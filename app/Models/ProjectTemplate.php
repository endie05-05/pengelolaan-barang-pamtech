<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTemplate extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
    ];

    public function items()
    {
        return $this->hasMany(TemplateItem::class, 'template_id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'template_id');
    }
}
