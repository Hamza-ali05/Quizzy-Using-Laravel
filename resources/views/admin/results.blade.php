@extends('layouts.app')

@section('title','Results - Quizzy')

@section('content')
<div class="card card-accent p-4">
  <h3>All Quiz Results</h3>
  <p class="text-muted">Here are the results of all submitted quizzes.</p>

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
      @forelse($results as $result)
        <tr>
          <td>{{ optional($result->member)->name }}</td>
          <td>{{ optional($result->quiz)->title }}</td>
          <td>{{ $result->score }}</td>
          <td>{{ $result->created_at->format('d M Y, H:i') }}</td>
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
