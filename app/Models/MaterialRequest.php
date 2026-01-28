<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaterialRequest extends Model
{
    protected $fillable = [
        'template_id',
        'created_by',
        'project_name',
        'technician_name',
        'location',
        'departure_date',
        'notes',
        'status',
        'checkout_by',
        'checkout_at',
        'checkin_by',
        'checkin_at',
    ];

    protected $casts = [
        'departure_date' => 'date',
        'checkout_at' => 'datetime',
        'checkin_at' => 'datetime',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_CHECKED_OUT = 'checked_out';
    const STATUS_RETURNED = 'returned';
    const STATUS_CLOSED = 'closed';

    // Relationships
    public function template(): BelongsTo
    {
        return $this->belongsTo(ProjectTemplate::class, 'template_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function checkoutUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checkout_by');
    }

    public function checkinUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checkin_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(MaterialRequestItem::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeCheckedOut($query)
    {
        return $query->where('status', self::STATUS_CHECKED_OUT);
    }

    public function scopeNeedsCheckin($query)
    {
        return $query->whereIn('status', [self::STATUS_CHECKED_OUT, self::STATUS_RETURNED]);
    }

    // Helpers
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isCheckedOut(): bool
    {
        return $this->status === self::STATUS_CHECKED_OUT;
    }

    public function canCheckout(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function canCheckin(): bool
    {
        return $this->status === self::STATUS_CHECKED_OUT;
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'warning',
            self::STATUS_CHECKED_OUT => 'info',
            self::STATUS_RETURNED => 'primary',
            self::STATUS_CLOSED => 'success',
            default => 'secondary',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'Menunggu',
            self::STATUS_CHECKED_OUT => 'Keluar',
            self::STATUS_RETURNED => 'Dikembalikan',
            self::STATUS_CLOSED => 'Selesai',
            default => 'Unknown',
        };
    }
}
