@extends('layouts.template')

@section('title', 'Homepage')

@section('content')

<style>
    .dokter-img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-top-left-radius: .25rem;
        border-top-right-radius: .25rem;
    }

    .dokter-card {
        height: 100%;
    }
</style>

<h1 class="mb-4">Daftar Dokter</h1>

<div class="container">
    <div class="row">
        @forelse ($dokters as $dokter)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm dokter-card">
                    @if ($dokter->foto)
                        <img src="{{ asset('storage/' . $dokter->foto) }}" class="dokter-img" alt="{{ $dokter->nama_dokter }}">
                    @else
                        <img src="https://via.placeholder.com/400x250?text=No+Image" class="dokter-img" alt="No Image">
                    @endif
                    <div class="card-body">
                  <div class="card-body d-flex flex-column">
    <h5 class="card-title">{{ $dokter->nama_dokter }}</h5>
    <p class="card-text"><strong>Spesialis:</strong> {{ $dokter->spesialis }}</p>
    <p class="card-text mb-3"><strong>Telepon:</strong> {{ $dokter->no_hp }}</p>
    
    {{-- Tombol ditambahkan di sini --}}
    <a href="{{ route('dokter.jadwal', $dokter->id) }}" class="btn btn-success mt-auto">
        <i class="bi bi-calendar-check-fill"></i> Lihat Jadwal & Booking
    </a>
</div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Tidak ada data dokter tersedia.</p>
        @endforelse
    </div>

    <div class="d-flex justify-content-end mt-4">
        {{ $dokters->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection