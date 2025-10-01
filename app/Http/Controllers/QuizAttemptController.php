<?php

namespace App\Http\Controllers;//define controller location

use App\Models\Attempt;//import attempt model
use App\Models\Member;//import member model
use App\Models\Quiz;//import quiz model
use Illuminate\Http\Request;//import request

class QuizAttemptController extends Controller
{
    //Display a listing of attempts.
    public function index()
    {
        // Load attempts with related member & quiz
        $attempts = Attempt::with(['member', 'quiz'])->get();
        return response()->json($attempts);
    }

    //Show the form for creating a new attempt.
    public function create()
    {
        // If you’re using Blade views
        $members = Member::all();
        $quizzes = Quiz::all();
        return view('attempts.create', compact('members', 'quizzes'));
    }

    //Store a newly created attempt in storage.
    public function store(Request $request)
    {
        $request->validate([
            'member_id'  => 'required|exists:members,id',
            'quiz_id'    => 'required|exists:quizzes,id', // note: your migration table is "quizs"
            'started_at' => 'nullable|date',
            'end_at'     => 'nullable|date|after_or_equal:started_at',
            'marks'      => 'nullable|integer|min:0',
        ]);

        $attempt = Attempt::create($request->all());

        return response()->json([
            'message' => 'Attempt created successfully!',
            'data' => $attempt
        ], 201);
    }

    //Display the specified attempt.
    public function show(Attempt $attempt)
    {
        $attempt->load(['member', 'quiz', 'answers']);
        return response()->json($attempt);
    }

    //Show the form for editing the specified attempt.
    public function edit(Attempt $attempt)
    {
        $members = Member::all();
        $quizzes = Quiz::all();
        return view('attempts.edit', compact('attempt', 'members', 'quizzes'));
    }

    //Update the specified attempt in storage.
    public function update(Request $request, Attempt $attempt)
    {
        $request->validate([
            'member_id'  => 'required|exists:members,id',
            'quiz_id'    => 'required|exists:quizzes,id',
            'started_at' => 'nullable|date',
            'end_at'     => 'nullable|date|after_or_equal:started_at',
            'marks'      => 'nullable|integer|min:0',
        ]);

        $attempt->update($request->all());

        return response()->json([
            'message' => 'Attempt updated successfully!',
            'data' => $attempt
        ]);
    }

    //Remove the specified attempt from storage.
    public function destroy(Attempt $attempt)
    {
        $attempt->delete();

        return response()->json([
            'message' => 'Attempt deleted successfully!'
        ]);
    }
}
