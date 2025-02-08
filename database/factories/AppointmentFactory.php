<?php

namespace Database\Factories;

use App\Models\TimeSlot;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'time_slot_id' => TimeSlot::factory()->state(['is_booked' => true]),
            'client_name' => fake()->name(),
            'client_email' => fake()->unique()->safeEmail(),
        ];
    }
}
