<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Produk extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function rak()
    {
        return $this->belongsTo(Rak::class, 'rak_id');
    }
    public function pemilik()
    {
        return $this->belongsTo(Pemilik::class, 'pemilik_id');
    }
    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuan_id');
    }

    public function tagss()
    {
        return $this->belongsToMany(Tag::class, 'produk_tags', 'id_produk', 'id_tag');
    }

    public static function getAllProduk($search = null, $selectedTag = null, $paginate = 6)
    {
        $query = Produk::selectRaw('produks.id,produks.foto, produks.kd_produk, produks.nama_produk, produks.harga, produks.stok, produks.satuan_id, produks.rak_id, produks.pemilik_id')
            ->with(['rak', 'pemilik', 'satuan'])
            ->orderBy('id', 'desc');

        // Filter berdasarkan pencarian
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'like', '%' . $search . '%')
                    ->orWhere('kd_produk', 'like', '%' . $search . '%')
                    ->orWhereHas('tagss', function ($q) use ($search) {
                        $q->where('nama_tag', 'like', '%' . $search . '%');
                    });
            });
        }

        // Filter berdasarkan tag yang dipilih
        if ($selectedTag) {
            if ($selectedTag != 'all') {
                $query->whereHas('pemilik', function ($q) use ($selectedTag) {
                    $q->where('pemilik', $selectedTag);
                });
            }
        }

        return $query->get();
    }

    public static function getProdukByTag($tagName)
    {
        // Query produk berdasarkan tag tertentu
        $produks = DB::select("SELECT p.*, GROUP_CONCAT(t.nama_tag) as tags
            FROM produks p
            JOIN produk_tags pt ON p.id = pt.id_produk
            JOIN tags t ON pt.id_tag = t.id
            WHERE t.nama_tag = ?
            GROUP BY p.id
        ", [$tagName]);

        return $produks;
    }
}
