<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\TimeSlot;
use App\Models\Appointment;
use App\Models\Psychologist;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Psychologist::factory(2)->hasTimeSlots(10)->create();
        Appointment::factory(10)->recycle(TimeSlot::all())->create();
    }
}
