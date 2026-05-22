@extends('admin')

@section('title', 'Register')

@section('content')

    <style>
        body {
            min-height: 100vh;
            overflow: hidden;
        }

        .register-container {
            min-height: 100vh;
        }

        .register-card {
            width: 100%;
            max-width: 430px;
            border: none;
            border-radius: 18px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.20);
        }

        .register-body {
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

        .btn-register {
            height: 46px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            transition: .3s;
        }

        .btn-register:hover {
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

    <div class="container-fluid register-container d-flex align-items-center justify-content-center">

        <div class="register-card">

            <div class="register-body">

                {{-- HEADER --}}
                <div class="text-center mb-4">

                    <a href="#" class="brand-logo">
                        CV.<span>Lisan</span>
                    </a>

                    <h4 class="fw-bold mt-3 mb-2">
                        Register
                    </h4>

                    <p class="welcome-text mb-0">
                        Buat akun baru untuk melanjutkan
                    </p>

                </div>

                {{-- FORM --}}
                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">
                            Nama Lengkap
                        </label>

                        <input type="text" class="form-control" name="name" placeholder="Masukkan nama lengkap">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Email
                        </label>

                        <input type="email" class="form-control" name="email" placeholder="Masukkan email">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Password
                        </label>

                        <input type="password" class="form-control" name="password" placeholder="Masukkan password">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">
                            Konfirmasi Password
                        </label>

                        <input type="password" class="form-control" name="password_confirmation"
                            placeholder="Konfirmasi password">
                    </div>

                    <button type="submit" class="btn btn-primary btn-register w-100">
                        Registrasi
                    </button>

                    <p class="text-center mt-4 mb-0 small-text">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="auth-link">
                            Login
                        </a>
                    </p>

                </form>

            </div>

        </div>

    </div>

@endsection
