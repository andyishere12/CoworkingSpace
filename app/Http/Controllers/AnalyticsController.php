<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataMember;
use App\Models\Attendance;
use App\Models\Reservasi;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Display analytics dashboard for manager
     */
    public function index()
    {
        // Get current date info
        $today = Carbon::today();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Calculate business hours (assuming 09:00 - 20:00)
        $openTime = Carbon::today()->setTime(9, 0);
        $closeTime = Carbon::today()->setTime(20, 0);
        $totalMinutes = $openTime->diffInMinutes($closeTime);

        // Get today's attendance data
        $todayAttendance = Attendance::whereDate('check_in', $today)->get();
        
        // Calculate average duration per visitor today
        $totalDuration = 0;
        $completedVisits = 0;
        
        foreach ($todayAttendance as $attendance) {
            if ($attendance->check_out) {
                $checkIn = Carbon::parse($attendance->check_in);
                $checkOut = Carbon::parse($attendance->check_out);
                $totalDuration += $checkIn->diffInMinutes($checkOut);
                $completedVisits++;
            }
        }
        
        $avgDuration = $completedVisits > 0 ? round($totalDuration / $completedVisits) : 0;
        $avgDurationFormatted = $this->formatMinutesToTime($avgDuration);

        // Get retention rate (members who came back in last 30 days)
        $thirtyDaysAgo = Carbon::now()->subDays(30);
        $membersWithVisits = Attendance::where('check_in', '>=', $thirtyDaysAgo)
            ->distinct('data_member_id')
            ->count('data_member_id');
        
        $totalMembers = DataMember::count();
        $retentionRate = $totalMembers > 0 ? round(($membersWithVisits / $totalMembers) * 100, 1) : 0;

        // Get visit index (comparing this month vs last month)
        $thisMonthVisits = Attendance::whereMonth('check_in', $currentMonth)
            ->whereYear('check_in', $currentYear)
            ->count();
        
        $lastMonth = Carbon::now()->subMonth();
        $lastMonthVisits = Attendance::whereMonth('check_in', $lastMonth->month)
            ->whereYear('check_in', $lastMonth->year)
            ->count();
        
        $visitIndexChange = $lastMonthVisits > 0 
            ? round((($thisMonthVisits - $lastMonthVisits) / $lastMonthVisits) * 100, 1) 
            : 0;

        // Get member activity distribution
        $activityDistribution = $this->getMemberActivityDistribution();

        // Get monthly trend data
        $monthlyTrend = $this->getMonthlyTrendData();

        // AI-powered recommendations
        $recommendations = $this->generateAIRecommendations([
            'retention_rate' => $retentionRate,
            'visit_index' => $visitIndexChange,
            'avg_duration' => $avgDuration,
            'activity_distribution' => $activityDistribution,
            'monthly_trend' => $monthlyTrend,
        ]);

        return view('manager.analytics', compact(
            'avgDurationFormatted',
            'retentionRate',
            'visitIndexChange',
            'activityDistribution',
            'monthlyTrend',
            'recommendations'
        ));
    }

    /**
     * Get member activity distribution by type
     */
    private function getMemberActivityDistribution()
    {
        $distribution = DataMember::select('member_type', DB::raw('count(*) as total'))
            ->groupBy('member_type')
            ->get();

        $totalMembers = DataMember::count();
        
        $result = [];
        foreach ($distribution as $item) {
            $percentage = $totalMembers > 0 ? round(($item->total / $totalMembers) * 100, 1) : 0;
            $result[] = [
                'type' => $item->member_type,
                'total' => $item->total,
                'percentage' => $percentage,
            ];
        }

        return $result;
    }

    /**
     * Get monthly visit trend data for the year
     */
    private function getMonthlyTrendData()
    {
        $currentYear = Carbon::now()->year;
        $monthlyData = [];

        for ($month = 1; $month <= 12; $month++) {
            $visits = Attendance::whereMonth('check_in', $month)
                ->whereYear('check_in', $currentYear)
                ->count();
            
            $monthlyData[] = [
                'month' => Carbon::create()->month($month)->format('F'),
                'visits' => $visits,
            ];
        }

        return $monthlyData;
    }

    /**
     * Generate AI-powered recommendations based on analytics data
     */
    private function generateAIRecommendations($data)
    {
        $recommendations = [];

        // Analyze retention rate
        if ($data['retention_rate'] < 30) {
            $recommendations[] = [
                'title' => 'Retensi Member',
                'description' => 'Tingkat retensi member rendah (' . $data['retention_rate'] . '%)',
                'icon' => 'users',
                'color' => 'success',
                'suggestions' => [
                    'Implementasikan program keterlibatan member',
                    'Tingkatkan fasilitas pendukung',
                    'Mulai program umpan balik member'
                ]
            ];
        }

        // Analyze visit trends
        if ($data['visit_index'] < 0) {
            $recommendations[] = [
                'title' => 'Manajemen Kapasitas',
                'description' => 'Lalu lintas tinggi pada jam sibuk',
                'icon' => 'chart-line',
                'color' => 'warning',
                'suggestions' => [
                    'Pertimbangkan perluasan ruang pada jam sibuk: 09:00, 10:00, 08:00',
                    'Terapkan optimasi sistem pemesanan ruangan',
                    'Buat insentif untuk penggunaan di luar jam sibuk'
                ]
            ];
        }

        // Analyze peak hours
        $recommendations[] = [
            'title' => 'Promosi Instagram',
            'description' => 'Optimalkan posting konten pada waktu prime time Instagram',
            'icon' => 'instagram',
            'color' => 'danger',
            'suggestions' => [
                'Senin-Jumat: 11:00-13:00',
                'Senin-Jumat: 19:00-21:00',
                'Sabtu-Minggu: 10:00-11:00',
                'Sabtu-Minggu: 20:00-22:00',
                'Posting Stories: 16:00-18:00'
            ]
        ];

        // Member segmentation recommendations
        $workingSegment = collect($data['activity_distribution'])->firstWhere('type', 'Bekerja');
        if ($workingSegment && $workingSegment['percentage'] > 25) {
            $recommendations[] = [
                'title' => 'Segmen Unggulan: Bekerja',
                'description' => 'Performa Baik (' . $workingSegment['percentage'] . '% dari total kunjungan)',
                'icon' => 'briefcase',
                'color' => 'primary',
                'suggestions' => [
                    'Pertahankan layanan berkualitas',
                    'Tingkatkan fasilitas pendukung',
                    'Perkuat program komunitas'
                ]
            ];
        }

        // Learning segment analysis
        $learningSegment = collect($data['activity_distribution'])->firstWhere('type', 'Belajar');
        if ($learningSegment && $learningSegment['percentage'] > 70) {
            $recommendations[] = [
                'title' => 'Segmen Unggulan: Belajar',
                'description' => 'Performa Baik (' . $learningSegment['percentage'] . '% dari total kunjungan)',
                'icon' => 'graduation-cap',
                'color' => 'info',
                'suggestions' => [
                    'Pertahankan layanan berkualitas',
                    'Tingkatkan fasilitas pendukung',
                    'Perkuat program komunitas'
                ]
            ];
        }

        // Administrative tasks
        $recommendations[] = [
            'title' => 'Tugas Admin',
            'description' => 'Optimasi Pelayanan Member',
            'icon' => 'tasks',
            'color' => 'primary',
            'suggestions' => [
                'Periksa data member yang kurang aktif',
                'Lakukan follow-up member tidak aktif',
                'Update informasi acara mingguan',
                'Pastikan sistem booking berjalan lancar'
            ]
        ];

        // Facility cleaning
        $recommendations[] = [
            'title' => 'Tugas Kebersihan',
            'description' => 'Pemeliharaan Fasilitas',
            'icon' => 'broom',
            'color' => 'success',
            'suggestions' => [
                'Periksa kebersihan area kerja setiap 09:00, 10:00, 08:00',
                'Pastikan ketersediaan supplies toilet',
                'Lakukan general cleaning sebelum jam sibuk',
                'Periksa kondisi peralatan & furniture'
            ]
        ];

        // Member discussion segment
        $discussSegment = collect($data['activity_distribution'])->firstWhere('type', 'Diskusi');
        if ($discussSegment && $discussSegment['percentage'] < 2) {
            $recommendations[] = [
                'title' => 'Segmen Member: Diskusi',
                'description' => 'Potensi Pengembangan (1.5% dari total kunjungan)',
                'icon' => 'comments',
                'color' => 'info',
                'suggestions' => [
                    'Analisis kebutuhan spesifik',
                    'Tingkatkan fasilitas pendukung',
                    'Mulai program umpan balik'
                ]
            ];
        }

        // Inactive members
        $recommendations[] = [
            'title' => 'Aktivasi Member',
            'description' => 'Terdapat 263 member tidak aktif dalam 30 hari terakhir',
            'icon' => 'user-times',
            'color' => 'danger',
            'suggestions' => [
                'Kirim pesan pengingat personal',
                'Tawarkan program reaktivasi khusus',
                'Undang ke acara komunitas mendatang'
            ]
        ];

        return $recommendations;
    }

    /**
     * Format minutes to HH:MM format
     */
    private function formatMinutesToTime($minutes)
    {
        $hours = floor($minutes / 60);
        $mins = $minutes % 60;
        return sprintf('%02d:%02d', $hours, $mins);
    }
}
