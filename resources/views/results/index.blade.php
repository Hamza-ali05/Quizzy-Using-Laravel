@extends('layouts.app')

@section('title','Results - Quizzy')

@section('content')
<div class="card card-accent p-4">
  <h3>All Quiz Results</h3>
  <p class="text-muted">Here are the results of submitted quizzes.</p>

  <table class="table table-bordered mt-3">
    <thead class="table-light">
      <tr>
        <th>Student</th>
        <th>Quiz</th>
        <th>Score</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      @forelse($attempts as $attempt)
        <tr>
          <td>{{ optional($attempt->member)->name }}</td>
          <td>{{ optional($attempt->quiz)->title }}</td>
          <td>{{ $attempt->marks ?? 0 }}</td>
          <td>{{ $attempt->created_at->format('d M Y, H:i') }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="4" class="text-center text-muted">No results yet.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
