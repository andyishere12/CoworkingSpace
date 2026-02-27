<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ManagerSettingsController extends Controller
{
    /**
     * Display settings page
     */
    public function index()
    {
        return view('manager.settings');
    }

    /**
     * Update profile information
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            // Update name and email
            $user->name = $validated['name'];
            $user->email = $validated['email'];

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // Delete old avatar if exists
                if ($user->avatar && Storage::disk('public')->exists('avatars/' . $user->avatar)) {
                    Storage::disk('public')->delete('avatars/' . $user->avatar);
                }

                // Store new avatar
                $avatarName = time() . '_' . $request->file('avatar')->getClientOriginalName();
                $request->file('avatar')->storeAs('avatars', $avatarName, 'public');
                $user->avatar = $avatarName;
            }

            $user->save();

            return redirect()->back()->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update profile: ' . $e->getMessage());
        }
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($validated['current_password'], $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect!');
        }

        try {
            $user->password = Hash::make($validated['new_password']);
            $user->save();

            return redirect()->back()->with('success', 'Password changed successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to change password: ' . $e->getMessage());
        }
    }

    /**
     * Update notification settings
     */
    public function updateNotifications(Request $request)
    {
        $user = Auth::user();

        try {
            // Store notification preferences in user settings (you may need to add a 'settings' JSON column to users table)
            $settings = [
                'email_pending_events' => $request->has('email_pending_events'),
                'email_pending_reservations' => $request->has('email_pending_reservations'),
                'email_weekly_summary' => $request->has('email_weekly_summary'),
                'browser_notifications' => $request->has('browser_notifications'),
            ];

            // For now, we'll use session storage
            // In production, you should add a 'settings' JSON column to users table
            session(['notification_settings' => $settings]);

            return redirect()->back()->with('success', 'Notification preferences saved!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to save preferences: ' . $e->getMessage());
        }
    }

    /**
     * Update AI settings
     */
    public function updateAI(Request $request)
    {
        $validated = $request->validate([
            'ai_enabled' => 'nullable|boolean',
            'ai_cache_duration' => 'required|integer|in:3600,21600,86400',
            'ai_max_recommendations' => 'required|integer|in:3,5,7',
        ]);

        try {
            $settings = [
                'ai_enabled' => $request->has('ai_enabled'),
                'ai_cache_duration' => $validated['ai_cache_duration'],
                'ai_max_recommendations' => $validated['ai_max_recommendations'],
            ];

            // Store in session (in production, use database)
            session(['ai_settings' => $settings]);

            return redirect()->back()->with('success', 'AI settings saved successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to save AI settings: ' . $e->getMessage());
        }
    }

    /**
     * Update dashboard preferences
     */
    public function updateDashboard(Request $request)
    {
        $validated = $request->validate([
            'default_date_range' => 'required|in:7,30,90,all',
        ]);

        try {
            $settings = [
                'default_date_range' => $validated['default_date_range'],
                'show_members_widget' => $request->has('show_members_widget'),
                'show_reservations_widget' => $request->has('show_reservations_widget'),
                'show_events_widget' => $request->has('show_events_widget'),
                'show_active_widget' => $request->has('show_active_widget'),
                'show_analytics' => $request->has('show_analytics'),
                'show_recent_activity' => $request->has('show_recent_activity'),
            ];

            // Store in session (in production, use database)
            session(['dashboard_settings' => $settings]);

            return redirect()->back()->with('success', 'Dashboard preferences saved!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to save preferences: ' . $e->getMessage());
        }
    }
}
