<?php

namespace App\Http\Controllers;

use App\Models\HauraJadwal;
use App\Models\HauraBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HauraBookingController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $bookings = null;

        if ($user->role === 'admin') {
            // Jika role adalah admin, ambil semua data booking beserta relasi user dan jadwalnya.
            $bookings = HauraBooking::with(['user', 'jadwal.dokter'])->latest()->paginate(10);
        } else {
            // Jika role adalah pasien, hanya ambil data booking milik user yang sedang login.
            $bookings = HauraBooking::where('user_id', $user->id)
                                ->with('jadwal.dokter')
                                ->latest()
                                ->paginate(10);
        }

        // Kirim data bookings ke view 'bookings.index'
        return view('booking.index_booking', compact('bookings'));
    }

        public function updateStatus(Request $request, HauraBooking $booking)
    {
        // Otorisasi: Pastikan hanya admin yang bisa mengakses
        if (Auth::user()->role !== 'admin') {
            abort(403, 'AKSES DITOLAK');
        }

        // Validasi: Pastikan status yang dikirim valid
        $request->validate([
            'status' => 'required|in:Menunggu,Disetujui,Ditolak',
        ]);

        // Update status pada record booking yang dipilih
        $booking->update(['status' => $request->status]);

        // Kembali ke halaman daftar booking dengan pesan sukses
        return redirect()->route('bookings.index')->with('success', 'Status booking berhasil diperbarui.');
    }

     public function create(Request $request)
    {
        $jadwal_id = $request->query('jadwal_id');
        $selectedJadwal = null;
        $allJadwals = null;

        if ($jadwal_id) {
            // Jika ada jadwal_id, ambil data jadwal spesifik tersebut beserta relasi dokternya.
            $selectedJadwal = HauraJadwal::with('dokter')->findOrFail($jadwal_id);
        } else {
            // Jika tidak ada, siapkan semua jadwal untuk dropdown (sebagai fallback)
            $allJadwals = HauraJadwal::with('dokter')->get();
        }

        return view('booking.create_booking', [
            'selectedJadwal' => $selectedJadwal,
            'allJadwals' => $allJadwals,
        ]);
    }

    /**
     * Menyimpan data booking baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'jadwal_id' => 'required|exists:haura_jadwals,id',
            'tanggal_konsultasi' => 'required|date|after_or_equal:today',
            'keluhan' => 'required|string|min:10',
        ], [
            'tanggal_konsultasi.after_or_equal' => 'Tanggal konsultasi tidak boleh tanggal yang sudah lewat.',
            'keluhan.required' => 'Mohon isikan keluhan yang Anda rasakan.',
        ]);

        // Buat record booking baru
        HauraBooking::create([
            'user_id' => Auth::id(), // Mengambil ID user yang sedang login
            'jadwal_id' => $request->jadwal_id,
            'tanggal_konsultasi' => $request->tanggal_konsultasi,
            'keluhan' => $request->keluhan,
            'status' => 'Menunggu', // Status default saat booking dibuat
        ]);
        
        // Arahkan ke halaman riwayat booking dengan pesan sukses
        // Anda perlu membuat route dan view untuk 'bookings.index' nanti
        return redirect()->route('dashboard')->with('success', 'Booking Anda telah berhasil dibuat dan menunggu persetujuan.');
    }
}
