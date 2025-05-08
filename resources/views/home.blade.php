@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Role & Permission Management System</h1>
                <p class="lead mb-4">A powerful and flexible system to manage user roles and permissions in your Laravel application.</p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4 me-md-2">Get Started</a>
                    @endif
                    <a href="#features" class="btn btn-outline-light btn-lg px-4">Learn More</a>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <img src="https://via.placeholder.com/600x400?text=Role+Management" alt="Role Management" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5" id="features">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Key Features</h2>
            <p class="lead text-muted">Everything you need for role and permission management</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 p-4 text-center">
                    <div class="feature-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h3 class="h4 mb-3">Role-Based Access Control</h3>
                    <p class="text-muted">Assign roles like Super Admin, Admin, Moderator, and User to control access to your application.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 p-4 text-center">
                    <div class="feature-icon">
                        <i class="fas fa-key"></i>
                    </div>
                    <h3 class="h4 mb-3">Granular Permissions</h3>
                    <p class="text-muted">Create and assign specific permissions to roles for fine-grained access control.</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100 p-4 text-center">
                    <div class="feature-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h3 class="h4 mb-3">Secure Routes & UI</h3>
                    <p class="text-muted">Protect routes and conditionally render UI components based on user roles and permissions.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">How It Works</h2>
            <p class="lead text-muted">Simple and effective role management</p>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <span class="display-4 fw-bold text-primary me-3">1</span>
                            <h3 class="h5 mb-0">Create Roles</h3>
                        </div>
                        <p class="text-muted">Define roles that represent different user types in your application.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4 mb-md-0">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <span class="display-4 fw-bold text-primary me-3">2</span>
                            <h3 class="h5 mb-0">Assign Permissions</h3>
                        </div>
                        <p class="text-muted">Create permissions and assign them to roles to control access to features.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <span class="display-4 fw-bold text-primary me-3">3</span>
                            <h3 class="h5 mb-0">Manage Users</h3>
                        </div>
                        <p class="text-muted">Assign roles to users and control their access throughout your application.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card p-5 text-center">
                    <h2 class="fw-bold mb-3">Ready to get started?</h2>
                    <p class="lead mb-4">Create an account and start managing your application's roles and permissions today.</p>
                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4 gap-3">Sign Up</a>
                        @endif
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg px-4">Login</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
 