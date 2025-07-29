@extends('admin.setup.setup-layout')

@section('page-title', 'Lab Test Management')
@section('page-description', 'Manage laboratory tests by department')

@section('setup-content')
<div class="card shadow">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-flask me-2"></i>Lab Tests
        </h6>
        <a href="{{ route('admin.setup.lab-test.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Add Lab Test
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Department Tabs -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex flex-wrap gap-2">
                    <!-- All Tests Card -->
                    <div class="card department-card {{ !$selectedDepartment ? 'active' : '' }}" 
                         style="min-width: 150px; max-width: 180px; cursor: pointer; transition: all 0.3s ease;">
                        <div class="card-body text-center p-2" 
                             onclick="window.location.href='{{ route('admin.setup.lab-test.index') }}'">
                            <h6 class="card-title mb-1 small">All Tests</h6>
                            <span class="badge bg-primary">{{ array_sum($departmentCounts) }}</span>
                        </div>
                    </div>
                    
                    <!-- Department Cards -->
                    @foreach($departments as $department)
                        <div class="card department-card {{ $selectedDepartment == $department->id ? 'active' : '' }}" 
                             style="min-width: 150px; max-width: 180px; cursor: pointer; transition: all 0.3s ease;">
                            <div class="card-body text-center p-2" 
                                 onclick="window.location.href='{{ route('admin.setup.lab-test.index', ['department' => $department->id]) }}'">
                                <h6 class="card-title mb-1 small">{{ $department->name }}</h6>
                                <span class="badge bg-primary">{{ $departmentCounts[$department->id] ?? 0 }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Lab Tests Table -->
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="mb-0 text-primary">
                    <i class="fas fa-flask me-2"></i>Lab Tests List
                    @if($selectedDepartment)
                        <span class="text-muted">- {{ $departments->find($selectedDepartment)->name ?? 'Unknown' }}</span>
                    @endif
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-primary">
                            <tr>
                                <th class="border-0"><i class="fas fa-hashtag me-1"></i>Code</th>
                                <th class="border-0"><i class="fas fa-flask me-1"></i>Name</th>
                                <th class="border-0"><i class="fas fa-building me-1"></i>Department</th>
                                <th class="border-0"><i class="fas fa-dollar-sign me-1"></i>Charge</th>
                                <th class="border-0"><i class="fas fa-info-circle me-1"></i>Status</th>
                                <th class="border-0"><i class="fas fa-calendar me-1"></i>Created</th>
                                <th class="border-0"><i class="fas fa-cogs me-1"></i>Actions</th>
                            </tr>
                        </thead>
                <tbody>
                    @forelse($labTests as $labTest)
                        <tr class="{{ $labTest->deleted_at ? 'table-danger' : '' }}">
                            <td>
                                <strong>{{ $labTest->code }}</strong>
                            </td>
                            <td>{{ $labTest->name }}</td>
                            <td>
                                <span class="badge bg-info">{{ $labTest->department->name ?? 'N/A' }}</span>
                            </td>
                            <td>{{ $labTest->formatted_charge }}</td>
                            <td>
                                {!! $labTest->status_badge !!}
                            </td>
                            <td>
                                {{ $labTest->created_at ? $labTest->created_at->format('M d, Y') : 'N/A' }}
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.setup.lab-test.show', $labTest) }}" 
                                       class="btn btn-sm btn-outline-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if(!$labTest->deleted_at)
                                        <a href="{{ route('admin.setup.lab-test.edit', $labTest) }}" 
                                           class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.setup.lab-test.destroy', $labTest) }}" 
                                              method="POST" class="d-inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this lab test?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.setup.lab-test.restore', $labTest->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success" title="Restore">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.setup.lab-test.force-delete', $labTest->id) }}" 
                                              method="POST" class="d-inline" 
                                              onsubmit="return confirm('Are you sure you want to permanently delete this lab test? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Permanently Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-flask fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No lab tests found</h5>
                                <p class="text-muted">
                                    @if($selectedDepartment)
                                        No lab tests found for this department.
                                    @else
                                        Create your first lab test to get started.
                                    @endif
                                </p>
                                <a href="{{ route('admin.setup.lab-test.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i>Add Lab Test
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.department-card {
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.department-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.15);
    border-color: #007bff;
}

.department-card.active {
    border-color: #007bff;
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
    box-shadow: 0 8px 20px rgba(0,123,255,0.3);
}

.department-card.active .text-primary {
    color: white !important;
}

.department-card.active .badge {
    background-color: rgba(255,255,255,0.2) !important;
    color: white !important;
}

.department-card .card-body {
    cursor: pointer;
}

.department-card .card-title {
    font-size: 0.8rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
    line-height: 1.2;
}

.department-card .badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
}

.card-header {
    border-bottom: 2px solid #e9ecef;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,123,255,0.05);
}

.btn-group .btn {
    transition: all 0.2s ease;
}

.btn-group .btn:hover {
    transform: scale(1.05);
}

.gap-2 {
    gap: 0.5rem !important;
}
</style>
@endsection 