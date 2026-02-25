<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Ruangan</title>

    <style>
        /* preserve print colours & force landscape */
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
            margin-top: 15px;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
            white-space: normal;
            word-break: break-word;
            overflow-wrap: anywhere;
        }

        th {
            background: #acacac;
            text-align: center;
            font-size: 9px;
        }

        td {
            font-size: 8.8px;
        }

        .header-table td {
            border: none;
        
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
            font-size: 13px;
        }

        .meta {
            font-size: 10px;
            text-align: right;
            margin-top: 10px;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
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

    <hr style="border: 1px solid black;">
    <table class="header-table" style="margin-top:10px; margin-bottom:10px;">
        <tr>
            <td width="50%" align="left">
                <span style="font-size:14px; font-weight:bold;">
                    DATA RUANGAN
                </span>
            </td>

            <td width="50%" align="right" style="font-size:10px;">
                Dicetak: {{ now()->format('d-m-Y') }} |
                Total: {{ count($rooms) }} Data
            </td>
        </tr>
    </table>

    {{-- TABLE --}}
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Nama Ruangan</th>
                <th width="15%">Tipe Ruangan</th>
                <th width="10%">Kapasitas</th>
                <th width="30%">Keterangan</th>
                <th width="15%">Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach($rooms as $i => $row)
            <tr>
                <td align="center">{{ $i + 1 }}</td>
                <td>{{ $row->nama ?? $row->name }}</td>
                <td align="center">{{ $row->type }}</td>
                <td align="center">{{ $row->capacity }}</td>
                <td>{{ $row->keterangan ?? $row->description }}</td>
                <td align="center">{{ $row->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <footer>
        <span>Dikelola oleh Trasa Coworking Space &copy; 2026</span>
    </footer>

</body>

</html>








