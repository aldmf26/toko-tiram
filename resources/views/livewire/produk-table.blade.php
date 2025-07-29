<div>
    <div class="row mb-4 mt-3">
        <div class="col-6">
            <input autofocus type="text" class="form-control" placeholder="Cari Produk..."
                wire:model.live.debounce.300ms="search">
        </div>
        <div class="col-3">
            <select wire:model.live="selectedRak" id="selectedRakId" required name="rak" style="width: 100%"
                class="selectRakFilter form-control">
                <option value="">Pilih Rak</option>
                @foreach ($raks as $rak)
                    <option>{{ $rak->rak }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-3">
            <select wire:model.live="selectedPemilik" id="selectedRakId" required name="rak" style="width: 100%"
                class="selectRakFilter form-control">
                <option value="">Pilih Pemilik</option>
                @foreach ($pemiliks as $pemilik)
                    <option>{{ $pemilik->pemilik }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <x-alert />
    <div wire:loading wire:target="delete">
        <button class="btn btn-secondary" type="button" disabled="">
            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
            Processing...
        </button>
    </div>
    <table class="table table-hover table-bordered">
        <thead class="bg-light">
            <tr>
                <th>#</th>
                <th>Foto</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Rak</th>
                {{-- <th>Tags</th> --}}
                <th>Pemilik</th>
                <th>Deskripsi</th>
                <th class="text-end">Harga Beli / Jual</th>
                <th class="text-end">Stok</th>
                <th class="text-end">Satuan</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produk as $i => $d)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        <div class="d-flex justify-content-center" style="max-width: 130px; height: 100px;">
                            @if (file_exists(public_path('uploads/' . $d->foto)))
                                <img style="width: 90px; height: 90px" class="mx-auto mh-100"
                                    src="{{ asset('uploads/' . $d->foto) }}">
                            @endif
                        </div>
                    </td>

                    <td>{{ $d->kd_produk }} </td>
                    <td>{{ $d->nama_produk }}</td>
                    <td>{{ $d->rak->rak }} </td>
                    {{-- <td class="text-primary">
                        {{ $d->tags }}
                    </td> --}}
                    <td>{{ $d->pemilik->pemilik }}</td>
                    <td>{{ $d->deskripsi }}</td>
                    <td align="right">{{ number_format($d->hrg_beli, 0) }} / {{ number_format($d->harga, 0) }}</td>
                    <td align="right">{{ $d->stok }}</td>
                    <td align="right">{{ $d->satuan->satuan }}</td>

                    <td align="center">
                        @can('produk.update')
                            <button class="btn btn-sm btn-primary edit_produk" id_produk="{{ $d->id }}"
                                data-bs-toggle="modal" data-bs-target="#edit">
                                <i class="fa fa-edit"></i>
                            </button>
                        @endcan
                        @can('produk.delete')
                            <button wire:confirm='jika dihapus maka terhapus juga data transaksi nya ?' wire:click="delete({{ $d->id }})" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-3 d-flex justify-content-between">
        <div>
            <select class="form-select" wire:model.live="perPage">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">50</option>
            </select>
        </div>
        <div>
            {{ $produk->links('vendor.livewire.simple-bootstrap') }} <!-- Paginasi -->
        </div>
    </div>
    {{-- @section('scripts')
        <script>
            document.addEventListener('livewire:init', function() {
                $('.selectRakFilter').select2();

            });

            document.addEventListener('livewire:update', function() {
                $('.selectRakFilter').select2();

            });

            $(document).ready(function() {
                $('#selectedRakId').on('change', function(e) {
                    livewire.emit('selectedRakItem', e.target.value)
                });

            });
        </script>
    @endsection --}}

</div>
