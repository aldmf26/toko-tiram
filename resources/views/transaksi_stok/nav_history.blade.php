@php
            $rot = request()->route()->getName();
        @endphp
        <div class="d-flex gap-1">
            <ul class="nav nav-pills float-start">
                @foreach (jenis_transaksi() as $d => $item)
                    <li class="nav-item">
                        <a class="nav-link  {{ $rot == "transaksi.history.$d" ? 'active' : '' }}" aria-current="page"
                            href="{{route("transaksi.history.$d")}}">{{ $d == 'stok_masuk' ? 'Stok Masuk' : ucwords($d) }}</a>
                    </li>
                @endforeach

            </ul>
        </div>
        <div class="col-lg-12">
            <hr style="border: 1px solid black;">
        </div>