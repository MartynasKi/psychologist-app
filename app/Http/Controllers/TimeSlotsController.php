<?php

namespace App\Http\Controllers;

use App\Models\TimeSlot;
use App\Models\Psychologist;
use App\Http\Resources\TimeSlotResource;

class TimeSlotsController extends Controller
{
    public function store($id)
    {
        $psychologist = Psychologist::findOrFail($id);

        $validated = request()->validate([
            'start_time' => 'required|date_format:Y-m-d H:i:s',
            'end_time' => 'required|date_format:Y-m-d H:i:s|after:start_time',
            'is_booked' => 'nullable|boolean',
        ]);

        // check overlapping time slots
        $overlappingSlots = $psychologist->timeSlots()
            ->where('start_time', '<=', $validated['end_time'])
            ->where('end_time', '>=', $validated['start_time'])
            ->exists();

        if ($overlappingSlots) {
            return response()->json(['message' => 'Time slot overlaps with existing time slot'], 422);
        }

        $timeSlot = $psychologist->timeSlots()->create($validated);
        return response()->json([
            'message' => 'Time slot created successfully',
            'data' => new TimeSlotResource($timeSlot)
        ], 201);
    }

    public function index($id)
    {
        $psychologist = Psychologist::findOrFail($id);
        return TimeSlotResource::collection($psychologist->timeSlots()->available()->get());
    }

    public function update($id)
    {
        $timeSlot = TimeSlot::findOrFail($id);

        $validated = request()->validate([
            'start_time' => 'nullable|date_format:Y-m-d H:i:s',
            'end_time'   => 'nullable|date_format:Y-m-d H:i:s|after:start_time',
            'is_booked'  => 'nullable|boolean',
        ]);

        if (empty($validated)) {
            return response()->json(['message' => 'At least one field must be provided'], 422);
        }

        // check overlapping time slots
        if (isset($validated['start_time']) && isset($validated['end_time'])) {
            $overlappingSlots = TimeSlot::where('start_time', '<=', $validated['end_time'])
                ->where('end_time', '>=', $validated['start_time'])
                ->where('psychologist_id', $timeSlot->psychologist_id)
                ->where('id', '!=', $timeSlot->id)
                ->exists();

            if ($overlappingSlots) {
                return response()->json(['message' => 'Time slot overlaps with existing time slot'], 422);
            }
        }

        $timeSlot->update($validated);

        return $timeSlot;
    }

    public function destroy($id)
    {
        $timeSlot = TimeSlot::findOrFail($id);
        $timeSlot->delete();
        return response()->json(['message' => 'Time slot deleted']);
    }
}
