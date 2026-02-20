<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Member</title>

    <style>
        /* ensure colors are preserved when printing */
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }

        /* force landscape A4 for both preview and PDF render */
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
                    DATA MEMBER
                </span>
            </td>

            <td width="50%" align="right" style="font-size:10px;">
                Dicetak: {{ now()->format('d-m-Y') }} |
                Total: {{ count($members) }} Data
            </td>
        </tr>
    </table>

    {{-- TABLE --}}
    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="13%">Nama</th>
                <th width="18%">Email</th>
                <th width="10%">Telepon</th>
                <th width="7%">Tipe</th>
                <th width="8%">Aktivitas</th>
                <th width="9%">Institusi</th>
                <th width="10%">Tanggal Lahir</th>
                <th width="16%">Alamat</th>
                <th width="6%">Tanggal Daftar</th>
            </tr>
        </thead>

        <tbody>
            @foreach($members as $i => $row)
            <tr>
                <td align="center">{{ $i + 1 }}</td>
                <td>{{ $row->nama }}</td>
                <td>{{ $row->email }}</td>
                <td align="center">{{ $row->no_hp }}</td>
                <td align="center">{{ $row->type }}</td>
                <td align="center">{{ $row->aktivitas }}</td>
                <td align="center">{{ $row->institusi }}</td>
                <td align="center">
                    {{ $row->tanggal_lahir ? \Carbon\Carbon::parse($row->tanggal_lahir)->format('d-m-Y') : '-' }}
                </td>
                <td>{{ $row->alamat }}</td>
                <td align="center">
                    {{ $row->created_at ? \Carbon\Carbon::parse($row->created_at)->format('d-m-Y') : '-' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <footer>
        <span>Dikelola oleh Trasa Coworking Space &copy; {{ date('Y') }}</span>
    </footer>

</body>

</html>