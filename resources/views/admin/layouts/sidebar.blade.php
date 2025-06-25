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
        
        <!-- Registration -->
        <li class="nav-item">
            <a class="nav-link has-submenu" href="#" data-bs-toggle="collapse" data-bs-target="#registrationSubmenu" aria-expanded="false">
                <i class="fas fa-user-plus"></i>
                <span>Registration</span>
                <i class="fas fa-chevron-down submenu-icon"></i>
            </a>
            <div class="collapse" id="registrationSubmenu">
                <ul class="nav flex-column submenu">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>New Patient</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Patient List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Appointments</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        
        <!-- Hospital -->
        <li class="nav-item">
            <a class="nav-link has-submenu" href="#" data-bs-toggle="collapse" data-bs-target="#hospitalSubmenu" aria-expanded="false">
                <i class="fas fa-hospital"></i>
                <span>Hospital</span>
                <i class="fas fa-chevron-down submenu-icon"></i>
            </a>
            <div class="collapse" id="hospitalSubmenu">
                <ul class="nav flex-column submenu">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Departments</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Bed Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Ward Management</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        
        <!-- Diagnostics -->
        <li class="nav-item">
            <a class="nav-link has-submenu" href="#" data-bs-toggle="collapse" data-bs-target="#diagnosticsSubmenu" aria-expanded="false">
                <i class="fas fa-stethoscope"></i>
                <span>Diagnostics</span>
                <i class="fas fa-chevron-down submenu-icon"></i>
            </a>
            <div class="collapse" id="diagnosticsSubmenu">
                <ul class="nav flex-column submenu">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Invoice</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Invoice Return</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Due Collection</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Re_print</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Report</span>
                        </a>
                    </li>
                    
                    
                </ul>
            </div>
        </li>
        
        <!-- OPD -->
        <li class="nav-item">
            <a class="nav-link has-submenu" href="#" data-bs-toggle="collapse" data-bs-target="#opdSubmenu" aria-expanded="false">
                <i class="fas fa-procedures"></i>
                <span>OPD</span>
                <i class="fas fa-chevron-down submenu-icon"></i>
            </a>
            <div class="collapse" id="opdSubmenu">
                <ul class="nav flex-column submenu">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>OPD Registration</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>OPD Queue</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>OPD Billing</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        
        <!-- Medicine -->
        <li class="nav-item">
            <a class="nav-link has-submenu" href="#" data-bs-toggle="collapse" data-bs-target="#medicineSubmenu" aria-expanded="false">
                <i class="fas fa-pills"></i>
                <span>Medicine</span>
                <i class="fas fa-chevron-down submenu-icon"></i>
            </a>
            <div class="collapse" id="medicineSubmenu">
                <ul class="nav flex-column submenu">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Medicine List</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Pharmacy</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Prescriptions</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        
        <!-- Inventory -->
        <li class="nav-item">
            <a class="nav-link has-submenu" href="#" data-bs-toggle="collapse" data-bs-target="#inventorySubmenu" aria-expanded="false">
                <i class="fas fa-boxes"></i>
                <span>Inventory</span>
                <i class="fas fa-chevron-down submenu-icon"></i>
            </a>
            <div class="collapse" id="inventorySubmenu">
                <ul class="nav flex-column submenu">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Stock Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Purchase Orders</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Suppliers</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        
        <!-- Laboratory -->
        <li class="nav-item">
            <a class="nav-link has-submenu" href="#" data-bs-toggle="collapse" data-bs-target="#laboratorySubmenu" aria-expanded="false">
                <i class="fas fa-flask"></i>
                <span>Laboratory</span>
                <i class="fas fa-chevron-down submenu-icon"></i>
            </a>
            <div class="collapse" id="laboratorySubmenu">
                <ul class="nav flex-column submenu">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Test Results</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Sample Status</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Lab Equipment</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        
        <!-- Accounts -->
        <li class="nav-item">
            <a class="nav-link has-submenu" href="#" data-bs-toggle="collapse" data-bs-target="#accountsSubmenu" aria-expanded="false">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Accounts</span>
                <i class="fas fa-chevron-down submenu-icon"></i>
            </a>
            <div class="collapse" id="accountsSubmenu">
                <ul class="nav flex-column submenu">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Income</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Expenses</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Financial Reports</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        
        <!-- Payment -->
        <li class="nav-item">
            <a class="nav-link has-submenu" href="#" data-bs-toggle="collapse" data-bs-target="#paymentSubmenu" aria-expanded="false">
                <i class="fas fa-credit-card"></i>
                <span>Payment</span>
                <i class="fas fa-chevron-down submenu-icon"></i>
            </a>
            <div class="collapse" id="paymentSubmenu">
                <ul class="nav flex-column submenu">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Payment Methods</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Invoices</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Transactions</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        
        <!-- Investigation Report -->
        <li class="nav-item">
            <a class="nav-link has-submenu" href="#" data-bs-toggle="collapse" data-bs-target="#investigationSubmenu" aria-expanded="false">
                <i class="fas fa-file-medical-alt"></i>
                <span>Investigation Report</span>
                <i class="fas fa-chevron-down submenu-icon"></i>
            </a>
            <div class="collapse" id="investigationSubmenu">
                <ul class="nav flex-column submenu">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Lab Reports</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Radiology Reports</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Clinical Reports</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        
        <!-- Doctor/Consultant Ticket -->
        <li class="nav-item">
            <a class="nav-link has-submenu" href="#" data-bs-toggle="collapse" data-bs-target="#doctorSubmenu" aria-expanded="false">
                <i class="fas fa-user-md"></i>
                <span>Doctor/Consultant</span>
                <i class="fas fa-chevron-down submenu-icon"></i>
            </a>
            <div class="collapse" id="doctorSubmenu">
                <ul class="nav flex-column submenu">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Invoice</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Due Collection</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Report</span>
                        </a>
                    </li>
                </ul>
            </div>
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

    <div class="sidebar-heading">SYSTEM</div>
    <ul class="nav flex-column">
        <!-- Code Maintenance -->
        <li class="nav-item">
            <a class="nav-link has-submenu" href="#" data-bs-toggle="collapse" data-bs-target="#codeMaintenanceSubmenu" aria-expanded="false">
                <i class="fas fa-code"></i>
                <span>Code Maintenance</span>
                <i class="fas fa-chevron-down submenu-icon"></i>
            </a>
            <div class="collapse" id="codeMaintenanceSubmenu">
                <ul class="nav flex-column submenu">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>System Updates</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Error Logs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Database Maintenance</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        
        <!-- Security Options -->
        <li class="nav-item">
            <a class="nav-link has-submenu" href="#" data-bs-toggle="collapse" data-bs-target="#securitySubmenu" aria-expanded="false">
                <i class="fas fa-shield-alt"></i>
                <span>Security Options</span>
                <i class="fas fa-chevron-down submenu-icon"></i>
            </a>
            <div class="collapse" id="securitySubmenu">
                <ul class="nav flex-column submenu">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Access Control</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Audit Logs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Security Settings</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        
        <!-- Utilities -->
        <li class="nav-item">
            <a class="nav-link has-submenu" href="#" data-bs-toggle="collapse" data-bs-target="#utilitiesSubmenu" aria-expanded="false">
                <i class="fas fa-tools"></i>
                <span>Utilities</span>
                <i class="fas fa-chevron-down submenu-icon"></i>
            </a>
            <div class="collapse" id="utilitiesSubmenu">
                <ul class="nav flex-column submenu">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>System Cleanup</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Import/Export</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Backup/Restore</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        
        <!-- Special Features -->
        <li class="nav-item">
            <a class="nav-link has-submenu" href="#" data-bs-toggle="collapse" data-bs-target="#specialFeaturesSubmenu" aria-expanded="false">
                <i class="fas fa-star"></i>
                <span>Special Features</span>
                <i class="fas fa-chevron-down submenu-icon"></i>
            </a>
            <div class="collapse" id="specialFeaturesSubmenu">
                <ul class="nav flex-column submenu">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>SMS Gateway</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>Email Notifications</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span>API Integration</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        
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