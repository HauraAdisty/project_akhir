<?php

namespace App\Http\Controllers;

use App\Models\HauraDokter;
use Illuminate\Http\Request;

class HauraJadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

      public function showByDokter(HauraDokter $dokter)
    {
        // Mengambil semua jadwal yang berelasi dengan dokter ini
        // pastikan di model Dokter ada relasi public function jadwals()
        $jadwals = $dokter->jadwals()->orderBy('hari')->get();

        // Mengirim data dokter dan jadwalnya ke view baru
        return view('jadwal.show_jadwal', compact('dokter', 'jadwals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
