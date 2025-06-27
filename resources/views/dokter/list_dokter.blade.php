@extends('layouts.template')

@section('title', 'List Dokter')
@section('navDokter', 'active')

@section('content')
    <h1>List Dokter</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Dokter</th>
                <th scope="col">Spesialis</th>
                <th scope="col">No HP</th>
                <th scope="col">Foto</th>
                <th scope="col" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dokters as $index => $dokter)
                <tr>
                    <th scope="row">{{ $index + 1 }}</th>
                    <td>{{ $dokter->nama_dokter }}</td>
                    <td>{{ $dokter->spesialis }}</td>
                    <td>{{ $dokter->no_hp }}</td>
                    <td>
                        @if ($dokter->foto)
                            <img src="{{ asset('storage/' . $dokter->foto) }}" alt="{{ $dokter->nama_dokter }}" width="60">
                        @else
                            <span class="text-muted">Tidak ada foto</span>
                        @endif
                    </td>
                   <td class="text-center">
    <a href="{{ route('dokter.show', $dokter->id) }}" class="btn btn-success btn-sm">Detail</a>

    {{-- Edit diarahkan ke show karena form edit ditampilkan di show --}}
    <a href="{{ route('dokter.show', $dokter->id) }}" class="btn btn-warning btn-sm">Edit</a>

    {{-- Form hapus --}}
    <form action="{{ route('dokter.destroy', $dokter->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus dokter ini?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
    </form>
</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
