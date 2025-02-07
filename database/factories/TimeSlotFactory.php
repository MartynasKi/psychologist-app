<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Psychologist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TimeSlot>
 */
class TimeSlotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'psychologist_id' => Psychologist::factory(),
            'start_time' => '2024-11-01 01:00:00',
            'end_time' => '2024-11-01 02:00:00',
            'is_booked' => fake()->boolean(),
        ];
    }
}
