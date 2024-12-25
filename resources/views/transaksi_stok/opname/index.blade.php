<x-app-layout :title="$title">
    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h3>{{ $title }}</h3>
            {{-- <button type="button" data-bs-toggle="modal" data-bs-target="#tambah" class="btn btn-primary"><i
                    class="fa fa-plus"></i> Tambah</button> --}}
        </div>

    </x-slot>

    <form action="{{ route('transaksi.save_opname') }}" method="post">
        @csrf
        <div class="section">
            @include('transaksi_stok.nav')
            <x-pemilik_nav route="transaksi.opname" />
            <input type="hidden" name="pemilik" value="{{ request()->get('pemilik') }}"">
            <div class="mb-3 d-flex justify-content-between">
                <input id="cari" style="width:30%" type="text" class="form-control" placeholder="cari nama produk"
                    autofocus>
                <div>

                    <a href="{{ route('transaksi.history.opname') }}" class="btn btn-sm  btn-info">History</a>
                    @role('presiden')
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    @endrole
                </div>
            </div>
            
            <x-alert pesan="{{ session()->get('error') }}" />

            <table id="tbl" class="table table-striped table-bordered">
                <thead class="bg-info text-white">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th width="200">Nama </th>
                        <th>Pemilik</th>
                        <th>Rak</th>
                        <th width="100" class="text-end">Stok Program</th>
                        <th width="100" class="text-end">Stok Fisik</th>
                        <th width="100" class="text-end">Selisih</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produk as $i => $d)
                        <tr x-data="{
                            stok_sistem: {{ $d->stok }},
                            stok_fisik: {{ $d->stok }},
                            selisih: 0,
                           
                        }">
                            <td>{{ $i + 1 }}</td>
                            <td>
                                <div class="d-flex justify-content-center" style="max-width: 100px; height: 70px;">
                                    <img style="width: 60px; height: 60px" class="mx-auto mh-100"
                                        src="{{ strpos($d->foto, 'http') !== false ? $d->foto : asset('/uploads/' . $d->foto) }}">
                                </div>
                            </td>
                            <td>#{{ $d->kd_produk }} {{ $d->nama_produk }} | {{ $d->satuan->satuan ?? '' }}</td>
                            <td>{{ $d->pemilik->pemilik ?? '' }}</td>
                            <td>{{ $d->rak->rak ?? '' }}</td>
                            <td class="text-end {{ $d->stok < 1 ? 'text-danger' : '' }}">{{ $d->stok }}</td>
                            <td>
                                <input type="hidden" name="stok_sebelum[]" value="{{ $d->stok }}">
                                <input required type="text" value="{{ $d->stok }}"
                                    class="form-control text-end" name="stok_fisik[]" x-model="stok_fisik"
                                    @keyup="selisih = stok_sistem - stok_fisik" onclick="this.select()">
                            </td>
                            <td>
                                <input readonly type="text" class="form-control text-end" name="selisih[]"
                                    :value="selisih">
                                <input type="hidden" class="form-control text-end" name="id_produk[]"
                                    value="{{ $d->id }}">
                            </td>
                            <td>
                                <input placeholder="keterangan selisih" type="text" class="form-control"
                                    name="keterangan[]">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </form>
    @section('scripts')
        <script>
            pencarian('cari', 'tbl');
        </script>
    @endsection
</x-app-layout>
