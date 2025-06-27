<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klinik Sehat - @yield('title', 'Home')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Custom styles can be added here */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .main-content {
            flex: 1;
        }
        .footer {
            background-color: #198754; /* Matching navbar color */
        }
    </style>
</head>
<body>

    <!-- Navbar Section -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                <i class="bi bi-heart-pulse-fill"></i>
                Klinik Sehat
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Main Nav Links -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('dokter/create') ? 'active' : '' }}" href="/dokter/create">Add Dokter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('bookings*') ? 'active' : '' }}" href="/bookings">My Bookings</a>
                    </li>
                </ul>

                <!-- Search Form -->
                <form class="d-flex me-3" action="{{ url('/') }}" method="GET" role="search">
                    <input class="form-control me-2" type="search" name="search" placeholder="Cari Dokter..." aria-label="Search" value="{{ request('search') }}">
                    <button class="btn btn-light" type="submit"><i class="bi bi-search"></i></button>
                </form>

                <!-- Auth Links -->
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i> Hello, {{ explode(' ', auth()->user()->name)[0] }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="/dashboard">Dashboard</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Login</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{ route('register') }}" class="btn btn-light">Register</a>
                        </li> --}}
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="container my-4 main-content">
        @yield('content')
    </div>

    <!-- Footer Section -->
    <footer class="footer text-white text-center py-3 mt-auto">
        <div class="container">
            Copyright © {{ date('Y') }} | Developed by <strong>Haura Adisty</strong>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
