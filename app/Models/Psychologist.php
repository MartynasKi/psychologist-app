<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Psychologist extends Model
{
    /** @use HasFactory<\Database\Factories\PsychologistFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
    ];

    public $timestamps = false;

    public function timeSlots(): HasMany
    {
        return $this->hasMany(TimeSlot::class);
    }
}
