<?php

namespace App\Http\Controllers;

use App\Models\TimeSlot;
use App\Models\Appointment;
use App\Http\Resources\AppointmentResource;
use App\Mail\AppointmentBooked;
use Illuminate\Support\Facades\Mail;

class AppointmentsController extends Controller
{
    public function index()
    {
        return AppointmentResource::collection(
            Appointment::with([
                'timeSlot' => fn($query) => $query->where('start_time', '>=', now())->with('psychologist'),
            ])->get()
        );
    }

    public function store()
    {
        $validated = request()->validate([
            'time_slot_id' => 'required|exists:time_slots,id',
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email',
        ]);

        $timeSlot = TimeSlot::findOrFail($validated['time_slot_id']);
        if ($timeSlot->is_booked) {
            return response()->json(['message' => 'Time slot is already booked'], 422);
        }

        $appointment = Appointment::create($validated);
        $timeSlot->update(['is_booked' => true]);

        // could be queued
        Mail::to($appointment->client_email)->send(new AppointmentBooked($appointment));

        return response()->json(['message' => 'Appointment created successfully', 'data' => $appointment], 201);
    }
}
