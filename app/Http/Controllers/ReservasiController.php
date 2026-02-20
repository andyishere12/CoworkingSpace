<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\DataMember;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReservasiExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ReservasiController extends Controller
{
    public function index()
    {
        $allreservasi = Reservasi::all();
        return view('Reservasi.index', compact('allreservasi'));
    }

    public function create()
    {
        $members = DataMember::all();
        return view('Reservasi.create', compact('members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pemesanan' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'institusi' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'description' => 'nullable|string',
            'attends' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'ruangan' => 'required|string|max:100',
            'status' => 'required|string|max:100',
        ]);

        Reservasi::create([
            'nama_pemesanan' => $request->nama_pemesanan,
            'kontak' => $request->kontak,
            'institusi' => $request->institusi,
            'purpose' => $request->purpose,
            'description' => $request->description,
            'attends' => $request->attends,
            'tanggal' => $request->tanggal,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'ruangan' => $request->ruangan,
            'status' => $request->status,
        ]);

        return redirect()->route('reservasi.index')->with('success', 'Reservasi berhasil dibuat!');
    }

    public function edit(Reservasi $reservasi)
    {
        $members = DataMember::all();
        return view('Reservasi.edit', compact('reservasi', 'members'));
    }

    public function update(Request $request, Reservasi $reservasi)
    {
        $request->validate([
            'nama_pemesanan' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'institusi' => 'required|string|max:255',
            'purpose' => 'required|string|max:255',
            'description' => 'nullable|string',
            'attends' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'ruangan' => 'required|string|max:100',
            'status' => 'required|string|max:100',
        ]);

        $reservasi->update([
            'nama_pemesanan' => $request->nama_pemesanan,
            'kontak' => $request->kontak,
            'institusi' => $request->institusi,
            'purpose' => $request->purpose,
            'description' => $request->description,
            'attends' => $request->attends,
            'tanggal' => $request->tanggal,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'ruangan' => $request->ruangan,
            'status' => $request->status,
        ]);

        return redirect()->route('reservasi.index')->with('success', 'Reservasi berhasil diperbarui!');
    }

    public function show(Reservasi $reservasi)
    {
        return view('reservasi.show', compact('reservasi'));
    }

    public function destroy(Reservasi $reservasi)
    {
        $reservasi->delete();
        return redirect()->route('reservasi.index')->with('success', 'Reservasi dihapus!');
    }

    public function reservasiPrint(Request $request)
    {
        // Ambil semua reservasi
        $reservasi = Reservasi::orderBy('created_at', 'desc')->get();

        // Flag untuk render HTML di browser
        $isPdf = false;

        return view('reservasi.pdf', compact(
            'reservasi',
            'isPdf'
        ));
    }

    public function exportExcel()
{
    return Excel::download(new ReservasiExport, 'DATA RESERVASI.xlsx');
}
public function exportPdf()
{
    $reservasi = Reservasi::all();
    $isPdf = true;

    $pdf = Pdf::loadView('reservasi.pdf', compact('reservasi', 'isPdf'))
        ->setPaper('a4', 'landscape');

    return $pdf->download('DATA RESERVASI.pdf');
}

}
