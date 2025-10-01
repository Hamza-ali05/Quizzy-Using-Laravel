@extends('layouts.app')

@section('title','Add Option - Quizzy')

@section('content')
<div class="card card-accent p-4">
  <h3>Add Option</h3>
  <form method="POST" action="{{ route('options.store') }}">
    @csrf

    <div class="mb-3">
      <label class="form-label">Question ID</label>
      <input type="number" name="question_id" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Option Text</label>
      <input type="text" name="option_s" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Is Correct?</label>
      <select name="correct_option" class="form-select">
        <option value="0">No</option>
        <option value="1">Yes</option>
      </select>
    </div>

    <button class="btn btn-primary-custom">Save Option</button>
    <a href="{{ route('options.index') }}" class="btn btn-outline-secondary">Cancel</a>
  </form>
</div>
@endsection
