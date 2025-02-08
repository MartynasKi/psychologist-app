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
        $startTime = fake()->unique()->dateTimeBetween('now', '+1 year');
        $endTime = Carbon::instance(clone $startTime)->addHour()->format('Y-m-d H:00:00');
        $startTime = $startTime->format('Y-m-d H:00:00');

        return [
            'psychologist_id' => Psychologist::factory(),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'is_booked' => false,
        ];
    }
}
