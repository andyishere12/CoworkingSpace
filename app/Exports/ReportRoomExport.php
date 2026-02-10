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

class ReportRoomExport implements FromArray, WithStyles, WithEvents, WithColumnWidths
{
    public function array(): array
    {
        $rooms = DB::table('rooms')->get();
        
        // Query total reservasi
        $roomReservations = DB::table('reservasis')
            ->select('ruangan', DB::raw('COUNT(*) as total_reservasi'))
            ->groupBy('ruangan')
            ->get()
            ->keyBy('ruangan');

        $rows = [];

        // ===== JUDUL =====
        $rows[] = ['LAPORAN RUANGAN'];
        $rows[] = []; // Baris kosong untuk jarak

        // ===== RINGKASAN RUANGAN =====
        $rows[] = ['RINGKASAN RUANGAN'];
        $rows[] = ['Total Ruangan', 'Ruangan Tersedia', 'Ruangan Tidak Tersedia'];
        
        $totalRooms = DB::table('rooms')->count();
        $availableRooms = DB::table('rooms')->where('status', 'available')->count();
        $notAvailableRooms = $totalRooms - $availableRooms;
        
        $rows[] = [$totalRooms, $availableRooms, $notAvailableRooms];

        // ===== BARIS KOSONG UNTUK JARAK =====
        $rows[] = [''];
        $rows[] = [''];

        // ===== STATISTIK TIPE RUANGAN =====
        $rows[] = ['STATISTIK TIPE RUANGAN'];
        $rows[] = ['No', 'Tipe Ruangan', 'Jumlah'];
        
        $typeStats = DB::table('rooms')
            ->select('type', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('type')
            ->get();

        $i = 1;
        foreach ($typeStats as $stat) {
            $rows[] = [
                $i++,
                $stat->type,
                $stat->jumlah,
            ];
        }

        // ===== BARIS KOSONG UNTUK JARAK =====
        $rows[] = [''];
        $rows[] = [''];

        // ===== RINGKASAN RESERVASI =====
        $rows[] = ['RINGKASAN RESERVASI RUANGAN'];
        $rows[] = ['No', 'Ruangan', 'Total Reservasi', 'Status Reservasi Terakhir'];
        
        // Query untuk ringkasan reservasi
        $reservationSummary = DB::table('reservasis as r')
            ->select('r.ruangan', 
                DB::raw('COUNT(*) as total_reservasi'),
                DB::raw('(SELECT status FROM reservasis WHERE ruangan = r.ruangan ORDER BY updated_at DESC LIMIT 1) as status_terakhir')
            )
            ->groupBy('r.ruangan')
            ->get();

        $j = 1;
        foreach ($reservationSummary as $summary) {
            $rows[] = [
                $j++,
                $summary->ruangan,
                $summary->total_reservasi,
                $summary->status_terakhir ?? 'Belum ada',
            ];
        }

        // ===== BARIS KOSONG UNTUK JARAK =====
        $rows[] = [''];
        $rows[] = [''];

        // ===== STATISTIK STATUS RESERVASI =====
        $rows[] = ['STATISTIK STATUS RESERVASI'];
        $rows[] = ['No', 'Status', 'Jumlah'];
        
        $statusStats = DB::table('reservasis')
            ->select('status', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('status')
            ->get();

        $k = 1;
        foreach ($statusStats as $stat) {
            $rows[] = [
                $k++,
                $stat->status,
                $stat->jumlah,
            ];
        }

        // ===== BARIS KOSONG UNTUK JARAK =====
        $rows[] = [''];
        $rows[] = ['']; // Tambahan baris kosong untuk pemisah

        // ===== DETAIL RUANGAN (DIPINDAHKAN KE BAWAH) =====
        $rows[] = ['DETAIL RUANGAN'];
        $rows[] = ['No', 'Nama Ruangan', 'Kapasitas', 'Tipe', 'Status', 'Total Reservasi', 'Deskripsi'];

        $no = 1;
        foreach ($rooms as $room) {
            // PERBAIKAN: Cek dulu apakah ruangan ada di reservasi
            $roomName = $room->name;
            $totalReservasi = 0;
            
            // Cari reservasi untuk ruangan ini
            foreach ($roomReservations as $key => $value) {
                // PERBAIKAN: Bandingkan dengan case-insensitive atau trim spasi
                if (strtolower(trim($key)) == strtolower(trim($roomName))) {
                    $totalReservasi = $value->total_reservasi;
                    break;
                }
            }
            
            // Alternatif: Gunakan query langsung untuk setiap ruangan
            if ($totalReservasi == 0) {
                $reservasiCount = DB::table('reservasis')
                    ->where('ruangan', $roomName)
                    ->count();
                $totalReservasi = $reservasiCount;
            }
            
            // PERBAIKAN KHUSUS: Jika masih 0, coba mapping manual
            if ($totalReservasi == 0) {
                // Mapping untuk nama ruangan yang berbeda antara tabel rooms dan reservasis
                $roomMappings = [
                    // Format: 'nama_di_reservasis' => 'nama_di_rooms'
                    'Room A' => 'Ruang Rembung',
                    'Ruang A' => 'Ruang Rembung',
                ];
                
                foreach ($roomMappings as $reservationName => $roomNameInDB) {
                    if ($roomNameInDB === $roomName) {
                        $reservasiCount = DB::table('reservasis')
                            ->where('ruangan', $reservationName)
                            ->count();
                        $totalReservasi = $reservasiCount;
                        break;
                    }
                }
            }
            
            $rows[] = [
                $no++,
                $roomName,
                $room->capacity,
                $room->type,
                $room->status,
                $totalReservasi,
                $room->description ?? '-',
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
                $sheet->mergeCells('A1:G1');
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

                // Daftar section dengan urutan yang sesuai (DETAIL RUANGAN di akhir)
                $sections = [
                    'RINGKASAN RUANGAN' => 3,
                    'STATISTIK TIPE RUANGAN' => 3,
                    'RINGKASAN RESERVASI RUANGAN' => 4,
                    'STATISTIK STATUS RESERVASI' => 3,
                    'DETAIL RUANGAN' => 7, // Dipindahkan ke urutan terakhir
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
                        $currentCell = trim($sheet->getCell("A{$r}")->getValue() ?? '');
                        if ($r > $dataStartRow && isset($sections[$currentCell])) {
                            $dataEndRow = $r - 1;
                            break;
                        }
                        
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
                        $sheet->getStyle("A{$dataStartRow}:{$endCol}{$dataEndRow}")->applyFromArray([
                            'borders' => [
                                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                            ],
                            'alignment' => [
                                'vertical' => Alignment::VERTICAL_CENTER,
                            ],
                        ]);
                        
                        // Alignment khusus per section
                        if ($sectionName === 'RINGKASAN RUANGAN') {
                            // Semua kolom center untuk ringkasan
                            $sheet->getStyle("A{$dataStartRow}:C{$dataEndRow}")->getAlignment()
                                ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                                ->setWrapText(false);
                                
                            $sheet->getColumnDimension('A')->setWidth(18);
                            $sheet->getColumnDimension('B')->setWidth(20);
                            $sheet->getColumnDimension('C')->setWidth(25);
                                
                        } elseif ($sectionName === 'STATISTIK TIPE RUANGAN') {
                            $sheet->getStyle("A{$dataStartRow}:C{$dataEndRow}")->getAlignment()
                                ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                                
                        } elseif ($sectionName === 'RINGKASAN RESERVASI RUANGAN') {
                            // Kolom No, Total Reservasi -> center
                            $centerCols = ['A', 'C'];
                            foreach ($centerCols as $col) {
                                $sheet->getStyle("{$col}{$dataStartRow}:{$col}{$dataEndRow}")->getAlignment()
                                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                                    ->setWrapText(false);
                            }
                            
                            // Kolom Ruangan -> left
                            $sheet->getStyle("B{$dataStartRow}:B{$dataEndRow}")->getAlignment()
                                ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                                ->setWrapText(false);
                            
                            // Kolom Status Reservasi Terakhir -> center
                            $sheet->getStyle("D{$dataStartRow}:D{$dataEndRow}")->getAlignment()
                                ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                                ->setWrapText(true);
                            
                            $sheet->getColumnDimension('B')->setAutoSize(true);
                            $sheet->getColumnDimension('D')->setWidth(25);
                            
                        } elseif ($sectionName === 'STATISTIK STATUS RESERVASI') {
                            $sheet->getStyle("A{$dataStartRow}:C{$dataEndRow}")->getAlignment()
                                ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                                
                            $sheet->getColumnDimension('B')->setWidth(25);
                                
                        } elseif ($sectionName === 'DETAIL RUANGAN') {
                            // PERBAIKAN: Semua kolom center kecuali Nama Ruangan dan Deskripsi
                            $centerCols = ['A', 'C', 'D', 'E', 'F']; // No, Kapasitas, Tipe, Status, Total Reservasi -> center
                            foreach ($centerCols as $col) {
                                $sheet->getStyle("{$col}{$dataStartRow}:{$col}{$dataEndRow}")->getAlignment()
                                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                                    ->setWrapText(false);
                            }
                            
                            $leftCols = ['B', 'G']; // Nama Ruangan, Deskripsi -> left
                            foreach ($leftCols as $col) {
                                $sheet->getStyle("{$col}{$dataStartRow}:{$col}{$dataEndRow}")->getAlignment()
                                    ->setHorizontal(Alignment::HORIZONTAL_LEFT);
                            }
                            
                            $sheet->getColumnDimension('B')->setAutoSize(true);
                        }
                    }
                    
                    // Auto-size untuk kolom Nama Ruangan di DETAIL RUANGAN
                    if ($sectionName === 'DETAIL RUANGAN' && isset($dataStartRow)) {
                        $sheet->getColumnDimension('B')->setAutoSize(true);
                    }
                }

                // Set wrap text untuk kolom dengan teks panjang
                $sheet->getStyle('G:G')->getAlignment()->setWrapText(true); // Deskripsi
                $sheet->getStyle('D:D')->getAlignment()->setWrapText(true); // Status Reservasi (untuk mencegah kepotong)

                // Set alignment untuk semua sel agar vertical center
                $sheet->getStyle("A1:{$highestCol}{$highestRow}")->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);
                    
                // Nonaktifkan wrap text untuk kolom Nama Ruangan di semua section
                $sheet->getStyle('B:B')->getAlignment()->setWrapText(false);
                
                // Atur row height otomatis untuk baris dengan wrap text
                for ($row = 1; $row <= $highestRow; $row++) {
                    $cellValueG = trim($sheet->getCell("G{$row}")->getValue() ?? '');
                    $cellValueD = trim($sheet->getCell("D{$row}")->getValue() ?? '');
                    
                    // Jika ada teks panjang, atur row height otomatis
                    if (strlen($cellValueG) > 50 || strlen($cellValueD) > 20) {
                        $sheet->getRowDimension($row)->setRowHeight(-1);
                    }
                }

                // Set semua angka di kolom Total Reservasi ke center untuk DETAIL RUANGAN
                if (isset($sectionRows['DETAIL RUANGAN'])) {
                    $dataStartRow = $sectionRows['DETAIL RUANGAN'] + 2;
                    
                    // Cari akhir data DETAIL RUANGAN
                    for ($r = $dataStartRow; $r <= $highestRow; $r++) {
                        $currentCell = trim($sheet->getCell("A{$r}")->getValue() ?? '');
                        if ($r > $dataStartRow && isset($sections[$currentCell])) {
                            $dataEndRow = $r - 1;
                            break;
                        }
                        if ($r === $highestRow) {
                            $dataEndRow = $r;
                        }
                    }
                    
                    // Set kolom F (Total Reservasi) ke center
                    if (isset($dataEndRow) && $dataEndRow >= $dataStartRow) {
                        $sheet->getStyle("F{$dataStartRow}:F{$dataEndRow}")->getAlignment()
                            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    }
                }

            },
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,   // No
            'B' => 30,  // Nama Ruangan - auto-size
            'C' => 12,  // Kapasitas
            'D' => 18,  // Tipe (DETAIL) / Status Reservasi (RINGKASAN RESERVASI)
            'E' => 15,  // Status
            'F' => 18,  // Total Reservasi
            'G' => 40,  // Deskripsi
        ];
    }
}