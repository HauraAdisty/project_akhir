@extends('layouts.template')

@section('title', Auth::user()->role === 'admin' ? 'Manajemen Booking' : 'Riwayat Booking Saya')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">

            <h4 class="mb-0">
                @if (Auth::user()->role === 'admin')
                    <i class="bi bi-journal-text me-2"></i>Manajemen Booking
                @else
                    <i class="bi bi-card-list me-2"></i>Riwayat Booking Saya
                @endif
            </h4>

            @if (Auth::user()->role === 'pasien')
                <a href="{{ route('bookings.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle-fill"></i> Buat Booking Baru
                </a>
            @endif
        </div>
        <div class="card-body">
            @if (session('success'))
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
                            @if (Auth::user()->role === 'admin')
                                <th>Nama Pasien</th>
                            @endif
                            <th>Dokter</th>
                            <th>Tgl Konsultasi</th>
                            <th>Jadwal</th>
                            <th>Status</th>
                            @if (Auth::user()->role === 'admin')
                                <th style="min-width: 170px;">Aksi Perubahan Status</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookings as $key => $booking)
                            <tr>
                                <td class="text-center">{{ $bookings->firstItem() + $key }}</td>

                                @if (Auth::user()->role === 'admin')
                                    <td>{{ $booking->user->name }}</td>
                                @endif

                                <td>
                                    <strong>{{ $booking->jadwal->dokter->nama_dokter }}</strong><br>
                                    <small class="text-muted">{{ $booking->jadwal->dokter->spesialis }}</small>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($booking->tanggal_konsultasi)->isoFormat('dddd, D MMMM Y') }}
                                </td>
                                <td>
                                    {{ $booking->jadwal->hari }},
                                    {{ \Carbon\Carbon::parse($booking->jadwal->jam_mulai)->format('H:i') }}
                                </td>
                                <td class="text-center">
                                    <span
                                        class="badge @if ($booking->status == 'Menunggu') bg-warning text-dark @elseif($booking->status == 'Disetujui') bg-success @else bg-danger @endif">
                                        {{ $booking->status }}
                                    </span>
                                </td>

                                {{-- ================================================================ --}}
                                {{-- LOGIKA BARU UNTUK ADMIN MENGUBAH STATUS --}}
                                {{-- ================================================================ --}}
                                @if (Auth::user()->role === 'admin')
                                    <td class="text-center">
                                        <form action="{{ route('bookings.updateStatus', $booking->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="input-group">
                                                <select name="status" class="form-select form-select-sm"
                                                    onchange="this.form.submit()">
                                                    <option value="Menunggu"
                                                        @if ($booking->status == 'Menunggu') selected @endif>Menunggu</option>
                                                    <option value="Disetujui"
                                                        @if ($booking->status == 'Disetujui') selected @endif>Setujui</option>
                                                    <option value="Ditolak"
                                                        @if ($booking->status == 'Ditolak') selected @endif>Tolak</option>
                                                </select>
                                                <button type="submit" class="btn btn-sm btn-outline-secondary">Go</button>
                                            </div>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ Auth::user()->role === 'admin' ? '7' : '5' }}"
                                    class="text-center text-muted py-4">
                                    Tidak ada data booking ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


            <div class="d-flex justify-content-center mt-3">
                {!! $bookings->links() !!}
            </div>
        </div>
    </div>
@endsection
