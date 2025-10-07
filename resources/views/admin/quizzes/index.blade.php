@extends('layouts.app')

@section('title','All Quizzes - Quizzy')
@section('content')
<div class="container">
    <h1>Quizzes</h1>

    <a href="{{ route('quizzes.create') }}" class="btn btn-primary mb-3">+ Create Quiz</a>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Title</th>
                <th>Description</th>
                
            </tr>
        </thead>
        <tbody>
            @forelse($quizzes as $quiz)
                <tr>
                    <td>{{ $quiz->title }}</td>
                    <td>{{ $quiz->description ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center text-muted">No quizzes found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
