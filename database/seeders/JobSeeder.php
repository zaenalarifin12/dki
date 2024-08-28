<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ([
            ['name' => 'Pegawai Negeri Sipil (PNS)'],
            ['name' => 'Karyawan Swasta'],
            ['name' => 'Pengusaha'],
            ['name' => 'Profesional'],
            ['name' => 'Petani'],
            ['name' => 'Pekerja Lepas'],
            ['name' => 'Guru'],
         ]
         as $job) {
            DB::table('jobs')->insert([
                'name' => $job['name']
            ]);
        }
    }
}
