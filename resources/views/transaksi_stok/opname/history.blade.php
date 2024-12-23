<x-app-layout :title="$title">
    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h3>{{ $title }}</h3>

        </div>

    </x-slot>


    <div class="section">
        @include('transaksi_stok.nav_history')

        <x-pemilik_nav route="transaksi.history.opname" />
        <x-alert pesan="{{ session()->get('error') }}" />
        <table class="table table-hover" id="example">
            <thead class="bg-light">
                <tr>
                    <th class="text-center">#</th>
                    <th>Tanggal</th>
                    <th class="text-start">No Invoice</th>
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
                        <td>{{ $d->admin }}</td>
                        <td align="center">
                            @can('history.opname.void')
                                <a onclick="return confirm('Yakin void?')"
                                    href="{{ route('transaksi.void.opname', ['no_invoice' => $d->no_invoice]) }}"
                                    class="btn btn-sm btn-danger">void</a>
                            @endcan 

                            <a target="_blank"
                                href="{{ route('transaksi.print.opname', ['no_invoice' => $d->no_invoice]) }}"
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
</x-app-layout>
