@extends('admin.layouts.app')

@section('title', 'Setup')

@section('content')
<div class="container-fluid px-0">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">@yield('page-title', 'Setup')</h1>
            <p class="text-muted mb-0">@yield('page-description', 'System configuration and management')</p>
        </div>
    </div>

    <div class="row">
        <!-- Setup Sidebar -->
        <div class="col-lg-2">  
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-cogs me-2"></i>Setup Menu
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('admin.setup.overview.index') }}" 
                           class="list-group-item list-group-item-action {{ request()->routeIs('admin.setup.overview.*') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt me-2"></i>Setup Overview
                        </a>
                        <a href="{{ route('admin.setup.prefix.index') }}" 
                           class="list-group-item list-group-item-action {{ request()->routeIs('admin.setup.prefix.*') ? 'active' : '' }}">
                            <i class="fas fa-download me-2"></i>Prefix Setup
                        </a>
                        <a href="{{ route('admin.setup.department.index') }}" 
                           class="list-group-item list-group-item-action {{ request()->routeIs('admin.setup.department.*') ? 'active' : '' }}">
                            <i class="fas fa-building me-2"></i>Department
                        </a>
                        <a href="{{ route('admin.setup.collection-kit.index') }}" 
                           class="list-group-item list-group-item-action {{ request()->routeIs('admin.setup.collection-kit.*') ? 'active' : '' }}">
                            <i class="fas fa-box me-2"></i>Collection Kits
                        </a>
                        <a href="{{ route('admin.setup.lab-test.index') }}" 
                            class="list-group-item list-group-item-action {{ request()->routeIs('admin.setup.lab-test.*') ? 'active' : '' }}">
                                <i class="fas fa-flask me-2"></i>Lab Tests
                        </a>
                        <a href="{{ route('admin.setup.opd-service.index') }}" 
                            class="list-group-item list-group-item-action {{ request()->routeIs('admin.setup.opd-service.*') ? 'active' : '' }}">
                                <i class="fas fa-stethoscope me-2"></i>OPD Services
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-lg-10">
            @yield('setup-content')
        </div>
    </div>
</div>
@endsection 