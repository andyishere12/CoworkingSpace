<?php

namespace App\Exports;

use App\Models\Reservasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ReservasiExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return Reservasi::select(
            'id',
            'nama_pemesanan',
            'kontak',
            'institusi',
            'purpose',
            'description',
            'attends',
            'tanggal',
            'waktu_mulai',
            'waktu_selesai',
            'ruangan',
            'status',
        )->get()->map(function ($row) {

            $tanggal = '';
            if ($row->tanggal) {
                try {
                    $tanggal = \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y');
                } catch (\Throwable $e) {
                    $tanggal = (string) $row->tanggal;
                }
            }

            return [
                $row->id,
                $row->nama_pemesanan,
                $row->kontak,
                $row->institusi,
                $row->purpose,
                $row->description,
                $row->attends,
                $tanggal,
                $row->waktu_mulai,
                $row->waktu_selesai,
                $row->ruangan,
                $row->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Pemesanan',
            'No. Kontak',
            'Institusi',
            'Tujuan',
            'Keterangan',
            'Jumlah Peserta',
            'Tanggal',
            'Waktu Mulai',
            'Waktu Selesai',
            'Ruangan',
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
        $sheet->setCellValue("A1", "DATA RESERVASI");

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

        // ===== LEFT KHUSUS (kolom panjang) =====
        foreach (['B', 'D', 'E', 'F', 'K'] as $col) {
            $sheet->getStyle("{$col}4:{$col}{$endRow}")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_LEFT);
        }

        // ===== WRAP TEXT =====
        foreach (['B', 'D', 'E', 'F'] as $col) {
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