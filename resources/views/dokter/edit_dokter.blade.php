@extends('layouts.template') {{-- Ganti dengan layouts.template jika nama layout Anda itu --}}

@section('title', 'Form Edit Dokter dan Jadwal')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg rounded-4">
        <div class="card-header bg-success text-white rounded-top-4 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Edit Data Dokter: {{ $dokter->nama_dokter }}</h4>
            <a href="{{ route('dokter.list_dokter') }}" class="btn btn-light btn-sm text-success fw-bold">
                <i class="bi bi-arrow-left-circle me-1"></i> Kembali ke Data Dokter
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

        {{-- Form ini akan mengirim ke method 'update' di controller --}}
        <form action="{{ route('dokter.update', $dokter->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Method spoofing untuk request UPDATE --}}
            
            <div class="card-body p-4">
                {{-- Data Dokter Utama --}}
                <h5 class="mb-3">Informasi Dokter</h5>
                <div class="mb-3 row">
                    <label for="nama_dokter" class="col-sm-3 col-form-label">Nama Dokter</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="nama_dokter" name="nama_dokter" value="{{ old('nama_dokter', $dokter->nama_dokter) }}" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="spesialis" class="col-sm-3 col-form-label">Spesialis</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="spesialis" name="spesialis" value="{{ old('spesialis', $dokter->spesialis) }}" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="no_hp" class="col-sm-3 col-form-label">No HP</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp', $dokter->no_hp) }}" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="foto" class="col-sm-3 col-form-label">Ganti Foto</label>
                    <div class="col-sm-9">
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                        @if($dokter->foto)
                        <div class="mt-2">
                            <small>Foto saat ini:</small><br>
                            <img src="{{ asset('storage/' . $dokter->foto) }}" alt="Foto {{ $dokter->nama_dokter }}" class="img-thumbnail" width="150">
                        </div>
                        @endif
                    </div>
                </div>

                <hr class="my-4">

                {{-- Bagian Jadwal Dinamis --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Jadwal Praktek</h5>
                    <button type="button" class="btn btn-sm btn-primary" id="tambah-jadwal">
                        <i class="bi bi-plus-circle"></i> Tambah Jadwal Baru
                    </button>
                </div>

                <div id="jadwal-container">
                    {{-- JADWAL YANG SUDAH ADA --}}
                    @foreach($dokter->jadwals as $jadwal)
                    <div class="row g-3 align-items-center mb-3 border p-3 rounded existing-jadwal" data-id="{{ $jadwal->id }}">
                        {{-- Hidden input untuk ID jadwal yang sudah ada --}}
                        <input type="hidden" name="jadwals[{{ $jadwal->id }}][id]" value="{{ $jadwal->id }}">
                        
                        <div class="col-md-3">
                            <label class="form-label">Hari</label>
                            <select name="jadwals[{{ $jadwal->id }}][hari]" class="form-select" required>
                                <option value="Senin" @if($jadwal->hari == 'Senin') selected @endif>Senin</option>
                                <option value="Selasa" @if($jadwal->hari == 'Selasa') selected @endif>Selasa</option>
                                <option value="Rabu" @if($jadwal->hari == 'Rabu') selected @endif>Rabu</option>
                                <option value="Kamis" @if($jadwal->hari == 'Kamis') selected @endif>Kamis</option>
                                <option value="Jumat" @if($jadwal->hari == 'Jumat') selected @endif>Jumat</option>
                                <option value="Sabtu" @if($jadwal->hari == 'Sabtu') selected @endif>Sabtu</option>
                                <option value="Minggu" @if($jadwal->hari == 'Minggu') selected @endif>Minggu</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Jam Mulai</label>
                            <input type="time" name="jadwals[{{ $jadwal->id }}][jam_mulai]" class="form-control" value="{{ $jadwal->jam_mulai }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Jam Selesai</label>
                            <input type="time" name="jadwals[{{ $jadwal->id }}][jam_selesai]" class="form-control" value="{{ $jadwal->jam_selesai }}" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="jadwals[{{ $jadwal->id }}][lokasi]" class="form-control" value="{{ $jadwal->lokasi }}" required>
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-sm w-100 remove-jadwal">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                    {{-- Baris jadwal baru akan ditambahkan oleh JavaScript di sini --}}
                </div>
                
                {{-- Container untuk menyimpan ID jadwal yang akan dihapus --}}
                <div id="deleted-jadwals-container"></div>
            </div>

            <div class="card-footer bg-light text-end">
                <button type="submit" class="btn btn-primary">Update Dokter dan Jadwal</button>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPT untuk menangani form dinamis --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('jadwal-container');
    const addButton = document.getElementById('tambah-jadwal');
    const deletedContainer = document.getElementById('deleted-jadwals-container');
    let newJadwalIndex = 0;

    function createNewJadwalRow() {
        const index = newJadwalIndex++;
        const row = document.createElement('div');
        row.classList.add('row', 'g-3', 'align-items-center', 'mb-3', 'border', 'p-3', 'rounded', 'new-jadwal');
        row.innerHTML = `
            <div class="col-md-3">
                <label class="form-label">Hari</label>
                <select name="new_jadwals[${index}][hari]" class="form-select" required>
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
                <label class="form-label">Jam Mulai</label>
                <input type="time" name="new_jadwals[${index}][jam_mulai]" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Jam Selesai</label>
                <input type="time" name="new_jadwals[${index}][jam_selesai]" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Lokasi</label>
                <input type="text" name="new_jadwals[${index}][lokasi]" class="form-control" placeholder="Lokasi Praktek" required>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm w-100 remove-jadwal">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(row);
    }

    addButton.addEventListener('click', createNewJadwalRow);

    container.addEventListener('click', function (e) {
        const removeButton = e.target.closest('.remove-jadwal');
        if (removeButton) {
            const rowToRemove = removeButton.closest('.row');
            
            // Cek apakah ini jadwal yang sudah ada atau yang baru ditambahkan
            if (rowToRemove.classList.contains('existing-jadwal')) {
                const jadwalId = rowToRemove.dataset.id;
                
                // Buat input hidden untuk menandai jadwal ini untuk dihapus
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'deleted_jadwals[]';
                hiddenInput.value = jadwalId;
                deletedContainer.appendChild(hiddenInput);
            }
            
            // Hapus baris dari tampilan
            rowToRemove.remove();
        }
    });
});
</script>
@endsection
