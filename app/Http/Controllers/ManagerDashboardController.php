<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DataMember;
use App\Models\Reservasi;
use App\Models\Event;

class ManagerDashboardController extends Controller
{
    public function index()
    {
        try {
            // Get statistics
            $totalMembers = DataMember::count();
            $pendingReservations = Reservasi::where('status', 'pending')->count();
            $pendingEvents = Event::where('status', 'pending')->count();
            
            // Active today - simplified (jika tabel attendance belum ada)
            $activeToday = 0;
            
            // Check if Attendance model exists
            if (class_exists('App\Models\Attendance')) {
                $activeToday = \App\Models\Attendance::whereNull('check_out')
                    ->whereDate('check_in', today())
                    ->count();
            }

            // Recent members (last 7 days)
            $recentMembers = DataMember::latest()
                ->take(5)
                ->get();

            // Pending approvals
            $pendingApprovals = [
                'reservations' => Reservasi::where('status', 'pending')->latest()->take(5)->get(),
                'events' => Event::where('status', 'pending')->latest()->take(5)->get(),
            ];

            return view('manager.dashboard', compact(
                'totalMembers',
                'pendingReservations',
                'pendingEvents',
                'activeToday',
                'recentMembers',
                'pendingApprovals'
            ));
            
        } catch (\Exception $e) {
            // If any error occurs, show dashboard with minimal data
            return view('manager.dashboard', [
                'totalMembers' => DataMember::count(),
                'pendingReservations' => 0,
                'pendingEvents' => 0,
                'activeToday' => 0,
                'recentMembers' => collect([]),
                'pendingApprovals' => [
                    'reservations' => collect([]),
                    'events' => collect([]),
                ],
            ]);
        }
    }
}