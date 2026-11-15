<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'VisitorCHED - Visitor Management System')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<header class="topbar">
    <div class="container nav">
        <a class="brand" href="{{ route('visitors.index') }}">VisitorCHED - Visitor Management System</a>
        <nav aria-label="Main navigation">
            <a href="{{ route('visitors.index') }}" class="{{ request()->routeIs('visitors.index') ? 'active' : '' }}">Visitor Records</a>
            <a class="navbutton" href="{{ route('visitors.create') }}">+ Register Visitor</a>
        </nav>
    </div>
</header>
<main class="container page">
    @if (session('success'))
        <div class="alert alert-success" role="status">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-error" role="alert">
            <strong>Please correct the following errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @yield('content')
</main>
<footer class="container muted" style="padding: 0 0 22px; text-align:center;">VisitorCHED - Visitor Management System</footer>
</body>
</html>
