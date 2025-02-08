<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use App\Models\TimeSlot;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTimeSlotRequest extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'start_time' => 'sometimes|date_format:Y-m-d H:i:s',
            'end_time'   => 'sometimes|date_format:Y-m-d H:i:s',
            'is_booked'  => 'sometimes|boolean',
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $validated = $validator->validated();

                // If no fields are provided, abort with a 422 error
                if (empty($validated)) {
                    abort(422, 'At least one field must be provided');
                }

                // check overlap
                if (isset($validated['start_time']) || isset($validated['end_time'])) {
                    $timeSlot = $this->route('timeSlot');

                    // get start time and end time either from the request or from database
                    $startTime = $validated['start_time'] ?? $timeSlot->start_time;
                    $endTime = $validated['end_time'] ?? $timeSlot->end_time;

                    $startTime = Carbon::parse($startTime);
                    $endTime = Carbon::parse($endTime);

                    if ($endTime < $startTime) {
                        abort(422, 'Date range is invalid. End time must be after start time (start: ' . $startTime->format('Y-m-d H:i:s') . ' end: ' . $endTime->format('Y-m-d H:i:s') . ')');
                    }

                    $isOverlapping = TimeSlot::isOverlapping(
                        $timeSlot->psychologist_id,
                        $startTime,
                        $endTime,
                        $timeSlot->id
                    );

                    if ($isOverlapping) {
                        abort(422, 'Time slot overlaps with existing time slot');
                    }
                }
            }
        ];
    }
}
