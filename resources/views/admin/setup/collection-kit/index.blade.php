@extends('admin.setup.setup-layout')

@section('page-title', 'Collection Kit Management')
@section('page-description', 'Manage laboratory collection kits and equipment')

@section('setup-content')
<div class="card shadow">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-box me-2"></i>Collection Kits
        </h6>
        <a href="{{ route('admin.setup.collection-kit.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Add Collection Kit
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

        <!-- Collection Kits Table -->
        <div class="card">
            <div class="card-header bg-white">
                <h6 class="mb-0 text-primary">
                    <i class="fas fa-box me-2"></i>Collection Kits List
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-primary">
                            <tr>
                                <th class="border-0"><i class="fas fa-hashtag me-1"></i>Product Code</th>
                                <th class="border-0"><i class="fas fa-box me-1"></i>Name</th>
                                <th class="border-0"><i class="fas fa-palette me-1"></i>Color</th>
                                <th class="border-0"><i class="fas fa-money-bill me-1"></i>Charge</th>
                                <th class="border-0"><i class="fas fa-info-circle me-1"></i>Status</th>
                                <th class="border-0"><i class="fas fa-calendar me-1"></i>Created</th>
                                <th class="border-0"><i class="fas fa-cogs me-1"></i>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($collectionKits as $collectionKit)
                                <tr class="{{ $collectionKit->deleted_at ? 'table-danger' : '' }}">
                                    <td>
                                        <strong>{{ $collectionKit->pcode }}</strong>
                                    </td>
                                    <td>{{ $collectionKit->name }}</td>
                                    <td>
                                        @if($collectionKit->color)
                                            <span class="badge bg-secondary">{{ $collectionKit->color }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>{{ $collectionKit->formatted_charge }}</td>
                                    <td>
                                        {!! $collectionKit->status_badge !!}
                                    </td>
                                    <td>
                                        {{ $collectionKit->created_at ? $collectionKit->created_at->format('M d, Y') : 'N/A' }}
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.setup.collection-kit.show', $collectionKit) }}" 
                                               class="btn btn-sm btn-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.setup.collection-kit.edit', $collectionKit) }}" 
                                               class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if($collectionKit->deleted_at)
                                                <form action="{{ route('admin.setup.collection-kit.restore', $collectionKit->id) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" title="Restore">
                                                        <i class="fas fa-undo"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.setup.collection-kit.force-delete', $collectionKit->id) }}" 
                                                      method="POST" class="d-inline" 
                                                      onsubmit="return confirm('Are you sure you want to permanently delete this collection kit?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Permanently Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.setup.collection-kit.destroy', $collectionKit) }}" 
                                                      method="POST" class="d-inline" 
                                                      onsubmit="return confirm('Are you sure you want to delete this collection kit?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-box fa-2x mb-3"></i>
                                            <p class="mb-0">No collection kits found.</p>
                                            <a href="{{ route('admin.setup.collection-kit.create') }}" class="btn btn-primary btn-sm mt-2">
                                                <i class="fas fa-plus me-1"></i>Add First Collection Kit
                                            </a>
                                        </div>
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