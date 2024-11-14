<?php

namespace Database\Seeders;

use App\Models\Pemilik;
use App\Models\Rak;
use App\Models\Satuan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RakPemilikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rak = [
            '0',
            'A',
            'B',
            'bawah tangga',
            'C',
            'D',
            'disamping rak e',
            'E',
            'F',
            'G',
            'H',
            'i',
            'J',
            'k',
            'L',
            'M',
            'N',
            'O',
            'O',
            'P',
            'Q',
            'R',
            'S',
            'T',
            'U',
            'workshop',
            'T'
        ];
        $pemilik = [
            'ts',
            'toko',
            'teluk tiram',
            'orchard',
            'aga',
            'rwb',
            'agri laras',
            'rwb mtd',
            'anak laki',
            'ibu lilly',
            'aga2',
            's',
            'birdnest',
            'rwb cls',
            'kebun',
            'rwb pariangan',
            'linda pribadi'
        ];

        $satuan = [
            'pcs', 'pack', 'set', 'roll', 'bungkus', 'roll / m', 'dus', 'box', 'dirigen', 
            'isi /pcs', 'botol', 'kotak', 'plastikan', 'psc', 'm', 'kaleng', 'tabung', 'meter', 
            'bks', 'lembar', 'karung', 'toples', 'p', 'btl', 'ktk'
        ];


        foreach ($rak as $r) {
            Rak::insert(['rak' => $r]);
        }
        foreach ($pemilik as $r) {
            Pemilik::insert(['pemilik' => $r]);
        }

        foreach ($satuan as $r) {
            Satuan::insert(['satuan' => $r]);
        }
    }
}
