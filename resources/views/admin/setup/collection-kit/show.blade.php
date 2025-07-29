@extends('admin.setup.setup-layout')

@section('page-title', 'Collection Kit Details')
@section('page-description', 'View collection kit information')

@section('setup-content')
<div class="card shadow">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-box me-2"></i>Collection Kit Details
        </h6>
        <div>
            <a href="{{ route('admin.setup.collection-kit.edit', $collectionKit) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('admin.setup.collection-kit.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Back to List
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th width="150" class="text-muted">Product Code:</th>
                        <td><strong>{{ $collectionKit->pcode }}</strong></td>
                    </tr>
                    <tr>
                        <th class="text-muted">Name:</th>
                        <td>{{ $collectionKit->name }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Color:</th>
                        <td>
                            @if($collectionKit->color)
                                <span class="badge bg-secondary">{{ $collectionKit->color }}</span>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="text-muted">Charge:</th>
                        <td>{{ $collectionKit->formatted_charge }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Status:</th>
                        <td>{!! $collectionKit->status_badge !!}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr>
                        <th width="150" class="text-muted">Created By:</th>
                        <td>{{ $collectionKit->created_by_name }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Updated By:</th>
                        <td>{{ $collectionKit->updated_by_name }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Created:</th>
                        <td>{{ $collectionKit->created_at ? $collectionKit->created_at->format('M d, Y \a\t g:i A') : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Updated:</th>
                        <td>{{ $collectionKit->updated_at ? $collectionKit->updated_at->format('M d, Y \a\t g:i A') : 'N/A' }}</td>
                    </tr>
                    @if($collectionKit->deleted_at)
                        <tr>
                            <th class="text-muted">Deleted:</th>
                            <td>{{ $collectionKit->deleted_at ? $collectionKit->deleted_at->format('M d, Y \a\t g:i A') : 'N/A' }}</td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>

        @if($collectionKit->labTests->count() > 0)
            <hr>
            <h6 class="text-primary mb-3">
                <i class="fas fa-flask me-2"></i>Associated Lab Tests ({{ $collectionKit->labTests->count() }})
            </h6>
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Charge</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($collectionKit->labTests as $labTest)
                            <tr>
                                <td><strong>{{ $labTest->code }}</strong></td>
                                <td>{{ $labTest->name }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $labTest->department->name ?? 'N/A' }}</span>
                                </td>
                                <td>{{ $labTest->formatted_charge }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <hr>
            <div class="text-center text-muted py-3">
                <i class="fas fa-flask fa-2x mb-2"></i>
                <p class="mb-0">No lab tests associated with this collection kit.</p>
            </div>
        @endif

        @if($collectionKit->deleted_at)
            <hr>
            <div class="d-flex justify-content-between">
                <form action="{{ route('admin.setup.collection-kit.restore', $collectionKit->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-undo me-1"></i>Restore Collection Kit
                    </button>
                </form>
                <form action="{{ route('admin.setup.collection-kit.force-delete', $collectionKit->id) }}" 
                      method="POST" class="d-inline" 
                      onsubmit="return confirm('Are you sure you want to permanently delete this collection kit?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Permanently Delete
                    </button>
                </form>
            </div>
        @else
            <hr>
            <form action="{{ route('admin.setup.collection-kit.destroy', $collectionKit) }}" 
                  method="POST" class="d-inline" 
                  onsubmit="return confirm('Are you sure you want to delete this collection kit?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash me-1"></i>Delete Collection Kit
                </button>
            </form>
        @endif
    </div>
</div>
@endsection 