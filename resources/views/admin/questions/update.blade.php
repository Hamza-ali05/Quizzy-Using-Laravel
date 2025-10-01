@extends('layouts.app')

@section('title','Question Updated - Quizzy')

@section('content')
<div class="card card-accent p-4 mx-auto" style="max-width:650px">
    <h3 class="mb-3">Update Confirmation</h3>
    <p class="text-success fw-bold">{{ $message ?? 'Question updated successfully!' }}</p>

    <table class="table table-bordered mt-3">
        <tr>
            <th>Question ID</th>
            <td>{{ $question->id }}</td>
        </tr>
        <tr>
            <th>Quiz</th>
            <td>{{ optional($question->quiz)->title }}</td>
        </tr>
        <tr>
            <th>Updated Question</th>
            <td>{{ $question->questions_text }}</td>
        </tr>
    </table>

    @if($question->options->count())
        <h5 class="mt-4">Options</h5>
        <ul class="list-group">
            @foreach($question->options as $opt)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $opt->option_s }}
                    @if($opt->correct_option)
                        <span class="badge bg-success">Correct</span>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif

    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('admin.questions.index') }}" class="btn btn-primary-custom">← Back to Questions</a>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Dashboard</a>
    </div>
</div>
@endsection
