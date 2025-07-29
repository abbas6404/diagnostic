@extends('admin.setup.setup-layout')

@section('page-title', 'Setup Overview')
@section('page-description', 'System configuration and management')

@section('setup-content')
<!-- Tab Content -->
<div class="card shadow">
    <div class="card-header py-3">
        <ul class="nav nav-tabs card-header-tabs" id="setupTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $activeTab === 'overview' ? 'active' : '' }}" 
                        id="overview-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#overview" 
                        type="button" 
                        role="tab">
                    <i class="fas fa-tachometer-alt me-1"></i>Overview
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $activeTab === 'update' ? 'active' : '' }}" 
                        id="update-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#update" 
                        type="button" 
                        role="tab">
                    <i class="fas fa-download me-1"></i>Update
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $activeTab === 'system' ? 'active' : '' }}" 
                        id="system-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#system" 
                        type="button" 
                        role="tab">
                    <i class="fas fa-server me-1"></i>System
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $activeTab === 'database' ? 'active' : '' }}" 
                        id="database-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#database" 
                        type="button" 
                        role="tab">
                    <i class="fas fa-database me-1"></i>Database
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $activeTab === 'maintenance' ? 'active' : '' }}" 
                        id="maintenance-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#maintenance" 
                        type="button" 
                        role="tab">
                    <i class="fas fa-tools me-1"></i>Maintenance
                </button>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="setupTabContent">
            <!-- Overview Tab -->
            <div class="tab-pane fade {{ $activeTab === 'overview' ? 'show active' : '' }}" 
                 id="overview" 
                 role="tabpanel">
                @include('admin.setup.overview.tabs.overview')
            </div>

            <!-- Update Tab -->
            <div class="tab-pane fade {{ $activeTab === 'update' ? 'show active' : '' }}" 
                 id="update" 
                 role="tabpanel">
                @include('admin.setup.overview.tabs.update')
            </div>

            <!-- System Tab -->
            <div class="tab-pane fade {{ $activeTab === 'system' ? 'show active' : '' }}" 
                 id="system" 
                 role="tabpanel">
                @include('admin.setup.overview.tabs.system')
            </div>

            <!-- Database Tab -->
            <div class="tab-pane fade {{ $activeTab === 'database' ? 'show active' : '' }}" 
                 id="database" 
                 role="tabpanel">
                @include('admin.setup.overview.tabs.database')
            </div>

            <!-- Maintenance Tab -->
            <div class="tab-pane fade {{ $activeTab === 'maintenance' ? 'show active' : '' }}" 
                 id="maintenance" 
                 role="tabpanel">
                @include('admin.setup.overview.tabs.maintenance')
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

@endpush 