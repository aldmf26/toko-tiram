@php
    $rot = request()->route()->getName();
@endphp
<div class="d-flex gap-1">
    <ul class="nav nav-pills float-start">

        @foreach (jenis_transaksi() as $d => $item)
            @if ($d != 'opname')
                <li class="nav-item">
                    <a class="nav-link  {{ $rot == "transaksi.$d" ? 'active' : '' }}" aria-current="page"
                        href="{{ route("transaksi.$d") }}">{{ $d == 'stok_masuk' ? 'Stok Masuk' : ucwords($d) }}</a>
                </li>
            @endif
        @endforeach
        @if (auth()->user()->hasRole('presiden'))
            <li class="nav-item">
                <a class="nav-link  {{ $rot == 'transaksi.opname' ? 'active' : '' }}" aria-current="page"
                    href="{{ route('transaksi.opname') }}">Opname</a>
            </li>
        @endif
    </ul>
</div>
<div class="col-lg-12">
    <hr style="border: 1px solid black;">
</div>
