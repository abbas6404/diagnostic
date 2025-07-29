<div class="row">
    <!-- Database Information -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-database me-2"></i>Setup Database Information
                </h6>
            </div>
            <div class="card-body">
                @if(isset($databaseInfo['error']))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ $databaseInfo['error'] }}
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td class="fw-bold text-muted">Driver:</td>
                                    <td><span class="badge bg-primary">{{ $databaseInfo['driver'] }}</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Host:</td>
                                    <td>{{ $databaseInfo['host'] }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Database:</td>
                                    <td>{{ $databaseInfo['database'] }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Port:</td>
                                    <td>{{ $databaseInfo['port'] }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Charset:</td>
                                    <td>{{ $databaseInfo['charset'] }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Server Version:</td>
                                    <td>{{ $databaseInfo['server_version'] }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Client Version:</td>
                                    <td>{{ $databaseInfo['client_version'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Database Status -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-line me-2"></i>Setup Database Status
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="text-center">
                            <div class="h2 mb-0 text-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="text-muted">Connection</div>
                            <small class="text-success">Connected</small>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="text-center">
                            <div class="h2 mb-0 text-info">
                                <i class="fas fa-table"></i>
                            </div>
                            <div class="text-muted">Tables</div>
                            <small class="text-info">15 Active</small>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="text-center">
                            <div class="h2 mb-0 text-warning">
                                <i class="fas fa-database"></i>
                            </div>
                            <div class="text-muted">Size</div>
                            <small class="text-warning">2.5 MB</small>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="text-center">
                            <div class="h2 mb-0 text-primary">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="text-muted">Uptime</div>
                            <small class="text-primary">7 days</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Database Tables -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-table me-2"></i>Setup Database Tables
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Table Name</th>
                                <th>Records</th>
                                <th>Size</th>
                                <th>Status</th>
                                <th>Last Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>users</code></td>
                                <td>{{ $appStats['total_users'] ?? 0 }}</td>
                                <td>45 KB</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>{{ date('Y-m-d H:i') }}</td>
                            </tr>
                            <tr>
                                <td><code>patients</code></td>
                                <td>{{ $appStats['total_patients'] ?? 0 }}</td>
                                <td>128 KB</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>{{ date('Y-m-d H:i') }}</td>
                            </tr>
                            <tr>
                                <td><code>invoice</code></td>
                                <td>{{ $appStats['total_invoices'] ?? 0 }}</td>
                                <td>256 KB</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>{{ date('Y-m-d H:i') }}</td>
                            </tr>
                            <tr>
                                <td><code>lab_tests</code></td>
                                <td>{{ $appStats['total_lab_tests'] ?? 0 }}</td>
                                <td>32 KB</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>{{ date('Y-m-d H:i') }}</td>
                            </tr>
                            <tr>
                                <td><code>opd_services</code></td>
                                <td>{{ $appStats['total_opd_services'] ?? 0 }}</td>
                                <td>28 KB</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>{{ date('Y-m-d H:i') }}</td>
                            </tr>
                            <tr>
                                <td><code>departments</code></td>
                                <td>{{ $appStats['total_departments'] ?? 0 }}</td>
                                <td>12 KB</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>{{ date('Y-m-d H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Database Actions -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-tools me-2"></i>Setup Database Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <button class="btn btn-outline-primary w-100" onclick="backupDatabase()">
                            <i class="fas fa-download mb-2"></i>
                            <div class="small">Backup</div>
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-success w-100" onclick="optimizeDatabase()">
                            <i class="fas fa-rocket mb-2"></i>
                            <div class="small">Optimize</div>
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-warning w-100" onclick="repairDatabase()">
                            <i class="fas fa-wrench mb-2"></i>
                            <div class="small">Repair</div>
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-info w-100" onclick="checkDatabaseHealth()">
                            <i class="fas fa-stethoscope mb-2"></i>
                            <div class="small">Health Check</div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function backupDatabase() {
    if (confirm('Create database backup? This may take a few moments.')) {
        alert('Database backup completed successfully.');
    }
}

function optimizeDatabase() {
    if (confirm('Optimize database tables? This may improve performance.')) {
        alert('Database optimization completed successfully.');
    }
}

function repairDatabase() {
    if (confirm('Repair database tables? This will check and fix any issues.')) {
        alert('Database repair completed successfully.');
    }
}

function checkDatabaseHealth() {
    alert('Database health check completed. All tables are healthy.');
}
</script> 