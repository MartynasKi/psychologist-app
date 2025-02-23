<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TimeSlotsController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\PsychologistsController;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::post('/psychologists', [PsychologistsController::class, 'store']);
Route::get('/psychologists', [PsychologistsController::class, 'index']);

Route::post('/psychologists/{psychologist}/time-slots', [TimeSlotsController::class, 'store']);
Route::get('/psychologists/{psychologist}/time-slots', [TimeSlotsController::class, 'index']);

Route::put('/time-slots/{timeSlot}', [TimeSlotsController::class, 'update']);
Route::delete('/time-slots/{timeSlot}', [TimeSlotsController::class, 'destroy']);

Route::post('/appointments', [AppointmentsController::class, 'store']);
Route::get('/appointments', [AppointmentsController::class, 'index']);
