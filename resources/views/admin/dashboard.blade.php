@extends('admin.layouts.app')

@section('title', 'Hospital Dashboard')

@section('content')
<div class="container-fluid px-0">
    <!-- Page Heading -->
    <div class="admin-dashboard-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0 fw-bold">Hospital Dashboard</h1>
                <p class="text-muted mb-0">Welcome back, Dr. {{ Auth::user()->name }}</p>
            </div>
            <div>
                <a href="#" class="btn btn-primary rounded-pill shadow-sm">
                    <i class="fas fa-file-medical-alt me-1"></i> Medical Reports
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row fade-in">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card h-100 border-start border-5 border-primary">
                <div class="card-body p-4">
                    <div class="row no-gutters align-items-center">
                        <div class="col">
                            <div class="text-uppercase text-primary fw-bold text-xs mb-1">
                                Patients
                            </div>
                            <div class="h2 mb-0 fw-bold text-gray-800">{{ $stats['users'] }}</div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-success me-1">
                                    <i class="fas fa-arrow-up"></i> {{ $lastWeekUsers }}
                                </span>
                                <span>new this week</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-injured fa-2x text-primary icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card h-100 border-start border-5 border-success">
                <div class="card-body p-4">
                    <div class="row no-gutters align-items-center">
                        <div class="col">
                            <div class="text-uppercase text-success fw-bold text-xs mb-1">
                                Doctors
                            </div>
                            <div class="h2 mb-0 fw-bold text-gray-800">{{ $stats['roles'] }}</div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="me-1">
                                    <i class="fas fa-user-md"></i>
                                </span>
                                <span>medical staff</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-md fa-2x text-success icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card h-100 border-start border-5 border-info">
                <div class="card-body p-4">
                    <div class="row no-gutters align-items-center">
                        <div class="col">
                            <div class="text-uppercase text-info fw-bold text-xs mb-1">
                                Appointments
                            </div>
                            <div class="h2 mb-0 fw-bold text-gray-800">{{ $stats['permissions'] }}</div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="me-1">
                                    <i class="fas fa-calendar-check"></i>
                                </span>
                                <span>scheduled today</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-info icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card h-100 border-start border-5 border-warning">
                <div class="card-body p-4">
                    <div class="row no-gutters align-items-center">
                        <div class="col">
                            <div class="text-uppercase text-warning fw-bold text-xs mb-1">
                                Hospital Beds
                            </div>
                            <div class="h2 mb-0 fw-bold text-gray-800">85%</div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="me-1">
                                    <i class="fas fa-procedures"></i>
                                </span>
                                <span>occupancy rate</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-procedures fa-2x text-warning icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Department Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 fw-bold text-primary">Patient Distribution by Department</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Chart Options:</div>
                            <a class="dropdown-item" href="#">View Details</a>
                            <a class="dropdown-item" href="#">Download Data</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Print Chart</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height:300px;">
                        <canvas id="usersByRoleChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 fw-bold text-primary">Recent Medical Activity</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="activityDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="activityDropdown">
                            <div class="dropdown-header">Activity Options:</div>
                            <a class="dropdown-item" href="#">View All</a>
                            <a class="dropdown-item" href="#">Clear All</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="activity-feed">
                        @foreach($activities as $activity)
                        <div class="d-flex align-items-start mb-4">
                            <div class="activity-icon me-3">
                                <span class="d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; border-radius: 12px; background-color: rgba({{ $activity['color'] === 'primary' ? '67, 97, 238' : ($activity['color'] === 'success' ? '76, 201, 240' : ($activity['color'] === 'warning' ? '247, 37, 133' : '230, 57, 70')) }}, 0.1);">
                                    <i class="fas {{ $activity['icon'] }} fa-lg" style="color: rgba({{ $activity['color'] === 'primary' ? '67, 97, 238' : ($activity['color'] === 'success' ? '76, 201, 240' : ($activity['color'] === 'warning' ? '247, 37, 133' : '230, 57, 70')) }}, 1);"></i>
                                </span>
                            </div>
                            <div class="activity-content w-100">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 fw-bold">{{ $activity['user'] }}</h6>
                                    <small class="text-muted">{{ $activity['time'] }}</small>
                                </div>
                                <p class="mb-0 text-muted">{{ $activity['action'] }}</p>
                                <small class="text-muted">Ward: {{ rand(1, 5) }}, Room: {{ rand(101, 520) }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Patients and Quick Actions -->
    <div class="row">
        <!-- Recent Patients -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 fw-bold text-primary">Recent Patients</h6>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary rounded-pill">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Patient</th>
                                    <th>ID</th>
                                    <th>Department</th>
                                    <th>Admitted</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentUsers as $user)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 36px; height: 36px; border-radius: 8px; background: linear-gradient(45deg, #1976d2, #64b5f6);">
                                                <span style="font-size: 14px; font-weight: 600;">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                            </div>
                                            <span class="fw-medium">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td>P-{{ 10000 + $user->id }}</td>
                                    <td>
                                        @foreach($user->roles as $role)
                                            <span class="badge rounded-pill" style="background-color: {{ $role->name === 'Super Admin' ? '#E53935' : ($role->name === 'Admin' ? '#1976D2' : ($role->name === 'Moderator' ? '#FFA000' : '#43A047')) }}">
                                                {{ $role->name === 'Super Admin' ? 'Cardiology' : ($role->name === 'Admin' ? 'Neurology' : ($role->name === 'Moderator' ? 'Pediatrics' : 'Orthopedics')) }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-light me-2" data-bs-toggle="tooltip" title="Update Record">
                                                <i class="fas fa-file-medical text-primary"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="View Medical History">
                                                <i class="fas fa-notes-medical text-info"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions and Hospital Info -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-primary">Medical Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="{{ route('admin.users.index') }}" class="card h-100 border-0 shadow-sm hover-card">
                                <div class="card-body text-center">
                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <h6 class="fw-bold mb-0">New Patient</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.roles.index') }}" class="card h-100 border-0 shadow-sm hover-card">
                                <div class="card-body text-center">
                                    <div class="rounded-circle bg-success bg-opacity-10 text-success mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                                        <i class="fas fa-calendar-plus"></i>
                                    </div>
                                    <h6 class="fw-bold mb-0">Appointments</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.permissions.index') }}" class="card h-100 border-0 shadow-sm hover-card">
                                <div class="card-body text-center">
                                    <div class="rounded-circle bg-info bg-opacity-10 text-info mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                                        <i class="fas fa-pills"></i>
                                    </div>
                                    <h6 class="fw-bold mb-0">Pharmacy</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.reports') }}" class="card h-100 border-0 shadow-sm hover-card">
                                <div class="card-body text-center">
                                    <div class="rounded-circle bg-warning bg-opacity-10 text-warning mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                                        <i class="fas fa-file-medical-alt"></i>
                                    </div>
                                    <h6 class="fw-bold mb-0">Lab Results</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-primary">Hospital Status</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-procedures text-danger me-2"></i>
                                <span class="text-muted">ICU Capacity</span>
                            </div>
                            <span class="badge bg-light text-dark">85% (17/20)</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 85%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-md text-primary me-2"></i>
                                <span class="text-muted">Staff on Duty</span>
                            </div>
                            <span class="badge bg-light text-dark">24/30</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 75%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-ambulance text-success me-2"></i>
                                <span class="text-muted">Ambulances</span>
                            </div>
                            <span class="badge bg-light text-dark">4/5 Available</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 90%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-vial text-info me-2"></i>
                                <span class="text-muted">Lab Capacity</span>
                            </div>
                            <span class="badge bg-light text-dark">65%</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 65%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    :root {
        --primary-color: #1976D2;  /* Medical blue */
        --secondary-color: #64B5F6;
        --success-color: #43A047;  /* Medical green */
        --info-color: #29B6F6;     /* Light blue */
        --warning-color: #FFA000;  /* Amber */
        --danger-color: #E53935;   /* Medical red */
    }

    .admin-dashboard-header {
        background-color: #fff;
        padding: 1.5rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .stats-card {
        transition: all 0.3s ease;
        border-radius: 0.75rem;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    
    .hover-card {
        transition: all 0.3s ease;
        border-radius: 0.75rem;
    }
    
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    
    .card {
        border-radius: 0.75rem;
        overflow: hidden;
    }
    
    .card-header {
        background-color: #ffffff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        color: #6c757d;
    }
    
    .table td {
        vertical-align: middle;
        padding-top: 1rem;
        padding-bottom: 1rem;
    }
    
    .table tr:last-child td {
        border-bottom: none;
    }
    
    .badge {
        padding: 0.4em 0.8em;
        font-weight: 500;
    }
    
    .btn-light {
        background-color: #f8f9fa;
        border-color: #f0f0f0;
    }
    
    .btn-light:hover {
        background-color: #e9ecef;
    }
    
    .activity-feed .activity-content {
        position: relative;
        padding-bottom: 1.25rem;
    }
    
    .activity-feed > div:not(:last-child) .activity-content:after {
        content: '';
        position: absolute;
        left: -20px;
        top: 40px;
        bottom: 0;
        width: 1px;
        background: rgba(0, 0, 0, 0.1);
    }
    
    .icon {
        opacity: 0.6;
    }
    
    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    
    .btn-primary:hover {
        background-color: #1565C0;
        border-color: #1565C0;
    }
    
    .text-primary {
        color: var(--primary-color) !important;
    }
    
    .border-primary {
        border-color: var(--primary-color) !important;
    }
    
    .bg-primary {
        background-color: var(--primary-color) !important;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Users by Role Chart
        const usersByRoleChart = document.getElementById('usersByRoleChart');
        
        if (usersByRoleChart) {
            const roleLabels = @json($usersByRole->pluck('name'));
            const departmentLabels = roleLabels.map(label => {
                switch(label) {
                    case 'Super Admin': return 'Cardiology';
                    case 'Admin': return 'Neurology';
                    case 'Moderator': return 'Pediatrics';
                    default: return 'Orthopedics';
                }
            });
            
            const roleData = @json($usersByRole->pluck('users_count'));
            
            new Chart(usersByRoleChart, {
                type: 'bar',
                data: {
                    labels: departmentLabels,
                    datasets: [{
                        label: 'Number of Patients',
                        data: roleData,
                        backgroundColor: [
                            'rgba(229, 57, 53, 0.8)',    // Cardiology - Red
                            'rgba(25, 118, 210, 0.8)',   // Neurology - Blue
                            'rgba(255, 160, 0, 0.8)',    // Pediatrics - Amber
                            'rgba(67, 160, 71, 0.8)',    // Orthopedics - Green
                            'rgba(156, 39, 176, 0.8)',   // Purple
                        ],
                        borderWidth: 0,
                        borderRadius: 6
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Patient Distribution by Medical Department',
                            font: {
                                size: 16,
                                family: "'Poppins', sans-serif"
                            },
                            padding: {
                                bottom: 20
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                font: {
                                    family: "'Poppins', sans-serif"
                                }
                            },
                            grid: {
                                display: true,
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            title: {
                                display: true,
                                text: 'Number of Patients',
                                font: {
                                    family: "'Poppins', sans-serif",
                                    size: 12
                                }
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    family: "'Poppins', sans-serif"
                                }
                            },
                            grid: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Department',
                                font: {
                                    family: "'Poppins', sans-serif",
                                    size: 12
                                }
                            }
                        }
                    }
                }
            });
        }
        
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endpush 