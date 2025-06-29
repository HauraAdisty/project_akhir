@extends('layouts.template') {{-- Ganti dengan layouts.template jika nama layout Anda itu --}}

@section('title', 'Register Pengguna Baru')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="col-md-7 col-lg-5">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white text-center py-3">
                    <h4 class="mb-0 fw-bold">
                        <i class="bi bi-person-plus-fill me-2"></i> Buat Akun Baru
                    </h4>
                </div>
                <div class="card-body p-4 p-md-5">

                    {{-- Menampilkan pesan error validasi jika ada --}}
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <h6 class="alert-heading">Oops! Terjadi kesalahan:</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Nama Lengkap -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Masukkan nama lengkap Anda">
                            </div>
                        </div>

                        <!-- Alamat Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required placeholder="Masukkan alamat email Anda">
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                                <input type="password" class="form-control" id="password" name="password" required placeholder="Buat password Anda">
                            </div>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi password Anda">
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">Daftar</button>
                        </div>

                        <hr class="my-4">

                        <div class="text-center">
                            <p class="mb-0">Sudah memiliki akun? <a href="{{ route('login') }}" class="text-decoration-none">Login di sini</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
