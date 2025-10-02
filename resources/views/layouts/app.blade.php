<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title', 'Quizzy')</title>

  <!-- Bootstrap (CDN) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root{
      --primary: #6C5CE7;
      --primary-dark: #5446c9;
      --accent: #6C5CE7;
      --muted:#f5f4ff;
      --text: #0f172a;
    }
    body { background: linear-gradient(180deg,var(--muted), #ffffff); color:var(--text); }
    .navbar-brand { font-weight:700; letter-spacing:0.6px; color:white !important; }
    .bg-primary-custom { background: var(--primary) !important; }
    .btn-primary-custom { background: var(--primary); border-color: var(--primary); color: #fff; }
    .card-accent { border-top: 4px solid var(--primary); box-shadow: 0 8px 18px rgba(108,92,231,0.06); }
    a.text-primary-custom { color: var(--primary); }
    footer { padding: 18px 0; text-align:center; color:#6b7280; font-size:14px; }
    .nav-link { color: rgba(255,255,255,0.92) !important; }
    .form-label { font-weight:600; }
    .btn-danger-custom {background-color: #dc3545; color: #fff; border: none; padding: 6px 12px; border-radius: 4px; transition: background-color 0.3s;}
.btn-danger-custom:hover { background-color: #b02a37; color: #fff;}

  </style>

  @stack('styles')
</head>
<body>
  <nav class="navbar navbar-expand-lg bg-primary-custom">
    <div class="container">
      <a class="navbar-brand" href="{{ route('welcome') }}">Quizzy</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon" style="color:#fff">☰</span>
      </button>

      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          
          
        </ul>

        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          @auth
            <li class="nav-item"><a class="nav-link" href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('student.dashboard') }}">Dashboard</a></li>
            <li class="nav-item">
              <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button class="btn btn-sm btn-outline-light">Logout</button>
              </form>
            </li>
          @else
            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>

  <main class="py-5">
    <div class="container">
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @yield('content')
    </div>
  </main>

  <footer>
    <div class="container">
      &copy; {{ date('Y') }} Quizzy · Built with ❤️
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>
