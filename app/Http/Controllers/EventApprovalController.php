<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventApprovalController extends Controller
{
    /**
     * Display events pending approval
     */
    public function index()
    {
        $events = Event::where('status', 'pending')
            ->orWhere('status', 'approved')
            ->orderBy('start_date', 'desc')
            ->get();

        return view('manager.event-approval', compact('events'));
    }

    /**
     * Approve an event
     */
    public function approve($id)
    {
        $event = Event::findOrFail($id);
        $event->status = 'approved';
        $event->save();

        return redirect()->back()->with('success', 'Event has been approved successfully.');
    }

    /**
     * Reject an event
     */
    public function reject($id)
    {
        $event = Event::findOrFail($id);
        $event->status = 'rejected';
        $event->save();

        return redirect()->back()->with('success', 'Event has been rejected.');
    }
}
