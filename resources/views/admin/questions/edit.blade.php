@extends('layouts.app')

@section('title','Edit Question - Quizzy')

@section('content')
<div class="card card-accent p-4">
  <h3>Edit Question</h3>

  <form method="POST" action="{{ route('questions.update', $question->id) }}">
    @csrf
    @method('PUT')

    {{-- Question Text --}}
    <div class="mb-3">
      <label class="form-label">Question Text</label>
      <textarea name="questions_text" class="form-control" required>{{ $question->questions_text }}</textarea>
    </div>

    {{-- Select Quiz --}}
    <div class="mb-3">
      <label class="form-label">Quiz</label>
      <select name="quiz_id" class="form-control">
        @foreach($quizzes as $quiz)
          <option value="{{ $quiz->id }}" {{ $quiz->id == $question->quiz_id ? 'selected' : '' }}>
            {{ $quiz->title }}
          </option>
        @endforeach
      </select>
    </div>

    {{-- Options --}}
    <h5 class="mt-4">Options</h5>
    @foreach($question->options as $opt)
      <div class="mb-3">
        <input type="text" name="options[{{ $opt->id }}][text]" class="form-control" value="{{ $opt->option_s }}" required>
        <div class="form-check mt-1">
          <input type="radio" name="correct_option" value="{{ $opt->id }}" class="form-check-input" {{ $opt->correct_option ? 'checked' : '' }}>
          <label class="form-check-label">Correct</label>
        </div>
      </div>
    @endforeach

    {{-- Password --}}
    <div class="mb-3 mt-4">
      <label class="form-label">Admin Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>

    <button class="btn btn-primary-custom">Update Question</button>
  </form>
</div>
@endsection
