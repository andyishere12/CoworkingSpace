<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KursiController extends Controller
{
    public function index()
    {
        // ambil total kursi
        $total_kursi = DB::table('settings_kursi')
            ->value('total_kursi');

        // hitung orang masih di dalam (belum checkout)
        $dipakai = DB::table('hadir')
            ->whereNull('waktu_keluar')
            ->count();

        // hitung sisa
        $tersedia = $total_kursi - $dipakai;

        return response()->json([
            'total' => (int)$total_kursi,
            'dipakai' => $dipakai,
            'tersedia' => $tersedia
        ]);
    }
}
