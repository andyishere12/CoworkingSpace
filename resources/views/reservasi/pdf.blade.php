<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Reservasi</title>

    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 11px;
            margin: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            font-size: 9px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            white-space: normal;
            word-wrap: break-word;
            line-height: 1.3;
        }

        th {
            background: #acacac;
            text-align: center;
            font-weight: bold;
        }

        .header-table td {
            border: none;
            padding: 2px;
        }

        .logo-kiri {
            width: 65px;
        }

        .logo-kanan {
            width: 90px;
        }

        .title {
            text-align: center;
            line-height: 1.3;
        }

        footer {
            position: fixed;
            bottom: -20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
        }
    </style>
</head>

<body>

    {{-- HEADER --}}
    <table class="header-table">
        <tr>
            <td width="15%">
                <img src="{{ public_path('gambar/logo_coworking.png') }}" class="logo-kiri">
            </td>

            <td width="70%" class="title">
                <span style="font-size:16px; font-weight:bold;">
                    DINAS KOPERASI, UKM & PERDAGANGAN<br>
                    TRASA COWORKING SPACE
                </span>
            </td>

            <td width="15%" align="right">
                <img src="{{ public_path('gambar/logo_dinas.jpeg') }}" class="logo-kanan">
            </td>
        </tr>
    </table>

    <hr style="border:1px solid black;">

    {{-- SUB HEADER --}}
    <table class="header-table" style="margin-top:6px;margin-bottom:6px;">
        <tr>
            <td width="50%" align="left">
                <span style="font-size:13px;font-weight:bold;">DATA RESERVASI</span>
            </td>

            <td width="50%" align="right" style="font-size:9px;">
                Dicetak: {{ now()->format('d-m-Y') }} |
                Total: {{ count($reservasi) }} Data
            </td>
        </tr>
    </table>

    {{-- TABLE --}}
    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="14%">Nama Pemesan</th>
                <th width="8%">No. Kontak</th>
                <th width="13%">Institusi</th>
                <th width="13%">Tujuan</th>
                <th width="13%">Keterangan</th>
                <th width="5%">Peserta</th>
                <th width="7%">Tanggal</th>
                <th width="5%">Mulai</th>
                <th width="5%">Selesai</th>
                <th width="9%">Ruangan</th>
                <th width="5%">Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach($reservasi as $i => $row)
            <tr>
                <td align="center">{{ $i + 1 }}</td>
                <td>{{ $row->nama_pemesanan }}</td>
                <td align="center">{{ $row->kontak }}</td>
                <td>{{ $row->institusi }}</td>
                <td>{{ $row->purpose }}</td>
                <td>{{ $row->description }}</td>
                <td align="center">{{ $row->attends }}</td>
                <td align="center">
                    {{ \Carbon\Carbon::parse($row->tanggal_reservasi)->format('d-m-Y') }}
                </td>
                <td align="center">
                    {{ \Carbon\Carbon::parse($row->waktu_mulai)->format('H:i') }}
                </td>

                <td align="center">
                    {{ \Carbon\Carbon::parse($row->waktu_selesai)->format('H:i') }}
                </td>
                <td align="center">{{ $row->ruangan }}</td>
                <td align="center">{{ $row->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <footer>
        Dikelola oleh Trasa Coworking Space © {{ date('Y') }}
    </footer>

</body>

</html>