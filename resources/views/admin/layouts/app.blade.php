<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom styles -->
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-light: #4895ef;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --info-color: #4895ef;
            --warning-color: #f72585;
            --danger-color: #e63946;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --sidebar-width: 255px;
            --header-height: 70px;
            --card-border-radius: 12px;
            --transition-speed: 0.3s;
            --box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            --box-shadow-hover: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* Main Layout Structure - New Layout */
        .admin-layout {
            display: flex;
            flex-direction: row;
            min-height: 100vh;
            width: 100%;
        }

        /* Sidebar Styles - Updated */
        .sidebar {
            width: var(--sidebar-width);
            background: white;
            color: #495057;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 0;
            z-index: 1031;
            box-shadow: var(--box-shadow);
            transition: all var(--transition-speed);
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE and Edge */
            border-right: 1px solid rgba(0, 0, 0, 0.05);
        }

        .sidebar::-webkit-scrollbar {
            width: 0; /* Chrome, Safari, Opera */
            display: none;
        }

        .sidebar-brand {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            background: linear-gradient(to right, rgba(67, 97, 238, 0.03), transparent);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .sidebar-brand .sidebar-logo {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .sidebar-brand .sidebar-logo i {
            font-size: 1.5rem;
            color: white;
        }
        
        .logo-circle {
            background: var(--primary-color);
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.2);
        }

        .sidebar-brand .fw-bold {
            font-size: 1.2rem;
            color: var(--primary-color);
        }

        .sidebar-toggle-btn {
            background: white;
            border: none;
            color: #555;
            cursor: pointer;
            transition: all 0.3s;
            width: 40px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0 10px 10px 0;
            position: fixed;
            left: var(--sidebar-width);
            top: 10px;
            z-index: 1032;
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-toggle-btn i {
            font-size: 1.8rem;
            color: var(--primary-color);
            transition: all 0.3s;
        }

        .sidebar-toggle-btn:hover {
            color: var(--primary-color);
            background: rgba(67, 97, 238, 0.05);
            width: 45px;
        }
        
        .sidebar-toggle-btn:hover i {
            transform: scale(1.2);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            padding: 1.2rem 1.5rem;
            background: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
        }

        .sidebar-user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 2px 10px rgba(67, 97, 238, 0.2);
        }

        .sidebar-user-info {
            margin-left: 12px;
            overflow: hidden;
        }

        .sidebar-user-name {
            font-weight: 600;
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #333;
        }

        .sidebar-user-role {
            font-size: 12px;
            color: #666;
        }

        .sidebar .nav-item {
            position: relative;
            margin: 0px 12px;
        }

        .sidebar .nav-link {
            color: #555;
            padding: 0.6rem 1.2rem;
            font-weight: 400;
            display: flex;
            align-items: center;
            transition: all 0.2s;
            border-radius: 8px;
            position: relative;
            overflow: hidden;
            margin-bottom: 4px;
        }

        .sidebar .nav-link:hover {
            color: var(--primary-color);
            background-color: rgba(67, 97, 238, 0.05);
            transform: translateX(3px);
        }

        .sidebar .nav-link.active {
            color: var(--primary-color);
            background: linear-gradient(90deg, rgba(67, 97, 238, 0.15), rgba(67, 97, 238, 0.05));
            font-weight: 600;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            transform: translateX(5px);
        }

        .sidebar .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: var(--primary-color);
            border-radius: 0 4px 4px 0;
        }

        .sidebar .nav-link i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
            font-size: 1rem;
            opacity: 0.8;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover i {
            opacity: 1;
            color: var(--primary-color);
        }

        .sidebar .nav-link.active i {
            opacity: 1;
            color: var(--primary-color);
            transform: scale(1.2);
            filter: drop-shadow(0 0 2px rgba(67, 97, 238, 0.3));
            animation: iconPulse 2s infinite;
        }

        @keyframes iconPulse {
            0% {
                filter: drop-shadow(0 0 2px rgba(67, 97, 238, 0.3));
            }
            50% {
                filter: drop-shadow(0 0 5px rgba(67, 97, 238, 0.5));
            }
            100% {
                filter: drop-shadow(0 0 2px rgba(67, 97, 238, 0.3));
            }
        }

        .sidebar .nav-link .badge {
            margin-left: auto;
            font-size: 0.65rem;
            font-weight: 400;
            padding: 0.35em 0.65em;
        }

        .sidebar-heading {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 1.2rem 1.8rem 0.5rem;
            color: #888;
            font-weight: 600;
            margin-bottom: 0;
        }

        .sidebar-footer {
            padding: 1rem 1.5rem;
            margin-top: auto;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            margin-top: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-footer a {
            color: #666;
            text-decoration: none;
            transition: all 0.2s;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            background-color: rgba(0, 0, 0, 0.03);
        }

        .sidebar-footer a:hover {
            color: var(--primary-color);
            background-color: rgba(67, 97, 238, 0.08);
        }

        .sidebar-footer a i {
            margin-right: 8px;
        }

        .sidebar-collapsed .sidebar {
            width: 65px;
        }

        .sidebar-collapsed .sidebar .sidebar-heading,
        .sidebar-collapsed .sidebar .nav-link span,
        .sidebar-collapsed .sidebar .sidebar-brand .fw-bold,
        .sidebar-collapsed .sidebar-user-info,
        .sidebar-collapsed .sidebar-footer span,
        .sidebar-collapsed .nav-link .badge {
            display: none;
        }

        .sidebar-collapsed .sidebar .nav-link {
            padding: 0.7rem;
            justify-content: center;
        }

        .sidebar-collapsed .sidebar .nav-link i {
            margin-right: 0;
            font-size: 1.1rem;
        }

        .sidebar-collapsed .content-container {
            margin-left: 65px;
        }

        .sidebar-collapsed .sidebar-user {
            justify-content: center;
        }

        .sidebar-collapsed .sidebar-brand {
            justify-content: center;
        }

        .sidebar-collapsed .sidebar-footer {
            justify-content: center;
            padding: 1rem 0;
        }

        .sidebar-collapsed .sidebar-toggle-btn {
            left: 65px;

            background: var(--primary-color);
        }
        .sidebar-collapsed .sidebar-toggle-btn:hover i {
            transform: rotate(180deg);
        }
        
        .sidebar-collapsed .sidebar-toggle-btn i {
            color: white;
        }

        .sidebar-collapsed .sidebar-toggle-btn i:hover {
            transform: rotate(180deg);
            background: var(--primary-light);
        }

        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
                width: 255px;
            }
            
            .content-container {
                margin-left: 0;
            }
            
            .sidebar-collapsed .content-container {
                margin-left: 0;
            }
            
            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1020;
                display: none;
                backdrop-filter: blur(2px);
                -webkit-backdrop-filter: blur(2px);
            }
            
            .sidebar-overlay.show {
                display: block;
            }
            
            .sidebar-collapsed .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar-collapsed .sidebar.show {
                transform: translateX(0);
            }
        }

        /* Animation */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Content Container */
        .content-container {
            flex: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            transition: all var(--transition-speed);
        }

        /* Navbar Styles - Updated with modern clean design */
        .admin-navbar {
            height: var(--header-height);
            background: white;
            box-shadow: var(--box-shadow);
            padding: 0 1.5rem;
            position: relative;
            width: 100%;
            z-index: 1030;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            margin-bottom: 10px;
        }

        .admin-navbar h5 {
            color: var(--dark-color);
            font-size: 1.25rem;
            position: relative;
            padding-left: 15px;
        }
        
        .admin-navbar h5:before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 20px;
            width: 5px;
            background: var(--primary-color);
            border-radius: 5px;
        }

        .admin-navbar .navbar-brand {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            position: relative;
        }

        .admin-navbar .navbar-brand i {
            font-size: 1.2rem;
            margin-right: 8px;
            color: var(--primary-color);
            transition: all 0.3s;
        }

        .admin-navbar .navbar-brand:hover i {
            transform: translateX(-3px);
        }

        .admin-navbar .nav-link {
            color: #555;
            font-weight: 500;
            padding: 0.6rem 1rem;
            border-radius: 8px;
            transition: all 0.2s;
            margin: 0 3px;
            position: relative;
        }

        .admin-navbar .nav-link:hover {
            color: var(--primary-color);
            background-color: rgba(67, 97, 238, 0.05);
        }

        .admin-navbar .navbar-toggler {
            border: none;
            color: #555;
            background-color: rgba(0, 0, 0, 0.03);
            padding: 0.5rem;
            border-radius: 8px;
            margin-left: 0.5rem;
            transition: all 0.2s;
        }

        .admin-navbar .navbar-toggler:hover {
            background-color: rgba(67, 97, 238, 0.05);
            color: var(--primary-color);
        }

        /* Updated Search Bar */
        .search-bar-navbar {
            position: relative;
        }

        .search-bar-navbar .form-control {
            background: rgba(0, 0, 0, 0.03);
            border: none;
            color: #555;
            border-radius: 20px;
            padding-left: 40px;
            min-width: 240px;
            transition: all 0.3s;
            font-size: 0.9rem;
        }

        .search-bar-navbar .form-control:focus {
            background: rgba(0, 0, 0, 0.05);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
            min-width: 260px;
        }

        .search-bar-navbar .form-control::placeholder {
            color: #999;
            font-size: 0.9rem;
        }

        .search-bar-navbar .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            z-index: 10;
            font-size: 0.9rem;
        }

        /* Action button */
        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.03);
            color: #555;
            transition: all 0.2s;
        }

        .action-btn:hover {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        /* Notification Icon */
        .notification-icon {
            position: relative;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.03);
            border-radius: 8px;
            transition: all 0.2s;
            color: #555;
        }

        .notification-icon:hover {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--warning-color);
            color: white;
            font-size: 0.65rem;
            height: 18px;
            width: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: 600;
            border: 2px solid white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Profile Dropdown - Updated */
        .profile-dropdown .dropdown-toggle {
            padding: 0.3rem;
            background: rgba(0, 0, 0, 0.03);
            border-radius: 8px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
        }

        .profile-dropdown .dropdown-toggle:hover {
            background: rgba(67, 97, 238, 0.1);
            transform: translateY(-2px);
        }

        .profile-dropdown .dropdown-toggle::after {
            display: none;
        }

        .profile-dropdown .dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            padding: 0;
            min-width: 280px;
            margin-top: 12px;
            animation: dropdownFade 0.2s ease;
            overflow: hidden;
        }

        .profile-dropdown .dropdown-item {
            padding: 0.8rem 1.2rem;
            display: flex;
            align-items: center;
            font-weight: 500;
            transition: all 0.2s;
            color: #555;
        }

        .profile-dropdown .dropdown-item i {
            margin-right: 12px;
            font-size: 1rem;
            width: 20px;
            text-align: center;
            color: #666;
            opacity: 0.8;
            transition: all 0.2s;
        }

        .profile-dropdown .dropdown-item:hover {
            background-color: rgba(67, 97, 238, 0.05);
            color: var(--primary-color);
        }

        .profile-dropdown .dropdown-item:hover i {
            opacity: 1;
            color: var(--primary-color);
        }

        .profile-dropdown .avatar-circle {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
            margin-right: 8px;
            transition: all 0.2s;
        }

        .profile-dropdown:hover .avatar-circle {
            transform: scale(1.05);
        }

        .profile-header {
            background: var(--primary-color);
            padding: 1.5rem;
            color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .profile-header .avatar-lg {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border: 3px solid rgba(255, 255, 255, 0.5);
            border-radius: 12px;
            margin: 0 auto 15px;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Footer styles */
        .footer {
            margin-top: auto;
        }

        /* Main content spacing */
        .main-content {
            padding: 20px;
            background-color: transparent;
        }

        /* Breadcrumb styling */
        .breadcrumb {
            margin-bottom: 0;
            background-color: transparent;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
        }

        /* Dashboard cards */
        .card {
            border: none;
            border-radius: var(--card-border-radius);
            box-shadow: var(--box-shadow);
            transition: all 0.3s;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--box-shadow-hover);
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1rem 1.25rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Dashboard header */
        .admin-dashboard-header {
            background-color: #fff;
            border-radius: var(--card-border-radius);
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: var(--box-shadow);
            border-left: 5px solid var(--primary-color);
        }
        
        .admin-dashboard-header h1 {
            margin-bottom: 5px;
            color: #333;
        }
        
        .admin-dashboard-header p {
            font-size: 1rem;
            opacity: 0.7;
        }

        /* Button styles */
        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--primary-light));
            border: none;
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(67, 97, 238, 0.4);
        }
        
        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(67, 97, 238, 0.2);
        }

        .submenu {
            margin-left: 20px;
            background-color: rgba(0, 0, 0, 0.1);
            border-radius: 8px;
          
           
        }
        
        .submenu .nav-link {
            padding: 6px 10px 6px 20px;
            font-size: 0.95rem;

        }

        @stack('styles')
    </style>
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        @include('admin.layouts.sidebar')

        <!-- Sidebar Toggle Button -->
        <button class="sidebar-toggle-btn" id="sidebar-toggle-btn">
            <i class="fas fa-angle-left"></i>
        </button>

        <!-- Content Container -->
        <div class="content-container">
            <!-- Sidebar Overlay for mobile -->
            <div class="sidebar-overlay"></div>
        
            <!-- Top Navbar -->
            @include('admin.layouts.header')

            <!-- Main Content -->
            <div class="main-content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle me-2"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <div>{{ session('error') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
            
            <!-- Footer -->
            @include('admin.layouts.footer')
        </div>
    </div>
    
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Enhanced sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarToggleBtn = document.getElementById('sidebar-toggle-btn');
            const sidebar = document.querySelector('.sidebar');
            const sidebarOverlay = document.querySelector('.sidebar-overlay');
            const adminLayout = document.querySelector('.admin-layout');
            const contentContainer = document.querySelector('.content-container');
            
            // Check for saved sidebar state
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                adminLayout.classList.add('sidebar-collapsed');
            }
            
            // Sidebar toggle button inside sidebar
            if (sidebarToggleBtn) {
                sidebarToggleBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    adminLayout.classList.toggle('sidebar-collapsed');
                    localStorage.setItem('sidebarCollapsed', adminLayout.classList.contains('sidebar-collapsed'));
                });
            }
            
            // Mobile sidebar toggle
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    sidebarOverlay.classList.toggle('show');
                });
            }
            
            // Overlay click event
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                });
            }
            
            // Close sidebar when clicking on a nav link on mobile
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            navLinks.forEach(function(link) {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 992) {
                        sidebar.classList.remove('show');
                        sidebarOverlay.classList.remove('show');
                    }
                });
            });
            
            // Adjust on window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992) {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                }
            });
            
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Navbar scroll effect
            window.addEventListener('scroll', function() {
                const navbar = document.querySelector('.admin-navbar');
                if (window.scrollY > 10) {
                    navbar.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.1)';
                } else {
                    navbar.style.boxShadow = '0 3px 10px rgba(0, 0, 0, 0.1)';
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html> 