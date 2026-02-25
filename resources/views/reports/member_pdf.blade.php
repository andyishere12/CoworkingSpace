<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Member</title>

    <style>
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }

        @page {
            size: A4 portrait;
            margin: 25px 30px 40px 30px;
            
        }

        @top-center, @bottom-center, @top-left, @top-right, @bottom-left, @bottom-right {
                content: none;
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
            margin-bottom: 30px;
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
        
            vertical-align: top;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
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
            /* tinggi footer */
            line-height: 20px;
            /* vertikal tengah */
            background-color: white;
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

    <hr>

    <span style="font-size:14px; font-weight:bold; text-align:center; display:block;" class="judul">
        LAPORAN MEMBER
    </span>

    {{-- ================= RINGKASAN ================= --}}
    <h3>Ringkasan Member</h3>

    <table>
        <tr>
            <th>Total Member</th>
            <th>Member Aktif</th>
            <th>Member Tidak Aktif</th>
        </tr>
        <tr class="center">
            <td>{{ $totalMember }}</td>
            <td>{{ $aktif }}</td>
            <td>{{ $nonAktif }}</td>
        </tr>
    </table>

    {{-- ================= TIPE ================= --}}
    <h3>Tipe Member</h3>

    <table>
        <tr>
            <th width="70%">Tipe Member</th>
            <th width="30%">Jumlah</th>
        </tr>
        @foreach ($tipeMember as $t)
        <tr>
            <td>{{ $t->type ?? '-' }}</td>
            <td class="center">{{ $t->jumlah }}</td>
        </tr>
        @endforeach
    </table>

    {{-- ================= AKTIVITAS ================= --}}
    <h3>Aktivitas Member</h3>

    <table>
        <tr>
            <th width="70%">Aktivitas</th>
            <th width="30%">Jumlah</th>
        </tr>
        @foreach ($aktivitasMember as $a)
        <tr>
            <td>{{ $a->aktivitas ?? '-' }}</td>
            <td class="center">{{ $a->jumlah }}</td>
        </tr>
        @endforeach
    </table>

    {{-- ================= PINDAH HALAMAN ================= --}}
    <div class="page-break"></div>

    {{-- ================= DETAIL ================= --}}
    <h3>Detail Member</h3>

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
                <td class="center">{{ $i+1 }}</td>
                <td>{{ $row->nama }}</td>
                <td>{{ $row->email }}</td>
                <td class="center">{{ $row->no_hp }}</td>
                <td class="center">{{ $row->type }}</td>
                <td class="center">{{ $row->aktivitas }}</td>
                <td class="center">{{ $row->institusi }}</td>
                <td class="center">
                    {{ $row->tanggal_lahir ? \Carbon\Carbon::parse($row->tanggal_lahir)->format('d-m-Y') : '-' }}
                </td>
                <td>{{ $row->alamat }}</td>
                <td class="center">
                    {{ $row->created_at ? \Carbon\Carbon::parse($row->created_at)->format('d-m-Y') : '-' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <footer>
        Dikelola oleh Trasa Coworking Space &copy; 2026
    </footer>

</body>

</html>







