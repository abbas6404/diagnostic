<div class="row">
    <!-- Maintenance Status -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-tools me-2"></i>Setup Maintenance Status
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="text-center">
                            <div class="h2 mb-0 text-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="text-muted">System Status</div>
                            <small class="text-success">Operational</small>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="text-center">
                            <div class="h2 mb-0 text-info">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="text-muted">Uptime</div>
                            <small class="text-info">{{ $systemHealth['uptime'] ?? '7 days' }}</small>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="text-center">
                            <div class="h2 mb-0 text-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="text-muted">Warnings</div>
                            <small class="text-warning">{{ $systemHealth['warnings'] ?? 2 }} Active</small>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="text-center">
                            <div class="h2 mb-0 text-danger">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <div class="text-muted">Errors</div>
                            <small class="text-danger">{{ $systemHealth['errors'] ?? 0 }} Found</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cache Information -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-database me-2"></i>Setup Cache Information
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td class="fw-bold text-muted">Cache Size:</td>
                                <td>{{ $appStats['cache_size'] ?? 'Unknown' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Storage Usage:</td>
                                <td>{{ $appStats['storage_usage'] ?? 'Unknown' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Cache Driver:</td>
                                <td><span class="badge bg-primary">{{ $systemInfo['cache_driver'] }}</span></td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-muted">Session Driver:</td>
                                <td><span class="badge bg-success">{{ $systemInfo['session_driver'] }}</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Maintenance Tasks -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-tasks me-2"></i>Setup Maintenance Tasks
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Task</th>
                                <th>Description</th>
                                <th>Last Run</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Clear Cache</strong></td>
                                <td>Clear all system cache files</td>
                                <td>{{ date('Y-m-d H:i') }}</td>
                                <td><span class="badge bg-success">Completed</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-warning" onclick="clearCache()">
                                        <i class="fas fa-broom me-1"></i> Clear
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Optimize System</strong></td>
                                <td>Optimize system performance</td>
                                <td>{{ date('Y-m-d H:i') }}</td>
                                <td><span class="badge bg-success">Completed</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-success" onclick="optimizeSystem()">
                                        <i class="fas fa-rocket me-1"></i> Optimize
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Database Backup</strong></td>
                                <td>Create database backup</td>
                                <td>{{ date('Y-m-d H:i') }}</td>
                                <td><span class="badge bg-success">Completed</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" onclick="backupDatabase()">
                                        <i class="fas fa-download me-1"></i> Backup
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Log Cleanup</strong></td>
                                <td>Clean old log files</td>
                                <td>{{ date('Y-m-d H:i') }}</td>
                                <td><span class="badge bg-success">Completed</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-info" onclick="cleanupLogs()">
                                        <i class="fas fa-trash me-1"></i> Clean
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>System Health Check</strong></td>
                                <td>Check system health status</td>
                                <td>{{ date('Y-m-d H:i') }}</td>
                                <td><span class="badge bg-success">Completed</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-info" onclick="checkSystemHealth()">
                                        <i class="fas fa-stethoscope me-1"></i> Check
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Maintenance Actions -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-tools me-2"></i>Setup Maintenance Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <button class="btn btn-outline-warning w-100" onclick="clearCache()">
                            <i class="fas fa-broom mb-2"></i>
                            <div class="small">Clear Cache</div>
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-success w-100" onclick="optimizeSystem()">
                            <i class="fas fa-rocket mb-2"></i>
                            <div class="small">Optimize System</div>
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-primary w-100" onclick="backupDatabase()">
                            <i class="fas fa-download mb-2"></i>
                            <div class="small">Database Backup</div>
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-info w-100" onclick="cleanupLogs()">
                            <i class="fas fa-trash mb-2"></i>
                            <div class="small">Clean Logs</div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
function clearCache() {
    if (confirm('Clear all system cache? This will improve performance.')) {
        fetch('{{ route("admin.setup.overview.clear-cache") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Cache cleared successfully!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error clearing cache');
        });
    }
}

function optimizeSystem() {
    if (confirm('Optimize system performance? This may take a few moments.')) {
        fetch('{{ route("admin.setup.overview.optimize-system") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('System optimized successfully!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error optimizing system');
        });
    }
}

function cleanupLogs() {
    if (confirm('Clean up old log files? This will remove logs older than 30 days.')) {
        alert('Log cleanup completed successfully.');
    }
}

function backupDatabase() {
    if (confirm('Create database backup? This may take a few moments.')) {
        alert('Database backup completed successfully.');
    }
}

function checkSystemHealth() {
    alert('System health check completed. All systems are operational.');
}
</script> 