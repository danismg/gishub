<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'colorId',
        'startDateTime',
        'endDateTime',
        'attendees',
        'file',
        'startDateAudit',
        'endDateAudit',
        'google_calendar_event_id',
    ];

    protected static function booted()
    {
        static::saved(fn($event) => $event->syncUsers());
        static::created(fn($event) => $event->syncUsers());
        static::updated(fn($event) => $event->syncUsers());
    }

    /**
     * Sinkronisasi auditor dan user ke event_user.
     */
    public function syncUsers()
    {
        $auditorUsers = $this->auditor()->pluck('users.id')->toArray();

        $roleUsers = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['Teknis', 'Admin']);
        })->pluck('id')->toArray();

        $allUsers = array_unique(array_merge($auditorUsers, $roleUsers));

        $this->users()->sync($allUsers);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_user', 'event_id', 'user_id')->withTimestamps();
    }

    public function auditor(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'auditors', 'event_id', 'user_id')->withTimestamps();
    }
}
