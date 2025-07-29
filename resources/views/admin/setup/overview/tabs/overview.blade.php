<div class="row">
    <!-- Current Version Card -->
    <div class="col-lg-6 mb-4">
        <div class="card border-left-primary shadow h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Current Version
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $currentVersion }}</div>
                        <div class="text-xs text-muted mt-1">System Version</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-info-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- System Status -->
    <div class="col-lg-6 mb-4">
        <div class="card border-left-success shadow h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            System Status
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $systemHealth['system_status'] ?? 'Operational' }}</div>
                        <div class="text-xs text-muted mt-1">All systems running</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Application Statistics -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-bar me-2"></i>Application Statistics
                </h6>
            </div>
            <div class="card-body">
                @if(isset($appStats['error']))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ $appStats['error'] }}
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <div class="h2 mb-0 text-primary">{{ $appStats['total_users'] }}</div>
                                <div class="text-muted">Total Users</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <div class="h2 mb-0 text-success">{{ $appStats['total_patients'] }}</div>
                                <div class="text-muted">Total Patients</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <div class="h2 mb-0 text-info">{{ $appStats['total_invoices'] }}</div>
                                <div class="text-muted">Total Invoices</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <div class="h2 mb-0 text-warning">{{ $appStats['total_lab_tests'] }}</div>
                                <div class="text-muted">Lab Tests</div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <div class="h2 mb-0 text-secondary">{{ $appStats['total_opd_services'] }}</div>
                                <div class="text-muted">OPD Services</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <div class="h2 mb-0 text-dark">{{ $appStats['total_departments'] }}</div>
                                <div class="text-muted">Departments</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <div class="h2 mb-0 text-info">{{ $appStats['cache_size'] }}</div>
                                <div class="text-muted">Cache Size</div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <div class="h2 mb-0 text-warning">{{ $appStats['storage_usage'] }}</div>
                                <div class="text-muted">Storage Usage</div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-tools me-2"></i>Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <button class="btn btn-outline-primary w-100" onclick="checkUpdates()">
                            <i class="fas fa-sync-alt mb-2"></i>
                            <div class="small">Check Updates</div>
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-success w-100" onclick="optimizeSystem()">
                            <i class="fas fa-rocket mb-2"></i>
                            <div class="small">Optimize</div>
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-warning w-100" onclick="clearCache()">
                            <i class="fas fa-broom mb-2"></i>
                            <div class="small">Clear Cache</div>
                        </button>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.setup.overview.index', ['tab' => 'update']) }}" class="btn btn-outline-info w-100">
                            <i class="fas fa-download mb-2"></i>
                            <div class="small">Updates</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

 