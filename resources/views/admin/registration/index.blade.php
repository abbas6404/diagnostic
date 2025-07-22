@extends('admin.layouts.app')

@section('title', isset($isArchived) && $isArchived ? 'Archived Patients' : 'Patient List')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary">
                    <i class="fas fa-users me-2"></i> {{ isset($isArchived) && $isArchived ? 'Archived Patients' : 'Patient List' }}
                </h5>
                <a href="{{ route('admin.patients.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-1"></i> New Patient
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            <!-- Search and Filter Section -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <form action="{{ route('admin.patients.index') }}" method="GET">
                        <div class="d-flex gap-2">
                            <div class="input-group flex-grow-1">
                                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search patients by name, ID, phone or address...">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                            
                            <div class="input-group" style="width: auto;">
                                <select class="form-select" name="status" onchange="this.form.submit()">
                                    <option value="active" {{ request('status') != 'archived' ? 'selected' : '' }}>Active Patients</option>
                                    <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived Patients</option>
                                </select>
                            </div>
                            
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-download"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="exportDropdown">
                                    <li><a class="dropdown-item" href="#"><i class="far fa-file-excel me-2"></i>Export Excel</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="far fa-file-pdf me-2"></i>Export PDF</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-print me-2"></i>Print</a></li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Patients Table -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th style="width: 100px;">Patient ID</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th>Gender</th>
                            <th>Age</th>
                            <th>Blood Group</th>
                            <th style="width: 150px;">Registered</th>
                            <th style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patients as $index => $patient)
                        <tr>
                            <td>{{ $index + $patients->firstItem() }}</td>
                            <td>{{ $patient->patient_id }}</td>
                            <td>{{ $patient->name_en }}</td>
                            <td>{{ $patient->phone }}</td>
                            <td>{{ $patient->address }}</td>
                            <td>{{ $patient->gender }}</td>
                            <td>
                                @php
                                    $age = '';
                                    if ($patient->dob) {
                                        $dob = new DateTime($patient->dob);
                                        $now = new DateTime();
                                        $diff = $now->diff($dob);
                                        $age = $diff->y . 'y ' . $diff->m . 'm';
                                    }
                                @endphp
                                {{ $age }}
                            </td>
                            <td>
                                <i class="fas fa-tint text-danger"></i> {{ $patient->blood_group }}
                            </td>
                            <td>{{ date('d M Y', strtotime($patient->reg_date)) }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    @if(isset($isArchived) && $isArchived)
                                        <form action="{{ route('admin.patients.restore', $patient->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success" title="Restore Patient"><i class="fas fa-trash-restore"></i></button>
                                        </form>
                                    @else
                                        <a href="{{ route('admin.patients.show', $patient->id) }}" class="btn btn-info" title="View"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('admin.patients.edit', $patient->id) }}" class="btn btn-primary" title="Edit"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admin.patients.destroy', $patient->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to archive this patient? The record will be soft deleted.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" style="border-radius: 0 5px 5px 0;" title="Archive (Soft Delete)"><i class="fas fa-archive"></i></button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">No patients found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <span class="text-muted">Showing {{ $patients->firstItem() ?? 0 }} to {{ $patients->lastItem() ?? 0 }} of {{ $patients->total() ?? 0 }} entries</span>
                </div>
                <div>
                    {{ $patients->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endsection 