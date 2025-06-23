<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HauraJadwal extends Model
{
    protected $table = 'haura_jadwals';

    protected $fillable = [
        'dokter_id', 'hari', 'jam_mulai', 'jam_selesai', 'lokasi'
    ];

    // Relasi ke dokter
    public function dokter()
    {
        return $this->belongsTo(HauraDokter::class, 'dokter_id');
    }

    // Relasi ke bookings
    public function bookings()
    {
        return $this->hasMany(HauraBooking::class, 'jadwal_id');
    }
}