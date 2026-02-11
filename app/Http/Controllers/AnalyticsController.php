<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataMember;
use App\Models\Attendance;
use App\Models\Reservasi;
use App\Models\Event;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Display analytics dashboard for manager
     */
    public function index()
    {
        try {
            // Get current date info
            $today = Carbon::today();
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;

            // Calculate business hours (09:00 - 20:00)
            $openTime = Carbon::today()->setTime(9, 0);
            $closeTime = Carbon::today()->setTime(20, 0);
            $totalMinutes = $openTime->diffInMinutes($closeTime);

            // === JAM SIBUK ===
            $peakHours = $this->getPeakHours();

            // === TINGKAT RETENSI ===
            $retentionRate = $this->getRetentionRate();

            // === DURASI RATA-RATA ===
            $avgDuration = $this->getAverageDuration();
            $avgDurationFormatted = $this->formatMinutesToTime($avgDuration);

            // === INDEKS KUNJUNGAN ===
            $visitIndexChange = $this->getVisitIndexChange();

            // === DISTRIBUSI AKTIVITAS MEMBER ===
            $activityDistribution = $this->getMemberActivityDistribution();

            // === TREN BULANAN ===
            $monthlyTrend = $this->getMonthlyTrendData();

            // === AI RECOMMENDATIONS ===
            $recommendations = $this->generateAIRecommendations([
                'retention_rate' => $retentionRate,
                'visit_index' => $visitIndexChange,
                'avg_duration' => $avgDuration,
                'peak_hours' => $peakHours,
                'activity_distribution' => $activityDistribution,
                'monthly_trend' => $monthlyTrend,
            ]);

            return view('manager.analytics', compact(
                'peakHours',
                'retentionRate',
                'avgDurationFormatted',
                'visitIndexChange',
                'activityDistribution',
                'monthlyTrend',
                'recommendations'
            ));

        } catch (\Exception $e) {
            // Log error
            \Log::error('Analytics Error: ' . $e->getMessage());
            
            // Return with default values
            return view('manager.analytics', [
                'peakHours' => '09:00',
                'retentionRate' => 0,
                'avgDurationFormatted' => '00:00',
                'visitIndexChange' => 0,
                'activityDistribution' => [],
                'monthlyTrend' => [],
                'recommendations' => [
                    [
                        'title' => 'System Info',
                        'description' => 'Not enough data yet',
                        'icon' => 'info-circle',
                        'color' => 'info',
                        'priority' => 'low',
                        'suggestions' => ['Start tracking attendance to see analytics']
                    ]
                ]
            ]);
        }
    }

    /**
     * Get peak hours (jam tersibuk)
     */
    private function getPeakHours()
    {
        try {
            $peakData = Attendance::selectRaw('HOUR(check_in) as hour, COUNT(*) as count')
                ->whereMonth('check_in', date('m'))
                ->whereYear('check_in', date('Y'))
                ->whereNotNull('check_in')
                ->groupBy(DB::raw('HOUR(check_in)'))
                ->orderByDesc('count')
                ->first();

            if ($peakData) {
                return sprintf('%02d:00', $peakData->hour);
            }

            return '09:00'; // Default
        } catch (\Exception $e) {
            return '09:00';
        }
    }

    /**
     * Get retention rate (member yang kembali dalam 30 hari)
     */
    private function getRetentionRate()
    {
        try {
            $thirtyDaysAgo = Carbon::now()->subDays(30);
            
            $totalMembers = DataMember::count();
            
            if ($totalMembers == 0) {
                return 0;
            }

            $membersWithVisits = Attendance::where('check_in', '>=', $thirtyDaysAgo)
                ->distinct('data_member_id')
                ->count('data_member_id');
            
            return round(($membersWithVisits / $totalMembers) * 100, 1);
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Get average duration per visit
     */
    private function getAverageDuration()
    {
        try {
            $attendances = Attendance::whereNotNull('check_out')
                ->whereMonth('check_in', date('m'))
                ->whereYear('check_in', date('Y'))
                ->get();

            if ($attendances->count() == 0) {
                return 0;
            }

            $totalDuration = 0;
            foreach ($attendances as $attendance) {
                $checkIn = Carbon::parse($attendance->check_in);
                $checkOut = Carbon::parse($attendance->check_out);
                $totalDuration += $checkIn->diffInMinutes($checkOut);
            }

            return round($totalDuration / $attendances->count());
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Get visit index change (bulan ini vs bulan lalu)
     */
    private function getVisitIndexChange()
    {
        try {
            $currentMonth = date('m');
            $currentYear = date('Y');
            
            $thisMonthVisits = Attendance::whereMonth('check_in', $currentMonth)
                ->whereYear('check_in', $currentYear)
                ->count();
            
            $lastMonth = Carbon::now()->subMonth();
            $lastMonthVisits = Attendance::whereMonth('check_in', $lastMonth->month)
                ->whereYear('check_in', $lastMonth->year)
                ->count();
            
            if ($lastMonthVisits == 0) {
                return $thisMonthVisits > 0 ? 100 : 0;
            }

            return round((($thisMonthVisits - $lastMonthVisits) / $lastMonthVisits) * 100, 1);
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Get member activity distribution by type
     */
    private function getMemberActivityDistribution()
    {
        try {
            // Cek apakah kolom member_type ada
            if (!DB::getSchemaBuilder()->hasColumn('data_members', 'member_type')) {
                return [];
            }

            $distribution = DataMember::select('member_type', DB::raw('count(*) as total'))
                ->groupBy('member_type')
                ->get();

            $totalMembers = DataMember::count();
            
            if ($totalMembers == 0) {
                return [];
            }

            $result = [];
            foreach ($distribution as $item) {
                $percentage = round(($item->total / $totalMembers) * 100, 1);
                $result[] = [
                    'type' => $item->member_type ?? 'Unknown',
                    'total' => $item->total,
                    'percentage' => $percentage,
                ];
            }

            return $result;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Get monthly visit trend data for the year
     */
    private function getMonthlyTrendData()
    {
        try {
            $currentYear = Carbon::now()->year;
            $monthlyData = [];

            for ($month = 1; $month <= 12; $month++) {
                $visits = Attendance::whereMonth('check_in', $month)
                    ->whereYear('check_in', $currentYear)
                    ->count();
                
                $monthlyData[] = [
                    'month' => Carbon::create()->month($month)->format('M'),
                    'visits' => $visits,
                ];
            }

            return $monthlyData;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Generate AI-powered recommendations (FREE - Rule-based AI)
     */
    private function generateAIRecommendations($data)
    {
        $recommendations = [];

        try {
            // AI Analysis 1: Retention Rate
            if ($data['retention_rate'] < 30) {
                $recommendations[] = [
                    'title' => 'Retensi Member Rendah',
                    'description' => 'Tingkat retensi member hanya ' . $data['retention_rate'] . '%',
                    'icon' => 'users',
                    'color' => 'danger',
                    'priority' => 'high',
                    'suggestions' => [
                        'Implementasikan program loyalitas member',
                        'Kirim email personal ke member tidak aktif',
                        'Buat survei kepuasan member',
                        'Tingkatkan fasilitas berdasarkan feedback'
                    ]
                ];
            } else if ($data['retention_rate'] >= 70) {
                $recommendations[] = [
                    'title' => 'Retensi Member Excellent!',
                    'description' => 'Tingkat retensi sangat baik: ' . $data['retention_rate'] . '%',
                    'icon' => 'check-circle',
                    'color' => 'success',
                    'priority' => 'low',
                    'suggestions' => [
                        'Pertahankan kualitas layanan saat ini',
                        'Minta testimoni dari member loyal',
                        'Buat referral program',
                    ]
                ];
            }

            // AI Analysis 2: Visit Trend
            if ($data['visit_index'] < -10) {
                $recommendations[] = [
                    'title' => 'Penurunan Kunjungan',
                    'description' => 'Kunjungan turun ' . abs($data['visit_index']) . '% vs bulan lalu',
                    'icon' => 'chart-line',
                    'color' => 'warning',
                    'priority' => 'high',
                    'suggestions' => [
                        'Review pricing & paket membership',
                        'Lakukan promosi khusus bulan ini',
                        'Survey alasan member berkurang',
                        'Tingkatkan aktivitas marketing'
                    ]
                ];
            } else if ($data['visit_index'] > 10) {
                $recommendations[] = [
                    'title' => 'Pertumbuhan Positif!',
                    'description' => 'Kunjungan naik ' . $data['visit_index'] . '% vs bulan lalu',
                    'icon' => 'arrow-up',
                    'color' => 'success',
                    'priority' => 'low',
                    'suggestions' => [
                        'Siapkan kapasitas tambahan jika perlu',
                        'Pertahankan strategi marketing saat ini',
                        'Catat best practices yang berhasil'
                    ]
                ];
            }

            // AI Analysis 3: Capacity Management
            $recommendations[] = [
                'title' => 'Manajemen Kapasitas',
                'description' => 'Jam sibuk: ' . $data['peak_hours'],
                'icon' => 'clock',
                'color' => 'info',
                'priority' => 'medium',
                'suggestions' => [
                    'Pertimbangkan perluasan ruang di jam ' . $data['peak_hours'],
                    'Terapkan sistem booking untuk peak hours',
                    'Buat promosi untuk jam sepi (diskon 10-15%)',
                    'Monitor kapasitas secara real-time'
                ]
            ];

            // AI Analysis 4: Social Media Strategy
            $recommendations[] = [
                'title' => 'Strategi Instagram',
                'description' => 'Optimasi posting berdasarkan engagement data',
                'icon' => 'instagram',
                'color' => 'danger',
                'priority' => 'medium',
                'suggestions' => [
                    'Post optimal: Senin-Jumat 11:00-13:00',
                    'Post optimal: Senin-Jumat 19:00-21:00',
                    'Weekend: 10:00-11:00 & 20:00-22:00',
                    'Stories: 16:00-18:00 (prime time)',
                    'Gunakan hashtag lokal & niche coworking'
                ]
            ];

            // AI Analysis 5: Member Segmentation
            if (!empty($data['activity_distribution'])) {
                $topSegment = collect($data['activity_distribution'])->sortByDesc('percentage')->first();
                
                if ($topSegment && $topSegment['percentage'] > 50) {
                    $recommendations[] = [
                        'title' => 'Segmen Dominan: ' . $topSegment['type'],
                        'description' => 'Mayoritas member (' . $topSegment['percentage'] . '%) adalah ' . $topSegment['type'],
                        'icon' => 'users-cog',
                        'color' => 'primary',
                        'priority' => 'medium',
                        'suggestions' => [
                            'Fokuskan fasilitas untuk segmen ' . $topSegment['type'],
                            'Buat event khusus untuk segmen ini',
                            'Survey kebutuhan spesifik mereka',
                            'Pertimbangkan paket khusus'
                        ]
                    ];
                }
            }

            // AI Analysis 6: Operational Tasks
            $recommendations[] = [
                'title' => 'Tugas Operasional Harian',
                'description' => 'Checklist optimasi pelayanan',
                'icon' => 'tasks',
                'color' => 'primary',
                'priority' => 'high',
                'suggestions' => [
                    'Periksa kebersihan area kerja: 09:00, 13:00, 17:00',
                    'Pastikan WiFi stabil & speed test',
                    'Cek AC & suhu ruangan (21-24°C)',
                    'Restock supplies: coffee, tissue, sanitizer',
                    'Follow-up pending reservations'
                ]
            ];

            // AI Analysis 7: Member Engagement
            $inactiveMembers = DataMember::whereDoesntHave('attendances', function($query) {
                $query->where('check_in', '>=', Carbon::now()->subDays(30));
            })->count();

            if ($inactiveMembers > 0) {
                $recommendations[] = [
                    'title' => 'Member Tidak Aktif',
                    'description' => $inactiveMembers . ' member tidak berkunjung 30+ hari',
                    'icon' => 'user-times',
                    'color' => 'warning',
                    'priority' => 'high',
                    'suggestions' => [
                        'Kirim email "We miss you" dengan special offer',
                        'Telpon personal untuk tanya feedback',
                        'Tawarkan 1 hari gratis comeback',
                        'Survey alasan tidak aktif'
                    ]
                ];
            }

            // Sort by priority
            usort($recommendations, function($a, $b) {
                $priority = ['high' => 1, 'medium' => 2, 'low' => 3];
                return $priority[$a['priority']] <=> $priority[$b['priority']];
            });

        } catch (\Exception $e) {
            \Log::error('AI Recommendations Error: ' . $e->getMessage());
        }

        return $recommendations;
    }

    /**
     * Format minutes to HH:MM
     */
    private function formatMinutesToTime($minutes)
    {
        $hours = floor($minutes / 60);
        $mins = $minutes % 60;
        return sprintf('%02d:%02d', $hours, $mins);
    }
}