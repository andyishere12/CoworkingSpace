<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Event</title>

    <style>
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }

        @page {
            size: A4 portrait;
            margin: 25px 30px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                background: white !important;
            }
            
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            img {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                max-width: 100%;
            }
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            background: white;
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
            border: 1px solid #000 !important;
        }

        th,
        td {
            border: 1px solid #000 !important;
            padding: 4px;
            white-space: nowrap;
        }

        th {
            background: #acacac !important;
            color: #000 !important;
            text-align: center !important;
            font-size: 10px;
            font-weight: bold !important;
        }

        td {
            font-size: 9.5px;
            background: white !important;
            color: #000 !important;
        }

        h3 {
            margin-top: 14px;
            margin-bottom: 4px;
            font-size: 12px;
            font-weight: bold;
            color: #333 !important;
        }

        .header-table td {
            border: none !important;
            padding: 2px !important;
            background: white !important;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            border: none !important;
            border-spacing: 0 !important;
        }

        .logo-kiri {
            width: 60px;
            height: auto;
            border: none !important;
        }

        .logo-kanan {
            width: 85px;
            height: auto;
            border: none !important;
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

        hr {
            border: none !important;
            border-top: 1px solid #333 !important;
            margin: 8px 0 !important;
            padding: 0 !important;
        }

        /* footer at bottom of every page, same as member report */
        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            height: 20px;
            line-height: 20px;
            background-color: white;
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
                @if(isset($isPdf) && $isPdf)
                    <img src="{{ public_path('gambar/logo_coworking.png') }}" class="logo-kiri" style="max-width: 60px; height: auto;">
                @else
                    <img src="{{ asset('gambar/logo_coworking.png') }}" class="logo-kiri" style="max-width: 60px; height: auto;">
                @endif
            </td>

            <td width="70%" class="title">
                <span style="font-size:15px; font-weight:bold;">
                    DINAS KOPERASI, UKM & PERDAGANGAN<br>
                    TRASA COWORKING SPACE
                </span>
            </td>

            <td width="15%" align="right">
                @if(isset($isPdf) && $isPdf)
                    <img src="{{ public_path('gambar/logo_dinas.jpeg') }}" class="logo-kanan" style="max-width: 85px; height: auto;">
                @else
                    <img src="{{ asset('gambar/logo_dinas.jpeg') }}" class="logo-kanan" style="max-width: 85px; height: auto;">
                @endif
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