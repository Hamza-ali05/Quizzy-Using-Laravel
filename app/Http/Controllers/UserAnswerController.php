<?php

namespace App\Http\Controllers;

use App\Models\UserAnswer;
use App\Models\Attempt;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Http\Request;

class UserAnswerController extends Controller
{
    /**
     * Display a listing of all user answers.
     */
    public function index()
    {
        $answers = UserAnswer::with(['attempt', 'question', 'option'])->get();
        return response()->json($answers);
    }

    /**
     * Show the form for creating a new user answer.
     */
    public function create()
    {
        $attempts  = Attempt::all();
        $questions = Question::all();
        $options   = Option::all();

        return view('student.attempt', compact('attempts', 'questions', 'options'));
    }

    /**
     * Store a newly created user answer in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'member_id'   => 'required|exists:members,id',
            'quiz_id'     => 'required|exists:quizzes,id',
            'question_id' => 'required|exists:questions,id',
            'option_id'   => 'required|exists:options,id',
            'attempt_id'  => 'nullable|exists:attempts,id',
        ]);

        $answer = UserAnswer::updateOrCreate(
            [
                'member_id'   => $request->member_id,
                'quiz_id'     => $request->quiz_id,
                'question_id' => $request->question_id,
                'attempt_id'  => $request->attempt_id,
            ],
            [
                'option_id'   => $request->option_id,
            ]
        );

        return response()->json([
            'message' => 'Answer saved successfully',
            'data'    => $answer
        ], 201);
    }

    /**
     * Display a single user answer.
     */
    public function show(UserAnswer $userAnswer)
    {
        $userAnswer->load(['attempt', 'question', 'option']);
        return response()->json($userAnswer);
    }

    /**
     * Show the form for editing a user answer.
     */
    public function edit(UserAnswer $userAnswer)
    {
        $attempts  = Attempt::all();
        $questions = Question::all();
        $options   = Option::all();

        return view('student.editoptions', compact('userAnswer', 'attempts', 'questions', 'options'));
    }

    /**
     * Update a user answer.
     */
    public function update(Request $request, UserAnswer $userAnswer)
    {
        $request->validate([
            'option_id'   => 'required|exists:options,id',
        ]);

        $userAnswer->update($request->all());

        return response()->json([
            'message' => 'Answer updated successfully!',
            'data'    => $userAnswer
        ]);
    }

    /**
     * Delete a user answer.
     */
    public function destroy(UserAnswer $userAnswer)
    {
        $userAnswer->delete();

        return response()->json([
            'message' => 'Answer deleted successfully!'
        ]);
    }
}
