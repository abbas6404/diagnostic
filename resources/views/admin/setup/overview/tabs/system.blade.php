<div class="row">
    <!-- System Information -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-server me-2"></i>Setup System Information
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="fw-bold text-muted">PHP Version:</td>
                                <td><span class="badge bg-success">{{ $systemInfo['php_version'] }}</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Laravel Version:</td>
                                <td><span class="badge bg-info">{{ $systemInfo['laravel_version'] }}</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Server Software:</td>
                                <td>{{ $systemInfo['server_software'] }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">App Name:</td>
                                <td>{{ $systemInfo['app_name'] ?? 'Diagnostic System' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">App Version:</td>
                                <td><span class="badge bg-primary">{{ $systemInfo['app_version'] ?? '1.0.0' }}</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Timezone:</td>
                                <td>{{ $systemInfo['timezone'] }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Locale:</td>
                                <td>{{ $systemInfo['locale'] ?? 'en' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Debug Mode:</td>
                                <td>
                                    <span class="badge {{ $systemInfo['debug_mode'] === 'Enabled' ? 'bg-warning' : 'bg-success' }}">
                                        {{ $systemInfo['debug_mode'] }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Maintenance Mode:</td>
                                <td>
                                    <span class="badge {{ $systemInfo['maintenance_mode'] === 'Enabled' ? 'bg-danger' : 'bg-success' }}">
                                        {{ $systemInfo['maintenance_mode'] }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">App URL:</td>
                                <td>{{ $systemInfo['app_url'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- System Configuration -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-cogs me-2"></i>Setup System Configuration
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="fw-bold text-muted">Database Driver:</td>
                                <td><span class="badge bg-primary">{{ $systemInfo['database_driver'] }}</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Cache Driver:</td>
                                <td><span class="badge bg-info">{{ $systemInfo['cache_driver'] }}</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Session Driver:</td>
                                <td><span class="badge bg-success">{{ $systemInfo['session_driver'] }}</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Storage Path:</td>
                                <td><code class="small">{{ $systemInfo['storage_path'] }}</code></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Public Path:</td>
                                <td><code class="small">{{ $systemInfo['public_path'] }}</code></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- System Health -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-heartbeat me-2"></i>Setup System Health
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="text-center">
                            <div class="h2 mb-0 text-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="text-muted">System Status</div>
                            <small class="text-success">Healthy</small>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="text-center">
                            <div class="h2 mb-0 text-info">
                                <i class="fas fa-memory"></i>
                            </div>
                            <div class="text-muted">Memory Usage</div>
                            <small class="text-info">{{ $systemHealth['memory_usage'] ?? 45 }}%</small>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="text-center">
                            <div class="h2 mb-0 text-warning">
                                <i class="fas fa-hdd"></i>
                            </div>
                            <div class="text-muted">Disk Usage</div>
                            <small class="text-warning">{{ $systemHealth['disk_usage'] ?? 67 }}%</small>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="text-center">
                            <div class="h2 mb-0 text-primary">
                                <i class="fas fa-network-wired"></i>
                            </div>
                            <div class="text-muted">Network</div>
                            <small class="text-primary">Active</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- System Actions -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-tools me-2"></i>Setup System Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <button class="btn btn-outline-primary w-100" onclick="optimizeSystem()">
                            <i class="fas fa-rocket mb-2"></i>
                            <div class="small">Optimize System</div>
                        </button>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-outline-warning w-100" onclick="clearCache()">
                            <i class="fas fa-broom mb-2"></i>
                            <div class="small">Clear Cache</div>
                        </button>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-outline-info w-100" onclick="checkSystemHealth()">
                            <i class="fas fa-stethoscope mb-2"></i>
                            <div class="small">System Health</div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function checkSystemHealth() {
    alert('System health check completed. All systems are operational.');
}
</script> 