<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Referral extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class)->orderByDesc('start_at');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function contactLogs(): HasManyThrough
    {
        return $this->hasManyThrough(ContactLog::class, Appointment::class);
    }

    public function latestAppointment(): HasOne
    {
        return $this->hasOne(Appointment::class)->ofMany([
            'start_at' => 'max',
            'id' => 'max',
        ]);
    }

    public function latestContactLog(): HasOneThrough
    {
        return $this->hasOneThrough(ContactLog::class, Appointment::class)->latest();
    }

    public function firstAppointment(): HasOne
    {
        return $this->hasOne(Appointment::class)->ofMany([
            'start_at' => 'min',
            'created_at' => 'max',
        ]);
    }

    public function notes(): MorphMany
    {
        return $this->morphMany(Note::class, 'notable');
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query->whereStatus('Open');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employment_advisor_id');
    }
}
