@extends('layouts.template')

@section('title', 'Form Edit Dokter')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg rounded-4">
            <div class="card-header bg-success text-white rounded-top-4 d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Form Edit Dokter</h4>
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
                {{-- Form Update Dokter --}}
                <form action="{{ route('dokter.update', $dokter->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Nama Dokter --}}
                    <div class="mb-3 row">
                        <label for="nama_dokter" class="col-sm-2 col-form-label">Nama Dokter</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_dokter" name="nama_dokter"
                                value="{{ old('nama_dokter', $dokter->nama_dokter) }}" required>
                        </div>
                    </div>

                    {{-- Spesialis --}}
                    <div class="mb-3 row">
                        <label for="spesialis" class="col-sm-2 col-form-label">Spesialis</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="spesialis" name="spesialis"
                                value="{{ old('spesialis', $dokter->spesialis) }}" required>
                        </div>
                    </div>

                    {{-- No HP --}}
                    <div class="mb-3 row">
                        <label for="no_hp" class="col-sm-2 col-form-label">No HP</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="no_hp" name="no_hp"
                                value="{{ old('no_hp', $dokter->no_hp) }}" required>
                        </div>
                    </div>

                    {{-- Foto --}}
                    <div class="mb-3 row">
                        <label for="foto" class="col-sm-2 col-form-label">Foto</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                            @if ($dokter->foto)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $dokter->foto) }}" alt="{{ $dokter->nama_dokter }}" width="150">
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Tombol Update --}}
                    <div class="mb-3 row">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-primary">Update Dokter</button>
                        </div>
                    </div>
                </form>

                {{-- Tombol Hapus --}}
                {{-- <form action="{{ route('dokter.destroy', $dokter->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus dokter ini?')" class="mt-2 text-end"> --}}
                    {{-- @csrf --}}
                    {{-- @method('DELETE') --}}
                   {{-- <button type="submit" class="btn btn-danger">Hapus Dokter</button> --}}
                {{-- </form> --}}

            </div>
        </div>
    </div>
@endsection
