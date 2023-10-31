<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'dob' => 'date',
        'started_at' => 'date',
        'ended_at' => 'date',
    ];

    protected $guarded = [];

    public function appointments(): HasManyThrough
    {
        return $this->hasManyThrough(Appointment::class, Referral::class)->orderByDesc('start_at');
    }

    public function latestReferral(): HasOne
    {
        return $this->hasOne(Referral::class)->latestOfMany('referred_at');
    }

    public function notes(): MorphMany
    {
        return $this->morphMany(Note::class, 'notable')->orderByDesc('type');
    }

    public function openReferral(): HasOne
    {
        return $this->hasOne(Referral::class)->whereStatus('Open');
    }

    public function openReferralAppointments(): HasManyThrough
    {
        return $this->throughOpenReferral()->hasAppointments()->orderByDesc('start_at');
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class);
    }
}
