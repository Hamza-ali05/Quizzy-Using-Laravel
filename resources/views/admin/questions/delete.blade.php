@extends('layouts.app')

@section('title','Delete Quiz - Quizzy')

@section('content')
<div class="card card-accent p-4">
  <h3>Delete Quiz</h3>
  <p>Are you sure you want to delete <strong>{{ $quiz->title }}</strong>?</p>

  <form action="{{ route('quizzes.destroy', $quiz->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger">Yes, delete</button>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
  </form>
</div>
@endsection
