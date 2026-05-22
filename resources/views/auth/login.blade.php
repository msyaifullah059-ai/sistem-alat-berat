@extends('admin')

@section('title', 'Login')

@section('content')

    <style>
        body {
            min-height: 100vh;
            overflow: hidden;
        }

        .login-container {
            min-height: 100vh;
        }

        .login-card {
            width: 100%;
            max-width: 430px;
            border: none;
            border-radius: 18px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.20);
        }

        .login-body {
            padding: 35px;
        }

        .brand-logo {
            font-size: 26px;
            font-weight: 700;
            color: #111827;
            text-decoration: none;
        }

        .brand-logo span {
            color: #2563eb;
        }

        .welcome-text {
            color: #6b7280;
            font-size: 14px;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
        }

        .form-control {
            height: 46px;
            border-radius: 12px;
            border: 1px solid #d1d5db;
            padding-left: 15px;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.10);
        }

        .btn-login {
            height: 46px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            transition: .3s;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.20);
        }

        .form-check-label,
        .small-text {
            font-size: 13px;
        }

        .auth-link {
            text-decoration: none;
            font-weight: 600;
            color: #2563eb;
        }

        .auth-link:hover {
            color: #1d4ed8;
        }
    </style>

    <div class="container-fluid login-container d-flex align-items-center justify-content-center">

        <div class="login-card">

            <div class="login-body">

                {{-- HEADER --}}
                <div class="text-center mb-4">

                    <a href="#" class="brand-logo">
                        CV.<span>Lisan</span>
                    </a>

                    <h4 class="fw-bold mt-3 mb-2">
                        Login
                    </h4>

                    <p class="welcome-text mb-0">
                        Silahkan login untuk melanjutkan
                    </p>

                </div>

                {{-- FORM --}}
                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    {{-- ERROR MESSAGE --}}
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">
                            Email
                        </label>

                        <input type="email" class="form-control" name="email" placeholder="Masukkan email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Password
                        </label>

                        <input type="password" class="form-control" name="password" placeholder="Masukkan password"
                            required>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">

                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>

                        <a href="#" class="auth-link small-text">
                            Lupa Password?
                        </a>

                    </div>

                    <button type="submit" class="btn btn-primary btn-login w-100">
                        Masuk
                    </button>

                    <p class="text-center mt-4 mb-0 small-text">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="auth-link">
                            Registrasi
                        </a>
                    </p>

                </form>

            </div>

        </div>

    </div>

@endsection
