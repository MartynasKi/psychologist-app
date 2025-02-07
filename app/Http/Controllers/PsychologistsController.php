<?php

namespace App\Http\Controllers;

use App\Models\Psychologist;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\PsychologistResource;

class PsychologistsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $psychologists = Psychologist::all();
        return PsychologistResource::collection($psychologists);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('psychologists', 'email')],
        ]);

        $psychologist = Psychologist::create($validated);
        return response()->json([
            'message' => 'Psychologist created successfully',
            'data' => new PsychologistResource($psychologist)
        ], 201);
    }
}
