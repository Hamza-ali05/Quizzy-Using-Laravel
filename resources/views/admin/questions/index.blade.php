@extends('layouts.app')

@section('title','Manage Questions - Quizzy')

@section('content')
<div class="container">
    <h1>Questions</h1>

    <a href="{{ route('quizzes.index') }}" class="btn btn-secondary mb-3">Back to Quizzes</a>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Question</th>
                <th>Quiz</th>
                <th>Options</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($questions as $question)
                <tr>
                    <td>{{ $question->text }}</td>
                    <td>{{ $question->quiz->title ?? 'N/A' }}</td>
                    <td>
                        @foreach($question->options as $opt)
                            <span class="badge {{ $opt->correct_option ? 'bg-success' : 'bg-secondary' }}">
                                {{ $opt->option_text }}
                            </span>
                        @endforeach
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted">No questions found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
