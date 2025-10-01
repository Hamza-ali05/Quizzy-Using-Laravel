@extends('layouts.app')

@section('title','Result Details - Quizzy')

@section('content')
<div class="card card-accent p-4 mx-auto" style="max-width:700px">
    <h3 class="mb-3">Result Details</h3>

    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>Student</th>
                <td>{{ optional($result->attempt->member)->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Quiz</th>
                <td>{{ optional($result->attempt->quiz)->title ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Question</th>
                <td>{{ optional($result->question)->questions_text ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Selected Option</th>
                <td>{{ optional($result->option)->option_s ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Correct?</th>
                <td>
                    @if($result->correct)
                        <span class="badge bg-success">✔ Correct</span>
                    @else
                        <span class="badge bg-danger">✖ Wrong</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Date</th>
                <td>{{ $result->created_at->format('d M Y, H:i') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="d-flex justify-content-between mt-3">
        <a href="{{ route('results.index') }}" class="btn btn-outline-secondary">← Back to Results</a>
        <a href="{{ route('student.dashboard') }}" class="btn btn-primary-custom">Go to Dashboard</a>
    </div>
</div>
@endsection
