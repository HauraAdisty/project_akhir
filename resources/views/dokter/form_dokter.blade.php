@extends('layouts.template') {{-- Ganti dengan layouts.template jika nama layout Anda itu --}}

@section('title', 'Form Input Dokter dan Jadwal')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg rounded-4">
        <div class="card-header bg-success text-white rounded-top-4 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Tambah Dokter Baru Beserta Jadwalnya</h4>
            <a href="{{ route('dokter.list_dokter') }}" class="btn btn-light btn-sm text-success fw-bold">
                <i class="bi bi-arrow-left-circle me-1"></i> Data Dokter
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger m-3">
                <strong>Whoops! Ada beberapa masalah:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('dokter.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body p-4">
                {{-- Data Dokter Utama --}}
                <h5 class="mb-3">Informasi Dokter</h5>
                <div class="mb-3 row">
                    <label for="nama_dokter" class="col-sm-3 col-form-label">Nama Dokter</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="nama_dokter" name="nama_dokter" value="{{ old('nama_dokter') }}" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="spesialis" class="col-sm-3 col-form-label">Spesialis</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="spesialis" name="spesialis" value="{{ old('spesialis') }}" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="no_hp" class="col-sm-3 col-form-label">No HP</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="foto" class="col-sm-3 col-form-label">Foto</label>
                    <div class="col-sm-9">
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
                    </div>
                </div>

                <hr class="my-4">

                {{-- Bagian Jadwal Dinamis --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Jadwal Praktek</h5>
                    <button type="button" class="btn btn-sm btn-primary" id="tambah-jadwal">
                        <i class="bi bi-plus-circle"></i> Tambah Jadwal
                    </button>
                </div>

                <div id="jadwal-container">
                    {{-- Baris jadwal akan ditambahkan oleh JavaScript di sini --}}
                </div>
            </div>

            <div class="card-footer bg-light text-end">
                <button type="submit" class="btn btn-primary">Simpan Dokter dan Jadwal</button>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPT untuk menangani form dinamis --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('jadwal-container');
    const addButton = document.getElementById('tambah-jadwal');
    let jadwalIndex = 0;

    function createJadwalRow() {
        const index = jadwalIndex++;
        const row = document.createElement('div');
        row.classList.add('row', 'g-3', 'align-items-center', 'mb-3', 'border', 'p-3', 'rounded');
        row.innerHTML = `
            <div class="col-md-3">
                <label for="jadwals_${index}_hari" class="form-label">Hari</label>
                <select name="jadwals[${index}][hari]" id="jadwals_${index}_hari" class="form-select" required>
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                    <option value="Sabtu">Sabtu</option>
                    <option value="Minggu">Minggu</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="jadwals_${index}_jam_mulai" class="form-label">Jam Mulai</label>
                <input type="time" name="jadwals[${index}][jam_mulai]" id="jadwals_${index}_jam_mulai" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label for="jadwals_${index}_jam_selesai" class="form-label">Jam Selesai</label>
                <input type="time" name="jadwals[${index}][jam_selesai]" id="jadwals_${index}_jam_selesai" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label for="jadwals_${index}_lokasi" class="form-label">Lokasi</label>
                <input type="text" name="jadwals[${index}][lokasi]" id="jadwals_${index}_lokasi" class="form-control" required>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm w-100 remove-jadwal">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(row);
    }

    addButton.addEventListener('click', createJadwalRow);

    container.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-jadwal') || e.target.closest('.remove-jadwal')) {
            e.target.closest('.row').remove();
        }
    });

    // Otomatis tambahkan satu baris jadwal saat halaman dimuat
    createJadwalRow();
});
</script>
@endsection
