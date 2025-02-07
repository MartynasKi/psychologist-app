<?php

namespace App\Http\Controllers;

use App\Models\TimeSlot;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppontmentsController extends Controller
{
    public function index()
    {
        return Appointment::with('timeSlot')
            ->whereHas('timeSlot', function ($query) {
                $query->where('start_time', '>=', now());
            })
            ->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'time_slot_id' => 'required|exists:time_slots,id',
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email',
        ]);

        $timeSlot = TimeSlot::findOrFail($validated['time_slot_id']);
        if ($timeSlot->is_booked) {
            return response()->json(['message' => 'Time slot already booked'], 422);
        }

        $appointment = Appointment::create($validated);
        $timeSlot->update(['is_booked' => true]);
        return $appointment;
    }
}
