{{-- @extends('layouts.app')

@section('title','Add Questions - Quizzy')

@section('content')
<div class="card card-accent p-4">
  <h3>Add Questions to: {{ $quiz->title }}</h3>
  <p class="text-muted">Enter a question and provide 4 possible answers. Mark the correct one.</p>

  <form method="POST" action="{{ route('questions.store', $quiz->id) }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">Question Text</label>
        <textarea name="text" class="form-control" required></textarea>
    </div>

    <div class="row">
        @for($i=0; $i<4; $i++)
            <div class="col-md-6 mb-3">
                <label class="form-label">Option {{ $i+1 }}</label>
                <input type="text" name="options[{{ $i }}][text]" class="form-control" required>
                <div class="form-check mt-1">
                    <input class="form-check-input" type="radio" name="correct_option" value="{{ $i }}" {{ $i==0?'checked':'' }}>
                    <label class="form-check-label">Mark as Correct</label>
                </div>
            </div>
        @endfor
    </div>

    <div class="d-flex justify-content-between mt-4">
        <button class="btn btn-primary-custom">Save Question</button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Finish & Publish Quiz</a>
    </div>
</form>

</div>
@endsection
--}}

@extends('layouts.app')

@section('title','Add Questions - Quizzy')

@section('content')
<div class="card card-accent p-4">
  <h3>Add Questions to: {{ $quiz->title }}</h3>
  <p class="text-muted">Enter a question and provide 4 possible answers. Mark the correct one.</p>

  <form method="POST" action="{{ route('questions.store', $quiz->id) }}">
    @csrf

    {{-- Question --}}
    <div class="mb-3">
        <label class="form-label">Question</label>
        <input type="text" name="text" class="form-control" required>
    </div>

    {{-- Options --}}
    <div class="mb-3">
        <label class="form-label">Options</label>
        @for($i=0; $i<4; $i++)
            <div class="input-group mb-2">
                <input type="text" name="options[{{ $i }}][text]" class="form-control" placeholder="Option {{ $i+1 }}" required>
                <div class="input-group-text">
                    <input type="radio" name="correct_option" value="{{ $i }}" {{ $i==0?'checked':'' }}> Correct
                </div>
            </div>
        @endfor
    </div>

    <div class="d-flex justify-content-between mt-4">
        <button type="submit" class="btn btn-success">Save Question</button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Finish & Publish Quiz</a>
    </div>
  </form>

</div>
@endsection
