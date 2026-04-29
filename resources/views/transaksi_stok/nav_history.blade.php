@php
    $rot = request()->route()->getName();
    $ujungRoute = collect(explode('.', $rot))->last();
@endphp
<div class="d-flex gap-1 justify-content-between">
    <ul class="nav nav-pills float-start">
        @foreach (jenis_transaksi() as $d => $item)
            @can('history.' . $d)
                <li class="nav-item">
                    <a class="nav-link  {{ $rot == "transaksi.history.$d" ? 'active' : '' }}" aria-current="page"
                        href="{{ route("transaksi.history.$d") }}">{{ $d == 'stok_masuk' ? 'Stok Masuk' : ucwords($d) }}</a>
                </li>
            @endcan
        @endforeach
    </ul>
    <div class="">
        {{-- <a href="{{route("transaksi.export",$ujungRoute)}}" class="btn btn-md btn-success"><i class="fas fa-file-excel"></i> Export {{$ujungRoute == 'stok_masuk' ? 'Stok Masuk' : ucwords($ujungRoute)}}</a> --}}
    <a data-bs-toggle="modal" data-bs-target="#export" href="#" class="btn btn-md btn-success"><i
                class="fas fa-file-excel"></i> Export
            {{ $ujungRoute == 'stok_masuk' ? 'Stok Masuk' : ucwords($ujungRoute) }}</a>

        <form action="{{ route('transaksi.export', $ujungRoute) }}" method="GET">
            <x-modal idModal="export" title="Detail Penjualan">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="dari_tanggal" class="form-label">Dari Tanggal</label>
                            <input type="date" class="form-control" name="dari_tanggal" id="dari_tanggal" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="sampai_tanggal" class="form-label">Sampai Tanggal</label>
                            <input type="date" class="form-control" name="sampai_tanggal" id="sampai_tanggal"
                                required>
                        </div>
                    </div>
                </div>
            </x-modal>
        </form>
    </div>
</div>
<div class="col-lg-12">
    <hr style="border: 1px solid black;">
</div>
