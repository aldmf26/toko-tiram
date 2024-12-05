<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination; // Untuk paginasi
use App\Models\Produk; // Import model Produk
use App\Models\Rak;

class ProdukTable extends Component
{
    use WithPagination;
    public $selectedRak = null;

    public $search = ''; // Untuk fitur pencarian
    public $perPage = 10; // Jumlah data per halaman

    // Listener untuk menangkap event reset pencarian
    protected $listeners = ['resetSearch' => 'resetSearch', 'selectedRakItem'];


    public function resetSearch()
    {
        $this->reset('search');
    }

    public function selectedRakItem($rak)
    {
        $this->selectedRak = $rak;
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage(); // Reset ke halaman pertama saat melakukan pencarian
    }

    public function render()
    {
        // Query data produk berdasarkan pencarian
        $products = Produk::query()
            ->when($this->selectedRak, function ($query) {
                $query->whereHas('rak', function ($query) {
                    $query->where('rak', $this->selectedRak);
                });
            })
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('nama_produk', 'like', '%' . $this->search . '%')
                        ->orWhere('kd_produk', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('kd_produk', 'DESC')
            ->paginate($this->perPage);

        $data = [
            'produk' => $products,
            'raks' => Rak::all()
        ];

        return view('livewire.produk-table', $data) // Sesuaikan layout
            ->with('pagination', 'vendor.livewire.simple-bootstrap');;
    }
}
