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
            --sidebar-width: 280px;
            --header-height: 70px;
            --card-border-radius: 12px;
            --transition-speed: 0.3s;
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
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
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
            background: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .sidebar-brand .sidebar-logo {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .sidebar-brand .sidebar-logo i {
            font-size: 1.5rem;
            background: var(--primary-color);
            color: white;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            margin-right: 10px;
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.2);
        }

        .sidebar-brand .fw-bold {
            font-size: 1.2rem;
            color: var(--primary-color);
        }

        .sidebar-toggle-btn {
            background: transparent;
            border: none;
            color: #888;
            cursor: pointer;
            transition: all 0.3s;
            padding: 5px;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
        }

        .sidebar-toggle-btn:hover {
            color: var(--primary-color);
            background: rgba(67, 97, 238, 0.05);
            transform: scale(1.1);
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
            margin: 4px 12px;
        }

        .sidebar .nav-link {
            color: #555;
            padding: 0.7rem 1.2rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: all 0.2s;
            border-radius: 8px;
            position: relative;
            overflow: hidden;
        }

        .sidebar .nav-link:hover {
            color: var(--primary-color);
            background-color: rgba(67, 97, 238, 0.05);
        }

        .sidebar .nav-link.active {
            color: var(--primary-color);
            background-color: rgba(67, 97, 238, 0.08);
            font-weight: 600;
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

        .sidebar .nav-link:hover i,
        .sidebar .nav-link.active i {
            opacity: 1;
            color: var(--primary-color);
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
            justify-content: space-between;
        }

        .sidebar-footer a {
            color: #666;
            text-decoration: none;
            transition: all 0.2s;
            font-size: 0.85rem;
        }

        .sidebar-footer a:hover {
            color: var(--primary-color);
        }

        .sidebar-footer .online-status {
            display: flex;
            align-items: center;
        }

        .sidebar-footer .online-status i {
            color: #22c55e;
            font-size: 10px;
            margin-right: 6px;
        }

        .sidebar-collapsed .sidebar {
            width: 70px;
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
            margin-left: 70px;
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
            transform: rotate(180deg);
        }

        .sidebar-collapsed .sidebar-toggle-btn:hover {
            transform: rotate(180deg) scale(1.1);
        }

        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
                width: 280px;
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
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 0 1.5rem;
            position: relative;
            width: 100%;
            z-index: 1030;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .admin-navbar::before {
            display: none;
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

        @stack('styles')
    </style>
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-brand">
                <div class="sidebar-logo">
                    <i class="fas fa-shield-alt"></i>
                    <span class="fw-bold">Control Panel</span>
                </div>
                <button class="sidebar-toggle-btn" id="sidebar-toggle-btn">
                    <i class="fas fa-angle-left"></i>
                </button>
            </div>
            
            <div class="sidebar-user">
                <div class="sidebar-user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name">{{ Auth::user()->name }}</div>
                    <div class="sidebar-user-role">
                        @if(Auth::user()->roles->isNotEmpty())
                            {{ Auth::user()->roles->first()->name }}
                        @else
                            User
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="sidebar-heading">Management</div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @can('view users')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
                @endcan
                
                @can('view roles')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}">
                        <i class="fas fa-user-tag"></i>
                        <span>Roles</span>
                    </a>
                </li>
                @endcan
                
                @can('view permissions')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}" href="{{ route('admin.permissions.index') }}">
                        <i class="fas fa-key"></i>
                        <span>Permissions</span>
                    </a>
                </li>
                @endcan
            </ul>

            <div class="sidebar-heading">Content</div>
            <ul class="nav flex-column">
                @can('manage posts')
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-newspaper"></i>
                        <span>Posts</span>
                        <span class="badge bg-success rounded-pill">New</span>
                    </a>
                </li>
                @endcan
                
                @can('manage comments')
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-comments"></i>
                        <span>Comments</span>
                    </a>
                </li>
                @endcan
                
                @can('manage media')
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-image"></i>
                        <span>Media</span>
                    </a>
                </li>
                @endcan
            </ul>

            <div class="sidebar-heading">System</div>
            <ul class="nav flex-column">
                @can('manage settings')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                        <i class="fas fa-cogs"></i>
                        <span>Settings</span>
                    </a>
                </li>
                @endcan
                
                @can('view reports')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}" href="{{ route('admin.reports') }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Reports</span>
                    </a>
                </li>
                @endcan
                
                @can('manage backups')
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-database"></i>
                        <span>Backups</span>
                    </a>
                </li>
                @endcan
            </ul>

            <div class="sidebar-footer">
                <div class="online-status">
                    <i class="fas fa-circle"></i>
                    <span>Online</span>
                </div>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                    <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                </a>
                <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

        <!-- Content Container -->
        <div class="content-container">
            <!-- Sidebar Overlay for mobile -->
            <div class="sidebar-overlay"></div>
        
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg admin-navbar">
                <div class="container-fluid">
                    <!-- Mobile Toggle Button -->
                    <button class="navbar-toggler border-0 me-3" type="button" id="sidebar-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                        <i class="fas fa-home"></i> Site Home
                    </a>
                    
                    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto align-items-center">
                            <!-- Enhanced Search -->
                            <li class="nav-item me-3">
                                <form class="search-bar-navbar" action="#" method="GET">
                                    <i class="fas fa-search search-icon"></i>
                                    <input class="form-control form-control-sm" type="search" placeholder="Search..." aria-label="Search">
                                </form>
                            </li>
                            
                            <!-- Action Buttons -->
                            <li class="nav-item me-2">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-plus-circle"></i>
                                </a>
                            </li>
                            
                            <!-- Notifications -->
                            <li class="nav-item dropdown me-2">
                                <a id="notificationsDropdown" class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="notification-icon">
                                        <i class="fas fa-bell"></i>
                                        <span class="notification-badge">3</span>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 p-0 overflow-hidden" aria-labelledby="notificationsDropdown" style="width: 320px;">
                                    <div class="p-3 border-bottom bg-primary text-white">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0 fw-bold">Notifications</h6>
                                            <a href="#" class="text-white small opacity-75">Mark all as read</a>
                                        </div>
                                    </div>
                                    <div class="p-2">
                                        <a href="#" class="dropdown-item p-2 rounded-3">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-3 p-2 rounded-circle text-white d-flex align-items-center justify-content-center" style="background: linear-gradient(45deg, var(--primary-color), var(--primary-light)); width: 45px; height: 45px;">
                                                    <i class="fas fa-user-plus"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <p class="mb-0 fw-medium">New user registered</p>
                                                    <div class="text-muted small d-flex align-items-center">
                                                        <i class="far fa-clock me-1"></i> 5 minutes ago
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="dropdown-item p-2 rounded-3">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-3 p-2 rounded-circle text-white d-flex align-items-center justify-content-center" style="background: linear-gradient(45deg, var(--success-color), var(--info-color)); width: 45px; height: 45px;">
                                                    <i class="fas fa-key"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <p class="mb-0 fw-medium">Permission updated</p>
                                                    <div class="text-muted small d-flex align-items-center">
                                                        <i class="far fa-clock me-1"></i> 1 hour ago
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="#" class="dropdown-item p-2 rounded-3">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-3 p-2 rounded-circle text-white d-flex align-items-center justify-content-center" style="background: linear-gradient(45deg, var(--warning-color), var(--danger-color)); width: 45px; height: 45px;">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <p class="mb-0 fw-medium">System alert</p>
                                                    <div class="text-muted small d-flex align-items-center">
                                                        <i class="far fa-clock me-1"></i> Yesterday
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <a href="#" class="dropdown-item text-center border-top py-3 fw-medium text-primary">
                                        View all notifications <i class="fas fa-chevron-right ms-1 small"></i>
                                    </a>
                                </div>
                            </li>
                            
                            <!-- User Profile -->
                            <li class="nav-item dropdown profile-dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                        <div class="d-none d-md-flex flex-column ms-1 me-1">
                                            <span class="fw-medium text-dark" style="font-size: 14px; line-height: 1.2">{{ Auth::user()->name }}</span>
                                            <small class="text-muted" style="font-size: 12px; line-height: 1">
                                                @if(Auth::user()->roles->isNotEmpty())
                                                    {{ Auth::user()->roles->first()->name }}
                                                @else
                                                    User
                                                @endif
                                            </small>
                                        </div>
                                        <i class="fas fa-chevron-down d-none d-md-block ms-1 text-muted" style="font-size: 12px;"></i>
                                    </div>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <div class="profile-header text-center">
                                        <div class="avatar-lg mx-auto mb-3">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                        <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                                        <p class="mb-0 text-muted">{{ Auth::user()->email }}</p>
                                    </div>
                                    <div class="p-1">
                                        <a class="dropdown-item rounded-3" href="#">
                                            <i class="fas fa-user"></i> My Profile
                                        </a>
                                        <a class="dropdown-item rounded-3" href="#">
                                            <i class="fas fa-cog"></i> Account Settings
                                        </a>
                                        <a class="dropdown-item rounded-3" href="#">
                                            <i class="fas fa-list"></i> Activity Log
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item rounded-3" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

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