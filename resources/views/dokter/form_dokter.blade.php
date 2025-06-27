@extends('layouts.template')

@section('title', 'Form Input Dokter')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg rounded-4">
            <div class="card-header bg-success text-white rounded-top-4 d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Tambah Dokter Baru</h4>
                <a href="{{ route('dokter.list_dokter') }}" class="btn btn-light btn-sm text-success fw-bold">
                    <i class="bi bi-arrow-left-circle me-1"></i> Data Dokter
                </a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger m-3">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card-body p-4">
                <form action="{{ route('dokter.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Nama Dokter --}}
                    <div class="mb-3 row">
                        <label for="nama_dokter" class="col-sm-2 col-form-label">Nama Dokter</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_dokter" name="nama_dokter" required>
                        </div>
                    </div>

                    {{-- Spesialis --}}
                    <div class="mb-3 row">
                        <label for="spesialis" class="col-sm-2 col-form-label">Spesialis</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="spesialis" name="spesialis" required>
                        </div>
                    </div>

                    {{-- No HP --}}
                    <div class="mb-3 row">
                        <label for="no_hp" class="col-sm-2 col-form-label">No HP</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                        </div>
                    </div>

                    {{-- Foto --}}
                    <div class="mb-3 row">
                        <label for="foto" class="col-sm-2 col-form-label">Foto</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="mb-3 row">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
