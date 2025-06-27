@extends('layouts.template') {{-- Pastikan ini adalah nama layout utama Anda --}}

@section('title', Auth::user()->role === 'admin' ? 'Manajemen Booking' : 'Riwayat Booking Saya')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        {{-- Judul halaman berubah sesuai role pengguna --}}
        <h4 class="mb-0">
            @if(Auth::user()->role === 'admin')
                <i class="bi bi-journal-text me-2"></i>Manajemen Booking
            @else
                <i class="bi bi-card-list me-2"></i>Riwayat Booking Saya
            @endif
        </h4>
        {{-- Tombol untuk membuat booking baru hanya muncul untuk pasien --}}
        @if(Auth::user()->role === 'pasien')
            <a href="{{ route('bookings.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle-fill"></i> Buat Booking Baru
            </a>
        @endif
    </div>
    <div class="card-body">
        {{-- Menampilkan pesan sukses setelah aksi (membuat/update booking) --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-light text-center">
                    <tr>
                        <th>#</th>
                        @if(Auth::user()->role === 'admin')
                            <th>Nama Pasien</th>
                        @endif
                        <th>Dokter</th>
                        <th>Tgl Konsultasi</th>
                        <th>Jadwal</th>
                        <th>Status</th>
                        @if(Auth::user()->role === 'admin')
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $key => $booking)
                        <tr>
                            <td class="text-center">{{ $bookings->firstItem() + $key }}</td>
                            
                            {{-- Kolom nama pasien hanya untuk admin --}}
                            @if(Auth::user()->role === 'admin')
                                <td>{{ $booking->user->name }}</td>
                            @endif

                            <td>
                                <strong>{{ $booking->jadwal->dokter->nama_dokter }}</strong><br>
                                <small class="text-muted">{{ $booking->jadwal->dokter->spesialis }}</small>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($booking->tanggal_konsultasi)->isoFormat('dddd, D MMMM Y') }}</td>
                            <td>
                                {{ $booking->jadwal->hari }}, {{ \Carbon\Carbon::parse($booking->jadwal->jam_mulai)->format('H:i') }}
                            </td>
                            <td class="text-center">
                                {{-- Badge status dengan warna berbeda --}}
                                <span class="badge 
                                    @if($booking->status == 'Menunggu') bg-warning text-dark 
                                    @elseif($booking->status == 'Disetujui') bg-success 
                                    @else bg-danger 
                                    @endif">
                                    {{ $booking->status }}
                                </span>
                            </td>

                            {{-- Kolom aksi hanya untuk admin --}}
                            @if(Auth::user()->role === 'admin')
                                <td class="text-center">
                                    {{-- Anda bisa menambahkan logika untuk mengubah status di sini --}}
                                    {{-- Contoh: Tombol modal atau form terpisah --}}
                                    <button class="btn btn-sm btn-primary">Detail</button>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            {{-- Pesan jika tidak ada data booking --}}
                            <td colspan="{{ Auth::user()->role === 'admin' ? '7' : '5' }}" class="text-center text-muted py-4">
                                Tidak ada data booking ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Link Paginasi --}}
        <div class="d-flex justify-content-center mt-3">
            {!! $bookings->links() !!}
        </div>
    </div>
</div>
@endsection
