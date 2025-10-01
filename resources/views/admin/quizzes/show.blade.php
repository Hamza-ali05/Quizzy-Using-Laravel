@extends('layouts.app')

@section('title', $quiz->title . ' - Quizzy')

@section('content')
<div class="card card-accent p-4">
  <h3>{{ $quiz->title }}</h3>
  <p class="text-muted">{{ $quiz->description }}</p>

  <table class="table table-bordered mt-3">
    <thead class="table-light">
      <tr>
        <th>#</th>
        <th>Question</th>
        <th>Options</th>
        <th>Correct Option</th>
      </tr>
    </thead>
    <tbody>
      @foreach($quiz->questions as $index => $question)
        <tr>
          <td>{{ $index+1 }}</td>
          <td>{{ $question->questions_text }}</td>
          <td>
            @foreach($question->options as $opt)
              <span class="badge bg-secondary me-1">{{ $opt->option_s }}</span>
            @endforeach
          </td>
          <td>
            @foreach($question->options as $opt)
              @if($opt->correct_option)
                <span class="badge bg-success">{{ $opt->option_s }}</span>
              @endif
            @endforeach
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection