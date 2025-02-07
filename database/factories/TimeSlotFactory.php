<?php

namespace Database\Factories;

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
            'start_time' => fake()->dateTimeBetween('-1 month', '+1 month'),
            'end_time' => fake()->dateTimeBetween('-1 month', '+1 month'),
            'is_booked' => fake()->boolean(),
        ];
    }
}
