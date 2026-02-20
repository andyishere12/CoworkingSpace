<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Reservasi</title>

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

        footer {
            position: fixed;
            bottom: -10px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
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
        LAPORAN RESERVASI
    </span>

    {{-- ================= RINGKASAN ================= --}}
    <h3>Ringkasan Reservasi</h3>

    <table>
        <tr>
            <th>Total Reservasi</th>
            <th>Pending</th>
            <th>Approved</th>
            <th>Rejected</th>
        </tr>
        <tr class="center">
            <td>{{ $totalReservasi }}</td>
            <td>{{ $pending }}</td>
            <td>{{ $approved }}</td>
            <td>{{ $rejected }}</td>
        </tr>
    </table>

    {{-- ================= STATISTIK RUANGAN ================= --}}
    <h3>Statistik Ruangan</h3>

    <table>
        <tr>
            <th width="70%">Ruangan</th>
            <th width="30%">Jumlah Reservasi</th>
        </tr>
        @foreach ($ruanganStats as $ruangan)
        <tr>
            <td>{{ $ruangan->ruangan ?? '-' }}</td>
            <td class="center">{{ $ruangan->jumlah }}</td>
        </tr>
        @endforeach
    </table>

    {{-- ================= STATISTIK STATUS ================= --}}
    <h3>Statistik Status</h3>

    <table>
        <tr>
            <th width="70%">Status</th>
            <th width="30%">Jumlah</th>
        </tr>
        @foreach ($statusStats as $status)
        <tr>
            <td>{{ $status->status ?? '-' }}</td>
            <td class="center">{{ $status->jumlah }}</td>
        </tr>
        @endforeach
    </table>

    {{-- ================= DETAIL RESERVASI ================= --}}
    <h3>Detail Reservasi</h3>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="12%">Nama Member</th>
                <th width="12%">Ruangan</th>
                <th width="10%">Tanggal</th>
                <th width="8%">Jam Mulai</th>
                <th width="8%">Jam Selesai</th>
                <th width="10%">Status</th>
                <th width="12%">Keterangan</th>
                <th width="10%">Tanggal Daftar</th>
            </tr>
        </thead>

        <tbody>
            @forelse($reservasi as $i => $res)
            <tr>
                <td class="center">{{ $i + 1 }}</td>
                <td>{{ $res->nama_member ?? '-' }}</td>
                <td>{{ $res->ruangan ?? '-' }}</td>
                <td class="center">
                    {{ $res->tanggal ? \Carbon\Carbon::parse($res->tanggal)->format('d-m-Y') : '-' }}
                </td>
                <td class="center">{{ $res->jam_mulai ?? '-' }}</td>
                <td class="center">{{ $res->jam_selesai ?? '-' }}</td>
                <td class="center">{{ $res->status ?? '-' }}</td>
                <td>{{ $res->keterangan ?? '-' }}</td>
                <td class="center">
                    {{ $res->created_at ? \Carbon\Carbon::parse($res->created_at)->format('d-m-Y') : '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="center">Tidak ada data reservasi</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <footer>
        Dikelola oleh Trasa Coworking Space © {{ date('Y') }}
    </footer>

</body>

</html>
