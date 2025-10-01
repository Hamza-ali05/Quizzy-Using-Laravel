@extends('layouts.app')

@section('title','Attempt Quiz - Quizzy')

@section('content')
<div class="card card-accent p-4">
    <h3>{{ $quiz->title }}</h3>
    <p class="text-muted">Question {{ $currentIndex }} of {{ $total }}</p>

    <form method="POST" action="{{ route('quizzes.submitAnswer', [$quiz->id, $currentIndex]) }}">
        @csrf
        <div class="mb-3">
            <strong>{{ $question->questions_text }}</strong>
        </div>

        @foreach($question->options as $opt)
            <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="option_id" 
                       value="{{ $opt->id }}" required>
                <label class="form-check-label">{{ $opt->option_s }}</label>
            </div>
        @endforeach

        <div class="d-flex justify-content-between mt-3">
            @if($currentIndex < $total)
            <button type="submit" class="btn btn-primary-custom">Next →</button>
            @else
                 <button type="submit" class="btn btn-success">Finish Quiz</button>
            @endif
        </div>
    </form>
</div>
@endsection
