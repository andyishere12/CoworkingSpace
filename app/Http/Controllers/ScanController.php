<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ScanController extends Controller
{
    public function index()
    {
        return view('scan.scanner');
    }

    public function store(Request $request)
    {
        $today = Carbon::today();

        // AMBIL MEMBER + FOTO
        $member = DB::table('data_members')
            ->where('nama', $request->nama)
            ->first();

        if (!$member) {
            return response()->json([
                'status' => 'error',
                'message' => 'Member tidak ditemukan'
            ], 404);
        }

        $foto = $member->foto
            ? asset('uploads/foto/' . $member->foto)
            : asset('uploads/foto/default.png');

        // CEK HADIR
        $hadir = DB::table('hadir')
            ->where('nama', $request->nama)
            ->whereDate('tanggal', $today)
            ->whereNull('waktu_keluar')
            ->first();

        // ================= CHECK OUT =================
        if ($hadir) {

            $waktuKeluar = Carbon::now();
            $detik = Carbon::parse($hadir->waktu_masuk)
                ->diffInSeconds($waktuKeluar);

            DB::table('hadir')->where('id', $hadir->id)->update([
                'waktu_keluar' => $waktuKeluar->format('H:i:s'),
                'durasi' => $detik,
                'updated_at' => now()
            ]);

            return response()->json([
                'status' => 'checkout',
                'detik' => $detik
            ]);
        }

        // ================= CHECK IN =================
        DB::table('hadir')->insert([
            'nama' => $request->nama,
            'type' => $request->type,
            'tanggal' => $today,
            'waktu_masuk' => Carbon::now()->format('H:i:s'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'status' => 'checkin',
            'foto' => $foto
        ]);
    }

}
