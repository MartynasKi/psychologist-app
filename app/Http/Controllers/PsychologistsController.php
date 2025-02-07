<?php

namespace App\Http\Controllers;

use App\Models\Psychologist;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PsychologistsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $psychologists = Psychologist::all();
        return $psychologists;
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

        Psychologist::create($validated);
        return response()->noContent(201);
    }
}
