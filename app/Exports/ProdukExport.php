<?php

namespace App\Exports;

use App\Models\Produk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class ProdukExport implements FromCollection, WithHeadings,WithStyles
{
    protected $datas;
    public function collection()
    {
        $this->datas = Produk::join('pemiliks as a', 'a.id', '=', 'produks.pemilik_id')
        ->join('raks as b', 'b.id', '=', 'produks.rak_id')
        ->join('satuans as c', 'c.id', '=', 'produks.satuan_id')
        ->orderBy('produks.kd_produk', 'desc')
        ->selectRaw("kd_produk, nama_produk, b.rak, a.pemilik, deskripsi, hrg_beli, harga, stok, c.satuan")
        ->get();

        return $this->datas;
    }
    public function headings(): array
    {
        return [
            'Kode Produk',
            'Nama Produk',
            'Rak',
            'Pemilik',
            'Deskripsi',
            'harga beli',
            'harga jual',
            'stok',
            'satuan'
        ];
    }
    public function styles(Worksheet $sheet)
    {
        $totalRows = count($this->datas) + 1; // +1 for the header row

        // Set header bold
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Border untuk semua data
        $sheet->getStyle("A2:I$totalRows")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);
    }
}
