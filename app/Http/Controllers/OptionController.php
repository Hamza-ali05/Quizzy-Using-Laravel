<?php

namespace App\Http\Controllers;//define controller location

use App\Models\Quiz;//import quiz model
use App\Models\Option;//import option model
use App\Models\Question;//import question model
use Illuminate\Http\Request;//import request

class OptionController extends Controller
{
    //display the options
    public function index()
    {
       $quizzes = Quiz::with('questions.options')->get();
       $questions = Question::with('options','quiz')->get();
       return view('admin.options.index', compact('quizzes', 'questions'));

    }

   //show the form for creating a new option
    public function create()
    {
        // Get all questions to assign option
        $questions = Question::all();
        return view('admin.options.create', compact('questions'));
    }

    //stores a new created option
    public function store(Request $request)
    {
        $request->validate([
            'question_id'    => 'required|exists:questions,id',
            'option_s'       => 'required|string|max:255',
            'correct_option' => 'required|boolean',
        ]);

        Option::create($request->all());

        return redirect()->route('options.index')->with('success', 'Option created successfully.');
    }

    //display the specified option
    public function show(Option $option)
    {
        // return view('admin.options.show', compact('option'));
    }

    //editing the option as it show the form
    public function edit(Option $option)
    {
        $questions = Question::all();
        return view('admin.options.edit', compact('option', 'questions'));
    }

    //update the option in storage
    public function update(Request $request, Option $option)
    {
        $request->validate([
            'question_id'    => 'required|exists:questions,id',
            'option_s'       => 'required|string|max:255',
            'correct_option' => 'required|boolean',
        ]);

        $option->update($request->all());

        return redirect()->route('options.index')->with('success', 'Option updated successfully.');
    }

    
    //Remove the specified option from storage.
    public function destroy(Option $option)
    {
        $option->delete();
        return redirect()->route('options.index')->with('success', 'Option deleted successfully.');
    }
}
