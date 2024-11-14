<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function produks()
    {
        return $this->belongsToMany(Produk::class, 'produk_tag');
    }
    public function produk()
    {
        return $this->belongsToMany(Produk::class, 'produk_tags', 'id_tag', 'id_produk');
    }

}
