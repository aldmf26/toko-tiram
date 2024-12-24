<?php

namespace App\Exports;

use App\Models\Produk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ProdukExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Produk::with(['rak', 'pemilik', 'satuan'])
        ->orderBy('id', 'desc')
        ->selectRaw('kd_produk, nama_produk')
        ->get();
    }
    public function headings(): array
    {
        return [
            'Kode Produk',
            'Nama Produk'
        ];
    }
}
