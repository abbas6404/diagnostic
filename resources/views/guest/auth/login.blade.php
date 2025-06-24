@extends('layouts.app')

@section('title', 'Login - AIO HealthCare')

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
    
    .login-container {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        width: 100%;
        position: relative;
        z-index: 10;
    }
    
    /* Semi-transparent overlay to ensure text readability */
   
    
    .login-wrapper {
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
    
    .login-card {
        border: none;
        border-radius: 0;
        background-color: #ffffff;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .login-header {
        text-align: center;
        padding: 2rem 2rem 1rem;
    }
    
    .login-logo {
        margin-bottom: 1.5rem;
    }
    
    .login-logo-icon {
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
    
    .login-title {
        font-weight: 700;
        font-size: 2rem;
        margin-bottom: 0.5rem;
        color: #333;
    }
    
    .login-subtitle {
        color: #6b7280;
        font-size: 1rem;
    }
    
    .login-form-container {
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
    
    .form-check-input:checked {
        background-color: #1976D2;
        border-color: #1976D2;
    }
    
    .login-footer {
        text-align: center;
        margin-top: 1.5rem;
    }
    
    .login-footer a {
        color: #1976D2;
        font-weight: 500;
        text-decoration: none;
    }
    
    .login-footer a:hover {
        text-decoration: underline;
    }
    
    .features-section {
        background: linear-gradient(135deg, #1976D2 0%, #1565C0 100%);
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
    
    .forgot-password {
        text-align: right;
        font-size: 0.9rem;
    }
    
    .remember-me {
        display: flex;
        align-items: center;
    }
    
    .remember-me label {
        font-size: 0.9rem;
        color: #6b7280;
        margin-left: 0.5rem;
    }
    
    .form-check-input {
        width: 1rem;
        height: 1rem;
        margin-top: 0.25rem;
        border: 1px solid #cbd5e0;
    }
    
    .support-text {
        text-align: center;
        font-size: 0.85rem;
        color: #6b7280;
        margin-top: 1.5rem;
    }
    
    .row.g-0 {
        height: 100%;
    }
    
    .col-lg-5, .col-lg-7 {
        height: 100%;
    }
    
    @media (max-height: 700px) {
        .login-wrapper {
            height: calc(100vh - 40px);
            border-radius: 0;
        }
        
        .login-logo-icon {
            width: 60px;
            height: 60px;
            font-size: 1.8rem;
        }
        
        .login-header {
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
<div class="login-container">
    <div class="login-wrapper">
        <div class="row g-0">
            <div class="col-lg-5">
                <div class="features-section">
                    <div>
                        <h1 class="feature-title">AIO HealthCare</h1>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-user-md"></i>
                            </div>
                            <div>
                                <h5>Staff Management</h5>
                                <p>Manage doctors and staff efficiently</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-procedures"></i>
                            </div>
                            <div>
                                <h5>Patient Records</h5>
                                <p>Complete electronic health records</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div>
                                <h5>Appointment System</h5>
                                <p>Schedule and manage appointments</p>
                            </div>
                        </div>
                        
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-pills"></i>
                            </div>
                            <div>
                                <h5>Pharmacy Integration</h5>
                                <p>Manage prescriptions and inventory</p>
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
                <div class="login-card">
                    <div class="login-header">
                        <div class="login-logo">
                            <div class="login-logo-icon">
                                <i class="fas fa-hospital"></i>
                            </div>
                        </div>
                        <h1 class="login-title">Welcome to AIO HealthCare</h1>
                        <p class="login-subtitle">Sign in to access your hospital management dashboard</p>
                    </div>
                    
                    <div class="login-form-container">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="login" class="form-label">Staff ID / Email</label>
                                <div class="input-group">
                                    <i class="fas fa-user input-icon"></i>
                                    <input id="login" type="text" class="form-control @error('login') is-invalid @enderror @error('email') is-invalid @enderror @error('phone') is-invalid @enderror" name="login" value="{{ old('login') }}" required autocomplete="login" autofocus>
                                </div>
                                
                                @error('login')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <i class="fas fa-lock input-icon"></i>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                </div>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="remember-me">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember">Remember Me</label>
                                </div>
                                
                                <div class="forgot-password">
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                                    @endif
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt me-2"></i> Access Healthcare Portal
                            </button>
                            
                            <div class="support-text">
                                For access issues, please contact IT support
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
