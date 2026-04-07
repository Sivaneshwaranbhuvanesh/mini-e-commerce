@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card p-4">
                <div class="text-center mb-4">
                    <h2 class="fw-bold" style="font-family:'Playfair Display',serif;">Welcome back</h2>
                    <p class="text-muted small">Sign in to your account</p>
                </div>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-500">Email address</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-500">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                               placeholder="••••••••" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <button type="submit" class="btn btn-accent w-100 py-2">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                    </button>
                </form>

                <hr class="my-4">
                <p class="text-center text-muted small mb-0">
                    Don't have an account?
                    <a href="{{ route('register') }}" style="color:var(--accent);font-weight:600;">Register</a>
                </p>

                <div class="mt-3 p-3 rounded" style="background:#f8f7f4;font-size:.8rem;">
                    <strong>Demo Credentials:</strong><br>
                    Admin: <code>admin@shop.com</code> / <code>password</code><br>
                    User: <code>user@shop.com</code> / <code>password</code>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection