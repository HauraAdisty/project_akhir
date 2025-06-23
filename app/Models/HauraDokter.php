<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HauraDokter extends Model
{
    protected $table = 'haura_dokters';

    protected $fillable = [
        'nama_dokter', 'spesialis', 'no_hp', 'foto'
    ];

    // Relasi: satu dokter punya banyak jadwal
    public function jadwals()
    {
        return $this->hasMany(HauraJadwal::class, 'dokter_id');
    }
}