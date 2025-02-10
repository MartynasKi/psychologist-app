<?php

namespace App\Http\Controllers;

use App\Models\TimeSlot;
use App\Models\Psychologist;
use App\Http\Resources\TimeSlotResource;
use App\Http\Requests\UpdateTimeSlotRequest;

class TimeSlotsController extends Controller
{
    public function index(Psychologist $psychologist)
    {
        return TimeSlotResource::collection($psychologist->timeSlots()->available()->get());
    }

    public function store(Psychologist $psychologist)
    {
        $validated = request()->validate([
            'start_time' => 'required|date_format:Y-m-d H:i:s',
            'end_time' => 'required|date_format:Y-m-d H:i:s|after:start_time',
            'is_booked' => 'sometimes|boolean',
        ]);

        if (TimeSlot::isOverlapping($psychologist->id, $validated['start_time'], $validated['end_time'])) {
            return response()->json(['message' => 'Time slot overlaps with existing time slot'], 422);
        }

        $timeSlot = $psychologist->timeSlots()->create($validated);
        return response()->json([
            'message' => 'Time slot created successfully',
            'data' => new TimeSlotResource($timeSlot)
        ], 201);
    }


    public function update(TimeSlot $timeSlot, UpdateTimeSlotRequest $request)
    {
        $validated = $request->validated();
        $timeSlot->update($validated);

        return response()->json([
            'message' => 'Time slot updated successfully',
            'data' => new TimeSlotResource($timeSlot)
        ], 200);
    }

    public function destroy(TimeSlot $timeSlot)
    {
        $timeSlot->delete();
        return response()->json(['message' => 'Time slot deleted'], 202);
    }
}
