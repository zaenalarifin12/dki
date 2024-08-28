<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    public function run()
    {
        // Seed Provinsi
        $provinsiIds = [];
        foreach (['Jawa Barat', 'Jawa Timur', 'Bali'] as $provinsi) {
            $provinsiIds[] = DB::table('provinsis')->insertGetId([
                'name' => $provinsi,
         
            ]);
        }

        // Seed Kabupaten
        $kabupatenIds = [];
        foreach ([
            ['name' => 'Bandung', 'provinsi_id' => $provinsiIds[0]],
            ['name' => 'Bogor', 'provinsi_id' => $provinsiIds[0]],
            ['name' => 'Surabaya', 'provinsi_id' => $provinsiIds[1]],
            ['name' => 'Malang', 'provinsi_id' => $provinsiIds[1]],
            ['name' => 'Denpasar', 'provinsi_id' => $provinsiIds[2]]
        ] as $kabupaten) {
            $kabupatenIds[] = DB::table('kabupatens')->insertGetId([
                'name' => $kabupaten['name'],
                'provinsi_id' => $kabupaten['provinsi_id'],
            
            ]);
        }

        // Seed Kecamatan
        $kecamatanIds = [];
        foreach ([
            ['name' => 'Cimenyan', 'kabupaten_id' => $kabupatenIds[0]],
            ['name' => 'Cileunyi', 'kabupaten_id' => $kabupatenIds[0]],
            ['name' => 'Bogor Barat', 'kabupaten_id' => $kabupatenIds[1]],
            ['name' => 'Bogor Selatan', 'kabupaten_id' => $kabupatenIds[1]],
            ['name' => 'Bubutan', 'kabupaten_id' => $kabupatenIds[2]],
            ['name' => 'Gubeng', 'kabupaten_id' => $kabupatenIds[2]],
            ['name' => 'Blimbing', 'kabupaten_id' => $kabupatenIds[3]],
            ['name' => 'Klojen', 'kabupaten_id' => $kabupatenIds[3]],
            ['name' => 'Denpasar Selatan', 'kabupaten_id' => $kabupatenIds[4]],
            ['name' => 'Denpasar Barat', 'kabupaten_id' => $kabupatenIds[4]],
        ] as $kecamatan) {
            $kecamatanIds[] = DB::table('kecamatans')->insertGetId([
                'name' => $kecamatan['name'],
                'kabupaten_id' => $kecamatan['kabupaten_id'],
                
            ]);
        }

        // Seed Desa
        foreach ([
            ['name' => 'Desa Cimenyan', 'kecamatan_id' => $kecamatanIds[0]],
            ['name' => 'Desa Kertajaya', 'kecamatan_id' => $kecamatanIds[0]],
            ['name' => 'Desa Cileunyi', 'kecamatan_id' => $kecamatanIds[1]],
            ['name' => 'Desa Cileunyi Kulon', 'kecamatan_id' => $kecamatanIds[1]],
            ['name' => 'Desa Kedunghalang', 'kecamatan_id' => $kecamatanIds[2]],
            ['name' => 'Desa Semplak', 'kecamatan_id' => $kecamatanIds[2]],
            ['name' => 'Desa Babakan', 'kecamatan_id' => $kecamatanIds[3]],
            ['name' => 'Desa Kopo', 'kecamatan_id' => $kecamatanIds[3]],
            ['name' => 'Desa Bubutan', 'kecamatan_id' => $kecamatanIds[4]],
            ['name' => 'Desa Gubeng', 'kecamatan_id' => $kecamatanIds[4]],
            ['name' => 'Desa Gubeng', 'kecamatan_id' => $kecamatanIds[5]],
            ['name' => 'Desa Penjaringan Sari', 'kecamatan_id' => $kecamatanIds[5]],
            ['name' => 'Desa Blimbing', 'kecamatan_id' => $kecamatanIds[6]],
            ['name' => 'Desa Dinoyo', 'kecamatan_id' => $kecamatanIds[6]],
            ['name' => 'Desa Klojen', 'kecamatan_id' => $kecamatanIds[7]],
            ['name' => 'Desa Janti', 'kecamatan_id' => $kecamatanIds[7]],
            ['name' => 'Desa Sanur', 'kecamatan_id' => $kecamatanIds[8]],
            ['name' => 'Desa Sidakarya', 'kecamatan_id' => $kecamatanIds[8]],
            ['name' => 'Desa Kuta', 'kecamatan_id' => $kecamatanIds[9]],
            ['name' => 'Desa Kerobokan', 'kecamatan_id' => $kecamatanIds[9]],
        ]
         as $desa) {
            DB::table('desas')->insert([
                'name' => $desa['name'],
                'kecamatan_id' => $desa['kecamatan_id'],
             
            ]);
        }        
    }
}
