<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Ruangan</title>

    <style>
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }

        @page {
            size: A4 portrait;
            margin: 20px 15px;
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
            font-size: 9px;
            line-height: 1.2;
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
            margin-top: 4px;
            table-layout: fixed;
            border: 1px solid #000 !important;
        }

        th,
        td {
            border: 1px solid #000 !important;
            padding: 3px;
            word-wrap: break-word;
        }

        th {
            background: #acacac !important; /* match member/event reports */
            color: #000 !important;
            text-align: center !important;
            font-size: 9px;
            font-weight: bold !important;
        }

        td {
            font-size: 8.5px;
            background: white !important;
            color: #000 !important;
        }

        h3 {
            margin-top: 10px;
            margin-bottom: 3px;
            font-size: 11px;
            font-weight: bold;
            color: #333 !important;
        }

        .header-table td {
            border: none !important;
            padding: 1px !important;
            background: white !important;
        
            vertical-align: top;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            border: none !important;
            border-spacing: 0 !important;
        }

        .logo-kiri {
            height: 88px;
            width: auto;
            max-width: 100%;
        }

        .logo-kanan {
            height: 82px;
            width: auto;
            max-width: 100%;
        }

        .title {
            text-align: center;
            line-height: 1.2;
        }

        .judul {
            margin-top: 10px;
            margin-bottom: 12px;
            font-size: 13px;
            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        .left {
            text-align: left;
        }

        .right {
            text-align: right;
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

        /* footer placed at bottom of every page */
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

        .section-spacer {
            height: 15px;
        }

        .wrap-text {
            white-space: normal;
            word-wrap: break-word;
        }

        .small-text {
            font-size: 8px;
        }

        /* Lebar kolom untuk portrait */
        .col-no {
            width: 5%;
        }

        .col-nama {
            width: 18%;
        }

        .col-kapasitas {
            width: 8%;
        }

        .col-tipe {
            width: 12%;
        }

        .col-status {
            width: 12%;
        }

        .col-reservasi {
            width: 10%;
        }

        .col-deskripsi {
            width: 35%;
        }

    </style>
</head>

<body>

    {{-- ================= HEADER ================= --}}
    <table class="header-table">
        <tr>
            <td width="15%">
                @if(isset($isPdf) && $isPdf)
                <img src="{{ public_path('gambar/logo_coworking.png') }}" class="logo-kiri">
                @else
                <img src="{{ asset('gambar/logo_coworking.png') }}" class="logo-kiri">
                @endif
            </td>

            <td width="70%" class="title">
                <span style="display:block; text-align:center; line-height:1.2;">
                    <span style="display:block; font-weight:700; font-size:16px; letter-spacing:0.2px; color:#111827;">DINAS KOPERASI, UKM, DAN PERDAGANGAN</span>
                    <span style="display:block; font-weight:700; font-size:14px; margin-top:2px; color:#1F2937;">TRASA COWORKING SPACE</span>
                    <span style="display:block; font-size:9px; margin-top:4px; line-height:1.35; color:#374151;">Jl. Jenderal Ahmad Yani No. 7, Slawi, Kabupaten Tegal, Jawa Tengah 52411, Indonesia</span>
                    <span style="display:block; font-size:9px; margin-top:2px; line-height:1.35; color:#374151;">Email: coworkingtegal@gmail.com</span>
                </span>
            </td>

            <td width="15%" align="right">
                @if(isset($isPdf) && $isPdf)
                <img src="{{ public_path('gambar/logo_dinas.jpeg') }}" class="logo-kanan">
                @else
                <img src="{{ asset('gambar/logo_dinas.jpeg') }}" class="logo-kanan">
                @endif
            </td>
        </tr>
    </table>

    <hr style="margin: 5px 0; border: 0.5px solid #000;">

    <span style="font-size:13px; font-weight:bold; text-align:center; display:block;" class="judul">
        LAPORAN RUANGAN
    </span>

    {{-- ================= RINGKASAN RUANGAN ================= --}}
    <h3>RINGKASAN RUANGAN</h3>

    <table class="small-text">
        <tr>
            <th class="center" width="33%">Total Ruangan</th>
            <th class="center" width="34%">Ruangan Tersedia</th>
            <th class="center" width="33%">Ruangan Tidak Tersedia</th>
        </tr>
        <tr>
            <td class="center">{{ $totalRooms ?? 0 }}</td>
            <td class="center">{{ $availableRooms ?? 0 }}</td>
            <td class="center">{{ $notAvailableRooms ?? 0 }}</td>
        </tr>
    </table>

    <div class="section-spacer"></div>

    {{-- ================= STATISTIK TIPE RUANGAN ================= --}}
    <h3>STATISTIK TIPE RUANGAN</h3>

    <table class="small-text">
        <tr>
            <th class="center col-no">No</th>
            <th class="center" width="70%">Tipe Ruangan</th>
            <th class="center" width="30%">Jumlah</th>
        </tr>
        @forelse($typeStats ?? [] as $index => $type)
        <tr>
            <td class="center">{{ $index + 1 }}</td>
            <td>{{ $type->type ?? '-' }}</td>
            <td class="center">{{ $type->jumlah ?? 0 }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="3" class="center">Tidak ada data</td>
        </tr>
        @endforelse
    </table>

    <div class="section-spacer"></div>

    {{-- ================= RINGKASAN RESERVASI RUANGAN ================= --}}
    <h3>RINGKASAN RESERVASI RUANGAN</h3>

    <table class="small-text">
        <tr>
            <th class="center col-no">No</th>
            <th class="center" width="40%">Ruangan</th>
            <th class="center" width="25%">Total Reservasi</th>
            <th class="center" width="35%">Status Reservasi Terakhir</th>
        </tr>
        @forelse($reservationSummary ?? [] as $index => $reservation)
        <tr>
            <td class="center">{{ $index + 1 }}</td>
            <td>{{ $reservation->ruangan ?? '-' }}</td>
            <td class="center">{{ $reservation->total_reservasi ?? 0 }}</td>
            <td class="center">{{ $reservation->status_terakhir ?? 'Belum ada' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="center">Tidak ada data reservasi</td>
        </tr>
        @endforelse
    </table>

    <div class="section-spacer"></div>

    {{-- ================= STATISTIK STATUS RESERVASI ================= --}}
    <h3>STATISTIK STATUS RESERVASI</h3>

    <table class="small-text">
        <tr>
            <th class="center col-no">No</th>
            <th class="center" width="70%">Status</th>
            <th class="center" width="30%">Jumlah</th>
        </tr>
        @forelse($statusStats ?? [] as $index => $status)
        <tr>
            <td class="center">{{ $index + 1 }}</td>
            <td>{{ $status->status ?? '-' }}</td>
            <td class="center">{{ $status->jumlah ?? 0 }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="3" class="center">Tidak ada data</td>
        </tr>
        @endforelse
    </table>

    {{-- ================= PINDAH HALAMAN ================= --}}
    <div class="page-break"></div>

    {{-- ================= DETAIL RUANGAN ================= --}}
    <h3>DETAIL RUANGAN</h3>

    <table class="small-text">
        <thead>
            <tr>
                <th class="center col-no">No</th>
                <th class="center col-nama">Nama Ruangan</th>
                <th class="center col-kapasitas">Kapasitas</th>
                <th class="center col-tipe">Tipe</th>
                <th class="center col-status">Status</th>
                <th class="center col-reservasi">Total Reservasi</th>
                <th class="center col-deskripsi">Deskripsi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($rooms ?? [] as $index => $room)
            @php
            $totalReservasi = 0;
            $roomName = $room->name ?? '';

            // **PERBAIKAN DI SINI**: Gunakan array $reservationsCount untuk pencarian
            if (!empty($roomName) && isset($reservationsCount) && is_array($reservationsCount)) {
            $key = strtolower(trim($roomName));
            $totalReservasi = $reservationsCount[$key] ?? 0;
            }
            @endphp
            <tr>
                <td class="center">{{ $index + 1 }}</td>
                <td>{{ $roomName }}</td>
                <td class="center">{{ $room->capacity ?? 0 }}</td>
                <td class="center">{{ $room->type ?? '-' }}</td>
                <td class="center">{{ $room->status ?? '-' }}</td>
                <td class="center">{{ $reservation->total_reservasi ?? 0 }}</td>
                <td class="wrap-text">{{ $room->description ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="center">Tidak ada data ruangan</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ================= FOOTER ================= --}}
    <footer>
        Dikelola oleh Trasa Coworking Space &copy; 2026
    </footer>

</body>

</html>







