<?php

namespace App\Http\Livewire;

use App\Models\Saldo as ModelsSaldo;
use App\Models\TransaksiStok;
use Livewire\Component;

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
        $data = [
            'sisaSaldo' => $this->saldo - $ttlRpPenjualan
        ];
        return view('livewire.saldo', $data);
    }
}
