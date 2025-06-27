<?php

namespace App\Models;

use App\Models\HauraUser;
use Illuminate\Database\Eloquent\Model;

class HauraBooking extends Model
{
    protected $table = 'haura_bookings';

    protected $fillable = [
        'user_id', 'jadwal_id', 'tanggal_konsultasi', 'keluhan', 'status'
    ];

    // Relasi ke user (pasien)
    public function user()
    {
        return $this->belongsTo(HauraUser::class, 'user_id');
    }

    // Relasi ke jadwal
    public function jadwal()
    {
        return $this->belongsTo(HauraJadwal::class, 'jadwal_id');
    }
}