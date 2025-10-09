<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Attempt;
use App\Models\UserAnswer;
use Illuminate\Http\Request; //import reques

class StudentController extends Controller
{
    
    public function dashboard()
    {
        $quizzes = Quiz::all();
        $attempts = Attempt::where('member_id', auth()->id())->with('quiz')->get();
        return view('student.dashboard', compact('quizzes', 'attempts'));
    }
  public function attempt(Quiz $quiz, $index = 1)
  {
    $user = auth()->user();
        $attempt = Attempt::where('member_id', $user->id)->where('quiz_id', $quiz->id)->whereNull('finished_at')->first();

        if ($attempt && $attempt->end_at && $attempt->end_at->isPast()) {
        return $this->finalizeAttemptAndRedirect($attempt, $quiz);}

        if (!$attempt) {$started = now();
            $endAt = $started->copy()->addMinutes($quiz->duration ?? 30);
            $attempt = Attempt::create([
            'member_id' => $user->id,
            'quiz_id' => $quiz->id,
            'started_at' => $started,
            'end_at' => $endAt,
            'marks' => null,
        ]);} else {
        if ($attempt->end_at && $attempt->end_at->isPast()) {
            
            return $this->finalizeAttemptAndRedirect($attempt, $quiz);
        }
    }

    
    $question = $quiz->questions()->skip($index - 1)->first();
    $total = $quiz->questions()->count();
    $currentIndex = $index;
    return view('student.attempt', compact('quiz','question','currentIndex','total','attempt'));}
    public function submitAnswer(Request $request, Quiz $quiz, $index)
{
    
    $request->validate([
        'option_id' => 'required|integer',
        'attempt_id' => 'required|integer'
    ]);

    
    $attempt = Attempt::findOrFail($request->attempt_id);
    if ($attempt->member_id !== auth()->id()) abort(403);

   
    $question = $quiz->questions()->skip($index - 1)->first();
    if (!$question) abort(404);

   
    UserAnswer::updateOrCreate(
        [
            'member_id'   => auth()->id(),
            'quiz_id'     => $quiz->id,
            'question_id' => $question->id,
            'attempt_id'  => $attempt->id,
        ],
        [
            'option_id'   => $request->option_id,
        ]
    );

    
    $next = $index + 1;

    if ($next <= $quiz->questions()->count()) {
        // still more questions
        return redirect()->route('quizzes.attempt', [$quiz->id, $next]);
    }

   
    return $this->finalizeAttemptAndRedirect($attempt, $quiz);
}
public function autoSubmit(Request $request, Quiz $quiz)
{
    $attempt = Attempt::find($request->attempt_id);

    if (!$attempt || $attempt->member_id !== auth()->id()) {
        abort(403);
    }

    return $this->finalizeAttemptAndRedirect($attempt, $quiz);
}


    private function finalizeAttemptAndRedirect($attempt, $quiz)
{
    
    $questions = $quiz->questions;
    $answers = UserAnswer::where('attempt_id', $attempt->id)->get();

    $answeredQuestionIds = $answers->pluck('question_id')->toArray();

    foreach ($questions as $question) {
        if (!in_array($question->id, $answeredQuestionIds)) {
            UserAnswer::create([
                'member_id'   => auth()->id(),
                'quiz_id'     => $quiz->id,
                'question_id' => $question->id,
                'option_id'   => null, // no option selected
                'attempt_id'  => $attempt->id,
            ]);
        }
    }

    $correctAnswers = 0;
    $totalQuestions = $quiz->questions()->count();

    foreach ($quiz->questions as $question) {
        $userAnswer = UserAnswer::where([
            'attempt_id' => $attempt->id,
            'question_id' => $question->id,
        ])->first();

        $correctOption = $question->options()->where('correct_option', 1)->first();

        if ($userAnswer && $correctOption && $userAnswer->option_id == $correctOption->id) {
            $correctAnswers++;
        }
    }

    $score = $correctAnswers;

    $attempt->update([
        'marks' => $score,
        'finished_at' => now(),
    ]);
    return redirect()->route('results.index')->with('success', '⏰ Time expired — your quiz was auto-submitted. You scored '. $score . ' out of ' . $totalQuestions . '.');
}

}