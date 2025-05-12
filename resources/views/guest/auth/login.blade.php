@extends('layouts.app')

@section('title', 'Login')

@push('styles')
<style>
    body {
        background-color: #f0f2fa;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%234e73df' fill-opacity='0.05'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    
    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }
    
    .login-wrapper {
        width: 100%;
        max-width: 1000px;
    }
    
    .login-card {
        border: none;
        border-radius: 1.5rem;
        overflow: hidden;
        background-color: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }
    
    .login-header {
        text-align: center;
        padding: 2.5rem 1rem 1.5rem;
    }
    
    .login-logo {
        margin-bottom: 1rem;
    }
    
    .login-logo-icon {
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
    
    .login-title {
        font-weight: 700;
        font-size: 1.75rem;
        margin-bottom: 0.5rem;
    }
    
    .login-subtitle {
        color: #6b7280;
        font-size: 0.95rem;
    }
    
    .login-form-container {
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
    
    .form-check-input:checked {
        background-color: #4e73df;
        border-color: #4e73df;
    }
    
    .login-footer {
        text-align: center;
        margin-top: 1.5rem;
    }
    
    .login-footer a {
        color: #4e73df;
        font-weight: 500;
        text-decoration: none;
    }
    
    .login-footer a:hover {
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
    
    .users-section {
        margin-top: auto;
        position: relative;
        z-index: 1;
    }
    
    .users-avatars {
        display: flex;
        align-items: center;
        margin-bottom: 0.75rem;
    }
    
    .users-avatars img {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 2px solid white;
        margin-right: -10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    
    .users-text {
        font-size: 0.9rem;
        opacity: 0.9;
    }
</style>
@endpush

@section('content')
<div class="login-container">
    <div class="login-wrapper">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="features-section">
                    <div class="features-content">
                        <h2 class="fw-bold mb-4">Welcome Back!</h2>
                        
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
                    
                    <div class="users-section">
                        <div class="users-avatars">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User">
                            <img src="https://randomuser.me/api/portraits/men/67.jpg" alt="User">
                            <img src="https://randomuser.me/api/portraits/women/21.jpg" alt="User">
                        </div>
                        <div class="users-text">Join 1000+ users already managing their application permissions</div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-8">
                <div class="login-card">
                    <div class="login-header">
                        <div class="login-logo">
                            <div class="login-logo-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                        </div>
                        <h1 class="login-title">Sign in to your account</h1>
                        <p class="login-subtitle">Enter your credentials to access your account</p>
                    </div>
                    
                    <div class="login-form-container">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="login" class="form-label">Email or Phone</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input id="login" type="text" class="form-control @error('login') is-invalid @enderror @error('email') is-invalid @enderror @error('phone') is-invalid @enderror" name="login" value="{{ old('login') }}" required autocomplete="login" autofocus placeholder="Enter your email or phone">
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
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter your password">
                                </div>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="remember">
                                        Remember Me
                                    </label>
                                </div>
                                
                                @if (Route::has('password.request'))
                                    <a class="text-primary text-decoration-none small" href="{{ route('password.request') }}">
                                        Forgot Password?
                                    </a>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-4">
                                <i class="fas fa-sign-in-alt me-2"></i> Sign In
                            </button>
                            
                            <div class="login-divider">
                                <div class="login-divider-line"></div>
                                <div class="login-divider-text">OR CONTINUE WITH</div>
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
                            
                            <div class="login-footer">
                                <p class="mb-0 small">Don't have an account? <a href="{{ route('register') }}">Sign Up</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
