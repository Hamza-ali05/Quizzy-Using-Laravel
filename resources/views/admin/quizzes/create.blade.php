@extends('layouts.app')

@section('title', 'Create Quiz - Admin Panel')

@section('content')
<div class="card p-4">
    <h2>Create New Quiz</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('quizzes.store') }}" method="POST">
        @csrf

        {{-- Quiz Title --}}
        <div class="mb-3">
            <label for="title" class="form-label">Quiz Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        {{-- Quiz Description --}}
        <div class="mb-3">
            <label for="description" class="form-label">Description (Optional)</label>
            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="duration" class="form-label">Duration (minutes)</label>
            <input type="number" name="duration" id="duration" class="form-control" min="1" value="{{ old('duration', 30) }}" required>
            <small class="text-muted">Set how long students have to finish the quiz.</small>
        </div>


        <button type="submit" class="btn btn-primary">Create Quiz</button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back to Quizzy</a>
    </form>
</div>
@endsection
