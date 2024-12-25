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
        styleExportBorder($this->datas, $sheet, 'K');
    }
}
