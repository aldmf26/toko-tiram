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

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'produk_tags', 'id_produk', 'id_tag');
    }

    public static function getAllProduk($search = null, $selectedTag = null)
    {
        $query = Produk::with(['rak', 'pemilik', 'satuan'])->orderBy('nama_produk', 'ASC');

        // Filter berdasarkan pencarian
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'like', '%' . $search . '%')
                    ->orWhereHas('tags', function ($q) use ($search) {
                        $q->where('nama_tag', 'like', '%' . $search . '%');
                    });
            });
        }

        // Filter berdasarkan tag yang dipilih
        if ($selectedTag) {
            if ($selectedTag != 'all') {
                $query->whereHas('tags', function ($q) use ($selectedTag) {
                    $q->where('nama_tag', $selectedTag);
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
