<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class EventExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return Event::select(
            'id',
            'title',
            'description',
            'start_date',
            'end_date',
            'status'
        )->get()->map(function ($row) {

            $startDate = '';
            $endDate = '';

            if ($row->start_date) {
                try {
                    $startDate = \Carbon\Carbon::parse($row->start_date)->format('d-m-Y');
                } catch (\Throwable $e) {
                    $startDate = (string) $row->start_date;
                }
            }

            if ($row->end_date) {
                try {
                    $endDate = \Carbon\Carbon::parse($row->end_date)->format('d-m-Y');
                } catch (\Throwable $e) {
                    $endDate = (string) $row->end_date;
                }
            }

            return [
                $row->id,
                $row->title,
                $row->description,
                $startDate,
                $endDate,
                $row->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Event',
            'Keterangan',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Status',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestCol = $sheet->getHighestColumn();

        // ===== INSERT TITLE =====
        $sheet->insertNewRowBefore(1, 2);
        $sheet->mergeCells("A1:{$highestCol}1");
        $sheet->setCellValue("A1", "DATA EVENT");

        $sheet->getStyle("A1")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $endRow = $highestRow + 2;

        // ===== BORDER =====
        $sheet->getStyle("A3:{$highestCol}{$endRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // ===== CENTER DEFAULT =====
        $sheet->getStyle("A3:{$highestCol}{$endRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        // ===== HEADER STYLE =====
        $sheet->getStyle("A3:{$highestCol}3")->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D9D9D9'],
            ],
        ]);

        // ===== LEFT KHUSUS (kolom teks) =====
        foreach (['B', 'C'] as $col) {
            $sheet->getStyle("{$col}4:{$col}{$endRow}")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_LEFT);
        }

        // ===== WRAP TEXT =====
        foreach (['B', 'C'] as $col) {
            $sheet->getStyle("{$col}4:{$col}{$endRow}")
                ->getAlignment()
                ->setWrapText(true);
        }

        // ===== FREEZE HEADER =====
        $sheet->freezePane("A4");

        // ===== ROW HEIGHT =====
        for ($i = 4; $i <= $endRow; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(22);
        }

        return [];
    }
}