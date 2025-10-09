<?php 
namespace App\Http\Controllers; //define controller location 

use App\Models\Quiz; //import quiz model 
use App\Models\Member; //import member model 
use App\Models\UserAnswer;
use App\Models\Attempt;
use App\Models\Result;
use App\Models\Option;
use Illuminate\Http\Request; //import request 

class QuizController extends Controller 
{ 
    
    public function index() 
    {
        // Load quizzes with their creator (member) 
        $quizzes = Quiz::with('creator')->get(); 
        return view('admin.quizzes.index', compact('quizzes')); 
        return response()->json($quizzes); 
    }

   
    public function create() 
    { 
        $quizzes = Quiz::all();
        return view('admin.quizzes.create'); 
    }

    
    public function store(Request $request) 
    {
        $validated = $request->validate([ 
            'title' => 'required|string|max:255', 
            'description' => 'nullable|string|max:200',
            'duration' => 'required|integer|min:1'
        ]);

        $quiz = Quiz::create([
            'title' => $validated['title'], 
            'description' => $validated['description'] ?? null,
            'duration' => $validated['duration'],
            'created_by' => auth()->id(), 
        ]); 

        
        return redirect()->route('questions.create', $quiz->id)->with('success', 'Quiz created successfully! Now add questions.');
    }

   
    public function show($id)
{
    $quiz = Quiz::where('id', $id)
                ->where('created_by', auth()->id()) 
                ->with('questions.options')
                ->firstOrFail();

    return view('admin.quizzes.show', compact('quiz'));
}

    
    public function edit(Quiz $quiz) 
    { 
        $members = Member::all();
        return view('admin.questions.edit', compact('quiz', 'members')); 
    }

   
    public function update(Request $request, Quiz $quiz) 
    { 
        $request->validate([ 
            'title' => 'required|string|max:150', 
            'description' => 'nullable|string|max:200', 
            'duration' => 'required|integer|min:1'
        ]);

        $quiz->update([ 
            'title' => $request->title, 
            'description' => $request->description, 
            'duration' => $validated['duration'],
            'created_by' => auth()->id(), 
        ]); 

        return response()->json([ 
            'message' => 'Quiz updated successfully!', 
            'data' => $quiz 
        ]); 
    }

    public function submit(Request $request, Quiz $quiz)
{
    $request->validate(['attempt_id' => 'required|integer']);
    $attempt = Attempt::findOrFail($request->attempt_id);
    if ($attempt->member_id !== auth()->id()) abort(403);

    
    $answers = UserAnswer::where('attempt_id', $attempt->id)->where('quiz_id', $quiz->id)->get()->keyBy('question_id');

    $score = 0;
    $total = $quiz->questions()->count();

    foreach ($quiz->questions as $question) {
        $ua = $answers->get($question->id);
        if (!$ua) {
            
            $correct = false;
            $chosenOptionId = null;
        } else {
            $chosenOptionId = $ua->option_id;
            $correct = Option::where('id', $chosenOptionId)->where('correct_option', 1)->exists();
            if ($correct) $score++;
        }

        
        Result::create([
            'quiz_id' => $quiz->id,
            'student_id' => auth()->id(),
            'question_id' => $question->id,
            'option_id' => $chosenOptionId,
            'correct' => (int)$correct,
        ]);
    }

   
    $attempt->marks = $score;
    $attempt->finished_at = now();
    $attempt->save();

    
    if ($request->expectsJson() || $request->input('auto')) {
        return response()->json(['redirect' => route('quizzes.result', $quiz->id) ]);
    }

    return redirect()->route('quizzes.result', $quiz->id);
}
    
    public function destroy(Quiz $quiz) 
    { 
        $quiz->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Quiz deleted successfully.');
    } 

}
