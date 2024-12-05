<div>
    <div class="row mb-4 mt-3">
        <div class="col-8">
            <input autofocus type="text" class="form-control" placeholder="Cari Produk..."
                wire:model.debounce.300ms="search">
        </div>
        <div class="col-4">
            <select wire:model="selectedRak" id="selectedRak" required name="rak" style="width: 100%" class="selectRak">
                <option value="">Pilih Rak</option>
                @foreach ($raks as $rak)
                    <option>{{ $rak->rak }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <table class="table table-hover table-bordered">
        <thead class="bg-light">
            <tr>
                <th>#</th>
                <th>Foto</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Rak</th>
                <th>Deskripsi</th>
                <th>Tags</th>
                <th class="text-end">Harga Beli / Jual</th>
                <th class="text-end">Stok</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produk as $i => $d)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        <div class="d-flex justify-content-center" style="max-width: 130px; height: 100px;">
                            <img style="width: 90px; height: 90px" class="mx-auto mh-100"
                                src="{{ @getimagesize(public_path('/uploads/' . $d->foto))
                                    ? asset('/uploads/' . $d->foto)
                                    : asset('/uploads/default.jpg') }}">
                        </div>
                    </td>


                    <td>{{ $d->kd_produk }} </td>
                    <td>{{ $d->nama_produk }}</td>
                    <td>{{ $d->rak->rak }} </td>
                    <td>{{ $d->deskripsi }}</td>
                    <td class="text-primary">
                        {{ $d->tags }}
                    </td>
                    <td align="right">{{ number_format($d->hrg_beli, 0) }} / {{ number_format($d->harga, 0) }}</td>
                    <td align="right">{{ $d->stok }}</td>
                    <td align="center">
                        <button class="btn btn-sm btn-primary edit_produk" id_produk="{{ $d->id }}"
                            data-bs-toggle="modal" data-bs-target="#edit">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-3 d-flex justify-content-between">
        <div>
            <select class="form-select" wire:model="perPage">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">50</option>
            </select>
        </div>
        <div>
            {{ $produk->links('vendor.livewire.simple-bootstrap') }} <!-- Paginasi -->
        </div>
    </div>
    @section('scripts')
        <script>
            document.addEventListener('livewire:load', function() {
                $('.selectRak').select2();

            });

            document.addEventListener('livewire:update', function() {
                $('.selectRak').select2();

            });

            $(document).ready(function() {
                $('#selectedRak').on('change', function(e) {
                    livewire.emit('selectedRakItem', e.target.value)
                });
            
            });
        </script>
    @endsection

</div>
