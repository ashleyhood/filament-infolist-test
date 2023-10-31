<?php

namespace App\Models;

use App\Enums\AppointmentLocation;
use App\Enums\AppointmentStatus;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Appointment extends Model
{
    use HasFactory;

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    protected $guarded = [];

    public function client(): HasOneThrough
    {
        return $this->hasOneThrough(Client::class, Referral::class, 'id', 'id', 'referral_id', 'client_id');
    }

    public function contactLog(): HasOne
    {
        return $this->hasOne(ContactLog::class);
    }

    public function referral(): BelongsTo
    {
        return $this->belongsTo(Referral::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
