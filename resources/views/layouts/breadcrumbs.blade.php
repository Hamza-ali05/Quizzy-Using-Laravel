@php
    $segments = '';
    $url = '';
@endphp

@if(count(\Request::segments()) > 0)
<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb bg-light p-2 rounded">
    <li class="breadcrumb-item">
        <a href="{{ route('welcome') }}">Home</a>
    </li>

    @foreach(\Request::segments() as $segment)
        @php
            $url .= '/' . $segment;
        @endphp
        @if (!$loop->last)
            <li class="breadcrumb-item">
                <a href="{{ url($url) }}">{{ ucfirst(str_replace('-', ' ', $segment)) }}</a>
            </li>
        @else
            <li class="breadcrumb-item active" aria-current="page">{{ ucfirst(str_replace('-', ' ', $segment)) }}</li>
        @endif
    @endforeach
  </ol>
</nav>
@endif
