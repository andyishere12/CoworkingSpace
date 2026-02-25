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

class ReportEventExport implements FromArray, WithStyles, WithEvents, WithColumnWidths
{
    public function array(): array
    {
        $events = DB::table('events')->get();
        
        // Gabungkan dengan event_reports jika ada
        $eventReports = DB::table('event_reports')
            ->get()
            ->keyBy('event_id');

        $rows = [];

        // ===== JUDUL =====
        $rows[] = ['LAPORAN EVENT'];
        $rows[] = []; // Baris kosong untuk jarak
        $rows[] = []; // Baris kosong untuk jarak

        // ===== STATISTIK EVENT =====
        $rows[] = ['STATISTIK EVENT'];
        $rows[] = ['No', 'Status Event', 'Jumlah'];
        
        $statusStats = DB::table('events')
            ->select('status', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('status')
            ->get();

        $i = 1;
        foreach ($statusStats as $stat) {
            $rows[] = [
                $i++,
                $stat->status,
                $stat->jumlah,
            ];
        }

        // ===== BARIS KOSONG UNTUK JARAK =====
        $rows[] = [''];
        $rows[] = [''];

        // ===== EVENT YANG AKAN DATANG =====
        $tanggalSekarang = date('Y-m-d');
        $upcomingEvents = DB::table('events')
            ->where('start_date', '>', $tanggalSekarang)
            ->orderBy('start_date', 'asc')
            ->where('status', 'active')
            ->get();

        $rows[] = ['EVENT YANG AKAN DATANG'];
        $rows[] = ['No', 'Judul Event', 'Deskripsi', 'Tanggal Mulai', 'Tanggal Selesai', 'Status'];

        $no_upcoming = 1;
        foreach ($upcomingEvents as $event) {
            $rows[] = [
                $no_upcoming++,
                $event->title,
                $event->description,
                $event->start_date ? date('d-m-Y', strtotime($event->start_date)) : '-',
                $event->end_date ? date('d-m-Y', strtotime($event->end_date)) : '-',
                $event->status,
            ];
        }

        if ($upcomingEvents->count() == 0) {
            $rows[] = ['-', 'Tidak ada event yang akan datang', '', '', '', ''];
        }

        // ===== BARIS KOSONG UNTUK JARAK =====
        $rows[] = [''];
        $rows[] = [''];

        // ===== EVENT YANG SEDANG BERLANGSUNG =====
        $ongoingEvents = DB::table('events')
            ->where('start_date', '<=', $tanggalSekarang)
            ->where('end_date', '>=', $tanggalSekarang)
            ->where('status', 'active')
            ->orderBy('start_date', 'asc')
            ->get();

        $rows[] = ['EVENT YANG SEDANG BERLANGSUNG'];
        $rows[] = ['No', 'Judul Event', 'Deskripsi', 'Tanggal Mulai', 'Tanggal Selesai', 'Status'];

        $no_ongoing = 1;
        foreach ($ongoingEvents as $event) {
            $rows[] = [
                $no_ongoing++,
                $event->title,
                $event->description,
                $event->start_date ? date('d-m-Y', strtotime($event->start_date)) : '-',
                $event->end_date ? date('d-m-Y', strtotime($event->end_date)) : '-',
                $event->status,
            ];
        }

        if ($ongoingEvents->count() == 0) {
            $rows[] = ['-', 'Tidak ada event yang sedang berlangsung', '', '', '', ''];
        }

        // ===== BARIS KOSONG UNTUK JARAK =====
        $rows[] = [''];
        $rows[] = [''];

        // ===== EVENT YANG SUDAH SELESAI =====
        $completedEvents = DB::table('events')
            ->where('end_date', '<', $tanggalSekarang)
            ->orderBy('end_date', 'desc')
            ->get();

        $rows[] = ['EVENT YANG SUDAH SELESAI'];
        $rows[] = ['No', 'Judul Event', 'Deskripsi', 'Tanggal Mulai', 'Tanggal Selesai', 'Status'];

        $no_completed = 1;
        foreach ($completedEvents as $event) {
            $rows[] = [
                $no_completed++,
                $event->title,
                $event->description,
                $event->start_date ? date('d-m-Y', strtotime($event->start_date)) : '-',
                $event->end_date ? date('d-m-Y', strtotime($event->end_date)) : '-',
                $event->status,
            ];
        }

        if ($completedEvents->count() == 0) {
            $rows[] = ['-', 'Tidak ada event yang sudah selesai', '', '', '', ''];
        }

        // ===== BARIS KOSONG UNTUK JARAK =====
        $rows[] = [''];
        $rows[] = [''];

        // ===== RINGKASAN BULANAN =====
        $rows[] = ['RINGKASAN EVENT PER BULAN'];
        $rows[] = ['No', 'Bulan', 'Tahun', 'Total Event'];
        
        $monthlySummary = DB::table('events')
            ->select(
                DB::raw('MONTH(start_date) as bulan'),
                DB::raw('YEAR(start_date) as tahun'),
                DB::raw('COUNT(*) as total_event')
            )
            ->groupBy('bulan', 'tahun')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();

        $j = 1;
        foreach ($monthlySummary as $summary) {
            $rows[] = [
                $j++,
                $this->getMonthName($summary->bulan),
                $summary->tahun,
                $summary->total_event,
            ];
        }

        // Jika ada data event_reports, tambahkan section laporan event
        if ($eventReports->count() > 0) {
            // ===== BARIS KOSONG UNTUK JARAK =====
            $rows[] = [''];
            $rows[] = [''];

            $rows[] = ['LAPORAN KINERJA EVENT'];
            $rows[] = ['No', 'ID Event', 'Tanggal Event', 'Peserta Terdaftar', 'Peserta Hadir', 'Tingkat Kehadiran', 'Revenue', 'Expenses', 'Profit', 'Rating'];

            $k = 1;
            foreach ($eventReports as $report) {
                $eventTitle = DB::table('events')->where('id', $report->event_id)->value('title');
                
                $rows[] = [
                    $k++,
                    $eventTitle ?: "Event #{$report->event_id}",
                    $report->event_date ? date('d-m-Y', strtotime($report->event_date)) : '-',
                    $report->registered_participants,
                    $report->actual_attendees,
                    $report->attendance_rate . '%',
                    'Rp ' . number_format($report->revenue, 0, ',', '.'),
                    'Rp ' . number_format($report->expenses, 0, ',', '.'),
                    'Rp ' . number_format($report->profit, 0, ',', '.'),
                    $report->rating,
                ];
            }
        }

        // ===== BARIS KOSONG UNTUK JARAK =====
        $rows[] = [''];
        $rows[] = [''];

        // ===== DETAIL EVENT (DIPINDAH KE BAWAH) =====
        $rows[] = ['DETAIL EVENT'];
        $rows[] = ['No', 'Judul Event', 'Deskripsi', 'Tanggal Mulai', 'Tanggal Selesai', 'Status'];

        $no = 1;
        foreach ($events as $event) {
            $rows[] = [
                $no++,
                $event->title,
                $event->description,
                $event->start_date ? date('d-m-Y', strtotime($event->start_date)) : '-',
                $event->end_date ? date('d-m-Y', strtotime($event->end_date)) : '-',
                $event->status,
            ];
        }

        return $rows;
    }

    private function getMonthName($monthNumber)
    {
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        return $months[$monthNumber] ?? $monthNumber;
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
                $sheet->mergeCells('A1:J1');
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

                // Daftar section
                $sections = [
                    'STATISTIK EVENT' => 3,
                    'EVENT YANG AKAN DATANG' => 6,
                    'EVENT YANG SEDANG BERLANGSUNG' => 6,
                    'EVENT YANG SUDAH SELESAI' => 6,
                    'RINGKASAN EVENT PER BULAN' => 4,
                    'LAPORAN KINERJA EVENT' => 10,
                    'DETAIL EVENT' => 6,
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
                        if (in_array($sectionName, ['EVENT YANG AKAN DATANG', 'EVENT YANG SEDANG BERLANGSUNG', 'EVENT YANG SUDAH SELESAI', 'DETAIL EVENT'])) {
                            // Kolom No, Tanggal Mulai, Tanggal Selesai, Status -> center
                            $centerCols = ['A', 'D', 'E', 'F'];
                            foreach ($centerCols as $col) {
                                $sheet->getStyle("{$col}{$dataStartRow}:{$col}{$dataEndRow}")->getAlignment()
                                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                                    ->setWrapText(false);
                            }
                            
                            // Kolom Judul Event, Deskripsi -> left
                            $leftCols = ['B', 'C'];
                            foreach ($leftCols as $col) {
                                $sheet->getStyle("{$col}{$dataStartRow}:{$col}{$dataEndRow}")->getAlignment()
                                    ->setHorizontal(Alignment::HORIZONTAL_LEFT);
                            }
                            
                        } else if ($sectionName === 'STATISTIK EVENT' || $sectionName === 'RINGKASAN EVENT PER BULAN') {
                            // Semua kolom center untuk tabel statistik
                            $sheet->getStyle("A{$dataStartRow}:{$endCol}{$dataEndRow}")->getAlignment()
                                ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                                
                        } else if ($sectionName === 'LAPORAN KINERJA EVENT') {
                            // Kolom No, Peserta, Rating -> center
                            $centerCols = ['A', 'D', 'E', 'F', 'J'];
                            foreach ($centerCols as $col) {
                                $sheet->getStyle("{$col}{$dataStartRow}:{$col}{$dataEndRow}")->getAlignment()
                                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                                    ->setWrapText(false);
                            }
                            
                            // Kolom ID Event, Tanggal Event -> left
                            $leftCols = ['B', 'C'];
                            foreach ($leftCols as $col) {
                                $sheet->getStyle("{$col}{$dataStartRow}:{$col}{$dataEndRow}")->getAlignment()
                                    ->setHorizontal(Alignment::HORIZONTAL_LEFT);
                            }
                            
                            // Kolom financial -> right
                            $rightCols = ['G', 'H', 'I'];
                            foreach ($rightCols as $col) {
                                $sheet->getStyle("{$col}{$dataStartRow}:{$col}{$dataEndRow}")->getAlignment()
                                    ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                            }
                        }
                    }
                }

                // Set wrap text untuk kolom deskripsi
                $sheet->getStyle('C:C')->getAlignment()->setWrapText(true);

                // Set alignment untuk semua sel agar vertical center
                $sheet->getStyle("A1:{$highestCol}{$highestRow}")->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);

            },
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,   // No
            'B' => 25,  // Judul Event / ID Event
            'C' => 40,  // Deskripsi / Tanggal Event
            'D' => 15,  // Tanggal Mulai / Peserta Terdaftar
            'E' => 15,  // Tanggal Selesai / Peserta Hadir
            'F' => 15,  // Status / Tingkat Kehadiran
            'G' => 20,  // Revenue
            'H' => 20,  // Expenses
            'I' => 20,  // Profit
            'J' => 12,  // Rating
        ];
    }
}