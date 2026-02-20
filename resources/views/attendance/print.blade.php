<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        @page {
            size: A4 landscape;
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

        th, td {
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

        .period {
            text-align: center;
            font-size: 11px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    {{-- HEADER dengan logo --}}
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

    <div style="font-size:14px; font-weight:bold; text-align:center;" class="judul">
        LAPORAN KEHADIRAN
    </div>

    <div class="period">
        Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
    </div>

    {{-- TABEL DATA KEHADIRAN --}}
    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="15%">Nama Member</th>
                <th width="8%">Tipe</th>
                <th width="10%">Tanggal</th>
                <th width="8%">Check In</th>
                <th width="8%">Check Out</th>
                <th width="8%">Durasi</th>
                <th width="8%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $attendance)
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>{{ $attendance->member->nama ?? '-' }}</td>
                <td class="center">{{ $attendance->member->type ?? '-' }}</td>
                <td class="center">{{ \Carbon\Carbon::parse($attendance->tanggal)->format('d-m-Y') }}</td>
                <td class="center">{{ $attendance->waktu_masuk }}</td>
                <td class="center">{{ $attendance->waktu_keluar ?? '-' }}</td>
                <td class="center">{{ $attendance->formatted_durasi }}</td>
                <td class="center">
                    @if($attendance->waktu_keluar)
                        Selesai
                    @else
                        Aktif
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="center">Tidak ada data kehadiran</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <footer>
        Dikelola oleh Trasa Coworking Space © {{ date('Y') }}
    </footer>

</body>
</html>