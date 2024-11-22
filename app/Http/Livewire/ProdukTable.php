<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination; // Untuk paginasi
use App\Models\Produk; // Import model Produk
class ProdukTable extends Component
{
    use WithPagination;

    public $search = ''; // Untuk fitur pencarian
    public $perPage = 10; // Jumlah data per halaman

    // Listener untuk menangkap event reset pencarian
    protected $listeners = ['resetSearch' => 'resetSearch'];

    public function resetSearch()
    {
        $this->reset('search');
    }

    public function updatingSearch()
    {
        $this->resetPage(); // Reset ke halaman pertama saat melakukan pencarian
    }

    public function render()
    {
        // Query data produk berdasarkan pencarian
        $products = Produk::query()
            ->where('nama_produk', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);
        $data = [
            'produk' => $products
        ];

        return view('livewire.produk-table', $data);
    }
}
