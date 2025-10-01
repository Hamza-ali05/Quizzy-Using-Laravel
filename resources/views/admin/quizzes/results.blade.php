@extends('layouts.app')

@section('title','Your Result - Quizzy')

@section('content')
<div class="card card-accent p-4 text-center">
  <h3>Quiz Completed!</h3>
  <p class="lead">You scored <strong>{{ $score }}</strong> out of <strong>{{ $total }}</strong>.</p>
  <a href="{{ route('student.dashboard') }}" class="btn btn-primary-custom">Back to Dashboard</a>
</div>
@endsection
-