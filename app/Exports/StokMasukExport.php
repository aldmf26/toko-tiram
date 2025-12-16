<?php

namespace App\Exports;

use App\Models\TransaksiStok;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StokMasukExport implements FromView, WithStyles
{

    protected $dari_tanggal;
    protected $sampai_tanggal;
    protected $datas;

    public function __construct($dari_tanggal, $sampai_tanggal)
    {
        $this->dari_tanggal = $dari_tanggal;
        $this->sampai_tanggal = $sampai_tanggal;
    }
    public function view(): View
    {
        $this->datas = TransaksiStok::with('produk','produk.rak', 'produk.pemilik', 'produk.satuan')
            ->where('jenis_transaksi', 'stok_masuk')
             ->whereBetween('tanggal', [
            $this->dari_tanggal . ' 00:00:00',
            $this->sampai_tanggal . ' 23:59:59'
        ])
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
