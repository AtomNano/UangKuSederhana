
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UangKu - @yield('title', 'Manajemen Keuangan')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #f8f9fa; 
        } 
        .card { 
            border: none; 
            border-radius: 0.75rem; 
            box-shadow: 0 4px 6px rgba(0,0,0,.05); 
        }
        .navbar-nav .nav-link:hover {
            color: #0d6efd !important;
        }
        .navbar .active {
            color: #0d6efd !important;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <i class="bi bi-wallet2 text-primary me-2 fs-4"></i>
                <span class="fw-bold">UangKu</span>
            </a>

            <!-- Toggle Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- Public Links -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-house-door me-1"></i>Beranda
                        </a>
                    </li>
                    

                    <!-- Auth Links -->
                    @auth
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
           href="{{ route('dashboard') }}">
            <i class="bi bi-speedometer2 me-1"></i>Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}" 
           href="{{ route('transactions.index') }}">
            <i class="bi bi-journal-text me-1"></i>Transaksi
        </a>
    </li>
@endauth
<li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#aboutModal">
                            <i class="bi bi-info-circle me-1"></i>Tentang
                        </a>
                    </li>
                </ul>

                <!-- Right Side Links -->
                <ul class="navbar-nav ms-auto align-items-center">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary btn-sm ms-2" href="{{ route('register') }}">
                                <i class="bi bi-person-plus me-1"></i>Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- About Modal -->
    <div class="modal fade" id="aboutModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-info-circle me-2"></i>Tentang UangKu
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h6 class="fw-bold">Aplikasi Manajemen Keuangan Sederhana</h6>
                    <p>UangKu adalah aplikasi web yang dirancang untuk membantu Anda mengelola keuangan pribadi dengan mudah dan efektif.</p>
                    
                    <h6 class="fw-bold mt-4">Fitur Utama</h6>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Pencatatan transaksi keuangan</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Manajemen gaji dan tabungan otomatis</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Perencanaan anggaran</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Visualisasi data keuangan</li>
                    </ul>

                    <h6 class="fw-bold mt-4">Developer</h6>
                    <div class="d-flex align-items-center">
                        <img src="https://github.com/AtomNano.png" alt="Developer" 
                             class="rounded-circle me-3" style="width: 60px; height: 60px;">
                        <div>
                            <h6 class="mb-1">AtomNano</h6>
                            <p class="mb-0 small">
                                <a href="https://github.com/AtomNano" target="_blank" class="text-decoration-none">
                                    <i class="bi bi-github me-1"></i>@AtomNano
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main class="container py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>