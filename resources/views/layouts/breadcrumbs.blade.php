@php
    use Illuminate\Support\Facades\Request;

    $segments = '';
    $url = '';
    $userRole = auth()->check() ? auth()->user()->role : null;

    // Map for friendly names
    $map = [
        'admin' => 'Admin',
        'student' => 'Student',
        'dashboard' => 'Dashboard',
        'quizzes' => 'Quizzes',
        'results' => 'Results',
        'view' => 'View Result',
        'create' => 'Create Quiz',
        'edit' => 'Edit Quiz',
        'questions' => 'Questions',
    ];
@endphp

@if(count(Request::segments()) > 0)
<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb bg-light p-2 rounded shadow-sm">

    {{-- Home --}}
    <li class="breadcrumb-item">
        <a href="{{ route('welcome') }}">Home</a>
    </li>

    {{-- Role breadcrumb --}}
    @if($userRole === 'admin')
        <li class="breadcrumb-item">
            <a href="{{ route('admin.dashboard') }}">Admin</a>
        </li>
    @elseif($userRole === 'student')
        <li class="breadcrumb-item">
            <a href="{{ route('student.dashboard') }}">Student</a>
        </li>
    @endif

    {{-- Loop through URL segments --}}
    @foreach(Request::segments() as $segment)
        @php
            // Skip duplicate role segment
            if ($segment === $userRole) continue;

            $url .= '/' . $segment;
            $label = $map[$segment] ?? ucfirst(str_replace('-', ' ', $segment));
        @endphp

        @if (!$loop->last)
            <li class="breadcrumb-item">
                <a href="{{ url($url) }}">{{ $label }}</a>
            </li>
        @else
            <li class="breadcrumb-item active" aria-current="page">{{ $label }}</li>
        @endif
    @endforeach

  </ol>
</nav>
@endif
