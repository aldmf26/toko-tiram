<?php

namespace App\Http\Livewire;
 
use Livewire\Component;
use App\Models\Pemilik;
use Livewire\WithPagination; // Untuk paginasi
use App\Models\Produk; // Import model Produk
use App\Models\Rak;
use App\Models\TransaksiStok;

class ProdukTable extends Component
{
    use WithPagination;
    public $selectedRak = null;
    public $selectedPemilik = null;

    public $search = ''; // Untuk fitur pencarian
    public $perPage = 10; // Jumlah data per halaman

    // Listener untuk menangkap event reset pencarian
    protected $listeners = ['resetSearch' => 'resetSearch', 'selectedRakItem', 'selectedPemilikItem'];


    public function resetSearch()
    {
        $this->reset('search');
    }

    public function selectedRakItem($rak)
    {
        $this->selectedRak = $rak;
        $this->resetPage();
    }


    public function selectedPemilikItem($pemilik)
    {
        $this->selectedPemilik = $pemilik;
        dd($this->selectedPemilik);
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage(); // Reset ke halaman pertama saat melakukan pencarian
    }

    public function delete($id)
    {
        Produk::find($id)->delete();
        TransaksiStok::where('produk_id', $id)->delete();

        session()->flash('sukses', 'Produk sukses terhapus.');
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
            ->when($this->selectedPemilik, function ($query) {
                $query->whereHas('pemilik', function ($query) {
                    $query->where('pemilik', $this->selectedPemilik);
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
            'raks' => Rak::all(),
            'pemiliks' => Pemilik::all(),
        ];

        return view('livewire.produk-table', $data) // Sesuaikan layout
            ->with('pagination', 'vendor.livewire.simple-bootstrap');;
    }
}
