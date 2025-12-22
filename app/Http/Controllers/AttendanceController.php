<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hadir;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        // Load relasi member
        $attendances = Hadir::with('member')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('waktu_masuk', 'desc')
            ->paginate(20);

        foreach ($attendances as $attendance) {
            if ($attendance->durasi !== null) {
                $hours = floor($attendance->durasi / 60);
                $minutes = $attendance->durasi % 60;
                $attendance->formatted_durasi = sprintf('%02d:%02d', $hours, $minutes);
            } else {
                $attendance->formatted_durasi = '-';
            }
        }

        return view('attendance.index', compact('attendances', 'startDate', 'endDate'));
    }

    // Check-in
    public function checkIn(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
        ]);

        Hadir::create([
            'member_id' => $validated['member_id'],
            'tanggal' => now()->toDateString(),
            'waktu_masuk' => now()->format('H:i:s'),
        ]);

        return redirect()->back()->with('success', 'Check-in berhasil');
    }

    // Check-out
    public function checkOut(Request $request)
    {
        $validated = $request->validate([
            'attendance_id' => 'required|exists:hadir,id',
        ]);

        $attendance = Hadir::findOrFail($validated['attendance_id']);

        if ($attendance->waktu_keluar) {
            return redirect()->back()->with('error', 'Sudah check-out');
        }

        $checkInTime = Carbon::parse($attendance->tanggal . ' ' . $attendance->waktu_masuk, 'Asia/Jakarta');
        $checkOutTime = now();
        $duration = $checkOutTime->diffInMinutes($checkInTime);

        $attendance->update([
            'waktu_keluar' => $checkOutTime->format('H:i:s'),
            'durasi' => $duration,
        ]);

        return redirect()->back()->with('success', 'Check-out berhasil');
    }
}
