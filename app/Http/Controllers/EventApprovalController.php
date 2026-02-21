<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class EventApprovalController extends Controller
{
    /**
     * Display list of pending events
     */
    public function index()
    {
        try {
            // Get all pending events with member info
            $pendingEvents = Event::with('member')
                ->where('status', 'pending')
                ->orderBy('start_date', 'asc')
                ->get();

            // Get approved events (recent 10)
            $approvedEvents = Event::with('member')
                ->where('status', 'approved')
                ->orderBy('updated_at', 'desc')
                ->take(10)
                ->get();

            // Get rejected events (recent 10)
            $rejectedEvents = Event::with('member')
                ->where('status', 'rejected')
                ->orderBy('updated_at', 'desc')
                ->take(10)
                ->get();

            // Statistics
            $stats = [
                'total_pending' => Event::where('status', 'pending')->count(),
                'total_approved' => Event::where('status', 'approved')->count(),
                'total_rejected' => Event::where('status', 'rejected')->count(),
                'total_all' => Event::count(),
            ];

            return view('manager.event-approval', compact(
                'pendingEvents',
                'approvedEvents',
                'rejectedEvents',
                'stats'
            ));
        } catch (\Exception $e) {
            \Log::error('Event Approval Index Error: ' . $e->getMessage());

            return view('manager.event-approval', [
                'pendingEvents' => collect(),
                'approvedEvents' => collect(),
                'rejectedEvents' => collect(),
                'stats' => [
                    'total_pending' => 0,
                    'total_approved' => 0,
                    'total_rejected' => 0,
                    'total_all' => 0,
                ]
            ]);
        }
    }

    /**
     * Approve an event
     */
    public function approve($id)
    {
        try {
            $event = Event::findOrFail($id);

            // Validate event is pending
            if ($event->status !== 'pending') {
                return redirect()->back()->with('error', 'Event sudah diproses sebelumnya!');
            }

            // Update status to approved
            $event->status = 'approved';
            $event->save();

            // \Log::info("Event #{$event->id} approved by manager #" . auth()->user()->id);

            return redirect()->back()->with('success', "Event '{$event->nama_event}' berhasil disetujui!");
        } catch (\Exception $e) {
            \Log::error('Event Approval Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyetujui event: ' . $e->getMessage());
        }
    }

    /**
     * Reject an event
     */
    public function reject(Request $request, $id)
    {
        try {
            $event = Event::findOrFail($id);

            // Validate event is pending
            if ($event->status !== 'pending') {
                return redirect()->back()->with('error', 'Event sudah diproses sebelumnya!');
            }

            // Validate rejection reason (optional but recommended)
            $request->validate([
                'rejection_reason' => 'nullable|string|max:500'
            ]);

            // Update status to rejected
            $event->status = 'rejected';

            // Alasan Penolakan
            $event->rejection_reason = $request->rejection_reason;

            $event->save();

            return redirect()->back()->with('success', "Event '{$event->nama_event}' ditolak!");
        } catch (\Exception $e) {
            \Log::error('Event Rejection Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menolak event: ' . $e->getMessage());
        }
    }
}