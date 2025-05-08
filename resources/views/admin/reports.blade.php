@extends('admin.layouts.app')

@section('title', 'Reports')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">System Reports</h5>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-secondary">Back to Dashboard</a>
                </div>

                <div class="card-body">
                    <div class="alert alert-info">
                        This page is only accessible to users with the <strong>view reports</strong> permission.
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    User Statistics
                                </div>
                                <div class="card-body">
                                    <canvas id="userChart"></canvas>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    Role Distribution
                                </div>
                                <div class="card-body">
                                    <canvas id="roleChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sample chart data - in a real application, this would come from your backend
    document.addEventListener('DOMContentLoaded', function() {
        // User statistics chart
        const userCtx = document.getElementById('userChart').getContext('2d');
        new Chart(userCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'New Users',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Role distribution chart
        const roleCtx = document.getElementById('roleChart').getContext('2d');
        new Chart(roleCtx, {
            type: 'pie',
            data: {
                labels: ['Super Admin', 'Admin', 'Moderator', 'User'],
                datasets: [{
                    label: 'Role Distribution',
                    data: [1, 3, 5, 25],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        });
    });
</script>
@endpush
@endsection 