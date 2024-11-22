<div>
    <div class="mb-4">
        <input type="text" class="form-control" placeholder="Cari Produk..." wire:model.debounce.300ms="search">
    </div>
    <table class="table table-hover">
        <thead class="bg-light">
            <tr>
                <th>#</th>
                <th>Foto</th>
                <th>Nama</th>
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
                                src="{{ strpos($d->foto, 'http') !== false ? $d->foto : asset('/uploads/' . $d->foto) }}">
                        </div>
                    </td>
                    <td>{{ $d->nama_produk }}</td>
                    <td>{{ $d->deskripsi }}</td>
                    <td class="text-primary">
                        {{ $d->tags }}
                    </td>
                    <td align="right">{{ number_format($d->hrg_beli, 0) }} / {{ number_format($d->harga, 0) }}</td>
                    <td align="right">{{ $d->stok }}</td>
                    <td align="center">
                        <button class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-3 d-flex">
        <div>
            <select class="form-select" wire:model="perPage">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">50</option>
            </select>
        </div>
        <div>
            {{ $produk->links() }} <!-- Paginasi -->
        </div>
    </div>
</div>
