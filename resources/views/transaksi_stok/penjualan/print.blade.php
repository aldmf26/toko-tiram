<x-print :title="$title" :no_invoice="$datas[0]->no_invoice" :tanggal="$datas[0]->tanggal">
    <x-slot name="table">
        <table class="table table-sm">
            <tbody>
                <tr>
                    <td scope="row" class="text-start">Pemilik</td>
                    @php
                        $cekSama = strtolower($datas[0]->produk->pemilik->pemilik) == strtolower($datas[0]->dijual_ke);
                    @endphp
                    <td class="text-end">{{ $datas[0]->produk->pemilik->pemilik }}</td>
                </tr>
                <tr>
                    <td scope="row" class="text-start">Dijual kepada</td>
                    <td class="text-end">{{ $datas[0]->dijual_ke }}</td>
                </tr>
                <tr>
                    <td scope="row" class="text-start">Untuk</td>
                    <td class="text-end">{{ $datas[0]->keterangan }}</td>
                </tr>
                <tr>
                    <td scope="row" class="text-start">Admin</td>
                    <td class="text-end">{{ $datas[0]->admin }}</td>
                </tr>
              
            </tbody>
        </table>
    </x-slot>

    <table class="table table-sm table-striped table-bordered">
        <thead class="bg-info text-white">
            <th class="text-center">No</th>
            <th>Nama Produk</th>
            <th class="text-end">Harga</th>
            <th class="text-end">Qty</th>
            <th class="text-end">Satuan</th>
            <th class="text-end">Ttl Rp</th>
        </thead>
        <tbody>
            @foreach ($datas as $d)
            @php
                $harga = $d->ttl_rp / $d->jumlah;
            @endphp
                <tr>
                    <td align="center">{{ $loop->iteration }}</td>
                    <td>{{ $d->produk->nama_produk }}</td>
                    <td class="text-end">{{ number_format($harga, 0) }}</td>
                    <td class="text-end">{{ number_format($d->jumlah, 0) }}</td>
                    <td class="text-end">{{ $d->produk->satuan->satuan }}</td>
                    @php
                        $ttl = $cekSama ? 0 : $harga * $d->jumlah;
                    @endphp
                    <td class="text-end">{{ number_format($ttl, 0) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Grand Total</th>
                <th class="text-end">
                    <h5>{{ number_format($totalQty, 0) }}</h5>
                </th>
                <th></th>
                <th class="text-end">
                    <h5>{{ number_format($cekSama ? 0 : $totalPrice, 0) }}</h5>
                </th>
            </tr>
        </tfoot>
    </table>

</x-print>
