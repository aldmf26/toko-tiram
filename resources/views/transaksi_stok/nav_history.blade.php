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
        <a href="{{route("transaksi.export",$ujungRoute)}}" class="btn btn-md btn-success"><i class="fas fa-file-excel"></i> Export {{$ujungRoute == 'stok_masuk' ? 'Stok Masuk' : ucwords($ujungRoute)}}</a>
    </div>
</div>
<div class="col-lg-12">
    <hr style="border: 1px solid black;">
</div>
