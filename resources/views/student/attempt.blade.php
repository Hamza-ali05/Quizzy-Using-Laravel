@extends('layouts.app')

@section('title', 'Attempt Quiz - Quizzy')

@section('content')

<div class="card card-accent p-4 shadow-sm">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="m-0">{{ $quiz->title }}</h3>
    <div id="quiz-timer" class="badge bg-primary fs-6 px-3 py-2">Loading...</div>
  </div>

  <p class="text-muted">Question {{ $currentIndex }} of {{ $total }}</p>

  {{-- ✅ One single form, handles both Next & Finish --}}
  <form id="questionForm" method="POST" 
        action="{{ route('quizzes.submitAnswer', ['quiz' => $quiz->id, 'index' => $currentIndex]) }}">
    @csrf

    <input type="hidden" name="attempt_id" value="{{ $attempt->id }}">

    <div class="mb-3">
      <strong>{{ $question->questions_text }}</strong>
    </div>

    @foreach($question->options as $opt)
      <div class="form-check mb-2">
        <input class="form-check-input" type="radio" name="option_id" 
               value="{{ $opt->id }}" id="opt{{ $opt->id }}">
        <label class="form-check-label" for="opt{{ $opt->id }}">{{ $opt->option_s }}</label>
      </div>
    @endforeach

    <div class="d-flex justify-content-between mt-4">
      @if($currentIndex < $total)
        {{-- ✅ Next button --}}
        <button type="submit" class="btn btn-primary-custom">Next →</button>
      @else
        {{-- ✅ Finish button --}}
        <button id="finishBtn" type="submit" class="btn btn-success">Finish Quiz</button>
      @endif
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const endAt = new Date("{{ $attempt->end_at->toIso8601String() }}").getTime();
  const timerEl = document.getElementById('quiz-timer');
  const form = document.getElementById('questionForm');
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '{{ csrf_token() }}';
  let intervalId;

  function formatTime(seconds) {
    const m = Math.floor(seconds / 60);
    const s = seconds % 60;
    return `${m}:${s < 10 ? '0' + s : s}`;
  }

  function tick() {
    const now = Date.now();
    let remaining = Math.floor((endAt - now) / 1000);

    if (remaining <= 0) {
      clearInterval(intervalId);
      timerEl.textContent = '⏰ Time is up!';
      autoSubmit();
      return;
    }

    timerEl.textContent = `⏳ ${formatTime(remaining)} remaining`;
  }

  function autoSubmit() {
    timerEl.textContent = '⏰ Time up! Auto-submitting...';
    document.querySelectorAll('button').forEach(btn => btn.disabled = true);

    // ✅ Automatically submit unfinished attempt to Laravel
    fetch("{{ route('quizzes.autoSubmit', $quiz->id) }}", {
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": csrfToken,
        "Accept": "application/json",
        "Content-Type": "application/json"
      },
      body: JSON.stringify({ attempt_id: "{{ $attempt->id }}" })
    })
    .then(response => {
      if (response.ok) {
        window.location.href = "{{ route('results.index') }}";
      } else {
        // fallback
        form.submit();
      }
    })
    .catch(err => {
      console.error("Auto-submit failed:", err);
      form.submit(); // fallback
    });
  }

  // Start the timer
  intervalId = setInterval(tick, 1000);
  tick();

  // Stop timer manually if quiz finished early
  document.getElementById('finishBtn')?.addEventListener('click', function() {
    clearInterval(intervalId);
  });
});
</script>

@endpush
