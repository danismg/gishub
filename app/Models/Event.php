<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\GoogleCalendar\Event as GoogleCalendarEvent;
use Illuminate\Support\Facades\Auth;

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
        'google_calendar_event_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($event) {
            $event->users()->attach(Auth::id());
        });
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'auditors', 'event_id', 'user_id')->withTimestamps();
    }
    public function audit(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'auditors', 'event_id', 'user_id')->withTimestamps();
    }

    protected $casts = [
        'user_id' => 'array',
    ];
}
