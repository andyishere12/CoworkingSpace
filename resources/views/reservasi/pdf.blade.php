<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Reservasi</title>

    <style>
        /* print-friendly and landscape */
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }

        @page {
            size: A4 landscape;
            margin: 30px;
        }

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
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 3px;
            white-space: normal;
            word-wrap: break-word;
            line-height: 1.3;
            overflow-wrap: anywhere;
        }

        th {
            background: #acacac;
            text-align: center;
            font-weight: bold;
            font-size: 8.5px;
        }

        td {
            font-size: 8px;
        }

        .header-table td {
            border: none;
            padding: 2px;
        
            vertical-align: top;
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

        img {
            max-width: 100%;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .title {
            text-align: center;
            line-height: 1.3;
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
    </style>
</head>

<body>

    {{-- HEADER --}}
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
        Dikelola oleh Trasa Coworking Space &copy; 2026
    </footer>

</body>

</html>








