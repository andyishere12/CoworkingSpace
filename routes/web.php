<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataMemberController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OperationalHoursController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;

// NEW: Import controllers untuk Manager
use App\Http\Controllers\ManagerDashboardController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\EventApprovalController;
use App\Http\Controllers\ReservationApprovalController;
use App\Http\Controllers\UserManagementController;

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/
// Rute Home (/) - Redirect berdasarkan role jika sudah login
Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    if (auth::user()->role === 'manager') {
        return redirect()->route('manager.dashboard');
    }

    return redirect()->route('dashboard'); // Diarahkan ke admin dashboard
});
/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');

Route::post('/login', [LoginController::class, 'handleLogin'])->name('login.process');

/*
|--------------------------------------------------------------------------
| Admin Routes (Protected) - ✅ UPDATED: Tambah middleware role:admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Attendance
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
    Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkout');

    // Resources
    Route::resource('data_member', DataMemberController::class);
    Route::resource('reservasi', ReservasiController::class);
    Route::resource('room', RoomController::class);
    Route::resource('event', EventController::class);

    // Scan
    Route::get('/scanner', [ScanController::class, 'index'])->name('scanner');
    Route::get('/scan', [ScanController::class, 'index'])->name('scan');
    Route::post('/scan/store', [ScanController::class, 'store'])->name('scan.store');
    Route::get('/scan/active-members', [ScanController::class, 'getActiveMembers'])->name('scan.active');
    Route::post('/manual-checkout', [ScanController::class, 'manualCheckout'])->name('scan.manual.checkout');
    Route::post('/manual-checkin', [ScanController::class, 'manualCheckin'])->name('scan.manual.checkin');
    Route::get('/search-members', [ScanController::class, 'searchMembers'])->name('scan.search.members');
    Route::get('/active-members', [ScanController::class, 'getActiveMembers'])->name('scan.active.members');

    // Operational Hours
    Route::prefix('operational-hours')->name('operational-hours.')->group(function () {
        Route::get('/', [OperationalHoursController::class, 'index'])->name('index');
        Route::get('/edit', [OperationalHoursController::class, 'edit'])->name('edit');
        Route::put('/update-all', [OperationalHoursController::class, 'updateAll'])->name('update-all');
    });

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/membership', [ReportController::class, 'membershipReport'])->name('membership');
        Route::get('/room', [ReportController::class, 'roomReport'])->name('room');
        Route::get('/event', [ReportController::class, 'eventReport'])->name('event');
        Route::get('/export/membership', [ReportController::class, 'exportMembership'])->name('export.membership');
        Route::get('/export/room', [ReportController::class, 'exportRoom'])->name('export.room');
        Route::get('/export/event', [ReportController::class, 'exportEvent'])->name('export.event');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Export Members to Excel
    Route::get('/members/export/excel', [DataMemberController::class, 'exportExcel'])
        ->name('members.export.excel');
    Route::get('/reservasi/export/excel', [ReservasiController::class, 'exportExcel'])
        ->name('reservasi.export.excel');
    Route::get('/room/export/excel', [RoomController::class, 'exportExcel'])
        ->name('room.export.excel');
    Route::get('/event/export/excel', [EventController::class, 'exportExcel'])
        ->name('event.export.excel');

    // Export Members to PDF
    Route::get('/members/export/pdf', [DataMemberController::class, 'exportPdf'])
        ->name('members.export.pdf');
    Route::get('/reservasi/export/pdf', [ReservasiController::class, 'exportPdf'])
        ->name('reservasi.export.pdf');
    Route::get('/room/export/pdf', [RoomController::class, 'exportPdf'])
        ->name('room.export.pdf');
    Route::get('/event/export/pdf', [EventController::class, 'exportPdf'])
        ->name('event.export.pdf');

    // Detailed Report Routes
    Route::get('/reports/member/excel', [ReportController::class, 'exportMembershipExcel']);
    Route::get('/reports/member/pdf', [ReportController::class, 'memberPdf']);

    Route::get('/reports/room/excel', [ReportController::class, 'exportRoomExcel']);
    Route::get('/reports/room/pdf', [ReportController::class, 'exportRoomPdf']);

    Route::get('/reports/event/excel', [ReportController::class, 'exportEventExcel']);
    Route::get('/reports/event/pdf', [ReportController::class, 'exportEventPdf']);
});

/*
| ✅ NEW: Manager Routes (Protected)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:manager'])->prefix('manager')->name('manager.')->group(function () {

    // Manager Dashboard
    Route::get('/dashboard', [ManagerDashboardController::class, 'index'])->name('dashboard');

     // Analytics dengan AI insights
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');

    // Members - Read Only
    Route::get('/members', [DataMemberController::class, 'index'])->name('members.index');
    Route::get('/members/{id}', [DataMemberController::class, 'show'])->name('members.show');

    // Event Approval
    Route::get('/event-approval', [EventApprovalController::class, 'index'])->name('event-approval.index');
    Route::post('/event-approval/{id}/approve', [EventApprovalController::class, 'approve'])->name('event-approval.approve');
    Route::post('/event-approval/{id}/reject', [EventApprovalController::class, 'reject'])->name('event-approval.reject');

    // Reservation Approval
    Route::get('/reservation-approval', [ReservationApprovalController::class, 'index'])->name('reservation-approval.index');
    Route::post('/reservation-approval/{id}/approve', [ReservationApprovalController::class, 'approve'])->name('reservation-approval.approve');
    Route::post('/reservation-approval/{id}/reject', [ReservationApprovalController::class, 'reject'])->name('reservation-approval.reject');

    // User Management
    Route::resource('users', UserManagementController::class);

    // Settings
    Route::get('/settings', function () {
        return view('manager.settings');
    })->name('settings');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

/*
|--------------------------------------------------------------------------
| Logout (Both Admin & Manager)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// Debug route untuk tes API Gemini (HANYA UNTUK PENGEMBANGAN, HAPUS SAAT DEPLOY)

Route::get('/debug-gemini-raw', function() {
    $apiKey = config('services.gemini.api_key');
    
    if (!$apiKey) {
        return 'ERROR: API key tidak ada!';
    }
    
    $prompt = "Output ONLY JSON. NO explanation.

[{\"title\":\"Test\",\"description\":\"Test\",\"icon\":\"users\",\"color\":\"info\",\"priority\":\"medium\",\"suggestions\":[\"A1\",\"A2\"]}]

Give 2 recommendations. JSON only, start with [";
    
    $response = \Illuminate\Support\Facades\Http::timeout(10)->post(
        'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $apiKey,
        [
            'contents' => [['parts' => [['text' => $prompt]]]],
            'generationConfig' => ['temperature' => 0.3, 'maxOutputTokens' => 1000]
        ]
    );
    
    if ($response->successful()) {
        $result = $response->json();
        $rawText = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'NO TEXT';
        
        echo "<h2>✅ SUCCESS! RAW:</h2>";
        echo "<pre style='background:#f4f4f4; padding:20px;'>" . htmlspecialchars($rawText) . "</pre>";
        
        $cleaned = preg_replace('/```(?:json)?\s*|\s*```/', '', $rawText);
        $cleaned = str_replace('```', '', $cleaned);
        $cleaned = trim($cleaned);
        
        echo "<h2>CLEANED:</h2>";
        echo "<pre style='background:#e8f4f8; padding:20px;'>" . htmlspecialchars($cleaned) . "</pre>";
        
        if (preg_match('/\[.*\]/s', $cleaned, $matches)) {
            echo "<h2>EXTRACTED:</h2>";
            echo "<pre style='background:#e8f8e8; padding:20px;'>" . htmlspecialchars($matches[0]) . "</pre>";
            
            $decoded = json_decode($matches[0], true);
            if ($decoded) {
                echo "<h2>✅ DECODED!</h2>";
                echo "<pre style='background:#d4edda; padding:20px;'>";
                print_r($decoded);
                echo "</pre>";
            } else {
                echo "<h2>❌ FAILED: " . json_last_error_msg() . "</h2>";
            }
        }
        
    } else {
        echo "<h2>❌ FAILED: " . $response->status() . "</h2>";
        echo "<pre>" . $response->body() . "</pre>";
    }
});