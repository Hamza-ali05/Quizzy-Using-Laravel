@extends('layouts.app')

@section('title','Create Quiz - Quizzy')

@section('content')
<div class="card card-accent p-4">
  <h3>Create Quiz</h3>
  <form method="POST" action="{{ route('quizzes.store') }}">
    @csrf
    <div class="mb-3">
      <label class="form-label">Title</label>
      <input name="title" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control"></textarea>
    </div>

    <div>
      <input type="hidden" name="created_by" value="{{ auth()->id() }}">
    </div>

    <button class="btn btn-primary-custom">Create</button>
  </form>
</div>
@endsection
