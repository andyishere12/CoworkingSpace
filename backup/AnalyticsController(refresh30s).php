

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\DataMember;
use App\Models\Attendance;
use App\Models\Reservasi;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        try {
            $peakHours = $this->getPeakHours();
            $retentionRate = $this->getRetentionRate();
            $avgDuration = $this->getAverageDuration();
            $visitIndexChange = $this->getVisitIndexChange();
            $activityDistribution = $this->getMemberActivityDistribution();
            $monthlyTrend = $this->getMonthlyTrendData();

            // AI-Powered Recommendations (Gemini FREE!)
            $recommendations = $this->generateGeminiRecommendations([
                'peak_hours' => $peakHours,
                'retention_rate' => $retentionRate,
                'avg_duration' => $avgDuration,
                'visit_index' => $visitIndexChange,
                'activity_distribution' => $activityDistribution,
                'monthly_trend' => $monthlyTrend,
                'total_members' => DataMember::count(),
                'active_today' => DB::table('hadir')
                    ->whereDate('tanggal', today())
                    ->whereNull('waktu_keluar')
                    ->count(),
            ]);

            $avgDurationFormatted = $this->formatMinutesToTime($avgDuration);

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
            \Log::error('Analytics Error: ' . $e->getMessage());
            return view('manager.analytics', $this->getDefaultData());
        }
    }

    /**
     *  GEMINI AI (FREE!) using Laravel HTTP Client
     */
    private function generateGeminiRecommendations($data)
    {
        $maxRetries = 2;
        $timeout = 30; // Increased from 10 to 30 seconds
        
        for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
            try {
                $apiKey = config('services.gemini.api_key');
                
                if (!$apiKey) {
                    \Log::warning('Gemini API key not set, using rule-based');
                    return $this->fallbackRuleBasedRecommendations($data);
                }

                $prompt = $this->buildGeminiPrompt($data);

                \Log::info("Gemini API attempt {$attempt}/{$maxRetries} (timeout: {$timeout}s)");

                $response = Http::timeout($timeout)->post(
                    'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-lite:generateContent?key=' . $apiKey,
                    [
                        'contents' => [
                            [
                                'parts' => [
                                    ['text' => $prompt]
                                ]
                            ]
                        ],
                        'generationConfig' => [
                            'temperature' => 0.7,
                            'maxOutputTokens' => 2000,
                        ]
                    ]
                );

                if ($response->successful()) {
                    $result = $response->json();
                    $aiText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';
                    
                    $recommendations = $this->parseGeminiResponse($aiText);
                    
                    if (!empty($recommendations)) {
                        \Log::info("✅ Gemini AI success on attempt {$attempt}");
                        return $recommendations;
                    }
                }

                \Log::warning("Gemini API response invalid on attempt {$attempt}");
                
                if ($attempt < $maxRetries) {
                    sleep(2); // Wait before retry
                    continue;
                }

            } catch (\Exception $e) {
                \Log::error("Gemini API Error (attempt {$attempt}/{$maxRetries}): " . $e->getMessage());
                
                if ($attempt < $maxRetries) {
                    sleep(2);
                    continue;
                }
            }
        }
        
        \Log::warning('Gemini API failed after all retries, falling back to rule-based');
        return $this->fallbackRuleBasedRecommendations($data);
    }

    private function buildGeminiPrompt($data)
    {
        return "Kamu adalah expert business analyst untuk coworking space di Indonesia. 
Analisis data berikut dan berikan 4-6 rekomendasi strategis.

**Data:**
- Jam Sibuk: {$data['peak_hours']}
- Retensi: {$data['retention_rate']}%
- Durasi Avg: {$data['avg_duration']} menit  
- Growth: {$data['visit_index']}%
- Total Member: {$data['total_members']}
- Aktif Hari Ini: {$data['active_today']}

**Distribusi:** " . json_encode($data['activity_distribution']) . "
**Tren:** " . json_encode($data['monthly_trend']) . "

**CRITICAL: Output ONLY valid JSON array. Start with [ and end with ]. NO markdown, NO code blocks, NO explanation before or after.**

Format:
[
  {
    \"title\": \"Judul Singkat\",
    \"description\": \"Penjelasan\",
    \"icon\": \"users\",
    \"color\": \"danger\",
    \"priority\": \"high\",
    \"suggestions\": [\"Action 1\", \"Action 2\", \"Action 3\"]
  }
]

Icons: users/chart-line/clock/calendar/tasks/user-times/check-circle/arrow-up/instagram
Colors: danger/warning/info/success/primary
Priority: high/medium/low
Language: Bahasa Indonesia
Focus: retention, capacity, revenue, engagement";
    }

    private function parseGeminiResponse($text)
    {
        // Aggressive markdown removal
        $cleaned = $text;
        $cleaned = preg_replace('/^```(?:json)?\s*/m', '', $cleaned);
        $cleaned = preg_replace('/\s*```\s*$/m', '', $cleaned);
        $cleaned = str_replace('```', '', $cleaned);
        $cleaned = trim($cleaned);
        
        // Extract JSON array if embedded in text
        if (preg_match('/\[.*\]/s', $cleaned, $matches)) {
            $cleaned = $matches[0];
        }
        
        \Log::info('=== GEMINI PARSING ===');
        \Log::info('Original length: ' . strlen($text));
        \Log::info('Cleaned: ' . substr($cleaned, 0, 200));
        
        $recommendations = json_decode($cleaned, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            \Log::error('JSON Error: ' . json_last_error_msg());
            \Log::error('Text sample: ' . substr($cleaned, 0, 500));
            return [];
        }

        if (is_array($recommendations) && !empty($recommendations)) {
            $valid = [];
            
            // Icon mapping for common AI responses
            $iconMap = [
                'moon' => 'clock',
                'lock' => 'user-times',
                'shield' => 'check-circle',
                'bell' => 'calendar',
                'star' => 'check-circle',
                'heart' => 'users',
                'settings' => 'tasks',
                'chart' => 'chart-line',
                'trophy' => 'check-circle',
                'lightbulb' => 'tasks',
            ];
            
            // Priority mapping
            $priorityMap = [
                'critical' => 'high',
                'urgent' => 'high',
                'important' => 'medium',
                'normal' => 'medium',
                'optional' => 'low',
            ];
            
            foreach ($recommendations as $rec) {
                if (isset($rec['title']) && isset($rec['suggestions']) && is_array($rec['suggestions'])) {
                    
                    // Map icon to available ones
                    $icon = $rec['icon'] ?? 'info-circle';
                    $rec['icon'] = $iconMap[$icon] ?? $icon;
                    
                    // Map priority
                    $priority = $rec['priority'] ?? 'medium';
                    $rec['priority'] = $priorityMap[$priority] ?? $priority;
                    
                    // Ensure valid priority
                    if (!in_array($rec['priority'], ['high', 'medium', 'low'])) {
                        $rec['priority'] = 'medium';
                    }
                    
                    // Set defaults
                    $rec['color'] = $rec['color'] ?? 'info';
                    $rec['description'] = $rec['description'] ?? '';
                    
                    $valid[] = $rec;
                }
            }
            
            \Log::info('✅ Parsed ' . count($valid) . ' valid recommendations');
            return $valid;
        }

        \Log::warning('⚠️ Array empty or invalid');
        return [];
    }

    private function fallbackRuleBasedRecommendations($data)
    {
        $recommendations = [];

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
        } elseif ($data['retention_rate'] >= 70) {
            $recommendations[] = [
                'title' => 'Retensi Member Excellent!',
                'description' => 'Tingkat retensi sangat baik: ' . $data['retention_rate'] . '%',
                'icon' => 'check-circle',
                'color' => 'success',
                'priority' => 'low',
                'suggestions' => [
                    'Pertahankan kualitas layanan saat ini',
                    'Minta testimoni dari member loyal',
                    'Buat referral program untuk member baru',
                ]
            ];
        }

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
        } elseif ($data['visit_index'] > 10) {
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

        $inactiveMembers = DB::table('data_members')
            ->whereNotExists(function ($query) {
                $thirtyDaysAgo = Carbon::now()->subDays(30)->format('Y-m-d');
                $query->select(DB::raw(1))
                    ->from('hadir')
                    ->whereColumn('hadir.member_id', 'data_members.id')
                    ->where('hadir.tanggal', '>=', $thirtyDaysAgo);
            })
            ->count();

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

        usort($recommendations, function($a, $b) {
            $priority = ['high' => 1, 'medium' => 2, 'low' => 3];
            return $priority[$a['priority']] <=> $priority[$b['priority']];
        });

        return $recommendations;
    }

    private function getPeakHours()
    {
        try {
            $peakData = DB::table('hadir')
                ->selectRaw('HOUR(waktu_masuk) as hour, COUNT(*) as count')
                ->whereMonth('tanggal', date('m'))
                ->whereYear('tanggal', date('Y'))
                ->whereNotNull('waktu_masuk')
                ->groupBy(DB::raw('HOUR(waktu_masuk)'))
                ->orderByDesc('count')
                ->first();

            return $peakData ? sprintf('%02d:00', $peakData->hour) : '09:00';
        } catch (\Exception $e) {
            return '09:00';
        }
    }

    private function getRetentionRate()
    {
        try {
            $thirtyDaysAgo = Carbon::now()->subDays(30)->format('Y-m-d');
            $totalMembers = DataMember::count();
            
            if ($totalMembers == 0) return 0;

            $membersWithVisits = DB::table('hadir')
                ->where('tanggal', '>=', $thirtyDaysAgo)
                ->distinct('member_id')
                ->count('member_id');
            
            return round(($membersWithVisits / $totalMembers) * 100, 1);
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getAverageDuration()
    {
        try {
            $avgDurasi = DB::table('hadir')
                ->whereMonth('tanggal', date('m'))
                ->whereYear('tanggal', date('Y'))
                ->whereNotNull('durasi')
                ->avg('durasi');

            return round($avgDurasi ?? 0);
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getVisitIndexChange()
    {
        try {
            $currentMonth = date('m');
            $currentYear = date('Y');
            
            $thisMonthVisits = DB::table('hadir')
                ->whereMonth('tanggal', $currentMonth)
                ->whereYear('tanggal', $currentYear)
                ->count();
            
            $lastMonth = Carbon::now()->subMonth();
            $lastMonthVisits = DB::table('hadir')
                ->whereMonth('tanggal', $lastMonth->month)
                ->whereYear('tanggal', $lastMonth->year)
                ->count();
            
            if ($lastMonthVisits == 0) {
                return $thisMonthVisits > 0 ? 100 : 0;
            }

            return round((($thisMonthVisits - $lastMonthVisits) / $lastMonthVisits) * 100, 1);
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getMemberActivityDistribution()
    {
        try {
            $distribution = DataMember::select('aktivitas', DB::raw('count(*) as total'))
                ->groupBy('aktivitas')
                ->get();

            $totalMembers = DataMember::count();
            if ($totalMembers == 0) return [];

            $result = [];
            foreach ($distribution as $item) {
                $percentage = round(($item->total / $totalMembers) * 100, 1);
                $result[] = [
                    'type' => $item->aktivitas ?? 'Unknown',
                    'total' => $item->total,
                    'percentage' => $percentage,
                ];
            }
            return $result;
        } catch (\Exception $e) {
            return [];
        }
    }

    private function getMonthlyTrendData()
    {
        try {
            $currentYear = Carbon::now()->year;
            $monthlyData = [];

            for ($month = 1; $month <= 12; $month++) {
                $visits = DB::table('hadir')
                    ->whereMonth('tanggal', $month)
                    ->whereYear('tanggal', $currentYear)
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

    private function formatMinutesToTime($minutes)
    {
        $hours = floor($minutes / 60);
        $mins = $minutes % 60;
        return sprintf('%02d:%02d', $hours, $mins);
    }

    private function getDefaultData()
    {
        return [
            'peakHours' => '09:00',
            'retentionRate' => 0,
            'avgDurationFormatted' => '00:00',
            'visitIndexChange' => 0,
            'activityDistribution' => [],
            'monthlyTrend' => [],
            'recommendations' => [[
                'title' => 'System Info',
                'description' => 'Belum ada data cukup',
                'icon' => 'info-circle',
                'color' => 'info',
                'priority' => 'low',
                'suggestions' => ['Mulai tracking attendance']
            ]]
        ];
    }
}