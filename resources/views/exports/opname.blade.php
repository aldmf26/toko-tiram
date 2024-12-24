<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>No Invoice</th>
            <th>Kode</th>
            <th>Nama Produk</th>
            <th>Pemilik</th>
            <th>Rak</th>
            <th>Stok Sebelum</th>
            <th>Stok Setelah</th>
            <th>Selisih</th>
            <th>Keterangan</th>
            <th>Admin</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($invoices as $d)
            <tr>
                <td>{{ tglFormat($d->tanggal) }}</td>
                <td>{{ $d->no_invoice }}</td>
                <td>{{ $d->produk->kd_produk }}</td>
                <td>{{ $d->produk->nama_produk }}</td>
                <td>{{ $d->produk->pemilik->pemilik }}</td>
                <td>{{ $d->produk->rak->rak }}</td>
                <td>{{ $d->stok_sebelum }}</td>
                <td>{{ $d->stok_setelah }}</td>
                <td>{{ $d->stok_sebelum - $d->stok_setelah }}</td>
                <td>{{ $d->keterangan }}</td>
                <td>{{ $d->admin }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center">Tidak ada data</td>
            </tr>
        @endforelse
    </tbody>
</table>

