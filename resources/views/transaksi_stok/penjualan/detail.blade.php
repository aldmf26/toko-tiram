<div class="list-group">
    @foreach($datas as $item)
    <div class="list-group-item p-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <!-- Gambar Produk -->
                <div class="me-3">
                    <img src="{{ asset('uploads/'.$item->produk->foto) }}" 
                         alt="{{ $item->produk->nama_produk }}"
                         class="rounded"
                         style="width: 60px; height: 60px; object-fit: cover;">
                </div>
                
                <!-- Info Produk -->
                <div>
                    <h6 class="mb-0">{{ $item->produk->nama_produk }}</h6>
                    <small class="text-muted">
                        {{ $item->produk->deskripsi }} | <span class="text-primary">#{{ $item->produk->tags }}</span>
                    </small>
                </div>
            </div>
            
            <!-- Harga -->
            <div class="text-end">
                <span class="text-sm mb-0">{{ number_format($item->produk->harga, 0) }}</span>
                <small class="text-muted">Qty: {{ $item->jumlah }}</small>
                <h6 class="mb-0">{{ number_format($item->produk->harga * $item->jumlah, 0) }}</h6>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="d-flex justify-content-end mt-4">
 
    <table class="table table-sm text-sm" style="width: 50%">
        <tbody>
            <tr>
                <td scope="row" class="text-start">Pemilik</td>
                <td class="text-end">{{ $datas[0]->produk->pemilik }}</td>
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
            <tr>
                <th scope="row" class="text-start">Grand Total</th>
                <td class="text-end">
                    <h5>{{ number_format($totalPrice, 0) }}</h5>
                </td>
            </tr>
        </tbody>
    </table>
</div>
