<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataMember;
use App\Models\Room;
use App\Models\Event;
use App\Models\Reservasi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
            'active_members' => DataMember::where('status', 'Aktive')->count(),
            'inactive_members' => DataMember::where('status', 'Inactive')->count(),
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

    // ==========================================
    // EXPORT FUNCTIONS
    // ==========================================
    public function exportMembership(Request $request)
    {
        return response()->json(['message' => 'Export membership report']);
    }

    public function exportRoom(Request $request)
    {
        return response()->json(['message' => 'Export room report']);
    }

    public function exportEvent(Request $request)
    {
        return response()->json(['message' => 'Export event report']);
    }
}