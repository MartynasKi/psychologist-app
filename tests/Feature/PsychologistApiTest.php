<?php

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
        '*' => [
            'id',
            'name',
        ],
    ]);
});

test('create time slot', function () {
    $psychologist = \App\Models\Psychologist::factory()->create();

    $response = $this->postJson('/psychologists/' . $psychologist->id . '/time-slots', [
        'start_time' => '2024-01-01 10:00:00',
        'end_time' => '2024-01-01 11:00:00',
    ]);

    $response->assertStatus(201);
});

test('create time slot with overlapping time', function () {
    $psychologist = \App\Models\Psychologist::factory()->create();

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
    $psychologist = \App\Models\Psychologist::factory()->create();

    $response = $this->getJson('/psychologists/' . $psychologist->id . '/time-slots');
    $response->assertStatus(200);
    $response->assertJsonStructure([
        '*' => [
            'id',
            'start_time',
            'end_time',
        ],
    ]);
});
