<x-app-layout :title="$title">
    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h3>{{ $title }}</h3>

        </div>

    </x-slot>


    <div class="section">
        @include('transaksi_stok.nav_history')
        <x-pemilik_nav route="transaksi.history.penjualan" />

        <x-alert pesan="{{ session()->get('error') }}" />
        <table class="table table-hover" id="example">
            <thead class="bg-light">
                <tr>
                    <th class="text-center">#</th>
                    <th>Tanggal</th>
                    <th class="text-start">No Invoice</th>
                    <th class="text-end">Qty</th>
                    <th class="text-end">Ttl Rp</th>
                    <th>Dijual ke</th>
                    <th width="200">Ket</th>
                    <th>Admin</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($datas as $d)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ tglFormat($d->tgl) }}</td>
                        <td class="text-start">{{ $d->no_invoice }}</td>
                        <td class="text-end">{{ number_format($d->qty) }}</td>
                        <td class="text-end">{{ number_format($d->ttl_rp) }}</td>
                        <td>{{ $d->dijual_ke }}</td>
                        <td>{{ $d->ket }}</td>
                        <td>{{ $d->admin }}</td>
                        <td>
                            @can('history.penjualan.void')
                                <a onclick="return confirm('Yakin void?')"
                                    href="{{ route('transaksi.void.penjualan', ['no_invoice' => $d->no_invoice]) }}"
                                    class="btn btn-sm btn-danger">void</a>
                            @endcan

                            <a href="#" no_invoice="{{ $d->no_invoice }}"
                                class="btn btn-sm btn-primary detail"><i class="fas fa-eye"></i></a>
                            <a target="_blank"
                                href="{{ route('transaksi.print.penjualan', ['no_invoice' => $d->no_invoice]) }}"
                                class="btn btn-sm btn-primary"><i class="fas fa-print"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    <x-modal idModal="detail" size="modal-lg" title="Detail Penjualan" btnSave="N">
        rowodajs
    </x-modal>

    @section('scripts')
        <script>
            $(document).on('click', '.detail', function() {
                let no_invoice = $(this).attr('no_invoice');
                $('#detail').modal('show')

                $.ajax({
                    url: "{{ route('transaksi.detail.penjualan') }}",
                    method: "GET",
                    data: {
                        no_invoice: no_invoice
                    },
                    beforeSend: function() {
                        $('#detail .modal-body').html('loading...');
                    },
                    success: function(data) {
                        $('#detail .modal-body').html(data);
                    }
                })
            })
        </script>
    @endsection
</x-app-layout>
