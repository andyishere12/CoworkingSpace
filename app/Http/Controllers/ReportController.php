<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataMember;
use App\Models\Room;
use App\Models\Event;
use App\Models\Reservasi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Exports\ReportMemberExport;
use App\Exports\ReportRoomExport;
use App\Exports\ReportEventExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

class ReportController extends Controller
{
    // Halaman index laporan (menu utama)
    public function index()
    {
        return view('reports.index');
    }

    // ==========================================
    // LAPORAN MEMBER (dari data_members)
    // ==========================================
    public function membershipReport(Request $request)
    {
        $type = $request->input('type', 'all');
        $activity = $request->input('activity', 'all');
        $status = $request->input('status', 'all');

        $query = DataMember::query();

        if ($type != 'all') {
            $query->where('type', $type);
        }

        if ($activity != 'all') {
            $query->where('aktivitas', $activity);
        }

        if ($status != 'all') {
            $query->where('status', $status);
        }

        $memberData = $query->orderBy('created_at', 'desc')->get();

        $statistics = [
            'total_members' => DataMember::count(),
            'active_members' => DataMember::where('status', 'aktif')->count(),
            'inactive_members' => DataMember::where('status', '!=', 'aktif')->count(),
            'member_count' => DataMember::where('type', 'Member')->count(),
            'mentor_count' => DataMember::where('type', 'Mentor')->count(),
            'oficial_count' => DataMember::where('type', 'Oficial')->count(),
            'tgs_count' => DataMember::where('type', 'Tegal Greate Seal')->count(),
            'business_count' => DataMember::where('aktivitas', 'Business')->count(),
            'worker_count' => DataMember::where('aktivitas', 'Worker')->count(),
            'student_count' => DataMember::where('aktivitas', 'Student')->count(),
            'freelancer_count' => DataMember::where('aktivitas', 'Freelancer')->count(),
            'community_count' => DataMember::where('aktivitas', 'Community')->count(),
        ];

        return view('reports.membership', compact('memberData', 'statistics', 'type', 'activity', 'status'));
    }

    // ==========================================
    // LAPORAN RUANGAN (dari rooms & reservasis)
    // ==========================================
    public function roomReport(Request $request)
    {
        $type = $request->input('type', 'all');
        $status = $request->input('status', 'all');

        $query = Room::query();

        if ($type != 'all') {
            $query->where('type', $type);
        }

        if ($status != 'all') {
            $query->where('status', $status);
        }

        $roomData = $query->orderBy('name')->get();

        $statistics = [
            'total_rooms' => Room::count(),
            'available_rooms' => Room::where('status', 'available')->count(),
            'total_capacity' => Room::sum('capacity'),
            'total_bookings' => Reservasi::count(),
            'by_type' => Room::select('type', DB::raw('count(*) as total'))
                ->groupBy('type')
                ->pluck('total', 'type')
                ->toArray(),
        ];

        $roomTypes = Room::distinct()->pluck('type')->toArray();

        $topRooms = Reservasi::select('ruangan', DB::raw('count(*) as total'))
            ->groupBy('ruangan')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        return view('reports.room', compact('roomData', 'statistics', 'type', 'status', 'roomTypes', 'topRooms'));
    }

    // ==========================================
    // LAPORAN EVENT (dari events)
    // ==========================================
    public function eventReport(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $status = $request->input('status', 'all');

        // Query events
        $query = Event::whereBetween('start_date', [$startDate, $endDate]);

        if ($status != 'all') {
            $query->where('status', $status);
        }

        $eventData = $query->orderBy('start_date', 'desc')->get();

        // Statistik
        $statistics = [
            'total_events' => Event::whereBetween('start_date', [$startDate, $endDate])->count(),
            'active_events' => Event::whereBetween('start_date', [$startDate, $endDate])
                ->where('status', 'active')->count(),
            'inactive_events' => Event::whereBetween('start_date', [$startDate, $endDate])
                ->where('status', 'inactive')->count(),
            'upcoming_events' => Event::where('start_date', '>', Carbon::now())
                ->whereBetween('start_date', [$startDate, $endDate])->count(),
            'ongoing_events' => Event::where('start_date', '<=', Carbon::now())
                ->where('end_date', '>=', Carbon::now())
                ->whereBetween('start_date', [$startDate, $endDate])->count(),
            'completed_events' => Event::where('end_date', '<', Carbon::now())
                ->whereBetween('start_date', [$startDate, $endDate])->count(),
            'all_events_total' => Event::count(),
        ];

        return view('reports.event', compact('eventData', 'statistics', 'startDate', 'endDate', 'status'));
    }

    // =================
    // EXPORT FUNCTIONS
    // =================

    // ===== MEMBER =====
    public function exportMembershipExcel(Request $request)
    {
        return Excel::download(new ReportMemberExport, 'LAPORAN MEMBER.xlsx');
    }

    public function memberPdf(Request $request)
    {
        $table = 'data_members';

        // Data utama
        $members = DB::table($table)
            ->orderBy('created_at', 'desc')
            ->get();

        // Ringkasan
        $totalMember = DB::table($table)->count();

        $aktif = DB::table($table)
            ->where('status', 'aktif')
            ->count();

        $nonAktif = DB::table($table)
            ->where('status', '!=', 'aktif')
            ->orWhereNull('status')
            ->count();

        // Statistik tipe
        $tipeMember = DB::table($table)
            ->select('type', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('type')
            ->get();

        // Statistik aktivitas
        $aktivitasMember = DB::table($table)
            ->select('aktivitas', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('aktivitas')
            ->get();

        $pdf = Pdf::loadView('reports.member_pdf', compact(
            'members',
            'totalMember',
            'aktif',
            'nonAktif',
            'tipeMember',
            'aktivitasMember'
        ));

        return $pdf->download('LAPORAN MEMBER.pdf');
    }


    // ===== ROOM =====
    public function exportRoomExcel(Request $request)
    {
        return Excel::download(new ReportRoomExport, 'LAPORAN RUANGAN.xlsx');
    }

    public function exportRoomPdf(Request $request)
    {
        // Ambil semua ruangan
        $rooms = Room::orderBy('name')->get();

        // Hitung statistik
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        $notAvailableRooms = $totalRooms - $availableRooms;

        // Statistik tipe ruangan
        $typeStats = Room::select('type', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('type')
            ->get();

        // Ringkasan reservasi per ruangan
        $reservationSummary = Reservasi::select(
            'ruangan',
            DB::raw('COUNT(*) as total_reservasi'),
            DB::raw('MAX(status) as status_terakhir')
        )
            ->groupBy('ruangan')
            ->orderBy('total_reservasi', 'desc')
            ->get();

        // Statistik status reservasi
        $statusStats = Reservasi::select('status', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('status')
            ->get();

        // **PERBAIKAN DI SINI**: Buat array asosiatif untuk memudahkan pencarian
        $reservationsCount = [];
        foreach ($reservationSummary as $reservation) {
            $reservationsCount[strtolower(trim($reservation->ruangan))] = $reservation->total_reservasi;
        }

        $pdf = PDF::loadView('reports.room_pdf', compact(
            'rooms',
            'totalRooms',
            'availableRooms',
            'notAvailableRooms',
            'typeStats',
            'reservationSummary',
            'statusStats',
            'reservationsCount' // Ganti dengan array yang lebih mudah digunakan
        ));

        return $pdf->download('LAPORAN RUANGAN.pdf');
    }


    // ===== EVENT =====
    public function exportEventExcel(Request $request)
    {
        return Excel::download(new ReportEventExport, 'LAPORAN EVENT.xlsx');
    }

    public function exportEventPdf(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $status = $request->input('status', 'all');

        // Query events
        $query = Event::whereBetween('start_date', [$startDate, $endDate]);

        if ($status != 'all') {
            $query->where('status', $status);
        }

        $events = $query->orderBy('start_date', 'desc')->get();

        // Statistik
        $statistics = [
            'total_events' => Event::whereBetween('start_date', [$startDate, $endDate])->count(),
            'active_events' => Event::whereBetween('start_date', [$startDate, $endDate])
                ->where('status', 'active')->count(),
            'inactive_events' => Event::whereBetween('start_date', [$startDate, $endDate])
                ->where('status', 'inactive')->count(),
            'upcoming_events' => Event::where('start_date', '>', Carbon::now())
                ->whereBetween('start_date', [$startDate, $endDate])->count(),
            'ongoing_events' => Event::where('start_date', '<=', Carbon::now())
                ->where('end_date', '>=', Carbon::now())
                ->whereBetween('start_date', [$startDate, $endDate])->count(),
            'completed_events' => Event::where('end_date', '<', Carbon::now())
                ->whereBetween('start_date', [$startDate, $endDate])->count(),
            'all_events_total' => Event::count(),
        ];

        // Pastikan logo ada di public/gambar/
        // Logo bisa disimpan di: public/gambar/logo_coworking.png dan public/gambar/logo_dinas.jpeg

        $imagePath = public_path('gambar');

        $pdf = PDF::loadView('reports.event_pdf', compact('events', 'statistics', 'startDate', 'endDate', 'imagePath'));

        // Optional: Atur opsi PDF
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'chroot' => public_path(),
        ]);

        return $pdf->download('LAPORAN EVENT   ' . date('d-m-Y') . '.pdf');
    }
}
