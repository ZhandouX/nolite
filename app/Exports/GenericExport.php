<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class GenericExport implements FromCollection, WithTitle, WithEvents
{
    protected array $data;
    protected string $title;

    public function __construct(array $data, string $title = 'Laporan')
    {
        $this->data = $data;
        $this->title = $title;
    }

    /**
     * Data untuk Excel (tanpa header)
     */
    public function collection()
    {
        return collect($this->data);
    }

    /**
     * Nama sheet Excel
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * Event styling dan penataan manual (judul + header)
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                if (empty($this->data)) return;

                // Ambil nama kolom dari array pertama
                $headers = array_keys($this->data[0]);
                $lastCol = $this->getLastColumn(count($headers));
                $dataStartRow = 3; // Baris data mulai dari baris ke-3

                // === 1️⃣ Tulis Judul di baris pertama ===
                $sheet->mergeCells("A1:{$lastCol}1");
                $sheet->setCellValue("A1", $this->title . ' - ' . now()->translatedFormat('d F Y'));
                $sheet->getStyle("A1")->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle("A1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getRowDimension('1')->setRowHeight(28);

                // === 2️⃣ Tulis Header Manual di baris kedua ===
                $colIndex = 'A';
                foreach ($headers as $header) {
                    $sheet->setCellValue("{$colIndex}2", $header);
                    $colIndex++;
                }

                // === 3️⃣ Pindahkan data ke mulai baris ke-3 ===
                $row = $dataStartRow;
                foreach ($this->data as $item) {
                    $col = 'A';
                    foreach ($headers as $header) {
                        $sheet->setCellValue("{$col}{$row}", $item[$header] ?? '');
                        $col++;
                    }
                    $row++;
                }

                $lastRow = $row - 1;

                // === 4️⃣ Styling Header ===
                $headerRange = "A2:{$lastCol}2";
                $sheet->getStyle($headerRange)->getFont()->setBold(true);
                $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($headerRange)
                      ->getFill()
                      ->setFillType(Fill::FILL_SOLID)
                      ->getStartColor()
                      ->setARGB('D9EAD3'); // hijau muda

                // === 5️⃣ Border tipis seluruh tabel ===
                $sheet->getStyle("A2:{$lastCol}{$lastRow}")
                      ->getBorders()
                      ->getAllBorders()
                      ->setBorderStyle(Border::BORDER_THIN)
                      ->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('000000'));

                // === 6️⃣ Otomatis lebar kolom ===
                foreach (range('A', $lastCol) as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // === 7️⃣ Rata tengah vertikal untuk semua isi ===
                $sheet->getStyle("A3:{$lastCol}{$lastRow}")
                      ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            }
        ];
    }

    /**
     * Mendapatkan huruf kolom terakhir berdasarkan jumlah kolom
     */
    private function getLastColumn(int $count): string
    {
        $letters = range('A', 'Z');
        if ($count <= 26) {
            return $letters[$count - 1];
        }

        $first = $letters[intval(($count - 1) / 26) - 1];
        $second = $letters[($count - 1) % 26];
        return $first . $second;
    }
}
