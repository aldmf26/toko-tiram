<?php

namespace Tests\Feature;

use App\Models\Pemilik;
use App\Models\Produk;
use App\Models\Satuan;
use App\Models\TransaksiStok;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PrintPenjualanTest extends TestCase
{
    use RefreshDatabase;

    public function test_penjualan_print_count_is_limited_to_two_and_second_print_shows_copy_label(): void
    {
        $user = User::factory()->create();
        $pemilik = Pemilik::create(['pemilik' => 'linda pribadi']);
        $satuan = Satuan::create(['satuan' => 'pcs']);

        $produk = Produk::create([
            'nama_produk' => 'Produk Test',
            'deskripsi' => 'Deskripsi test',
            'harga' => 15000,
            'stok' => 10,
            'foto' => null,
            'admin' => $user->name,
            'hrg_beli' => 12000,
            'tags' => null,
            'satuan_id' => $satuan->id,
            'rak_id' => 0,
            'pemilik_id' => $pemilik->id,
            'kd_produk' => 1001,
        ]);

        $invoice = 'PNJ-TEST-001';

        TransaksiStok::create([
            'produk_id' => $produk->id,
            'jenis_transaksi' => 'penjualan',
            'jumlah' => 2,
            'stok_sebelum' => 10,
            'stok_setelah' => 8,
            'urutan' => 1,
            'no_invoice' => $invoice,
            'dijual_ke' => 'linda pribadi',
            'keterangan' => 'Penjualan test',
            'tanggal' => now(),
            'admin' => $user->name,
            'ttl_rp' => 30000,
            'print_count' => 0,
        ]);

        TransaksiStok::create([
            'produk_id' => $produk->id,
            'jenis_transaksi' => 'penjualan',
            'jumlah' => 1,
            'stok_sebelum' => 8,
            'stok_setelah' => 7,
            'urutan' => 2,
            'no_invoice' => $invoice,
            'dijual_ke' => 'linda pribadi',
            'keterangan' => 'Penjualan test',
            'tanggal' => now(),
            'admin' => $user->name,
            'ttl_rp' => 15000,
            'print_count' => 0,
        ]);

        $firstPrint = $this->actingAs($user)->get(route('transaksi.print.penjualan', ['no_invoice' => $invoice]));
        $firstPrint->assertStatus(200);
        $this->assertDatabaseHas('transaksi_stoks', [
            'no_invoice' => $invoice,
            'print_count' => 1,
        ]);

        $secondPrint = $this->actingAs($user)->get(route('transaksi.print.penjualan', ['no_invoice' => $invoice]));
        $secondPrint->assertStatus(200);
        $secondPrint->assertSee('COPY');
        $this->assertDatabaseHas('transaksi_stoks', [
            'no_invoice' => $invoice,
            'print_count' => 2,
        ]);

        $thirdPrint = $this->actingAs($user)->get(route('transaksi.print.penjualan', ['no_invoice' => $invoice]));
        $thirdPrint->assertStatus(403);
    }
}
