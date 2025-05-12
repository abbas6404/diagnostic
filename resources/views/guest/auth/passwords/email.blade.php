@extends('layouts.app')

@section('title', 'Forgot Password')

@push('styles')
<style>
    body {
        background-color: #f0f2fa;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%234e73df' fill-opacity='0.05'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    
    .forgot-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }
    
    .forgot-wrapper {
        width: 100%;
        max-width: 1000px;
    }
    
    .forgot-card {
        border: none;
        border-radius: 1.5rem;
        overflow: hidden;
        background-color: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }
    
    .forgot-header {
        text-align: center;
        padding: 2.5rem 1rem 1.5rem;
    }
    
    .forgot-logo {
        margin-bottom: 1rem;
    }
    
    .forgot-logo-icon {
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
    
    .forgot-title {
        font-weight: 700;
        font-size: 1.75rem;
        margin-bottom: 0.5rem;
    }
    
    .forgot-subtitle {
        color: #6b7280;
        font-size: 0.95rem;
    }
    
    .forgot-form-container {
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
    
    .forgot-footer {
        text-align: center;
        margin-top: 1.5rem;
    }
    
    .forgot-footer a {
        color: #4e73df;
        font-weight: 500;
        text-decoration: none;
    }
    
    .forgot-footer a:hover {
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
    
    .alert-success {
        background-color: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.2);
        color: #10b981;
        border-radius: 0.75rem;
        padding: 1rem;
    }
</style>
@endpush

@section('content')
<div class="forgot-container">
    <div class="forgot-wrapper">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="features-section">
                    <div class="features-content">
                        <h2 class="fw-bold mb-4">Password Recovery</h2>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-key"></i>
                            </div>
                            <div>
                                <h5>Secure Reset</h5>
                                <p>Reset your password securely</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h5>Email Verification</h5>
                                <p>Link sent to your email</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div>
                                <h5>Account Protection</h5>
                                <p>Keep your account secure</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-8">
                <div class="forgot-card">
                    <div class="forgot-header">
                        <div class="forgot-logo">
                            <div class="forgot-logo-icon">
                                <i class="fas fa-lock-open"></i>
                            </div>
                        </div>
                        <h1 class="forgot-title">Forgot Your Password?</h1>
                        <p class="forgot-subtitle">Enter your email address and we'll send you a password reset link</p>
                    </div>

                    <div class="forgot-form-container">
                    @if (session('status'))
                            <div class="alert alert-success mb-4" role="alert">
                                <i class="fas fa-check-circle me-2"></i> {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                            <div class="mb-4">
                                <label for="email" class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter your email address">
                                </div>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                            <button type="submit" class="btn btn-primary w-100 mb-4">
                                <i class="fas fa-paper-plane me-2"></i> Send Password Reset Link
                                </button>
                            
                            <div class="forgot-footer">
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
