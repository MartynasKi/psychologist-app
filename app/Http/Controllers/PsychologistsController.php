<?php

namespace App\Http\Controllers;

use App\Models\Psychologist;
use App\Http\Resources\PsychologistResource;

class PsychologistsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // later we could add pagination
        $psychologists = Psychologist::all();
        return PsychologistResource::collection($psychologists);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $validated = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:psychologists,email',
        ]);

        $psychologist = Psychologist::create($validated);
        return response()->json([
            'message' => 'Psychologist created successfully',
            'data' => new PsychologistResource($psychologist)
        ], 201);
    }
}
