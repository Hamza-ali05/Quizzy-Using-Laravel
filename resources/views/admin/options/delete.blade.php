@extends('layouts.app')

@section('title','Delete Option - Quizzy')

@section('content')
<div class="card card-accent p-4">
  <h3>Delete Option</h3>
  <p>Are you sure you want to delete option <strong>{{ $option->option_s }}</strong>?</p>

  <form method="POST" action="{{ route('admin.options.destroy', $option->id) }}">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger">Yes, delete</button>
    <a href="{{ route('admin.options.index') }}" class="btn btn-outline-secondary">Cancel</a>
  </form>
</div>
@endsection
