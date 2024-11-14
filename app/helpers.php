<?php 

if (!function_exists('jenis_transaksi')) {
    /**
     * Mengambil jenis transaksi berdasarkan prefix atau semua jenis transaksi.
     * 
     * @param string|null $prefix
     * @return string|array
     */
    function jenis_transaksi($prefix = null)
    {
        $jenis_transaksi = [
            'penjualan' => 'PNJ',
            'stok_masuk' => 'STK',
            'opname' => 'OPN',
        ];

        // Jika ada parameter prefix, kembalikan jenis transaksi berdasarkan prefix-nya
        if ($prefix) {
            $jenis = array_search($prefix, $jenis_transaksi);
            return $jenis ?: null;  // Jika prefix tidak ditemukan, return null
        }

        // Jika tidak ada parameter, kembalikan semua jenis transaksi
        return $jenis_transaksi;
    }
}
if (!function_exists('tglFormat')) {
    function tglFormat($tgl)
    {
        return date('d M Y', strtotime($tgl));
    }
}
if (!function_exists('sumCol')) {
    function sumCol($datas, $col)
    {
        return array_sum(array_column($datas, $col));
    }
}
if (!function_exists('globalVar')) {
    function globalVar($param)
    {
        $datas = [
            'appUrl' => "https://putrirembulan.com/assets/img/portfolio/TokoAga2.png"
        ];

        return $datas[$param];
    }
}