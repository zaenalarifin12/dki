<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    // LocationController.php
public function getKabupaten($provinsiId)
{
    $kabupaten = Kabupaten::where('provinsi_id', $provinsiId)->get();
    return response()->json($kabupaten);
}

public function getKecamatan($kabupatenId)
{
    $kecamatan = Kecamatan::where('kabupaten_id', $kabupatenId)->get();
    return response()->json($kecamatan);
}

public function getDesa($kecamatanId)
{
    $desa = Desa::where('kecamatan_id', $kecamatanId)->get();
    return response()->json($desa);
}

}
