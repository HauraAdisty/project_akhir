@extends('layouts.template') {{-- Ganti dengan layouts.template jika nama layout Anda itu --}}

@section('title', 'Jadwal Dokter ' . $dokter->nama_dokter)

@section('content')
<div class="container">
    {{-- Detail Dokter --}}
    <div class="card mb-4 shadow-sm">
        <div class="row g-0">
            <div class="col-md-3">
                <img src="{{ asset('storage/' . $dokter->foto) }}" class="img-fluid rounded-start" alt="{{ $dokter->nama_dokter }}" style="height: 100%; object-fit: cover;">
            </div>
            <div class="col-md-9">
                <div class="card-body">
                    <h2 class="card-title">{{ $dokter->nama_dokter }}</h2>
                    <p class="card-text fs-5 text-muted">{{ $dokter->spesialis }}</p>
                    <p class="card-text"><small class="text-muted">Kontak: {{ $dokter->no_hp }}</small></p>
                </div>
            </div>
        </div>
    </div>

    {{-- Daftar Jadwal --}}
    <h3 class="mb-3">Jadwal Praktek Tersedia</h3>
    <div class="list-group">
        @forelse ($jadwals as $jadwal)
            <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">{{ $jadwal->hari }}</h5>
                    <p class="mb-1">
                        <i class="bi bi-clock-fill"></i> 
                        {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }} WIB
                    </p>
                    <p class="mb-0 text-muted">
                        <i class="bi bi-geo-alt-fill"></i> {{ $jadwal->lokasi }}
                    </p>
                </div>
                {{-- Tombol ini akan mengarah ke form booking dengan membawa ID jadwal --}}
                <a href="{{ route('bookings.create', ['jadwal_id' => $jadwal->id]) }}" class="btn btn-primary">
                    <i class="bi bi-calendar-plus-fill"></i> Booking Jadwal Ini
                </a>
            </div>
        @empty
            <div class="alert alert-secondary text-center" role="alert">
                Dokter ini belum memiliki jadwal praktek yang tersedia.
            </div>
        @endforelse
    </div>
    
    <div class="mt-4">
        <a href="{{ url('/') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali ke Daftar Dokter</a>
    </div>
</div>
@endsection
