<?php

namespace App\Http\Controllers;

use App\Exports\OpnameExport;
use App\Exports\PenjualanExport;
use App\Exports\StokMasukExport;
use App\Models\Pemilik;
use App\Models\Produk;
use App\Models\Tag;
use App\Models\TransaksiStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TransaksiStokController extends Controller
{
    public function index()
    {
        $tags = Tag::get();
        $produk =  Produk::getAllProduk();

        $data = [
            'title' => 'Transaksi Stok',
            'tags' => $tags,
            'produk' => $produk
        ];
        return view('transaksi_stok.penjualan.index', $data);
    }

    public function save_pembayaran(Request $r)
    {
        try {
            DB::beginTransaction();
            $orderDetails = $r->orderDetails;
            $totalPrice = $r->totalPrice;
            $keterangan = $r->keterangan;
            $dijual_ke = $r->dijual_ke;

            $admin = auth()->user()->name;

            $lastInvoice = TransaksiStok::where([['jenis_transaksi', 'penjualan'], ['dijual_ke', $dijual_ke]])
            ->orderBy('urutan', 'desc')
            ->first();

            // Tentukan urutan berikutnya
            $urutan = $lastInvoice ? $lastInvoice->urutan + 1 : 1001;
            $no_invoice = $dijual_ke . '-' . $urutan;

            for ($i = 0; $i < count($r->id_produk); $i++) {
                $id_produk = $r->id_produk[$i];
                $qty = $r->qty[$i];
                $price = $r->price[$i];
                $produk = Produk::find($id_produk);
                $stok = $produk->stok - $qty;

                $pemilik = Pemilik::find($produk->pemilik_id);
                $ttl_rp = $pemilik->pemilik == $dijual_ke ? 0 : $qty * $price;

                TransaksiStok::create([
                    'produk_id' => $produk->id,
                    'jenis_transaksi' => 'penjualan',
                    'urutan' => $urutan,
                    'no_invoice' => $no_invoice,
                    'jumlah' => $qty,
                    'stok_sebelum' => $produk->stok,
                    'stok_setelah' => $stok,
                    'keterangan' => $keterangan,
                    'dijual_ke' => $dijual_ke,
                    'ttl_rp' => $ttl_rp,
                    'tanggal' => now(),
                    'admin' => $admin
                ]);
                $produk->update(['stok' => $stok]);
            }

            DB::commit();
            return redirect()->route('transaksi.history.penjualan', ['pemilik' => $dijual_ke])->with('sukses', 'Data Berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function void(Request $r)
    {
        try {
            DB::beginTransaction();

            $no_invoice = $r->no_invoice;

            // Ambil semua transaksi berdasarkan nomor invoice
            $transaksi = TransaksiStok::where('no_invoice', $no_invoice)->get();

            foreach ($transaksi as $item) {
                // Update stok produk
                $produk = Produk::find($item->produk_id);
                if ($produk && $item->jenis_transaksi === 'penjualan') {
                    // Tambahkan jumlah yang dijual kembali ke stok
                    $produk->update(['stok' => $produk->stok + $item->jumlah]);
                }
            }

            // Hapus semua transaksi berdasarkan nomor invoice
            TransaksiStok::where('no_invoice', $no_invoice)->delete();

            DB::commit();
            return redirect()->route('transaksi.history.penjualan')->with('sukses', 'Data Berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function history(Request $r)
    {
        $selectedPemilik = $r->pemilik ?? 'linda pribadi';
        $datas = TransaksiStok::getHistory(null, 'penjualan', $selectedPemilik);

        $data = [
            'title' => 'History Penjualan',
            'datas' => $datas,
        ];
        return view('transaksi_stok.penjualan.history', $data);
    }

    public function dataDetail($no_invoice, $title = 'Detail Penjualan')
    {
        $no_invoice = $no_invoice;
        $datas = TransaksiStok::with(['produk', 'produk.satuan'])->where('no_invoice', $no_invoice)->get();
        $totalPrice = $datas->sum(fn($item) => $item->ttl_rp);
        $totalQty = $datas->sum(fn($item) => $item->jumlah);

        $data = [
            'title' => $title,
            'datas' => $datas,
            'no_invoice' => $no_invoice,
            'totalPrice' => $totalPrice,
            'totalQty' => $totalQty,
        ];
        return $data;
    }

    public function detail_penjualan(Request $r)
    {
        $data = $this->dataDetail($r->no_invoice);
        return view('transaksi_stok.penjualan.detail', $data);
    }
    public function print_penjualan(Request $r)
    {
        $data = $this->dataDetail($r->no_invoice);

        return view('transaksi_stok.penjualan.print', $data);
    }

    public function stok_masuk(Request $r)
    {
        $admin = auth()->user()->name;
        $urutan = 1001 + TransaksiStok::where('jenis_transaksi', 'stok_masuk')->count();
        $no_invoice = "M" . '-' . $urutan;

        $pemilik = $r->pemilik ?? 'linda pribadi';
        $produk =  Produk::getAllProduk(null, $pemilik);

        $data = [
            'title' => 'Stok Masuk',
            'no_invoice' => $no_invoice,
            'admin' => $admin,
            'produk' => $produk,
            'pemilik' => $pemilik,
        ];
        return view('transaksi_stok.stok_masuk.index', $data);
    }

    public function save_stok_masuk(Request $r)
    {
        $tgl = $r->tgl;
        $no_invoice = $r->no_invoice;
        $pemilik = $r->pemilik;

        try {
            DB::beginTransaction();
            $lastInvoice = TransaksiStok::where('jenis_transaksi', 'stok_masuk')
            ->orderBy('urutan', 'desc')
            ->first();
            // Tentukan urutan berikutnya
            $urutan = $lastInvoice ? $lastInvoice->urutan + 1 : 1001;
            $no_invoice = 'M-' . $urutan;
            $admin = auth()->user()->name;
            for ($i = 0; $i < count($r->id_produk); $i++) {
                $id_produk = $r->id_produk[$i];
                $produk = Produk::find($id_produk);

                $qty = $r->qty[$i];

                TransaksiStok::create([
                    'produk_id' => $produk->id,
                    'jenis_transaksi' => 'stok_masuk',
                    'urutan' => $urutan,
                    'dijual_ke' => $pemilik,
                    'no_invoice' => $no_invoice,
                    'jumlah' => $qty,
                    'stok_sebelum' => $produk->stok,
                    'stok_setelah' => $produk->stok + $qty,
                    'keterangan' => null,
                    'tanggal' => $tgl,
                    'admin' => $admin
                ]);

                $produk->update(['stok' => $produk->stok + $qty]);
            }

            DB::commit();
            return redirect()->route('transaksi.history.stok_masuk')->with('sukses', 'Stok masuk berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function history_stok_masuk(Request $r)
    {
        $selectedPemilik = $r->pemilik ?? 'linda pribadi';
        $datas = TransaksiStok::getHistory(null, 'stok_masuk', $selectedPemilik);
        $data = [
            'title' => 'History Stok_masuk',
            'datas' => $datas
        ];
        return view('transaksi_stok.stok_masuk.history', $data);
    }

    public function print_stok_masuk(Request $r)
    {
        $data = $this->dataDetail($r->no_invoice, 'History Stok Masuk');

        return view('transaksi_stok.stok_masuk.print', $data);
    }

    public function void_stok_masuk(Request $r)
    {
        try {
            DB::beginTransaction();

            $no_invoice = $r->no_invoice;

            // Ambil semua data transaksi berdasarkan no_invoice
            $datas = TransaksiStok::where('no_invoice', $no_invoice)->get();

            foreach ($datas as $item) {
                $produk = Produk::find($item->produk_id);

                if ($produk && $item->jenis_transaksi === 'opname') {
                    // Kembalikan stok ke kondisi sebelum opname
                    $produk->update(['stok' => $item->stok_sebelum]);
                }
            }

            // Hapus semua transaksi opname terkait no_invoice
            TransaksiStok::where('no_invoice', $no_invoice)->delete();

            DB::commit();
            return redirect()->back()->with('sukses', 'Data opname berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function opname(Request $r)
    {
        $selectedPemilik = $r->pemilik ?? 'linda pribadi';
        $produk =  Produk::getAllProduk(null, $selectedPemilik);
        $data = [
            'title' => 'Opname Stok',
            'selectedPemilik' => $selectedPemilik,
            'produk' => $produk,
        ];
        return view('transaksi_stok.opname.index', $data);
    }

    public function save_opname(Request $r)
    {
        try {
            DB::beginTransaction();
            $lastInvoice = TransaksiStok::where('jenis_transaksi', 'opname')
            ->orderBy('urutan', 'desc')
            ->first();
            // Tentukan urutan berikutnya
            $urutan = $lastInvoice ? $lastInvoice->urutan + 1 : 1001;
            $no_invoice = 'O-' . $urutan;
            
            $admin = auth()->user()->name;
            $pemilik = $r->pemilik;
            for ($i = 0; $i < count($r->id_produk); $i++) {
                $id_produk = $r->id_produk[$i];
                $produk = Produk::find($id_produk);

                $stok_sistem = $produk->stok;
                $stok_sebelum = $r->stok_sebelum[$i];
                $stok_fisik = $r->stok_fisik[$i];
                $selisih = $stok_sebelum - $stok_fisik;
                $keterangan = $r->keterangan[$i] ?? '';

                $cekSelisih[] = $selisih;
                $cekSebelum[] = $stok_sebelum;
                if ($selisih !== 0) {
                    TransaksiStok::create([
                        'produk_id' => $produk->id,
                        'jenis_transaksi' => 'opname',
                        'urutan' => $urutan,
                        'dijual_ke' => $pemilik,
                        'no_invoice' => $no_invoice,
                        'jumlah' => $stok_fisik, // stok baru hasil opname
                        'stok_sebelum' => $stok_sistem,
                        'stok_setelah' => $stok_fisik,
                        'keterangan' => $keterangan,
                        'tanggal' => now(),
                        'admin' => $admin
                    ]);

                    $produk->update(['stok' => $stok_fisik]);
                } 
            }
            DB::commit();
            return redirect()->route('transaksi.opname', ['pemilik' => $pemilik])->with('sukses', 'Data Berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function history_opname(Request $r)
    {
        $selectedPemilik = $r->pemilik ?? 'linda pribadi';
        $datas = TransaksiStok::getHistory(null, 'opname', $selectedPemilik);
        $data = [
            'title' => 'History Opname',
            'datas' => $datas
        ];
        return view('transaksi_stok.opname.history', $data);
    }

    public function print_opname(Request $r)
    {
        $data = $this->dataDetail($r->no_invoice, 'History Opname');

        return view('transaksi_stok.opname.print', $data);
    }

    public function void_opname(Request $r)
    {
        try {
            DB::beginTransaction();

            $no_invoice = $r->no_invoice;

            // Ambil semua data transaksi berdasarkan no_invoice
            $datas = TransaksiStok::where('no_invoice', $no_invoice)->get();

            foreach ($datas as $item) {
                $produk = Produk::find($item->produk_id);

                if ($produk && $item->jenis_transaksi === 'opname') {
                    // Kembalikan stok ke kondisi sebelum opname
                    $produk->update(['stok' => $item->stok_sebelum]);
                }
            }

            // Hapus semua transaksi opname terkait no_invoice
            TransaksiStok::where('no_invoice', $no_invoice)->delete();

            DB::commit();
            return redirect()->back()->with('sukses', 'Data opname berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function export($jenis)
    {
        $jenis_transaksi = [
            'penjualan' => new PenjualanExport,
            'stok_masuk' => new StokMasukExport,
            'opname' => new OpnameExport,
        ];
        
        return Excel::download($jenis_transaksi[$jenis], "$jenis Export.xlsx");
    }

}
