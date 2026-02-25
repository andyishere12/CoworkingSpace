<?php

namespace App\Http\Controllers;

use App\Models\DataMember;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MemberExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class DataMemberController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = DataMember::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('type', 'like', '%' . $search . '%')
                    ->orWhere('aktivitas', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('institusi', 'like', '%' . $search . '%');
            });
        }

        $allmember = $query->orderBy('created_at', 'desc')->get();

        return view('data_member.index', compact('allmember'));
    }

    public function show($id)
    {
        $member = DataMember::findOrFail($id);

        if (request()->wantsJson()) {
            return response()->json($member);
        }

        return view('data_member.show', compact('member'));
    }

    public function edit(DataMember $data_member)
    {
        return view('data_member.edit', compact('data_member'));
    }

    public function update(Request $request, DataMember $data_member)
    {
        $request->validate([
            'nama' => 'required|max:100',
            'tanggal_lahir' => 'required',
            'alamat' => 'required|max:255',
            'email' => 'required|email',
            'no_hp' => 'nullable|max:20',
            'aktivitas' => 'required|max:100',
            'institusi' => 'required|max:100',
            'type' => 'required|max:100',
            'status' => 'required|max:100',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $foto_name = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('uploads/foto'), $foto_name);
            $data_member->foto = $foto_name;
        }

        $data_member->update([
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'aktivitas' => $request->aktivitas,
            'institusi' => $request->institusi,
            'type' => $request->type,
            'status' => $request->status,
        ]);

        return redirect()->route('data_member.index')->with('success', 'Member berhasil diperbarui!');
    }

    public function create()
    {
        return view('data_member.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:100',
            'tanggal_lahir' => 'required',
            'alamat' => 'required|max:255',
            'email' => 'required|email|unique:data_members,email',
            'no_hp' => 'nullable|max:20',
            'aktivitas' => 'required|max:100',
            'institusi' => 'required|max:100',
            'type' => 'required|max:100',
            'status' => 'required|max:100',
            'foto' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $foto_name = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('uploads/foto'), $foto_name);
        }

        DataMember::create([
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'aktivitas' => $request->aktivitas,
            'institusi' => $request->institusi,
            'type' => $request->type,
            'status' => $request->status,
            'foto' => $foto_name,
        ]);

        return redirect()->route('data_member.index')
            ->with('success', 'Member berhasil ditambahkan!');
    }

    public function destroy(DataMember $data_member)
    {
        $data_member->delete();
        return redirect()->route('data_member.index');
    }

    public function memberPrint(Request $request)
    {
        $members = DataMember::orderBy('created_at', 'desc')->get();

        $totalMember = $members->count();
        $aktif = $members->where('status', 'aktif')->count();
        $nonAktif = $totalMember - $aktif;

        $tipeMember = $members->groupBy('type')->map(function ($group, $key) {
            return (object)['type' => $key ?: 'Tidak Diketahui', 'jumlah' => $group->count()];
        })->values();

        $aktivitasMember = $members->groupBy('aktivitas')->map(function ($group, $key) {
            return (object)['aktivitas' => $key ?: 'Tidak Diketahui', 'jumlah' => $group->count()];
        })->values();

        $isPdf = true;
        $exportOnlyDetail = false;

        $pdf = Pdf::loadView('data_member.pdf', compact(
            'members',
            'totalMember',
            'aktif',
            'nonAktif',
            'tipeMember',
            'aktivitasMember',
            'isPdf',
            'exportOnlyDetail'
        ))->setPaper('a4', 'landscape');

        return $pdf->stream('DATA MEMBER.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new MemberExport, 'DATA MEMBER.xlsx');
    }

    public function exportPdf()
    {
        $members = DataMember::all();
        $isPdf = true;
        $pdf = Pdf::loadView('data_member.pdf', compact('members', 'isPdf'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('DATA MEMBER.pdf');
    }
}
