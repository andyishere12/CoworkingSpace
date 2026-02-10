<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ReportMemberExport implements FromArray, WithStyles, WithEvents, WithColumnWidths
{
    public function array(): array
    {
        $table = 'data_members';

        $members = DB::table($table)->get();

        $total = DB::table($table)->count();
        
        // PERBAIKAN: Status mungkin 'Aktif', 'Active', atau 'Aktive'
        // Cek semua kemungkinan status aktif
        $aktif = DB::table($table)
            ->where(function($query) {
                $query->where('status', 'Aktif')
                      ->orWhere('status', 'Active')
                      ->orWhere('status', 'Aktive')
                      ->orWhere('status', 'ACTIVE')
                      ->orWhere('status', 1);
            })
            ->count();
        
        // PERBAIKAN: Hitung tidak aktif sebagai total dikurangi aktif
        $nonAktif = $total - $aktif;

        $tipe = DB::table($table)
            ->select('type', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('type')->get();

        $aktivitas = DB::table($table)
            ->select('aktivitas', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('aktivitas')->get();

        $rows = [];

        // ===== JUDUL =====
        $rows[] = ['LAPORAN MEMBER'];
        $rows[] = []; // Baris kosong untuk jarak

        // ===== RINGKASAN ===== (DIPINDAHKAN KE ATAS)
        $rows[] = ['RINGKASAN MEMBER'];
        $rows[] = ['No', 'Total Member', 'Member Aktif', 'Member Tidak Aktif'];
        $rows[] = [1, $total, $aktif, $nonAktif];

        // ===== BARIS KOSONG UNTUK JARAK =====
        $rows[] = [''];
        $rows[] = [''];

        // ===== TIPE =====
        $rows[] = ['TIPE MEMBER'];
        $rows[] = ['No', 'Tipe', 'Jumlah'];
        $i = 1;
        foreach ($tipe as $t) {
            $rows[] = [$i++, $t->type, $t->jumlah];
        }

        // ===== BARIS KOSONG UNTUK JARAK =====
        $rows[] = [''];
        $rows[] = [''];

        // ===== AKTIVITAS =====
        $rows[] = ['AKTIVITAS MEMBER'];
        $rows[] = ['No', 'Aktivitas', 'Jumlah'];
        $i = 1;
        foreach ($aktivitas as $a) {
            $rows[] = [$i++, $a->aktivitas, $a->jumlah];
        }

        // ===== BARIS KOSONG UNTUK JARAK =====
        $rows[] = [''];
        $rows[] = [''];

        // ===== DETAIL ===== (DIPINDAHKAN KE BAWAH)
        $rows[] = ['DETAIL MEMBER'];
        $rows[] = ['No', 'Nama', 'Tipe', 'Tanggal Lahir', 'Alamat', 'Email', 'Telepon', 'Aktivitas', 'Institusi'];

        $no = 1;
        foreach ($members as $m) {
            $rows[] = [
                $no++,
                $m->nama,
                $m->type,
                $m->tanggal_lahir ? date('d-m-Y', strtotime($m->tanggal_lahir)) : '-',
                $m->alamat,
                $m->email,
                $m->no_hp,
                $m->aktivitas,
                $m->institusi,
            ];
        }

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 14],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestCol = $sheet->getHighestColumn();

                // Judul utama
                $sheet->mergeCells('A1:I1');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'E0E0E0'],
                    ],
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                ]);

                // Set row height untuk semua baris
                for ($i = 1; $i <= $highestRow; $i++) {
                    $sheet->getRowDimension($i)->setRowHeight(22);
                }

                // Daftar section dengan urutan baru (DETAIL MEMBER sekarang terakhir)
                $sections = [
                    'RINGKASAN MEMBER' => 4,
                    'TIPE MEMBER' => 3,
                    'AKTIVITAS MEMBER' => 3,
                    'DETAIL MEMBER' => 9,
                ];

                $sectionRows = [];
                
                // Cari semua baris yang berisi section header
                for ($row = 1; $row <= $highestRow; $row++) {
                    $cellValue = trim($sheet->getCell("A{$row}")->getValue() ?? '');
                    
                    if (isset($sections[$cellValue])) {
                        $sectionRows[$cellValue] = $row;
                    }
                }

                // Format setiap section
                foreach ($sectionRows as $sectionName => $sectionRow) {
                    $colCount = $sections[$sectionName];
                    $endCol = chr(ord('A') + $colCount - 1);
                    
                    // Merge dan format section header
                    $sheet->mergeCells("A{$sectionRow}:{$endCol}{$sectionRow}");
                    $sheet->getStyle("A{$sectionRow}")->applyFromArray([
                        'font' => ['bold' => true, 'size' => 12],
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_LEFT,
                            'vertical' => Alignment::VERTICAL_CENTER
                        ],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'F0F0F0'],
                        ],
                        'borders' => [
                            'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                        ],
                    ]);
                    
                    // Format header tabel (baris setelah section header)
                    $headerRow = $sectionRow + 1;
                    $sheet->getStyle("A{$headerRow}:{$endCol}{$headerRow}")->applyFromArray([
                        'font' => ['bold' => true],
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                            'vertical' => Alignment::VERTICAL_CENTER,
                        ],
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'E8E8E8'],
                        ],
                        'borders' => [
                            'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                        ],
                    ]);
                    
                    // Temukan baris data untuk tabel ini
                    $dataStartRow = $headerRow + 1;
                    $dataEndRow = $dataStartRow;
                    
                    // Cari akhir data (hingga baris sebelum section berikutnya atau baris kosong)
                    for ($r = $dataStartRow; $r <= $highestRow; $r++) {
                        // Cek apakah ini awal section berikutnya
                        $currentCell = trim($sheet->getCell("A{$r}")->getValue() ?? '');
                        if ($r > $dataStartRow && isset($sections[$currentCell])) {
                            $dataEndRow = $r - 1;
                            break;
                        }
                        
                        // Cek apakah baris ini kosong (semua kolom kosong)
                        $isEmptyRow = true;
                        for ($col = 0; $col < $colCount; $col++) {
                            $colLetter = chr(ord('A') + $col);
                            $cellValue = trim($sheet->getCell("{$colLetter}{$r}")->getValue() ?? '');
                            if ($cellValue !== '') {
                                $isEmptyRow = false;
                                break;
                            }
                        }
                        
                        if ($r > $dataStartRow && $isEmptyRow) {
                            $dataEndRow = $r - 1;
                            break;
                        }
                        
                        if ($r === $highestRow) {
                            $dataEndRow = $r;
                        }
                    }
                    
                    // Jika ada data, format border
                    if ($dataEndRow >= $dataStartRow && $dataEndRow > 0) {
                        // Format border untuk data rows
                        $sheet->getStyle("A{$dataStartRow}:{$endCol}{$dataEndRow}")->applyFromArray([
                            'borders' => [
                                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                            ],
                            'alignment' => [
                                'vertical' => Alignment::VERTICAL_CENTER,
                            ],
                        ]);
                        
                        // Alignment khusus per kolom untuk DETAIL MEMBER
                        if ($sectionName === 'DETAIL MEMBER') {
                            // Kolom No, Tipe, Tanggal Lahir, Telepon, Aktivitas -> center
                            $centerCols = ['A', 'C', 'D', 'G', 'H'];
                            foreach ($centerCols as $col) {
                                $sheet->getStyle("{$col}{$dataStartRow}:{$col}{$dataEndRow}")->getAlignment()
                                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                                    ->setWrapText(false);
                            }
                            
                            // Kolom Nama, Alamat, Email, Institusi -> left
                            $leftCols = ['B', 'E', 'F', 'I'];
                            foreach ($leftCols as $col) {
                                $sheet->getStyle("{$col}{$dataStartRow}:{$col}{$dataEndRow}")->getAlignment()
                                    ->setHorizontal(Alignment::HORIZONTAL_LEFT);
                            }
                            
                            // Nonaktifkan wrap text untuk kolom Nama (B) agar tidak jadi 2 baris
                            $sheet->getStyle("B{$dataStartRow}:B{$dataEndRow}")->getAlignment()
                                ->setWrapText(false);
                                
                            // PERBAIKAN: Auto-size untuk kolom Nama agar tidak kepotong
                            $sheet->getColumnDimension('B')->setAutoSize(true);
                            
                        } else {
                            // Untuk tabel lain, semua kolom center
                            $sheet->getStyle("A{$dataStartRow}:{$endCol}{$dataEndRow}")->getAlignment()
                                ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        }
                    }
                    
                    // PERBAIKAN KHUSUS: Untuk RINGKASAN MEMBER, atur lebar kolom agar tidak terpotong
                    if ($sectionName === 'RINGKASAN MEMBER') {
                        // Set lebar kolom untuk ringkasan agar lebih lebar
                        $sheet->getColumnDimension('B')->setWidth(18); // Total Member
                        $sheet->getColumnDimension('C')->setWidth(18); // Member Aktif
                        $sheet->getColumnDimension('D')->setWidth(20); // Member Tidak Aktif
                        
                        // Nonaktifkan wrap text untuk semua kolom di ringkasan
                        $sheet->getStyle("A{$dataStartRow}:D{$dataEndRow}")->getAlignment()
                            ->setWrapText(false);
                    }
                }

                // Set wrap text untuk kolom dengan teks panjang (kecuali Nama)
                $wrapCols = ['E', 'F', 'I']; // Hanya Alamat, Email, dan Institusi
                foreach ($wrapCols as $col) {
                    $sheet->getStyle("{$col}:{$col}")->getAlignment()->setWrapText(true);
                }

                // Set alignment untuk semua sel agar vertical center
                $sheet->getStyle("A1:{$highestCol}{$highestRow}")->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);
                    
                // Nonaktifkan wrap text untuk kolom Nama
                $sheet->getStyle('B:B')->getAlignment()->setWrapText(false);
                
                // PERBAIKAN: Auto-size untuk kolom Nama (B) di DETAIL MEMBER section
                if (isset($sectionRows['DETAIL MEMBER'])) {
                    $sheet->getColumnDimension('B')->setAutoSize(true);
                }

            },
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,   // No
            'B' => 40,  // Nama - Diperlebar dan akan auto-size
            'C' => 15,  // Tipe
            'D' => 18,  // Tanggal Lahir
            'E' => 30,  // Alamat - wrap text aktif
            'F' => 35,  // Email - wrap text aktif
            'G' => 18,  // Telepon
            'H' => 18,  // Aktivitas
            'I' => 25,  // Institusi - wrap text aktif
        ];
    }
}