@extends('layouts.template') {{-- Pastikan nama layout Anda adalah app.blade.php --}}

@section('title', 'Login')

@section('content')
{{-- Menggunakan flexbox untuk menengahkan form secara vertikal --}}
<div class="row justify-content-center align-items-center" style="min-height: 75vh;">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-success text-white text-center py-3">
                <h4 class="mb-0 fw-bold">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Login Pengguna
                </h4>
            </div>
            <div class="card-body p-4 p-md-5">

                {{-- Menampilkan error validasi --}}
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                         <i class="bi bi-exclamation-triangle-fill me-2"></i>
                         Login Gagal! Periksa kembali email dan password Anda.
                    </div>
                @endif
                
                {{-- Menampilkan pesan status (misal: setelah reset password) --}}
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text" id="email-icon"><i class="bi bi-envelope-fill"></i></span>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="contoh@email.com" aria-describedby="email-icon">
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text" id="password-icon"><i class="bi bi-key-fill"></i></span>
                            <input type="password" class="form-control" id="password" name="password" required placeholder="Masukkan password Anda" aria-describedby="password-icon">
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ingat Saya</label>
                        </div>
                        {{-- Ganti '#' dengan route('password.request') jika Anda mengimplementasikannya --}}
                        <a href="#" class="small">Lupa Password?</a>
                    </div>


                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg">Login</button>
                    </div>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="mb-0">Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
