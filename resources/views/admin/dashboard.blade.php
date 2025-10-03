@extends('layouts.app')

@section('title','Admin Dashboard - Quizzy')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h3>Welcome, {{ auth()->user()->name }}</h3>
    <p class="text-muted">Here you can create and manage Quizzes.</p>
  </div>
  <a class="btn btn-primary-custom" href="{{ route('quizzes.create') }}">Create New Quiz</a>
</div>

<div class="row">
  <div class="col-md-8">
    <div class="card p-3 card-accent">
      <h5>Your Quizzes</h5>

      @if($quizzes->isEmpty())
        <p class="text-center text-muted mt-3">No quizzes created yet.</p>
      @else
        <table class="table mt-3">
          <thead>
            <tr>
              <th>Title</th>
              <th>Creator</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($quizzes as $quiz)
              <tr>
                <td>{{ $quiz->title }}</td>
                <td>{{ optional($quiz->creator)->name }}</td>
                <td class="d-flex gap-2">
                  {{-- View button --}}
                  <a class="btn btn-primary-custom" href="{{ route('quizzes.show', $quiz->id) }}">View</a>
                  
                  {{-- Delete button --}}
                  <form action="{{ route('quizzes.destroy', $quiz->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this quiz?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger-custom">Delete</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>

  <div class="col-md-4">
    <div class="card p-3 card-accent">
      <h6>Quick Actions</h6>
      <div class="d-grid gap-2"> 
        <a class="btn btn-primary-custom" href="{{ route('results.index') }}">View Results</a>
        <a class="btn btn-primary-custom" href="{{ route('questions.index') }}">Manage Questions</a>
      </div>
    </div>
  </div>
</div>
@endsection
