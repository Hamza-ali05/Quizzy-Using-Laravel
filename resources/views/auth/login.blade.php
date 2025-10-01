@extends('layouts.app')

@section('title','Login - Quizzy')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card card-accent p-4">
      <h3 class="mb-3">Login to Quizzy</h3>

      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input name="email" type="email" value="{{ old('email') }}" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Password</label>
          <input name="password" type="password" class="form-control" required>
        </div>

        <div class="d-flex justify-content-between align-items-center">
          <button class="btn btn-primary-custom">Login</button>
          <a href="{{ route('register') }}" class="text-primary-custom">Create an account</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
