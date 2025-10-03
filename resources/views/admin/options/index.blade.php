
@extends('layouts.app')

@section('title','Manage Questions & Options - Quizzy')

@section('content')
<div class="container">
    <h1>Manage Questions</h1>

    {{-- Create new quiz button --}}
    <a href="{{ route('quizzes.create') }}" class="btn btn-primary mb-3">+ Create New Quiz</a>

    {{-- ====================== --}}
    {{-- Section: Select Quiz --}}
    {{-- ====================== --}}
    @if($quizzes->count())
        <div class="mb-3">
            <label class="form-label">Select Quiz:</label>
            <select class="form-select d-inline w-auto" onchange="if(this.value) window.location=this.value;">
                <option value="{{ route('questions.index') }}">-- Select a quiz --</option>
                @foreach($quizzes as $quiz)
                    <option value="{{ route('questions.index', ['quiz_id' => $quiz->id]) }}"
                        {{ request('quiz_id') == $quiz->id ? 'selected' : '' }}>
                        {{ $quiz->title }}
                    </option>
                @endforeach
            </select>
        </div>
    @endif

    {{-- ====================== --}}
    {{-- Section: Questions Table --}}
    {{-- ====================== --}}
    @if($selectedQuiz)
        <div class="d-flex justify-content-between align-items-center mt-4">
            <h4>Questions for: <span class="text-primary">{{ $selectedQuiz->title }}</span></h4>

            {{-- ✅ Add Question button for the selected quiz --}}
            <a href="{{ route('questions.create', $selectedQuiz->id) }}" class="btn btn-success">
                + Add Question to this Quiz
            </a>
        </div>

        <table class="table table-bordered mt-3">
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
    @else
        <p class="text-muted mt-3">Please select a quiz to view its questions.</p>
    @endif
    <form>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back to Quizzy</a>
    </form>
</div>
@endsection
