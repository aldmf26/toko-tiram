<?php

namespace App\Exports;

use App\Models\TransaksiStok;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StokMasukExport implements FromView,WithStyles
{

    protected $datas;
    public function view(): View
    {
        $this->datas = TransaksiStok::with('produk.rak', 'produk.pemilik', 'produk.satuan')
                        ->where('jenis_transaksi', 'stok_masuk')
                        ->orderBy('id', 'desc')
                        ->get();
                        
        return view('exports.stok_masuk', [
            'invoices' => $this->datas
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $totalRows = count($this->datas) + 1; // +1 for the header row

        // Set header bold
        $sheet->getStyle('A1:K1')->applyFromArray([
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
        $sheet->getStyle("A2:K$totalRows")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);
    }
}
