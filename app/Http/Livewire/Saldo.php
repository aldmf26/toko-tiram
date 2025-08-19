<?php

namespace App\Http\Livewire;

use App\Models\Produk;
use App\Models\Saldo as ModelsSaldo;
use App\Models\TransaksiStok;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Http;


class Saldo extends Component
{
    public $saldo, $isLoading = false;

    public function mount()
    {
        $this->saldo = ModelsSaldo::latest()->value('saldo');
    }

    public function update()
    {
        $this->isLoading = true;
        ModelsSaldo::create([
            'saldo' => $this->saldo,
            'tgl' => date('Y-m-d'),
            'admin' => auth()->user()->name
        ]);
        $this->isLoading = false;
        $this->dispatch('close-modal', 'tambah');
    }
    public function render()
    {
        $ttlRpPenjualan = TransaksiStok::where('jenis_transaksi', 'penjualan')->sum('ttl_rp');
        // $ttlRpPenjualan = TransaksiStok::where('jenis_transaksi', 'penjualan')->sum('ttl_rp');
        $ttlHarga = Produk::sum(DB::raw('harga * stok'));
        $data = [
            'sisaSaldo' => $this->saldo - $ttlRpPenjualan + $ttlHarga
        ];
        return view('livewire.saldo', $data);
    }
}
