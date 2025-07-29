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
            <a class="nav-link has-submenu {{ request()->routeIs('admin.patients.*') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#registrationSubmenu" aria-expanded="{{ request()->routeIs('admin.patients.*') ? 'true' : 'false' }}">
                <i class="fas fa-user-plus"></i>
                <span>Registration</span>
                <i class="fas fa-chevron-down submenu-icon"></i>
            </a>
            <div class="collapse {{ request()->routeIs('admin.patients.*') ? 'show' : '' }}" id="registrationSubmenu">
                <ul class="nav flex-column submenu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.patients.create') ? 'active' : '' }}" href="{{ route('admin.patients.create') }}">
                            <span>New Patient</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.patients.index') ? 'active' : '' }}" href="{{ route('admin.patients.index') }}">
                            <span>Patient List</span>
                        </a>
                    </li>
       
                </ul>
            </div>
        </li>
             <!-- Doctor/Consultant Ticket -->
             <li class="nav-item">
            <a class="nav-link has-submenu {{ request()->routeIs('admin.doctor.*') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#doctorSubmenu" aria-expanded="{{ request()->routeIs('admin.doctor.*') ? 'true' : 'false' }}">
                <i class="fas fa-user-md"></i>
                <span>Doctor/Consultant</span>
                <i class="fas fa-chevron-down submenu-icon"></i>
            </a>
            <div class="collapse {{ request()->routeIs('admin.doctor.*') ? 'show' : '' }}" id="doctorSubmenu">
                <ul class="nav flex-column submenu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.doctor.invoice') ? 'active' : '' }}" href="{{ route('admin.doctor.invoice') }}">
                            <span>Invoice</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.doctor.duecollection') ? 'active' : '' }}" href="{{ route('admin.doctor.duecollection') }}">
                            <span>Due Collection</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.doctor.report') ? 'active' : '' }}" href="{{ route('admin.doctor.report') }}">
                            <span>Report</span>
                        </a>
                    </li>   
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.doctor.reprint') ? 'active' : '' }}" href="{{ route('admin.doctor.reprint') }}">
                            <span>Re-print</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        
        <!-- Hospital -->
        <li class="nav-item">
            <a class="nav-link has-submenu {{ request()->routeIs('admin.hospital.*') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#hospitalSubmenu" aria-expanded="{{ request()->routeIs('admin.hospital.*') ? 'true' : 'false' }}">
                <i class="fas fa-hospital"></i>
                <span>Hospital</span>
                <i class="fas fa-chevron-down submenu-icon"></i>
            </a>
            <div class="collapse {{ request()->routeIs('admin.hospital.*') ? 'show' : '' }}" id="hospitalSubmenu">
                <ul class="nav flex-column submenu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.hospital.admission') ? 'active' : '' }}" href="{{ route('admin.hospital.admission') }}">
                            <span>Admission</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.hospital.bed-management') ? 'active' : '' }}" href="{{ route('admin.hospital.bed-management') }}">
                            <span>Bed Management</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.hospital.bed-change') ? 'active' : '' }}" href="{{ route('admin.hospital.bed-change') }}">
                            <span>Bed Change</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.hospital.discharge') ? 'active' : '' }}" href="{{ route('admin.hospital.discharge') }}">
                            <span>Discharge</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.hospital.advance-collection') ? 'active' : '' }}" href="{{ route('admin.hospital.advance-collection') }}">
                            <span>Advance Collection</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.hospital.procedure-entry') ? 'active' : '' }}" href="{{ route('admin.hospital.procedure-entry') }}">
                            <span>Procedure Entry</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.hospital.due-collection') ? 'active' : '' }}" href="{{ route('admin.hospital.due-collection') }}">
                            <span>Due Collection</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        
        <!-- Diagnostics -->
        <li class="nav-item">
            <a class="nav-link has-submenu {{ request()->routeIs('admin.diagnostics.*') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#diagnosticsSubmenu" aria-expanded="{{ request()->routeIs('admin.diagnostics.*') ? 'true' : 'false' }}">
                <i class="fas fa-stethoscope"></i>
                <span>Diagnostics</span>
                <i class="fas fa-chevron-down submenu-icon"></i>
            </a>
            <div class="collapse {{ request()->routeIs('admin.diagnostics.*') ? 'show' : '' }}" id="diagnosticsSubmenu">
                <ul class="nav flex-column submenu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.diagnostics.invoice') ? 'active' : '' }}" href="{{ route('admin.diagnostics.invoice') }}">
                            <span>Invoice</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.diagnostics.invoice-return') ? 'active' : '' }}" href="{{ route('admin.diagnostics.invoice-return') }}">
                            <span>Invoice Return</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.diagnostics.duecollection') ? 'active' : '' }}" href="{{ route('admin.diagnostics.duecollection') }}">  
                            <span>Due Collection</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.diagnostics.reprint') ? 'active' : '' }}" href="{{ route('admin.diagnostics.reprint') }}">
                            <span>Re-print</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.diagnostics.report') ? 'active' : '' }}" href="{{ route('admin.diagnostics.report') }}">
                            <span>Report</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        
        <!-- OPD -->
        <li class="nav-item">
            <a class="nav-link has-submenu {{ request()->routeIs('admin.opd.*') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#opdSubmenu" aria-expanded="{{ request()->routeIs('admin.opd.*') ? 'true' : 'false' }}">
                <i class="fas fa-procedures"></i>
                <span>OPD</span>
                <i class="fas fa-chevron-down submenu-icon"></i>
            </a>
            <div class="collapse {{ request()->routeIs('admin.opd.*') ? 'show' : '' }}" id="opdSubmenu">
                <ul class="nav flex-column submenu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.opd.invoice') ? 'active' : '' }}" href="{{ route('admin.opd.invoice') }}">
                            <span>Invoice</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.opd.duecollection') ? 'active' : '' }}" href="{{ route('admin.opd.duecollection') }}">
                            <span>Due Collection</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.opd.reprint') ? 'active' : '' }}" href="{{ route('admin.opd.reprint') }}">
                            <span>Re-print</span>
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
            <a class="nav-link has-submenu {{ request()->routeIs('admin.laboratory.*') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#laboratorySubmenu" aria-expanded="{{ request()->routeIs('admin.laboratory.*') ? 'true' : 'false' }}">
                <i class="fas fa-flask"></i>
                <span>Laboratory</span>
                <i class="fas fa-chevron-down submenu-icon"></i>
            </a>
            <div class="collapse {{ request()->routeIs('admin.laboratory.*') ? 'show' : '' }}" id="laboratorySubmenu">
                <ul class="nav flex-column submenu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.laboratory.test-results') ? 'active' : '' }}" href="{{ route('admin.laboratory.test-results') }}">
                            <span>Test Results</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.laboratory.sample-collection') ? 'active' : '' }}" href="{{ route('admin.laboratory.sample-collection') }}">
                            <span>Sample Collection</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.laboratory.lab-equipment') ? 'active' : '' }}" href="{{ route('admin.laboratory.lab-equipment') }}">
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
        

        
   
        
        @can('view users')
        <li class="nav-item">
            <a class="nav-link {{ (request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*')) ? 'active' : '' }} has-submenu" href="#" data-bs-toggle="collapse" data-bs-target="#usersSubmenu" aria-expanded="{{ (request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*')) ? 'true' : 'false' }}">
                <i class="fas fa-users"></i>
                <span>User & Staff</span>
                <i class="fas fa-chevron-down submenu-icon"></i>
            </a>
            <div class="collapse {{ (request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*')) ? 'show' : '' }}" id="usersSubmenu">
                <ul class="nav flex-column submenu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                            <span>Staff</span>
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
        <!-- Setup -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.setup.*') ? 'active' : '' }}" href="{{ route('admin.setup.index') }}">
                <i class="fas fa-cogs"></i>
                <span>Setup</span>
                        </a>
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