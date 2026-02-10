<?php

namespace App\Exports;

use App\Models\DataMember;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class MemberExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithStyles,
    WithCustomStartCell
{
    public function startCell(): string
    {
        return 'A3';
    }

    public function collection()
    {
        return DataMember::select(
            'id',
            'nama',
            'type',
            'tanggal_lahir',
            'alamat',
            'email',
            'no_hp',
            'aktivitas',
            'institusi',
            'status',
            'created_at',
        )->get()->map(function ($row) {
            return [
                $row->id,
                $row->nama,
                $row->type,
                $row->tanggal_lahir ? \Carbon\Carbon::parse($row->tanggal_lahir)->format('d-m-Y') : '-',
                $row->alamat,
                $row->email,
                $row->no_hp,
                $row->aktivitas,
                $row->institusi,
                $row->status,
                $row->created_at ? \Carbon\Carbon::parse($row->created_at)->format('d-m-Y') : '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Tipe',
            'Tanggal Lahir',
            'Alamat',
            'Email',
            'Telepon',
            'Aktivitas',
            'Institusi',
            'Status',
            'Tanggal Daftar',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestCol = $sheet->getHighestColumn();

        // === JUDUL ===
        $sheet->mergeCells("A1:{$highestCol}1");
        $sheet->setCellValue('A1', 'DATA MEMBER');

        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // === BORDER ===
        $sheet->getStyle("A3:{$highestCol}{$highestRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // === CENTER DEFAULT ===
        $sheet->getStyle("A3:{$highestCol}{$highestRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        // === HEADER STYLE ===
        $sheet->getStyle("A3:{$highestCol}3")->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'D9D9D9',
                ],
            ],
        ]);

        // === LEFT ALIGN KHUSUS ===
        // B = Nama, E = Alamat, F = Email, I = Institusi
        $sheet->getStyle("B4:B{$highestRow}")
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->getStyle("E4:E{$highestRow}")
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->getStyle("F4:F{$highestRow}")
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $sheet->getStyle("I4:I{$highestRow}")
            ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            
        // ===== FREEZE HEADER =====
        $sheet->freezePane("A4");
        return [];
    }
}
