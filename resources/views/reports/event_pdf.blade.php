<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Event</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 25px 30px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
        }

        thead {
            display: table-header-group;
        }

        tr {
            page-break-inside: avoid;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            white-space: nowrap;
        }

        th {
            background: #acacac;
            text-align: center;
            font-size: 10px;
        }

        td {
            font-size: 9.5px;
        }

        h3 {
            margin-top: 14px;
            margin-bottom: 4px;
            font-size: 12px;
        }

        .header-table td {
            border: none;
            padding: 2px;
        }

        .logo-kiri {
            width: 60px;
        }

        .logo-kanan {
            width: 85px;
        }

        .title {
            text-align: center;
            line-height: 1.25;
        }

        .judul {
            margin-top: 12px;
            margin-bottom: 14px;
        }

        .center {
            text-align: center;
        }

        .page-break {
            page-break-before: always;
        }

        footer {
            position: fixed;
            bottom: -10px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
        }

        .periode-info {
            text-align: center;
            font-size: 11px;
            margin-bottom: 10px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    {{-- ================= HEADER ================= --}}
    <table class="header-table">
        <tr>
            <td width="15%">
                <img src="gambar/logo_coworking.png" class="logo-kiri">
            </td>

            <td width="70%" class="title">
                <span style="font-size:15px; font-weight:bold;">
                    DINAS KOPERASI, UKM & PERDAGANGAN<br>
                    TRASA COWORKING SPACE
                </span>
            </td>

            <td width="15%" align="right">
                <img src="gambar/logo_dinas.jpeg" class="logo-kanan">
            </td>
        </tr>
    </table>

    <hr>

    <span style="font-size:14px; font-weight:bold; text-align:center; display:block;" class="judul">
        LAPORAN EVENT
    </span>

    {{-- ================= INFO PERIODE ================= --}}
    @if(isset($startDate) && isset($endDate))
    <div class="periode-info">
        Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
    </div>
    @endif

    {{-- ================= RINGKASAN STATISTIK ================= --}}
    <h3>Ringkasan Statistik Event</h3>

    <table>
        <tr>
            <th width="60%">Jenis Statistik</th>
            <th width="40%">Jumlah</th>
        </tr>
        <tr>
            <td>Total Events (Filtered)</td>
            <td class="center">{{ $statistics['total_events'] ?? 0 }}</td>
        </tr>
        <tr>
            <td>Active Events</td>
            <td class="center">{{ $statistics['active_events'] ?? 0 }}</td>
        </tr>
        <tr>
            <td>Inactive Events</td>
            <td class="center">{{ $statistics['inactive_events'] ?? 0 }}</td>
        </tr>
        <tr>
            <td>Upcoming Events (Akan Datang)</td>
            <td class="center">{{ $statistics['upcoming_events'] ?? 0 }}</td>
        </tr>
        <tr>
            <td>Ongoing Events (Sedang Berlangsung)</td>
            <td class="center">{{ $statistics['ongoing_events'] ?? 0 }}</td>
        </tr>
        <tr>
            <td>Completed Events (Selesai)</td>
            <td class="center">{{ $statistics['completed_events'] ?? 0 }}</td>
        </tr>
        <tr>
            <td><strong>All Events (Total Semua)</strong></td>
            <td class="center"><strong>{{ $statistics['all_events_total'] ?? 0 }}</strong></td>
        </tr>
    </table>

    {{-- ================= STATISTIK STATUS ================= --}}
    <h3>Distribusi Berdasarkan Status</h3>

    <table>
        <tr>
            <th width="70%">Status Event</th>
            <th width="30%">Jumlah</th>
        </tr>
        @php
            $statusCounts = [];
            foreach ($events as $event) {
                $status = $event->status ?? 'unknown';
                $statusCounts[$status] = isset($statusCounts[$status]) ? $statusCounts[$status] + 1 : 1;
            }
        @endphp
        @foreach($statusCounts as $statusName => $count)
        <tr>
            <td>{{ ucfirst($statusName) }}</td>
            <td class="center">{{ $count }}</td>
        </tr>
        @endforeach
    </table>

    {{-- ================= PINDAH HALAMAN UNTUK DETAIL ================= --}}
    <div class="page-break"></div>

    {{-- ================= DETAIL EVENT ================= --}}
    <h3>Detail Event</h3>

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="18%">Judul Event</th>
                <th width="20%">Deskripsi</th>
                <th width="12%">Tanggal Mulai</th>
                <th width="12%">Tanggal Selesai</th>
                <th width="8%">Durasi (hari)</th>
                <th width="10%">Status</th>
                <th width="16%">Tanggal Dibuat</th>
            </tr>
        </thead>

        <tbody>
            @forelse($events as $i => $event)
            <tr>
                <td class="center">{{ $i + 1 }}</td>
                <td>{{ $event->title }}</td>
                <td>{{ $event->description ?: '-' }}</td>
                <td class="center">
                    {{ $event->start_date ? \Carbon\Carbon::parse($event->start_date)->format('d-m-Y') : '-' }}
                </td>
                <td class="center">
                    {{ $event->end_date ? \Carbon\Carbon::parse($event->end_date)->format('d-m-Y') : '-' }}
                </td>
                <td class="center">
                    @if($event->start_date && $event->end_date)
                        {{ \Carbon\Carbon::parse($event->start_date)->diffInDays(\Carbon\Carbon::parse($event->end_date)) + 1 }} hari
                    @else
                        -
                    @endif
                </td>
                <td class="center">{{ $event->status }}</td>
                <td class="center">
                    {{ $event->created_at ? \Carbon\Carbon::parse($event->created_at)->format('d-m-Y') : '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="center">Tidak ada data event</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ================= RINGKASAN EVENT PER BULAN ================= --}}
    @if(count($events) > 0)
    <div class="page-break"></div>

    <h3>Ringkasan Event Per Bulan</h3>

    @php
        $monthlySummary = [];
        
        // Hitung event per bulan
        foreach ($events as $event) {
            if ($event->start_date) {
                $yearMonth = \Carbon\Carbon::parse($event->start_date)->format('Y-m');
                if (!isset($monthlySummary[$yearMonth])) {
                    $monthlySummary[$yearMonth] = [
                        'year' => \Carbon\Carbon::parse($event->start_date)->format('Y'),
                        'month' => \Carbon\Carbon::parse($event->start_date)->format('m'),
                        'count' => 0
                    ];
                }
                $monthlySummary[$yearMonth]['count']++;
            }
        }
        
        // Urutkan berdasarkan bulan terbaru
        krsort($monthlySummary);
    @endphp

    <table>
        <tr>
            <th width="10%">No</th>
            <th width="60%">Bulan - Tahun</th>
            <th width="30%">Jumlah Event</th>
        </tr>
        @php $no = 1; @endphp
        @foreach($monthlySummary as $summary)
        <tr>
            <td class="center">{{ $no++ }}</td>
            <td>
                {{ \Carbon\Carbon::create($summary['year'], $summary['month'], 1)->translatedFormat('F Y') }}
            </td>
            <td class="center">{{ $summary['count'] }}</td>
        </tr>
        @endforeach
    </table>
    @endif

    <footer>
        Dikelola oleh Trasa Coworking Space © {{ date('Y') }}
    </footer>

</body>
</html>