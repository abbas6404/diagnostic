@extends('layouts.app')

@section('title', 'Register')

@push('styles')
<style>
    body {
        background-color: #f0f2fa;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%234e73df' fill-opacity='0.05'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    
    .register-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }
    
    .register-wrapper {
        width: 100%;
        max-width: 1000px;
    }
    
    .register-card {
        border: none;
        border-radius: 1.5rem;
        overflow: hidden;
        background-color: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }
    
    .register-header {
        text-align: center;
        padding: 2.5rem 1rem 1.5rem;
    }
    
    .register-logo {
        margin-bottom: 1rem;
    }
    
    .register-logo-icon {
        width: 50px;
        height: 50px;
        background-color: #4e73df;
        color: white;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 5px 15px rgba(78, 115, 223, 0.3);
    }
    
    .register-title {
        font-weight: 700;
        font-size: 1.75rem;
        margin-bottom: 0.5rem;
    }
    
    .register-subtitle {
        color: #6b7280;
        font-size: 0.95rem;
    }
    
    .register-form-container {
        padding: 0 2.5rem 2.5rem;
    }
    
    .form-control {
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
        height: 3.25rem;
        font-size: 0.95rem;
        background-color: #f9fafc;
        transition: all 0.2s ease;
    }
    
    .form-control:focus {
        border-color: #4e73df;
        background-color: white;
        box-shadow: 0 0 0 0.15rem rgba(78, 115, 223, 0.15);
    }
    
    .form-label {
        color: #4b5563;
        font-weight: 500;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }
    
    .input-group-text {
        background-color: #f9fafc;
        border-color: #e2e8f0;
        color: #6b7280;
        border-radius: 0.75rem;
    }
    
    .input-group .form-control {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
    
    .input-group-text {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }
    
    .btn-primary {
        background-color: #4e73df;
        border: none;
        border-radius: 0.75rem;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        height: 3.25rem;
        transition: all 0.2s ease;
    }
    
    .btn-primary:hover {
        background-color: #3a5ccc;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(78, 115, 223, 0.2);
    }
    
    .login-divider {
        display: flex;
        align-items: center;
        margin: 1.5rem 0;
    }
    
    .login-divider-line {
        flex-grow: 1;
        height: 1px;
        background-color: #e2e8f0;
    }
    
    .login-divider-text {
        padding: 0 1rem;
        color: #6b7280;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    .social-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        font-weight: 500;
        transition: all 0.2s ease;
        width: 100%;
        height: 3.25rem;
        text-decoration: none;
        color: #4b5563;
        background-color: white;
        font-size: 0.95rem;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }
    
    .social-btn:hover {
        background-color: #f9fafb;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        text-decoration: none;
    }
    
    .social-btn svg {
        margin-right: 0.75rem;
    }
    
    .register-footer {
        text-align: center;
        margin-top: 1.5rem;
    }
    
    .register-footer a {
        color: #4e73df;
        font-weight: 500;
        text-decoration: none;
    }
    
    .register-footer a:hover {
        text-decoration: underline;
    }
    
    .features-section {
        background-color: #4e73df;
        color: white;
        padding: 2.5rem;
        border-radius: 1.5rem;
        position: relative;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    
    .features-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
        transform: rotate(30deg);
        z-index: 0;
    }
    
    .features-content {
        position: relative;
        z-index: 1;
    }
    
    .feature-item {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 1rem;
        transition: all 0.2s ease;
    }
    
    .feature-item:hover {
        background-color: rgba(255, 255, 255, 0.15);
        transform: translateX(5px);
    }
    
    .feature-icon {
        width: 40px;
        height: 40px;
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
    }
    
    .feature-item h5 {
        font-size: 1rem;
        margin-bottom: 0.15rem;
        font-weight: 600;
    }
    
    .feature-item p {
        font-size: 0.85rem;
        margin-bottom: 0;
        opacity: 0.8;
    }
    
    .password-requirements {
        background-color: #f9fafc;
        border-radius: 0.75rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
        border: 1px solid #e2e8f0;
    }
    
    .password-requirements h6 {
        color: #4b5563;
        font-size: 0.9rem;
        margin-bottom: 0.75rem;
    }
    
    .password-requirements ul {
        padding-left: 1.5rem;
        margin-bottom: 0;
    }
    
    .password-requirements li {
        font-size: 0.85rem;
        color: #6b7280;
        margin-bottom: 0.25rem;
    }
    
    .password-requirements li.valid {
        color: #10b981;
    }
    
    .password-requirements li i {
        margin-right: 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="register-container">
    <div class="register-wrapper">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="features-section">
                    <div class="features-content">
                        <h2 class="fw-bold mb-4">Join Our Community</h2>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div>
                                <h5>Secure Access Control</h5>
                                <p>Protect your application resources</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <h5>Role Management</h5>
                                <p>Define user access levels</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <div>
                                <h5>Permission Control</h5>
                                <p>Fine-grained access settings</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-8">
                <div class="register-card">
                    <div class="register-header">
                        <div class="register-logo">
                            <div class="register-logo-icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                        </div>
                        <h1 class="register-title">Create an Account</h1>
                        <p class="register-subtitle">Fill out the form below to get started</p>
                    </div>
                    
                    <div class="register-form-container">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Enter your full name">
                                </div>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter your email address">
                        </div>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Create a strong password">
                        </div>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="password-requirements">
                                <h6 class="fw-bold">Password Requirements:</h6>
                                <ul>
                                    <li><i class="fas fa-check-circle"></i> At least 8 characters long</li>
                                    <li><i class="fas fa-check-circle"></i> Contains at least one uppercase letter</li>
                                    <li><i class="fas fa-check-circle"></i> Contains at least one lowercase letter</li>
                                    <li><i class="fas fa-check-circle"></i> Contains at least one number</li>
                                    <li><i class="fas fa-check-circle"></i> Contains at least one special character</li>
                                </ul>
                        </div>

                            <div class="mb-4">
                                <label for="password-confirm" class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-4">
                                <i class="fas fa-user-plus me-2"></i> Create Account
                            </button>
                            
                            <div class="login-divider">
                                <div class="login-divider-line"></div>
                                <div class="login-divider-text">OR SIGN UP WITH</div>
                                <div class="login-divider-line"></div>
                        </div>

                            <div class="row g-3 mb-4">
                                <div class="col-sm-6">
                                    <a href="#" class="social-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 48 48">
                                            <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                                            <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                                            <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                                            <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                                        </svg>
                                        Google
                                    </a>
                                </div>
                                <div class="col-sm-6">
                                    <a href="#" class="social-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" style="color: #1877F2;">
                                            <path fill="currentColor" d="M24 12.073c0-5.8-4.702-10.5-10.5-10.5s-10.5 4.7-10.5 10.5c0 5.24 3.84 9.584 8.86 10.373v-7.337h-2.666v-3.037h2.666V9.98c0-2.63 1.568-4.085 3.97-4.085 1.15 0 2.35.205 2.35.205v2.584h-1.322c-1.304 0-1.71.81-1.71 1.64v1.97h2.912l-.465 3.036H16.16v7.337c5.02-.788 8.84-5.131 8.84-10.373z"/>
                                        </svg>
                                        Facebook
                                    </a>
                                </div>
                            </div>
                            
                            <div class="register-footer">
                                <p class="mb-0 small">Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
