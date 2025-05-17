<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Feedback System</title>
        <link rel="icon" href="{{asset('/')}}images/c2c-restoration.png">
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- DataTables CSS -->
        <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <!-- Toastr CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
        <!-- SweetAlert2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
        
        <style>
            .sidebar {
                min-height: 100vh;
                background: #343a40;
                color: #fff;
                position: fixed;
                top: 0;
                left: 0;
                width: 250px;
                padding-top: 1rem;
                transition: all 0.3s;
            }
            .sidebar .nav-link {
                color: rgba(255,255,255,.75);
                padding: 0.75rem 1rem;
            }
            .sidebar .nav-link:hover {
                color: #fff;
                background: rgba(255,255,255,.1);
            }
            .sidebar .nav-link.active {
                color: #fff;
                background: rgba(255,255,255,.1);
            }
            .sidebar .nav-link i {
                margin-right: 0.5rem;
            }
            .sidebar .logo-img {
                height: 48px;
                max-width: 100%;
                object-fit: contain;
                margin-bottom: 1rem;
            }
            .main-content {
                margin-left: 250px;
                padding: 1rem;
            }
            .navbar {
                padding: 0.75rem 1.5rem;
                background: #fff;
                border-bottom: 1px solid #dee2e6;
                box-shadow: 0 2px 6px rgba(0,0,0,0.04);
                z-index: 1001;
            }
            .navbar .dropdown-menu {
                min-width: 160px;
                border-radius: 0.5rem;
                box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            }
            .navbar .dropdown-toggle {
                font-weight: 500;
            }
            @media (max-width: 991.98px) {
                .main-content {
                    padding: 0.5rem;
                }
            }
            @media (max-width: 768px) {
                .sidebar {
                    margin-left: -250px;
                }
                .sidebar.active {
                    margin-left: 0;
                }
                .main-content {
                    margin-left: 0;
                    padding: 0.5rem;
                }
                .main-content.active {
                    margin-left: 250px;
                }
                .dashboard-cards > .col-12 {
                    margin-bottom: 1rem;
                }
            }
            .navbar .profile-dropdown {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                background: #f5f6fa;
                border: 1px solid #e3e6ed;
                border-radius: 2rem;
                padding: 0.35rem 1rem 0.35rem 0.75rem;
                font-weight: 500;
                color: #222;
                box-shadow: 0 1px 4px rgba(0,0,0,0.04);
                text-decoration: none !important;
                transition: background 0.2s, box-shadow 0.2s;
            }
            .navbar .profile-dropdown:hover, .navbar .profile-dropdown:focus {
                background: #e9ecef;
                color: #111;
                text-decoration: none;
                box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            }
            .navbar .profile-dropdown .fa-user-circle {
                font-size: 1.25rem;
                color: #007bff;
            }
            .navbar .dropdown-toggle::after {
                margin-left: 0.5em;
            }
        </style>
        
        @stack('styles')
    </head>
    <body>
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="px-3 mb-4 text-center">
                <img src="{{ asset('images/c2c-restoration.png') }}" alt="Logo" class="logo-img">
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                       href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}" 
                       href="{{ route('customers.index') }}">
                        <i class="fas fa-envelope"></i> Send Feedback Mail
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('feedbacks.*') ? 'active' : '' }}" 
                       href="{{ route('feedbacks.index') }}">
                        <i class="fas fa-comments"></i> Customer Feedbacks
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg shadow-sm">
                <div class="container-fluid">
                    <button class="btn btn-link d-md-none" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="ms-auto">
                        <div class="dropdown">
                            <button class="profile-dropdown dropdown-toggle" type="button" id="userDropdown" 
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <div class="container-fluid py-4">
                @yield('content')
            </div>
        </div>

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- Toastr JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <!-- SweetAlert2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            // Configure Toastr
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000"
            };

            // CSRF Token setup for AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Sidebar Toggle for Mobile
            $('#sidebarToggle').on('click', function() {
                $('.sidebar').toggleClass('active');
                $('.main-content').toggleClass('active');
            });

            // SweetAlert2 Delete Confirmation
            function confirmDelete(url, callback) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        callback();
                    }
                });
            }
        </script>

        @stack('scripts')
    </body>
</html>
