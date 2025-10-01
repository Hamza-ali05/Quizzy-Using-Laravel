@extends('layouts.app')

@section('title','Student Dashboard - Quizzy')

@section('content')
<div class="card card-accent p-4">
  <div class="d-flex justify-content-between align-items-center">
    <div>
      <h3>Welcome, {{ auth()->user()->name }}</h3>
    </div>
    <div>
      <a href="{{ route('results.index') }}" 
         class="btn btn-primary-custom fw-bold px-4">
        View Results
      </a>
    </div>
  </div>
</div>

<div class="card card-accent p-4 mt-3">
  <p>Here are the available quizzes you can attempt</p>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Quiz Title</th>
        <th>Description</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @forelse($quizzes as $quiz)
        <tr>
          <td>{{ $quiz->title }}</td>
          <td>{{ $quiz->description }}</td>
          <td>
            <a href="{{ route('quizzes.attempt', $quiz->id) }}" 
               class="btn btn-sm btn-primary-custom">
              Attempt
            </a>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="3" class="text-center text-muted">No quizzes available right now.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
