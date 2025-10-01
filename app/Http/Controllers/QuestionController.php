<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuestionController extends Controller{
    public function index()
    {
        // all quizzes with questions & options
        $questions = Question::with('options')->get();
        $quizzes = Quiz::all();
        return view('admin.options.index', compact('questions' , 'quizzes'));
    }

    //Show the form for creating a new question.
    public function create(Quiz $quiz)
    {
        return view('admin.questions.create', compact('quiz'));
    }
    public function store(Request $request, Quiz $quiz)
    {
        $request->validate([
            'text' => 'required|string|max:255',
            'options' => 'required|array|min:2',
            'options.*.text' => 'required|string|max:255',
            'correct_option' => 'required|integer',
        ]);
        // ✅ save question using correct column
        $question = $quiz->questions()->create([
            'questions_text' => $request->text,
        ]);
        // ✅ save options using correct column
        foreach ($request->options as $i => $opt)
        {
            $question->options()->create([
                'option_s' => $opt['text'],
                'correct_option' => ($request->correct_option == $i) ? 1 : 0,
            ]);
        }
        return redirect()->route('questions.create', $quiz->id)->with('success', 'Question added successfully! Add another or finish.');
    }
    
    //Display the specified question.
    public function show(Question $question)
    {
        $question->load(['quiz', 'options']);
        return response()->json($question);
    }

    //Show the form for editing the specified question.
    public function edit(Question $question)
    {
        $quizzes = Quiz::all();
        return view('admin.questions.edit', compact('question', 'quizzes'));
    }
    
    public function update(Request $request, Question $question)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'questions_text' => 'required|string|max:255',
            'options' => 'required|array|min:2',
            'options.*.text' => 'required|string|max:255',
            'correct_option' => 'required|integer',
        ]);

    // ✅ update question
    $question->update([
        'quiz_id' => $request->quiz_id,
        'questions_text' => $request->questions_text,
    ]);

    // ✅ delete old options before re-adding
    $question->options()->delete();

    // ✅ add updated options
    foreach ($request->options as $i => $opt) 
    {
        $question->options()->create([
            'option_s' => $opt['text'],
            'correct_option' => ($request->correct_option == $i) ? 1 : 0,
        ]);
    }
    return redirect()->route('questions.index')->with('success', 'Question updated successfully!');
}
public function destroy(Question $question)
{
    // delete related options first (to avoid orphan rows, if cascade not set)
    $question->options()->delete();

    // delete the question itself
    $question->delete();

    // redirect back to Manage Questions page with a success message
    return redirect()->route('questions.index')->with('success', 'Question deleted successfully!');
}
}













   