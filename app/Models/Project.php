<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'location',
        'technician_id',
        'template_id',
        'status',
        'start_date',
        'end_date',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function template()
    {
        return $this->belongsTo(ProjectTemplate::class, 'template_id');
    }

    public function materials()
    {
        return $this->hasMany(ProjectMaterial::class);
    }
}
