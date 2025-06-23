<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class HauraDoktersTableSeeder extends Seeder
{
    public function run()
    {
        $dokters = [
            ['nama' => 'dr. Siti Aisyah',  'spesialis' => 'Dokter Umum',    'no_hp' => '081234567890', 'foto' => 'siti.jpg'],
            ['nama' => 'dr. Riko Saputra', 'spesialis' => 'Dokter Gigi',     'no_hp' => '082345678901', 'foto' => 'riko.jpg'],
            ['nama' => 'dr. Lestari Dewi', 'spesialis' => 'Spesialis Anak',  'no_hp' => '083456789012', 'foto' => 'lestari.jpg'],
        ];

        // Buat folder public/storage/image jika belum ada
        $destinationFolder = public_path('storage/image');
        if (!File::exists($destinationFolder)) {
            File::makeDirectory($destinationFolder, 0755, true);
        }

        foreach ($dokters as $d) {
            $sourcePath = database_path('seeders/sample_images/' . $d['foto']);
            $destinationPath = $destinationFolder . '/' . $d['foto'];

            // Cek apakah file gambar tersedia
            if (File::exists($sourcePath)) {
                File::copy($sourcePath, $destinationPath);
                $fotoPath = 'image/' . $d['foto'];
            } else {
                // Jika tidak ada, pakai gambar default atau kosong
                $fotoPath = 'image/default.jpg'; // pastikan file ini ada, atau ganti null jika tidak
            }

            DB::table('haura_dokters')->insert([
                'nama_dokter' => $d['nama'],
                'spesialis' => $d['spesialis'],
                'no_hp' => $d['no_hp'],
                'foto' => $fotoPath,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}