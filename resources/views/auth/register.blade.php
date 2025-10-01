@extends('layouts.app')

@section('title','Register - Quizzy')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-7">
    <div class="card card-accent p-4">
      <h3>Create an account</h3>

      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">@foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach</ul>
        </div>
      @endif

      <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
          <label class="form-label">Full name</label>
          <input name="name" value="{{ old('name') }}" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input name="email" type="email" value="{{ old('email') }}" class="form-control" required>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Password</label>
            <input name="password" type="password" class="form-control" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Confirm Password</label>
            <input name="password_confirmation" type="password" class="form-control" required>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Role</label>
          <select name="role" class="form-select">
            <option value="student" selected>Student</option>
            <option value="admin">Admin</option>
          </select>
        </div>

        <div class="d-flex justify-content-between align-items-center">
          <button class="btn btn-primary-custom">Register</button>
          <a href="{{ route('login') }}" class="text-primary-custom">Already have an account?</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
