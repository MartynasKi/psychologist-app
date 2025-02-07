<?php

use App\Models\TimeSlot;
use App\Models\Appointment;
use App\Models\Psychologist;

test('create psychologist', function () {
    $response = $this->postJson('/psychologists', [
        'name' => 'Albert Einstein',
        'email' => 'albert@einstein.com',
    ]);

    $response->assertStatus(201);
    $this->assertDatabaseHas('psychologists', [
        'name' => 'Albert Einstein',
        'email' => 'albert@einstein.com',
    ]);

    // test email must be unique
    $secondResponse = $this->postJson('/psychologists', [
        'name' => 'Albert Einstein',
        'email' => 'albert@einstein.com',
    ]);

    $secondResponse->assertStatus(422)
        ->assertJsonValidationErrors(['email']);
});

test('get list of psychologists', function () {
    $response = $this->getJson('/psychologists');
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => [
            '*' => [
                'id',
                'name',
                'email',
            ],
        ],
    ]);
});

test('create time slot', function () {
    $psychologist = Psychologist::factory()->create();

    $response = $this->postJson('/psychologists/' . $psychologist->id . '/time-slots', [
        'start_time' => '2025-02-08 10:00:00',
        'end_time' => '2025-02-08 11:00:00',
    ]);

    $response->assertStatus(201);
});

test('create time slot error with overlapping time', function () {
    $psychologist = Psychologist::factory()->create();

    $response = $this->postJson('/psychologists/' . $psychologist->id . '/time-slots', [
        'start_time' => '2024-01-01 10:00:00',
        'end_time' => '2024-01-01 11:00:00',
    ]);

    $response = $this->postJson('/psychologists/' . $psychologist->id . '/time-slots', [
        'start_time' => '2024-01-01 10:30:00',
        'end_time' => '2024-01-01 11:00:00',
    ]);

    $response->assertStatus(422);
});

test('get list of time slots', function () {
    $psychologist = Psychologist::factory()->has(TimeSlot::factory()->count(3))->create();

    $response = $this->getJson('/psychologists/' . $psychologist->id . '/time-slots');
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => [
            '*' => [
                'id',
                'start_time',
                'end_time',
                'is_booked',
            ],
        ],
    ]);
});

test('update time slot', function () {
    $timeSlot = TimeSlot::factory()->create();
    $inverse = !$timeSlot->is_booked;

    $response = $this->putJson('/time-slots/' . $timeSlot->id, [
        'is_booked' => $inverse,
    ]);

    $response->assertStatus(200);

    $timeSlot = $timeSlot->refresh();
    $this->assertEquals($inverse, $timeSlot->is_booked);
});

test('destroy time slot', function () {
    $timeSlot = TimeSlot::factory()->create();

    $response = $this->deleteJson('/time-slots/' . $timeSlot->id);
    $response->assertStatus(200);

    $this->assertDatabaseMissing('time_slots', [
        'id' => $timeSlot->id,
    ]);
});

test('create appointment', function () {
    $timeSlot = TimeSlot::factory()->create([
        'start_time' => '2025-02-08 10:00:00',
        'end_time' => '2025-02-08 11:00:00',
        'is_booked' => false,
    ]);

    $response = $this->postJson('/appointments', [
        'time_slot_id' => $timeSlot->id,
        'client_name' => 'John Doe',
        'client_email' => 'john@doe.com',
    ]);

    $response->assertStatus(201);

    $this->assertDatabaseHas('appointments', [
        'time_slot_id' => $timeSlot->id,
        'client_name' => 'John Doe',
        'client_email' => 'john@doe.com',
    ]);
});

test('get list of appointments', function () {
    $timeSlot = TimeSlot::factory()->create([
        'start_time' => now()->addHours(1),
        'end_time' => now()->addHours(2),
        'is_booked' => false,
    ]);

    $appointment = Appointment::factory()->create([
        'time_slot_id' => $timeSlot->id,
        'client_name' => 'John Doe',
        'client_email' => 'john@doe.com',
    ]);

    $response = $this->getJson('/appointments');
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => [
            '*' => [
                'id'
            ]
        ],
    ]);
});
