<?php

namespace App\Http\Controllers;
use App\Models\DataMember;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DataMemberController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        if ($search) {
            $allmember = DataMember::where('nama', 'like', '%' . $search . '%')
                ->orWhere('type', 'like', '%' . $search . '%')
                ->orWhere('aktivitas', 'like', '%' . $search . '%')
                ->orWhere('status', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('institusi', 'like', '%' . $search . '%')
                ->get();
        } else {
            $allmember = DataMember::all();
        }
        
        return view('data_member.index', compact('allmember'));
    }

    public function create()
    {
        return view('data_member.create');
    }

    public function store(Request $request)
    {
        // VALIDASI
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

        // UPLOAD FOTO
        if ($request->hasFile('foto')) {
            $foto_name = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('uploads/foto'), $foto_name);
        }

        // SIMPAN DATA KE DATABASE
        $member = DataMember::create([
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

        return redirect()->route('data_member.index')->with('success', 'Member berhasil ditambahkan!');
    }

    public function show($id)
    {
        $member = DataMember::findOrFail($id);
        return view('data_member.show', compact('member'));
    }

    public function edit(DataMember $data_member)
    {
        return view('data_member.edit', compact('data_member'));
    }

    public function update(Request $request, DataMember $data_member)
    {
        // Validasi
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

        // Upload foto baru jika ada
        if ($request->hasFile('foto')) {
            $foto_name = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('uploads/foto'), $foto_name);
            $data_member->foto = $foto_name;
        }

        // Update data
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

    public function destroy(DataMember $data_member)
    {
        $data_member->delete();
        return redirect()->route('data_member.index');
    }
}