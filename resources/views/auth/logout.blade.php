@extends('layouts.app')

@section('title','Logged out - Quizzy')

@section('content')
<div class="text-center">
  <div class="card card-accent p-4 mx-auto" style="max-width:600px">
    <h3>You've been logged out</h3>
    <p>Thanks for visiting Quizzy.</p>
    <a href="{{ route('welcome') }}" class="btn btn-primary-custom">Return to Home</a>
  </div>
</div>
@endsection
