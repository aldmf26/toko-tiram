<?php

namespace App\Http\Controllers;

use App\Exports\ProdukExport;
use App\Models\Pemilik;
use App\Models\Produk;
use App\Models\Rak;
use App\Models\Satuan;
use App\Models\Tag;
use App\Models\TransaksiStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProdukController extends Controller
{

    public function index()
    {
        $kd_produk = Produk::query()->latest('kd_produk')->value('kd_produk');
        $data = [
            'title' => 'Daftar Produk',
            'kd_produk' => $kd_produk  + 1
        ];
        return view('produk.index', $data);
    }

    public function satuan()
    {
        $satuan = Satuan::all();
        $data = [
            'satuan' => $satuan
        ];
        return view('produk.satuan', $data);
    }

    public function create_satuan(Request $r)
    {
        $satuan = Satuan::where('satuan', $r->satuan)->first();
        if (!$satuan) {
            DB::table('satuans')->insert([
                'satuan' => $r->satuan
            ]);
        }
    }

    public function rak()
    {
        $rak = Rak::all();
        $data = [
            'rak' => $rak
        ];
        return view('produk.rak', $data);
    }

    public function create_rak(Request $r)
    {
        $rak = Rak::where('rak', $r->rak)->first();
        if (!$rak) {
            DB::table('raks')->insert([
                'rak' => $r->rak
            ]);
        }
    }

    public function pemilik()
    {
        $pemilik = Pemilik::all();
        $data = [
            'pemilik' => $pemilik
        ];
        return view('produk.pemilik', $data);
    }


    public function create_pemilik(Request $r)
    {
        $pemilik = Pemilik::where('pemilik', $r->pemilik)->first();
        if (!$pemilik) {
            DB::table('pemiliks')->insert([
                'pemilik' => $r->pemilik
            ]);
        }
    }

    public function create(Request $r)
    {
        try {
            DB::beginTransaction();

            // Validasi apakah produk sudah ada berdasarkan nama produk dan deskripsi
            $produkExist = Produk::where('nama_produk', $r->nm_produk)
                ->where('deskripsi', $r->deskripsi)
                ->first();

            if ($produkExist) {
                return redirect()->back()->with('error', 'Produk sudah ada!');
            }
            $lastInvoice = TransaksiStok::where('jenis_transaksi', 'stok_masuk')
                ->orderBy('urutan', 'desc')
                ->first();
            // Tentukan urutan berikutnya
            $urutan = $lastInvoice ? $lastInvoice->urutan + 1 : 1001;
            $no_invoice = 'M-' . $urutan;

            $admin = auth()->user()->name;
            $nm_produk = $r->nm_produk;
            $tags = $r->tags;
            $deskripsi = $r->deskripsi;
            $hrg_beli = $r->hrg_beli;
            $hrg_jual = $r->hrg_jual;
            $kd_produk = $r->kd_produk;
            $stok = $r->stok;
            $rak_id = $r->rak;
            $pemilik_id = $r->pemilik;
            $satuan_id = $r->satuan;


            if ($r->hasFile('image')) {
                $imageName = time() . '.' . $r->image->extension();
                $r->image->move(public_path('uploads'), $imageName);
                // $r->image->storeAs('public/uploads', $imageName);
            } else {
                $imageName = $r->image;
            }


            $produk = Produk::create([
                'nama_produk' => $nm_produk,
                'deskripsi' => $deskripsi,
                'harga' => $hrg_jual,
                'foto' => $imageName,
                'stok' => $stok,
                'tags' => $tags,
                'satuan_id' => $satuan_id,
                'rak_id' => $rak_id,
                'pemilik_id' => $pemilik_id,
                'hrg_beli' => $hrg_beli,
                'kd_produk' => $kd_produk,
                'admin' => $admin
            ]);

            // Mengubah tags menjadi array dan simpan jika belum ada
            $tagsArr = explode(',', $tags);
            foreach ($tagsArr as $tag) {
                if (!DB::table('tags')->where('nama_tag', $tag)->exists()) {
                    DB::table('tags')->insert([
                        'nama_tag' => $tag,
                    ]);
                }

                DB::table('produk_tags')->insert([
                    'id_produk' => $produk->id,
                    'id_tag' => DB::table('tags')->where('nama_tag', $tag)->first()->id,
                ]);
            }


            // Catat stok awal di transaksi_stok
            TransaksiStok::create([
                'produk_id' => $produk->id,
                'jenis_transaksi' => 'stok_masuk',
                'urutan' => $urutan,
                'no_invoice' => $no_invoice,
                'jumlah' => $stok,
                'stok_sebelum' => 0,
                'stok_setelah' => $stok,
                'keterangan' => 'Stok awal produk',
                'tanggal' => now(),
                'admin' => $admin
            ]);

            DB::commit();
            return redirect()->back()->withInput()->with('sukses', 'berhasil tambah data');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $r)
    {

        try {
            DB::beginTransaction();

            $admin = auth()->user()->name;
            $nm_produk = $r->nm_produk;
            $tags = $r->tags;
            $deskripsi = $r->deskripsi;
            $hrg_beli = $r->hrg_beli;
            $hrg_jual = $r->hrg_jual;
            $kd_produk = $r->kd_produk;
            $stok = $r->stok;
            $rak_id = $r->rak_id;
            $pemilik_id = $r->pemilik_id;
            $satuan_id = $r->satuan_id;
            $id_produk = $r->id_produk;

            $produk = Produk::findOrFail($id_produk);

            // Periksa apakah ada gambar baru diunggah
            if ($r->hasFile('image')) {
                // Hapus gambar lama jika ada
                if ($produk->foto && file_exists(public_path('uploads/' . $produk->foto))) {
                    unlink(public_path('uploads/' . $produk->foto));
                }

                // Simpan gambar baru
                $imageName = time() . '.' . $r->image->extension();
                $r->image->move(public_path('uploads'), $imageName);
            } else {
                // Pertahankan gambar lama
                $imageName = $produk->foto;
            }

            $produk->update([
                'nama_produk' => $nm_produk,
                'deskripsi' => $deskripsi,
                'harga' => $hrg_jual,
                'foto' => $imageName,
                'stok' => $stok,
                'tags' => $tags,
                'satuan_id' => $satuan_id,
                'rak_id' => $rak_id,
                'pemilik_id' => $pemilik_id,
                'hrg_beli' => $hrg_beli,
                'kd_produk' => $kd_produk,
                'admin' => $admin
            ]);

         

            DB::commit();
            return redirect()->back()->withInput()->with('sukses', 'berhasil tambah data');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function daftar_rak(Request $r)
    {
        $rak = Rak::all();
        $satuan = Satuan::all();
        $pemilik = Pemilik::all();

        $data = [
            'title' => 'Daftar Rak / Satuan / Pemilik',
            'rak' => $rak,
            'satuan' => $satuan,
            'pemilik' => $pemilik,
        ];
        return view('produk.daftar_rak', $data);
    }

    public function edit(Request $r)
    {
        $produk = Produk::where('id', $r->id_produk)->first();

        $data = [
            'produk' => $produk,
            'satuan' => Satuan::all(),
            'rak' => Rak::all(),
            'pemilik' => Pemilik::all(),
        ];
        return view('produk.edit', $data);
    }

    public function export()
    {
        return Excel::download(new ProdukExport, 'produk.xlsx');
    }
}
