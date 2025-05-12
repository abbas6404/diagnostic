@extends('layouts.app')

@section('title', 'Reset Password')

@push('styles')
<style>
    body {
        background-color: #f0f2fa;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%234e73df' fill-opacity='0.05'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    
    .reset-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }
    
    .reset-wrapper {
        width: 100%;
        max-width: 1000px;
    }
    
    .reset-card {
        border: none;
        border-radius: 1.5rem;
        overflow: hidden;
        background-color: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }
    
    .reset-header {
        text-align: center;
        padding: 2.5rem 1rem 1.5rem;
    }
    
    .reset-logo {
        margin-bottom: 1rem;
    }
    
    .reset-logo-icon {
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
    
    .reset-title {
        font-weight: 700;
        font-size: 1.75rem;
        margin-bottom: 0.5rem;
    }
    
    .reset-subtitle {
        color: #6b7280;
        font-size: 0.95rem;
    }
    
    .reset-form-container {
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
    
    .reset-footer {
        text-align: center;
        margin-top: 1.5rem;
    }
    
    .reset-footer a {
        color: #4e73df;
        font-weight: 500;
        text-decoration: none;
    }
    
    .reset-footer a:hover {
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
<div class="reset-container">
    <div class="reset-wrapper">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="features-section">
                    <div class="features-content">
                        <h2 class="fw-bold mb-4">Reset Your Password</h2>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-key"></i>
                            </div>
                            <div>
                                <h5>Create New Password</h5>
                                <p>Set a strong, secure password</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-lock"></i>
                            </div>
                            <div>
                                <h5>Enhanced Security</h5>
                                <p>Protect your account</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div>
                                <h5>Account Protection</h5>
                                <p>Keep your data secure</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-8">
                <div class="reset-card">
                    <div class="reset-header">
                        <div class="reset-logo">
                            <div class="reset-logo-icon">
                                <i class="fas fa-key"></i>
                            </div>
                        </div>
                        <h1 class="reset-title">Reset Password</h1>
                        <p class="reset-subtitle">Create a new password for your account</p>
                    </div>

                    <div class="reset-form-container">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="Enter your email address">
                                </div>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
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
                                <label for="password-confirm" class="form-label">Confirm New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your new password">
                            </div>
                        </div>

                            <button type="submit" class="btn btn-primary w-100 mb-4">
                                <i class="fas fa-key me-2"></i> Reset Password
                                </button>
                            
                            <div class="reset-footer">
                                <p class="mb-0 small">
                                    <a href="{{ route('login') }}"><i class="fas fa-arrow-left me-1"></i> Back to Login</a>
                                </p>
                            </div>
                        </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
