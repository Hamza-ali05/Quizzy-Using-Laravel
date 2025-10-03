<?php 
namespace App\Http\Controllers; //define controller location 

use App\Models\Quiz; //import quiz model 
use App\Models\Member; //import member model 
use Illuminate\Http\Request; //import request 

class QuizController extends Controller 
{ 
    /**
     * Display a listing of quizzes.
     */
    public function index() 
    {
        // Load quizzes with their creator (member) 
        $quizzes = Quiz::with('creator')->get(); 
        return view('admin.quizzes.index', compact('quizzes')); 
        return response()->json($quizzes); 
    }

    /**
     * Show the form for creating a new quiz.
     */
    public function create() 
    { 
        // If using Blade views
        $quizzes = Quiz::all();
        return view('admin.quizzes.create'); 
        //return view('admin.quizzes.create', compact('members')); 
    }

    /**
     * Store a newly created quiz in storage.
     */
    public function store(Request $request) 
    {
        $validated = $request->validate([ 
            'title' => 'required|string|max:255', 
            'description' => 'nullable|string|max:200', 
        ]);

        $quiz = \App\Models\Quiz::create([
            'title' => $validated['title'], 
            'description' => $validated['description'] ?? null, 
            'created_by' => auth()->id(), // ✅ fixed: set automatically 
        ]); 

        // Redirect admin to add questions for this quiz
        return redirect()->route('questions.create', $quiz->id)->with('success', 'Quiz created successfully! Now add questions.');
    }

    /**
     * Display the specified quiz.
     */
    
    public function show($id)
{
    $quiz = \App\Models\Quiz::where('id', $id)
                ->where('created_by', auth()->id()) // ✅ only quizzes created by logged-in admin
                ->with('questions.options')
                ->firstOrFail();

    return view('admin.quizzes.show', compact('quiz'));
}

    
    public function edit(Quiz $quiz) 
    { 
        $members = Member::all();
        return view('admin.questions.edit', compact('quiz', 'members')); 
    }

    /**
     * Update the specified quiz in storage.
     */
    public function update(Request $request, Quiz $quiz) 
    { 
        $request->validate([ 
            'title' => 'required|string|max:150', 
            'description' => 'nullable|string|max:200', 
        ]);

        $quiz->update([ 
            'title' => $request->title, 
            'description' => $request->description, 
            'created_by' => auth()->id(), // ✅ fixed here too 
        ]); 

        return response()->json([ 
            'message' => 'Quiz updated successfully!', 
            'data' => $quiz 
        ]); 
    }

    /**
     * Remove the specified quiz from storage.
     */
    public function destroy(Quiz $quiz) 
    { 
        $quiz->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Quiz deleted successfully.');
    } 

}
