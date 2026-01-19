<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'contact_no',
        'service_id',
        'message',
        'status',
        'priority',
        'assigned_to',
        'internal_notes',
        'source',
        'ip_address',
        'user_agent',
        'responded_at',
        'resolved_at',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Scopes
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    public function scopeHighPriority($query)
    {
        return $query->whereIn('priority', ['high', 'urgent']);
    }

    public function scopeUnassigned($query)
    {
        return $query->whereNull('assigned_to');
    }

    // Accessors
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'new' => 'primary',
            'in_progress' => 'warning',
            'resolved' => 'success',
            'spam' => 'danger',
            default => 'secondary',
        };
    }

    public function getPriorityBadgeAttribute(): string
    {
        return match($this->priority) {
            'urgent' => 'danger',
            'high' => 'warning',
            'normal' => 'info',
            'low' => 'secondary',
            default => 'secondary',
        };
    }

    // Methods
    public function markAsResponded(): void
    {
        $this->update([
            'responded_at' => now(),
            'status' => 'in_progress'
        ]);
    }

    public function markAsResolved(): void
    {
        $this->update([
            'resolved_at' => now(),
            'status' => 'resolved'
        ]);
    }
}