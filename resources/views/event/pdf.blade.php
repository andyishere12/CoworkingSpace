<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Event</title>

    <style>
        /* preserve colours when printing in browser */
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }

        /* always landscape A4 for preview and PDF file */
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
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            white-space: nowrap;

        }

        th {
            background: #acacac;
            text-align: center;
        }

        .header-table td {
            border: none;
        }

        .logo-kiri {
            width: 70px;
            height: auto;
        }

        .logo-kanan {
            width: 100px;
            height: 60px;
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

            <td width="70%" class="title">
                <span style="font-size:18px; font-weight:bold;">
                    <b>DINAS KOPERASI, UKM & PERDAGANGAN</b><br>
                    <b>TRASA COWORKING SPACE</b>
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
                    DATA EVENT
                </span>
            </td>

            <td width="50%" align="right" style="font-size:10px;">
                Dicetak: {{ now()->format('d-m-Y') }} |
                Total: {{ count($events) }} Data
            </td>
        </tr>
    </table>

    {{-- TABLE --}}
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="30%">Nama Event</th>
                <th width="25%">Keterangan</th>
                <th width="15%">Tanggal Mulai</th>
                <th width="15%">Tanggal Selesai</th>
                <th width="10%">Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach($events as $i => $row)
            <tr>
                <td align="center">{{ $i + 1 }}</td>
                <td>{{ $row->title }}</td>
                <td>{{ $row->description }}</td>
                <td align="center">{{ \Carbon\Carbon::parse($row->start_date)->format('d-m-Y') }}</td>
                <td align="center">{{ \Carbon\Carbon::parse($row->end_date)->format('d-m-Y') }}</td>
                <td align="center">{{ $row->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <footer>
        <span>Dikelola oleh Trasa Coworking Space &copy; {{ date('Y') }}</span>
    </footer>

</body>

</html>