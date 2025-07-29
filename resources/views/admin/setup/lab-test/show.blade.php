@extends('admin.setup.setup-layout')

@section('page-title', 'Lab Test Details')
@section('page-description', 'View lab test information')

@section('setup-content')
<div class="row">
    <div class="col-md-7">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-flask me-2"></i>Lab Test Details
                </h6>
                <div class="btn-group" role="group">
                    @if(!$labTest->deleted_at)
                        <a href="{{ route('admin.setup.lab-test.edit', $labTest) }}" 
                           class="btn btn-warning btn-sm">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                    @endif
                    <a href="{{ route('admin.setup.lab-test.index') }}" 
                       class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Basic Information -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td class="fw-bold text-muted" style="width: 40%;">Test Code:</td>
                                    <td><strong class="text-primary">{{ $labTest->code }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Test Name:</td>
                                    <td><strong>{{ $labTest->name }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Department:</td>
                                    <td>
                                        <span class="badge bg-info">{{ $labTest->department->name ?? 'N/A' }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Charge:</td>
                                    <td><strong class="text-success">{{ $labTest->formatted_charge }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Status:</td>
                                    <td>{!! $labTest->status_badge !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td class="fw-bold text-muted" style="width: 40%;">Created:</td>
                                    <td>{{ $labTest->created_at ? $labTest->created_at->format('M d, Y \a\t g:i A') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Created By:</td>
                                    <td>
                                        @if($labTest->createdBy)
                                            <span class="badge bg-secondary">{{ $labTest->createdBy->name ?? 'Unknown' }}</span>
                                        @else
                                            <span class="text-muted">Unknown</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Last Updated:</td>
                                    <td>{{ $labTest->updated_at ? $labTest->updated_at->format('M d, Y \a\t g:i A') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Updated By:</td>
                                    <td>
                                        @if($labTest->updatedBy)
                                            <span class="badge bg-secondary">{{ $labTest->updatedBy->name ?? 'Unknown' }}</span>
                                        @else
                                            <span class="text-muted">Unknown</span>
                                        @endif
                                    </td>
                                </tr>
                                @if($labTest->deleted_at)
                                    <tr>
                                        <td class="fw-bold text-muted">Deleted:</td>
                                        <td class="text-danger">{{ $labTest->deleted_at->format('M d, Y \a\t g:i A') }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Description Section -->
                @if($labTest->description)
                    <div class="card border-left-primary mb-4">
                        <div class="card-body">
                            <h6 class="card-title text-primary">
                                <i class="fas fa-info-circle me-2"></i>Description
                            </h6>
                            <p class="card-text">{{ $labTest->description }}</p>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                @if($labTest->deleted_at)
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Note:</strong> This lab test has been deleted. You can restore it or permanently delete it.
                    </div>
                    
                    <div class="d-flex gap-2">
                        <form action="{{ route('admin.setup.lab-test.restore', $labTest->id) }}" 
                              method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-undo me-1"></i>Restore Lab Test
                            </button>
                        </form>
                        
                        <form action="{{ route('admin.setup.lab-test.force-delete', $labTest->id) }}" 
                              method="POST" class="d-inline" 
                              onsubmit="return confirm('Are you sure you want to permanently delete this lab test? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt me-1"></i>Permanently Delete
                            </button>
                        </form>
                    </div>
                @else
                    <div class="d-flex gap-2">
                        <form action="{{ route('admin.setup.lab-test.destroy', $labTest) }}" 
                              method="POST" class="d-inline" 
                              onsubmit="return confirm('Are you sure you want to delete this lab test?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-1"></i>Delete Lab Test
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Collection Kits Section -->
    <div class="col-md-5">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-boxes me-2"></i>Collection Kits
                    @if($labTest->collectionKits && $labTest->collectionKits->count() > 0)
                        <span class="badge bg-primary ms-2">{{ $labTest->collectionKits->count() }}</span>
                    @endif
                </h6>
            </div>
            <div class="card-body">
                @if($labTest->collectionKits && $labTest->collectionKits->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($labTest->collectionKits as $kit)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong class="text-primary">{{ $kit->pcode }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $kit->name }}</small>
                                    @if($kit->color)
                                        <br>
                                        <small>
                                            <span class="badge" style="background-color: {{ $kit->color }}; color: white;">
                                                {{ $kit->color }}
                                            </span>
                                        </small>
                                    @endif
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-success">{{ $kit->formatted_charge }}</span>
                                    <br>
                                    <small class="text-muted">
                                        <span class="badge bg-{{ $kit->status == 'active' ? 'success' : 'warning' }}">
                                            {{ ucfirst($kit->status) }}
                                        </span>
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">No collection kits assigned to this lab test.</p>
                        <small class="text-muted">Collection kits can be added when editing the lab test.</small>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 