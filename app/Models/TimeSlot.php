<?php

namespace App\Models;

use App\Models\Psychologist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimeSlot extends Model
{
    /** @use HasFactory<\Database\Factories\TimeSlotFactory> */
    use HasFactory;

    protected $fillable = [
        'psychologist_id',
        'start_time',
        'end_time',
        'is_booked',
    ];

    public $timestamps = false;

    public function psychologist(): BelongsTo
    {
        return $this->belongsTo(Psychologist::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_booked', false);
    }
}
