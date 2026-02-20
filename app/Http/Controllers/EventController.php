<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EventExport;
use Barryvdh\DomPDF\Facade\Pdf;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('member')->orderBy('created_at', 'desc')->get();
        return view('event.index', compact('events'));
    }

    public function create()
    {
        // Pass daftar member untuk dropdown Organizer di form
        return view('event.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'jumlah_peserta' => 'nullable|integer|min:0',
            'organizer'      => 'nullable|string|max:255',
        ]);

        Event::create([
            'title'          => $request->title,
            'description'    => $request->description,
            'start_date'     => $request->start_date,
            'end_date'       => $request->end_date,
            'jumlah_peserta' => $request->jumlah_peserta ?? 0,
            'organizer'      => $request->organizer,
            'status'         => 'pending',
        ]);

        return redirect()->route('event.index')->with('success', 'Event berhasil dibuat! Menunggu persetujuan manager.');
    }

    public function edit(Event $event)
    {
        return view('event.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'jumlah_peserta' => 'nullable|integer|min:0',
            'organizer'      => 'nullable|string|max:255',
        ]);

        $event->update([
            'title'          => $request->title,
            'description'    => $request->description,
            'start_date'     => $request->start_date,
            'end_date'       => $request->end_date,
            'jumlah_peserta' => $request->jumlah_peserta ?? $event->jumlah_peserta,
            'organizer'      => $request->organizer ?? $event->organizer,
        ]);

        return redirect()->route('event.index')->with('success', 'Event berhasil diperbarui!');
    }

    public function show(Event $event)
    {
        return view('event.show', compact('event'));
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('event.index')->with('success', 'Event dihapus!');
    }

    public function exportExcel()
    {
        return Excel::download(new EventExport, 'DATA EVENT.xlsx');
    }

    public function exportPdf()
    {
        $events = Event::all();
        $pdf = Pdf::loadView('event.pdf', compact('events'))
                  ->setPaper('a4', 'landscape');
        return $pdf->download('DATA EVENT.pdf');
    }
}