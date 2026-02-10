<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RoomExport;
use Barryvdh\DomPDF\Facade\Pdf;

class RoomController extends Controller
{
    public function index()
    {
        $allrooms = Room::all();
        return view('room.index', compact('allrooms'));
    }

    public function create()
    {
        return view('room.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|max:255',
        ]);

        Room::create([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'type' => $request->type,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('room.index')->with('success', 'Room berhasil dibuat!');
    }

    public function edit(Room $room)
    {
        return view('room.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string|max:255',
        ]);

        $room->update([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'type' => $request->type,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('room.index')->with('success', 'Room berhasil diperbarui!');
    }

    public function show(Room $room)
    {
        return view('room.show', compact('room'));
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('room.index')->with('success', 'Room dihapus!');
    }
    public function exportExcel()
    {
        return Excel::download(new RoomExport, 'DATA RUANGAN.xlsx');
    }
    public function exportPdf()
    {
        $rooms = Room::all();

        $pdf = Pdf::loadView('room.pdf', compact('rooms'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('DATA RUANGAN.pdf');
    }
}
