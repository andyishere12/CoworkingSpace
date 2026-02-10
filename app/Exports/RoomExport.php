<?php

namespace App\Exports;

use App\Models\Room;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RoomExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return Room::select(
            'id',
            'name',
            'type',
            'capacity',
            'description',
            'status',
        )->get()->map(function ($row) {
            return [
                $row->id,
                $row->name,
                $row->type,
                $row->capacity,
                $row->description,
                $row->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Ruangan',
            'Tipe Ruangan',
            'Kapasitas',
            'Keterangan',
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
        $sheet->setCellValue("A1", "DATA RUANGAN");

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

        // ===== LEFT KHUSUS =====
        foreach (['B', 'C', 'E'] as $col) {
            $sheet->getStyle("{$col}4:{$col}{$endRow}")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_LEFT);
        }

        // ===== WRAP TEXT =====
        foreach (['B', 'C', 'E'] as $col) {
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