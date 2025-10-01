@extends('layouts.app')

@section('title','Welcome - Quizzy')

@section('content')
<div class="text-center">
  <div class="mx-auto" style="max-width:900px">
    <div class="card card-accent p-4">
      <h1 class="mb-3" style="color:var(--primary)">Welcome to Quizzy</h1>
      <p class="lead">Create, share and attempt quizzes. Simple, fast and pretty.</p>
      <div class="d-flex justify-content-center gap-2 mt-4">
        @guest
          <a class="btn btn-lg btn-primary-custom" href="{{ route('register') }}">Get Started</a>
          <a class="btn btn-lg btn-outline-primary" href="{{ route('login') }}">Login</a>
        @else
          <a class="btn btn-lg btn-primary-custom" href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('student.dashboard') }}">Go to Dashboard</a>
        @endguest
      </div>
    </div>
  </div>
</div>
@endsection
