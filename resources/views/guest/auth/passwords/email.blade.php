@extends('layouts.app')

@section('title', 'Forgot Password - AIO HealthCare')

@push('styles')
<style>
    body {
        background-color: #1976D2;
        background-image: url("{{ asset('images/login_bg.jpg') }}");
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        height: 100vh;
        margin: 0;
        font-family: 'Poppins', sans-serif;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .forgot-container {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        width: 100%;
        position: relative;
        z-index: 10;
    }
    
    .forgot-wrapper {
        width: 100%;
        max-width: 1000px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        border-radius: 20px;
        overflow: hidden;
        max-height: 100vh;
        height: calc(100vh - 100px);
        margin: 0 auto;
        background-color: white;
        position: relative;
        z-index: 20;
    }
    
    .forgot-card {
        border: none;
        border-radius: 0;
        overflow: hidden;
        background-color: #ffffff;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .forgot-header {
        text-align: center;
        padding: 2rem 2rem 1rem;
    }
    
    .forgot-logo {
        margin-bottom: 1.5rem;
    }
    
    .forgot-logo-icon {
        width: 80px;
        height: 80px;
        background-color: #1976D2;
        color: white;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        box-shadow: 0 5px 15px rgba(25, 118, 210, 0.3);
    }
    
    .forgot-title {
        font-weight: 700;
        font-size: 2rem;
        margin-bottom: 0.5rem;
        color: #333;
    }
    
    .forgot-subtitle {
        color: #6b7280;
        font-size: 1rem;
    }
    
    .forgot-form-container {
        padding: 0 3rem 2rem;
        flex: 1;
        overflow-y: auto;
    }
    
    .form-label {
        color: #4b5563;
        font-weight: 500;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }
    
    .form-control {
        border-radius: 0.5rem;
        padding: 0.75rem 1rem 0.75rem 2.5rem;
        border: 1px solid #e2e8f0;
        height: 3rem;
        font-size: 0.95rem;
        background-color: #ffffff;
        transition: all 0.2s ease;
        width: 100%;
    }
    
    .form-control:focus {
        border-color: #1976D2;
        background-color: white;
        box-shadow: 0 0 0 2px rgba(25, 118, 210, 0.1);
        outline: none;
    }
    
    .input-group {
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
        z-index: 10;
        font-size: 0.9rem;
    }
    
    .btn-primary {
        background-color: #1976D2;
        border: none;
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        height: 3rem;
        transition: all 0.2s ease;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-primary:hover {
        background-color: #1565C0;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(25, 118, 210, 0.2);
    }
    
    .forgot-footer {
        text-align: center;
        margin-top: 1.5rem;
    }
    
    .forgot-footer a {
        color: #1976D2;
        font-weight: 500;
        text-decoration: none;
    }
    
    .forgot-footer a:hover {
        text-decoration: underline;
    }
    
    .features-section {
        background: linear-gradient(135deg, #2979c0 0%, #2161a0 100%);
        color: white;
        padding: 2.5rem 2rem;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        overflow-y: auto;
    }
    
    .feature-title {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 2rem;
        line-height: 1.2;
    }
    
    .feature-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1.5rem;
        padding: 1.25rem;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 1rem;
        transition: all 0.3s ease;
    }
    
    .feature-item:hover {
        background-color: rgba(255, 255, 255, 0.2);
        transform: translateX(5px);
    }
    
    .feature-icon {
        width: 45px;
        height: 45px;
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.25rem;
    }
    
    .feature-item h5 {
        font-size: 1.15rem;
        margin-bottom: 0.15rem;
        font-weight: 600;
    }
    
    .feature-item p {
        font-size: 0.9rem;
        margin-bottom: 0;
        opacity: 0.8;
    }
    
    .footer-text {
        text-align: center;
        margin-top: 1rem;
    }
    
    .heartbeat-icon {
        font-size: 3rem;
        display: block;
        text-align: center;
        margin-bottom: 1rem;
        animation: heartbeat 1.5s ease-in-out infinite;
    }
    
    @keyframes heartbeat {
        0% { transform: scale(1); }
        14% { transform: scale(1.1); }
        28% { transform: scale(1); }
        42% { transform: scale(1.1); }
        70% { transform: scale(1); }
    }
    
    .alert-success {
        background-color: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.2);
        color: #10b981;
        border-radius: 0.75rem;
        padding: 1rem;
    }
    
    .support-text {
        text-align: center;
        font-size: 0.85rem;
        color: #6b7280;
        margin-top: 1.5rem;
    }
    
    .back-to-login {
        display: inline-flex;
        align-items: center;
        color: #1976D2;
        font-weight: 500;
        text-decoration: none;
        margin-top: 1rem;
    }
    
    .back-to-login:hover {
        text-decoration: underline;
    }
    
    .row.g-0 {
        height: 100%;
    }
    
    .col-lg-5, .col-lg-7 {
        height: 100%;
    }
    
    @media (max-height: 700px) {
        .forgot-wrapper {
            height: calc(100vh - 40px);
            border-radius: 0;
        }
        
        .forgot-logo-icon {
            width: 60px;
            height: 60px;
            font-size: 1.8rem;
        }
        
        .forgot-header {
            padding: 1.5rem 2rem 0.5rem;
        }
        
        .feature-item {
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        .feature-icon {
            width: 35px;
            height: 35px;
        }
    }
</style>
@endpush

@section('content')
<div class="forgot-container">
    <div class="forgot-wrapper">
        <div class="row g-0">
            <div class="col-lg-5">
                <div class="features-section">
                    <div>
                        <h1 class="feature-title">AIO HealthCare</h1>
                        
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
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-user-lock"></i>
                            </div>
                            <div>
                                <h5>Identity Verification</h5>
                                <p>Confirm your identity safely</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="footer-text">
                        <i class="fas fa-heartbeat heartbeat-icon"></i>
                        <p>Improving healthcare management</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-7">
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
                                    <i class="fas fa-envelope input-icon"></i>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                </div>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i> Send Password Reset Link
                            </button>
                            
                            <div class="support-text">
                                For access issues, please contact IT support
                            </div>
                            
                            <div class="text-center mt-4">
                                <a href="{{ route('login') }}" class="back-to-login">
                                    <i class="fas fa-arrow-left me-2"></i> Back to Login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
