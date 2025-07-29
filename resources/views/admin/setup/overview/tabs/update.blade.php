<div class="row">
    <!-- Current Version Card -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle me-2"></i>Setup Current Version
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="h1 mb-3 text-primary">{{ $currentVersion }}</div>
                    <p class="text-muted mb-3">Current System Version</p>
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="h5 mb-0 text-success">Stable</div>
                            <small class="text-muted">Status</small>
                        </div>
                        <div class="col-4">
                            <div class="h5 mb-0 text-info">{{ date('Y-m-d') }}</div>
                            <small class="text-muted">Last Check</small>
                        </div>
                        <div class="col-4">
                            <div class="h5 mb-0 text-warning">Auto</div>
                            <small class="text-muted">Update Mode</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Status -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-line me-2"></i>Setup Update Status
                </h6>
            </div>
            <div class="card-body">
                <div id="updateStatus">
                    <div class="text-center">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <h5 class="text-success">System is up to date</h5>
                        <p class="text-muted">No updates available at this time</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Available Updates -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-download me-2"></i>Setup Available Updates
                </h6>
                <span class="badge bg-primary">{{ count($availableUpdates) }} updates available</span>
            </div>
            <div class="card-body">
                @if(count($availableUpdates) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Version</th>
                                    <th>Type</th>
                                    <th>Release Date</th>
                                    <th>Size</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($availableUpdates as $update)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary">{{ $update['version'] }}</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $update['type'] === 'feature' ? 'bg-success' : 'bg-warning' }}">
                                            {{ ucfirst($update['type']) }}
                                        </span>
                                    </td>
                                    <td>{{ $update['release_date'] }}</td>
                                    <td>{{ $update['size'] }}</td>
                                    <td>{{ $update['description'] }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" onclick="installUpdate('{{ $update['version'] }}')">
                                            <i class="fas fa-download me-1"></i> Install
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <h5 class="text-success">No updates available</h5>
                        <p class="text-muted">Your system is running the latest version</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Update History -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-history me-2"></i>Setup Update History
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Version</th>
                                <th>Installed Date</th>
                                <th>Description</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($updateHistory as $update)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary">{{ $update['version'] }}</span>
                                </td>
                                <td>{{ $update['installed_date'] }}</td>
                                <td>{{ $update['description'] }}</td>
                                <td>
                                    <span class="badge bg-success">Installed</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Update Settings -->
<div class="row">
 

    <!-- System Requirements -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-list-check me-2"></i>Setup System Requirements
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold">PHP Version</span>
                        <span class="badge bg-success">✓ 8.2.0+</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: 100%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold">Laravel Version</span>
                        <span class="badge bg-success">✓ 12.0+</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: 100%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold">Database</span>
                        <span class="badge bg-success">✓ MySQL 8.0+</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: 100%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold">Storage Space</span>
                        <span class="badge bg-success">✓ 500MB+</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: 100%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold">Memory</span>
                        <span class="badge bg-success">✓ 256MB+</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let selectedVersion = null;

function checkForUpdates() {
    const button = event.target;
    const originalText = button.innerHTML;
    
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Checking...';
    
            fetch('{{ route("admin.setup.overview.check-updates") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.updates_available > 0) {
                showUpdateAvailable(data);
            } else {
                showNoUpdates();
            }
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error checking for updates');
    })
    .finally(() => {
        button.disabled = false;
        button.innerHTML = originalText;
    });
}

function showUpdateAvailable(data) {
    const statusDiv = document.getElementById('updateStatus');
    statusDiv.innerHTML = `
        <div class="text-center">
            <i class="fas fa-download fa-3x text-primary mb-3"></i>
            <h5 class="text-primary">Updates Available!</h5>
            <p class="text-muted">${data.updates_available} update(s) ready to install</p>
            <p class="text-muted">Latest version: ${data.latest_version}</p>
            <button class="btn btn-primary" onclick="performUpdate()">
                <i class="fas fa-download me-1"></i> Install Updates
            </button>
        </div>
    `;
}

function showNoUpdates() {
    const statusDiv = document.getElementById('updateStatus');
    statusDiv.innerHTML = `
        <div class="text-center">
            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
            <h5 class="text-success">System is up to date</h5>
            <p class="text-muted">No updates available at this time</p>
        </div>
    `;
}

function installUpdate(version) {
    selectedVersion = version;
    performUpdate();
}

function performUpdate() {
    const version = selectedVersion || 'latest';
    
    if (confirm(`Install update to version ${version}? This may take a few minutes.`)) {
        const button = event.target;
        const originalText = button.innerHTML;
        
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Installing...';
        
        fetch('{{ route("admin.setup.overview.perform-update") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                version: version
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error installing update');
        })
        .finally(() => {
            button.disabled = false;
            button.innerHTML = originalText;
        });
    }
}
</script> 