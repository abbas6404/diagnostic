<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-logo">
            <div class="logo-circle">
                <i class="fas fa-shield-alt"></i>
            </div>
            <span class="fw-bold px-2">Control Panel</span>
        </div>
    </div>
  
    <div class="sidebar-heading">MANAGEMENT</div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        @can('view users')
        <li class="nav-item">
            <a class="nav-link {{ (request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*')) ? 'active' : '' }} has-submenu" href="#" data-bs-toggle="collapse" data-bs-target="#usersSubmenu" aria-expanded="{{ (request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*')) ? 'true' : 'false' }}">
                <i class="fas fa-users"></i>
                <span>Users</span>
                <i class="fas fa-chevron-down submenu-icon"></i>
            </a>
            <div class="collapse {{ (request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*')) ? 'show' : '' }}" id="usersSubmenu">
                <ul class="nav flex-column submenu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                            <span>Users</span>
                        </a>
                    </li>
                    @can('view roles')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}">
                            <span>Roles</span>
                        </a>
                    </li>
                    @endcan
                    @can('view permissions')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}" href="{{ route('admin.permissions.index') }}">
                            <span>Permissions</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </div>
        </li>
        @endcan
    </ul>

    <div class="sidebar-heading">CONTENT</div>
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

    <div class="sidebar-heading">SYSTEM</div>
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
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
            <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
        </a>
        <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</div> 