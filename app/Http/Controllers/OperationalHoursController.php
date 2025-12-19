<?php

namespace App\Http\Controllers;

use App\Models\OperationalHour;
use Illuminate\Http\Request;

class OperationalHoursController extends Controller
{
    public function index()
    {
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        
        // Ensure all days exist in database
        foreach ($days as $day) {
            OperationalHour::firstOrCreate(
                ['day' => $day],
                [
                    'open_time' => '08:00:00',
                    'close_time' => '16:00:00',
                    'is_closed' => $day === 'Minggu'
                ]
            );
        }
        
        $operationalHours = OperationalHour::orderByRaw(
            "FIELD(day, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')"
        )->get();
        
        return view('operational-hours.index', compact('operationalHours'));
    }

    public function edit()
    {
        $dayNames = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        
        $operationalHours = [];
        
        foreach ($dayNames as $day) {
            $operationalHours[] = OperationalHour::firstOrCreate(
                ['day' => $day],
                [
                    'open_time' => '08:00:00',
                    'close_time' => '16:00:00',
                    'is_closed' => $day === 'Minggu'
                ]
            );
        }
        
        return view('operational-hours.edit', compact('operationalHours'));
    }

    public function updateAll(Request $request)
    {
        // Validasi dengan format yang benar (termasuk detik)
        $request->validate([
            'hours.*.open_time' => 'nullable',
            'hours.*.close_time' => 'nullable',
            'hours.*.is_closed' => 'nullable'
        ]);

        foreach ($request->hours as $id => $data) {
            $hour = OperationalHour::find($id);
            
            if ($hour) {
                // Cek apakah checkbox dicentang (checkbox yang tidak dicentang tidak akan ada di $data)
                $isClosed = isset($data['is_closed']) && $data['is_closed'] == '1';
                
                $hour->update([
                    'open_time' => $isClosed ? null : ($data['open_time'] ?? null),
                    'close_time' => $isClosed ? null : ($data['close_time'] ?? null),
                    'is_closed' => $isClosed
                ]);
            }
        }

        return redirect()->route('operational-hours.index')
            ->with('success', 'Jam operasional berhasil diperbarui!');
    }
}