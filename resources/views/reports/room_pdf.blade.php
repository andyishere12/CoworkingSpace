<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Ruangan</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 20px 15px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            line-height: 1.2;
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
        }

        th,
        td {
            border: 1px solid #000;
            padding: 3px;
            word-wrap: break-word;
        }

        th {
            background: #e0e0e0;
            text-align: center;
            font-size: 9px;
            font-weight: bold;
        }

        td {
            font-size: 8.5px;
        }

        h3 {
            margin-top: 10px;
            margin-bottom: 3px;
            font-size: 11px;
            font-weight: bold;
            color: #333;
        }

        .header-table td {
            border: none;
            padding: 1px;
        }

        .logo-kiri {
            width: 55px;
        }

        .logo-kanan {
            width: 80px;
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

        footer {
            position: fixed;
            bottom: -15px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
            color: #666;
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
                <img src="{{ public_path('gambar/logo_coworking.png') }}" class="logo-kiri">
            </td>

            <td width="70%" class="title">
                <span style="font-size:14px; font-weight:bold;">
                    DINAS KOPERASI, UKM & PERDAGANGAN<br>
                    TRASA COWORKING SPACE
                </span>
            </td>

            <td width="15%" align="right">
                <img src="{{ public_path('gambar/logo_dinas.jpeg') }}" class="logo-kanan">
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
        Dikelola oleh Trasa Coworking Space © {{ date('Y') }}
    </footer>

</body>

</html>