@extends('layouts.template') {{-- Pastikan nama layout Anda sudah benar --}}

@section('title', 'Formulir Booking Konsultasi')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="bi bi-calendar-plus-fill me-2"></i>Formulir Booking Konsultasi</h4>
                </div>

                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf

                        {{-- Bagian ini menampilkan detail jadwal jika sudah dipilih --}}
                        @if ($selectedJadwal)
                            <div class="alert alert-info">
                                <h5 class="alert-heading">Detail Jadwal Pilihan Anda:</h5>
                                <p class="mb-1"><strong>Dokter:</strong> {{ $selectedJadwal->dokter->nama_dokter }} ({{ $selectedJadwal->dokter->spesialis }})</p>
                                <p class="mb-1"><strong>Jadwal:</strong> {{ $selectedJadwal->hari }}, Pukul {{ \Carbon\Carbon::parse($selectedJadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($selectedJadwal->jam_selesai)->format('H:i') }}</p>
                                <p class="mb-0"><strong>Lokasi:</strong> {{ $selectedJadwal->lokasi }}</p>
                            </div>
                            <input type="hidden" name="jadwal_id" value="{{ $selectedJadwal->id }}">
                        
                        {{-- Bagian ini menampilkan dropdown jika jadwal belum dipilih --}}
                        @else
                            <div class="mb-3">
                                <label for="jadwal_id" class="form-label">Pilih Dokter dan Jadwal</label>
                                <select name="jadwal_id" id="jadwal_id" class="form-select" required>
                                    <option value="" disabled selected>-- Silakan Pilih Jadwal --</option>
                                    @foreach ($allJadwals as $jadwal)
                                        <option value="{{ $jadwal->id }}">
                                            {{ $jadwal->dokter->nama_dokter }} ({{ $jadwal->dokter->spesialis }}) - {{ $jadwal->hari }}, {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <hr>

                        <div class="mb-3">
                            <label for="tanggal_konsultasi" class="form-label">Pilih Tanggal Konsultasi</label>
                            <input type="date" class="form-control @error('tanggal_konsultasi') is-invalid @enderror" id="tanggal_konsultasi" name="tanggal_konsultasi" value="{{ old('tanggal_konsultasi') }}" required>
                            @error('tanggal_konsultasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="keluhan" class="form-label">Jelaskan Keluhan Anda</label>
                            <textarea class="form-control @error('keluhan') is-invalid @enderror" id="keluhan" name="keluhan" rows="4" placeholder="Contoh: Saya merasakan demam dan pusing sejak 2 hari yang lalu..." required>{{ old('keluhan') }}</textarea>
                             @error('keluhan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Kirim Permintaan Booking</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
