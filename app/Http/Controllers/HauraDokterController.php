<?php

namespace App\Http\Controllers;

use App\Models\HauraDokter;
use App\Models\HauraJadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class HauraDokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokters = HauraDokter ::latest()->paginate(6);
         return view('homepage', compact('dokters'));
    }

    public function list()
{
    $dokters = HauraDokter::all();
    return view('dokter.list_dokter', compact('dokters'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dokter.form_dokter');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) // Ganti StoreDokterRequest dengan Request untuk sementara
    {
        // 1. Validasi data dokter dan jadwal
        $validatedData = $request->validate([
            'nama_dokter' => 'required|string|max:255',
            'spesialis' => 'required|string|max:100',
            'no_hp' => 'required|string|max:20',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'jadwals' => 'required|array|min:1', // Memastikan setidaknya ada satu jadwal
            'jadwals.*.hari' => 'required|string',
            'jadwals.*.jam_mulai' => 'required',
            'jadwals.*.jam_selesai' => 'required|after:jadwals.*.jam_mulai',
            'jadwals.*.lokasi' => 'required|string|max:100',
        ]);

        // Gunakan transaction untuk memastikan semua data tersimpan atau tidak sama sekali
        DB::beginTransaction();
        try {
            // 2. Simpan informasi dokter terlebih dahulu
            $fotoPath = $request->file('foto')->store('dokters', 'public');
            
            $dokter = HauraDokter::create([
                'nama_dokter' => $validatedData['nama_dokter'],
                'spesialis' => $validatedData['spesialis'],
                'no_hp' => $validatedData['no_hp'],
                'foto' => $fotoPath,
            ]);

            // 3. Loop dan simpan setiap jadwal yang berelasi dengan dokter yang baru dibuat
            foreach ($validatedData['jadwals'] as $jadwalData) {
                $jadwal = new HauraJadwal($jadwalData);
                $dokter->jadwals()->save($jadwal);
            }

            // Jika semua berhasil, commit transaction
            DB::commit();

            return redirect()->route('home')->with('success', 'Data dokter dan jadwalnya berhasil ditambahkan.');

        } catch (\Exception $e) {
            // Jika terjadi error, batalkan semua yang sudah tersimpan
            DB::rollBack();
            // Redirect kembali dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
 public function show(string $id)
{
    $dokter = HauraDokter::findOrFail($id);
    return view('dokter.edit_dokter', compact('dokter'));
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
public function update(Request $request, $id)
{
    // Validasi input

    $request->validate([
        'nama_dokter' => 'required|string|max:255',
        'spesialis' => 'required|string|max:255',
        'no_hp' => 'required|string|max:20',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Ambil data dokter berdasarkan ID
    $dokter = HauraDokter::findOrFail($id);

    // Isi field
    $dokter->nama_dokter = $request->nama_dokter;
    $dokter->spesialis = $request->spesialis;
    $dokter->no_hp = $request->no_hp;

    // Jika ada file foto baru yang diupload
    if ($request->hasFile('foto')) {
        // Hapus file lama jika ada
        if ($dokter->foto && Storage::exists('public/' . $dokter->foto)) {
            Storage::delete('public/' . $dokter->foto);
        }

        // Simpan foto baru
        $path = $request->file('foto')->store('dokter', 'public');
        $dokter->foto = $path;
    }

    // Simpan perubahan
    $dokter->save();

    // Redirect kembali dengan pesan sukses
    return redirect()->route('dokter.list_dokter')->with('success', 'Data dokter berhasil diperbarui!');

}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    $dokter = HauraDokter::findOrFail($id);

    // Hapus foto jika ada
    if ($dokter->foto && Storage::exists('public/' . $dokter->foto)) {
        Storage::delete('public/' . $dokter->foto);
    }

    $dokter->delete();

    return redirect()->route('dokter.list_dokter')->with('success', 'Data dokter berhasil dihapus.');
}

    }

