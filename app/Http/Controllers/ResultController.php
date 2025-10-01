<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Attempt;
use App\Models\Question;
use App\Models\Option;

class ResultController extends Controller
{
    /**
     * Display a listing of results.
     */
    public function index()
    {
        // Load results with relationships
        $attempts = \App\Models\Attempt::with(['member', 'quiz'])->get();

        return view('results.index', compact('attempts'));

    }

    /**
     * Store a newly created result in storage.
     */
    public function store(Request $request, Quiz $quiz)
    {
        $student = auth()->user();
        $score = 0;
        $total = $quiz->questions()->count();
        foreach ($quiz->questions as $question) {
        $chosen = $request->input("question_{$question->id}");

        $isCorrect = $question->options()->where('id', $chosen)->where('correct_option', 1)->exists();

        if ($isCorrect) $score++;

        Result::create([
            'quiz_id'     => $quiz->id,
            'student_id'  => $student->id,
            'question_id' => $question->id,
            'option_id'   => $chosen,
            'correct'     => $isCorrect,
        ]);
     }
     return view('student.results.show', compact('score', 'total'));
    }

    /**
     * Display the specified result.
     */
    public function show($id)
    {
        $result = Result::with(['attempt', 'question', 'option'])->findOrFail($id);

        return view('results.show', compact('result'));
    }

    /**
     * Remove the specified result from storage.
     */
    public function destroy($id)
    {
        $result = Result::findOrFail($id);
        $result->delete();

        return redirect()->route('results.index')->with('success', 'Result deleted successfully.');
    }
}

