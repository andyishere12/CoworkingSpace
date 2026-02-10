<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Ruangan</title>

    <style>
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
            bottom: -20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
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
                <span style="font-size:18px; font-weight:bold;">
                    <b>DINAS KOPERASI, UKM & PERDAGANGAN</b><br>
                    <b>TRASA COWORKING SPACE</b>
                </span>
            </td>

            <td width="15%" align="right">
                <img src="{{ public_path('gambar/logo_dinas.jpeg') }}" class="logo-kanan">
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
        <span>Dikelola oleh Trasa Coworking Space &copy; {{ date('Y') }}</span>
    </footer>

</body>

</html>