<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>No Invoice</th>
            <th>Kode</th>
            <th>Nama Produk</th>
            <th>Pemilik</th>
            <th>Rak</th>
            <th>Dijual kepada</th>
            <th>Untuk</th>
            <th>Qty</th>
            <th>Ttl Rp</th>
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
                <td>{{ $d->dijual_ke }}</td>
                <td>{{ $d->keterangan }}</td>
                <td>{{ $d->jumlah }}</td>
                <td>{{ $d->ttl_rp }}</td>
                <td>{{ $d->admin }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center">Tidak ada data</td>
            </tr>
        @endforelse
    </tbody>
</table>

