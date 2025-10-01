@extends('layouts.app')

@section('title','Manage Questions & Options - Quizzy')

@section('content')
<div class="container">
    <h1>Manage Questions</h1>

    {{-- Create new quiz button --}}
    <a href="{{ route('quizzes.create') }}" class="btn btn-primary mb-3">+ Create New Quiz</a>

    {{-- Add question to a quiz --}}
    @if($quizzes->count())
        <div class="mb-3">
            <label class="form-label">Add Question to Quiz:</label>
            <select class="form-select d-inline w-auto" onchange="if(this.value) window.location=this.value;">
                <option value="">Select a quiz...</option>
                @foreach($quizzes as $quiz)
                    <option value="{{ route('questions.create', $quiz->id) }}">{{ $quiz->title }}</option>
                @endforeach
            </select>

            {{-- Extra button for adding a question --}}
            <a href="{{ route('questions.create', $quizzes->first()->id) }}" 
               class="btn btn-success ms-2">+ Add Question with Options</a>
        </div>
    @endif

    {{-- Questions + options table --}}
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Question</th>
                <th>Options</th>
                <th>Correct Option</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($questions as $question)
                <tr>
                    {{-- Question text --}}
                    <td>{{ $question->questions_text }}</td>

                    {{-- Options --}}
                    <td>
                        @foreach($question->options as $opt)
                            <span class="badge bg-secondary">{{ $opt->option_s }}</span>
                        @endforeach
                    </td>

                    {{-- Correct Option --}}
                    <td>
                        @foreach($question->options as $opt)
                            @if($opt->correct_option)
                                <span class="badge bg-success">{{ $opt->option_s }}</span>
                            @endif
                        @endforeach
                    </td>

                    {{-- Actions --}}
                    <td>
                        <a href="{{ route('questions.edit', $question->id) }}" 
                           class="btn btn-sm btn-outline-primary">Edit</a>

                        <form method="POST" action="{{ route('questions.destroy', $question->id) }}" 
                              class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this question and its options?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">No questions yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
