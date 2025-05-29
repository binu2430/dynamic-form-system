<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Form System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" >Dynamic Form System</a>
            <div class="navbar-nav">
            <div class="navbar-nav ms-auto d-flex flex-row align-items-center gap-3">
            @auth

    <a class="btn btn-success" href="{{ route('forms.index') }}">Manage Forms</a>
    @endauth


    @guest
        <a class="nav-link" href="{{ route('login') }}">Login</a>
        @if (Route::has('register'))
            <a class="nav-link" href="{{ route('register') }}">Register</a>
        @endif
    @else
        <span class="nav-link">{{ Auth::user()->name }}</span>
        <a class="nav-link" href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    @endguest
</div>            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>