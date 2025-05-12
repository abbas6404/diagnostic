<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Admin Panel') - {{ config('app.name') }}</title>
    
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-dark text-white" id="sidebar-wrapper" style="width: 250px;">
            <div class="sidebar-heading p-3 border-bottom">
                <i class="fas fa-user-shield me-2"></i> Admin Panel
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action bg-dark text-white border-light {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
                @permission('view users')
                <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action bg-dark text-white border-light {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <i class="fas fa-users me-2"></i> Users
                </a>
                @endpermission
                @permission('view roles')
                <a href="{{ route('admin.roles.index') }}" class="list-group-item list-group-item-action bg-dark text-white border-light {{ request()->routeIs('admin.roles*') ? 'active' : '' }}">
                    <i class="fas fa-user-tag me-2"></i> Roles
                </a>
                @endpermission
                @permission('view permissions')
                <a href="{{ route('admin.permissions.index') }}" class="list-group-item list-group-item-action bg-dark text-white border-light {{ request()->routeIs('admin.permissions*') ? 'active' : '' }}">
                    <i class="fas fa-key me-2"></i> Permissions
                </a>
                @endpermission
                <a href="{{ route('admin.settings') }}" class="list-group-item list-group-item-action bg-dark text-white border-light {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <i class="fas fa-cog me-2"></i> Settings
                </a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper" class="flex-fill">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-outline-light" id="menu-toggle">
                        <i class="fas fa-bars"></i>
                    </button>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a href="{{ route('home') }}" class="nav-link" target="_blank">
                                    <i class="fas fa-external-link-alt me-1"></i> View Site
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="{{ route('user.profile') }}">Profile</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container-fluid p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0 text-gray-800">@yield('title', 'Dashboard')</h1>
                    @yield('actions')
                </div>
                
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle sidebar
            const menuToggle = document.getElementById('menu-toggle');
            const wrapper = document.getElementById('wrapper');
            
            if (menuToggle) {
                menuToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    wrapper.classList.toggle('toggled');
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html> 