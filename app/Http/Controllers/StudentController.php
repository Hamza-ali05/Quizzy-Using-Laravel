<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Attempt;
use App\Models\UserAnswer;


class StudentController extends Controller
{
    public function dashboard()
    {
        $quizzes = \App\Models\Quiz::all();
        $attempts = \App\Models\Attempt::where('member_id', auth()->id())->with('quiz')->get();
        return view('student.dashboard', compact('quizzes', 'attempts'));
    }
    public function submitAnswer(Request $request, \App\Models\Quiz $quiz, $index)
    {
        $student = auth()->user();
        // create attempt if not exists
        $attempt = \App\Models\Attempt::firstOrCreate
        (
            ['member_id' => $student->id, 'quiz_id' => $quiz->id],
            ['marks' => 0]
        );
        $question = $quiz->questions[$index - 1] ?? null;
        if (!$question)
        {
            return redirect()->route('student.dashboard')->with('error', 'Invalid question.');
        }
        $chosen = $request->option_id;
        $isCorrect = $question->options()->where('id', $chosen)->where('correct_option', 1)->exists();
        if ($isCorrect) 
        {
            $attempt->increment('marks');
        }
        \App\Models\UserAnswer::create([
            'member_id'   => $student->id,
            'quiz_id'     => $quiz->id,
            'question_id' => $question->id,
            'option_id'   => $chosen,
            'attempt_id'  => $attempt->id,
        ]);
        if ($index < $quiz->questions->count()) {
            return redirect()->route('quizzes.attempt', [$quiz->id, $index + 1]);
        }
        return redirect()->route('student.dashboard')->with('success', 'Quiz finished! Your score has been saved.');
    }
    public function attempt(Quiz $quiz, $questionIndex = 1){
    // find or create attempt for this user + quiz


    $attempt = Attempt::firstOrCreate(
        [
            'member_id' => auth()->id(),
            'quiz_id'   => $quiz->id,
        ]
    );
    $questions = $quiz->questions()->with('options')->get();
    $total = $questions->count();
    if ($questionIndex > $total) {
        // TODO: calculate marks & redirect
        return redirect()->route('results.index')->with('success', 'Quiz completed!');
    }
    $question = $questions[$questionIndex - 1];
    return view('student.attempt', [
        'quiz' => $quiz,
        'question' => $question,
        'currentIndex' => $questionIndex,
        'total' => $total,
        'attempt' => $attempt,
    ]);
}
}
