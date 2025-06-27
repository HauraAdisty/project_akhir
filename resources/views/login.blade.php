@extends('layouts.template') {{-- Pastikan ini adalah nama file layout utama Anda --}}

@section('title', 'Login Pengguna')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="col-md-7 col-lg-5">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white text-center py-3">
                    <h4 class="mb-0 fw-bold">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Selamat Datang Kembali
                    </h4>
                </div>
                <div class="card-body p-4 p-md-5">

                    {{-- Menampilkan pesan error validasi jika ada --}}
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                             <i class="bi bi-exclamation-triangle-fill me-2"></i>
                             Email atau Password yang Anda masukkan tidak sesuai.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Alamat Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Masukkan alamat email Anda">
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                                <input type="password" class="form-control" id="password" name="password" required placeholder="Masukkan password Anda">
                            </div>
                        </div>

                        <!-- Ingat Saya & Lupa Password -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Ingat Saya</label>
                            </div>
                            <a href="#" class="small text-decoration-none">Lupa Password?</a>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">Login</button>
                        </div>

                        <hr class="my-4">

                        {{-- <div class="text-center">
                            <p class="mb-0">Belum memiliki akun? <a href="{{ route('register') }}" class="text-decoration-none">Daftar di sini</a></p>
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
