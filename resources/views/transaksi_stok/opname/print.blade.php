<x-print :title="$title" :no_invoice="$datas[0]->no_invoice" :tanggal="$datas[0]->tanggal">

    <table class="table table-sm table-striped table-bordered">
        <thead class="bg-info text-white">
            <th class="text-center">No</th>
            <th>Nama Produk</th>
            <th>Pemilik</th>
            <th>Rak</th>
            <th width="130" class="text-end">Stok Program</th>
            <th width="100" class="text-end">Stok Fisik</th>
            <th width="100" class="text-end">Selisih</th>
            <th width="100" class="text-end">Satuan</th>
            <th>Keterangan</th>
        </thead>
        <tbody>
            @foreach ($datas as $d)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $d->produk->nama_produk }}</td>
                    <td>{{ $d->produk->pemilik->pemilik }}</td>
                    <td>{{ $d->produk->rak->rak }}</td>
                    <td class="text-end">{{ number_format($d->stok_sebelum, 0) }}</td>
                    <td class="text-end">{{ number_format($d->stok_setelah, 0) }}</td>
                    <td class="text-end">{{ number_format($d->stok_sebelum - $d->stok_setelah, 0) }}</td>
                    <td class="text-end">{{ $d->produk->satuan->satuan }}</td>
                    <td>{{ $d->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</x-print>
