<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Attempt;
use App\Models\Question;
use App\Models\Option;

class ResultController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'admin') {
        // Admin can see results only for quizzes he created
        $attempts = Attempt::with(['member', 'quiz'])->whereHas('quiz', function ($q) use ($user) {
            $q->where('created_by', $user->id);
        })
        ->get();
    }
    elseif ($user->role === 'student') {
        // Student can only see his own attempts
        $attempts = Attempt::with(['member', 'quiz'])
            ->where('member_id', $user->id)
            ->get();
    } else {
        // For safety, no results
        $attempts = collect();
    }

    return view('results.index', compact('attempts'));
}

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

    public function show($id)
    {
        $result = Result::with(['attempt', 'question', 'option'])->findOrFail($id);

        return view('results.show', compact('result'));
    }

    public function destroy($id)
    {
        $result = Result::findOrFail($id);
        $result->delete();

        return redirect()->route('results.index')->with('success', 'Result deleted successfully.');
    }
}

