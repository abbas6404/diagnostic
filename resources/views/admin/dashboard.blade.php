@extends('admin.layouts.app')

@section('title', 'Hospital Dashboard')

@section('content')
<div class="container-fluid px-0">
    <!-- Content Row -->
    <div class="row">
        <!-- Department Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4" style="height: 80vh; background-image: url('{{ asset('images/sarker_health_complex.jpg') }}'); background-size: cover; background-position: center;">
                   
           
           
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')

@endpush

@push('scripts')

@endpush 