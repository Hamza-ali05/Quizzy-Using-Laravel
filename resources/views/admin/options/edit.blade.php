@extends('layouts.app')

@section('title','Edit Option - Quizzy')

@section('content')
<div class="card card-accent p-4">
  <h3>Edit Option</h3>
  <form method="POST" action="{{ route('admin.options.update',$option->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label class="form-label">Question ID</label>
      <input type="number" name="question_id" value="{{ $option->question_id }}" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Option Text</label>
      <input type="text" name="option_s" value="{{ $option->option_s }}" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Is Correct?</label>
      <select name="correct_option" class="form-select">
        <option value="0" {{ !$option->correct_option ? 'selected' : '' }}>No</option>
        <option value="1" {{ $option->correct_option ? 'selected' : '' }}>Yes</option>
      </select>
    </div>

    <button class="btn btn-primary-custom">Update Option</button>
    <a href="{{ route('admin.options.index') }}" class="btn btn-outline-secondary">Cancel</a>
  </form>
</div>
@endsection
