@props([
    'route' => '',
])
@php
    $routeName = Request::route()->getName();
    $ambilName = explode('.', Request::route()->getName());
    $ambilName = end($ambilName);
    $selectedPemilik = request()->get('pemilik') ?? 'linda pribadi';

    $cekBukanHistory = $routeName == 'transaksi.opname' || $routeName == 'transaksi.stok_masuk';
    $pemilik = DB::table('pemiliks as a')
        ->leftJoin('transaksi_stoks as b', 'b.dijual_ke', '=', 'a.pemilik')
        ->select('a.pemilik', DB::raw('COUNT(b.id) as total_invoice'))
        ->when(!$cekBukanHistory, function ($query) use ($ambilName) {
            return $query->where('b.jenis_transaksi', $ambilName);
        })
        ->groupBy('a.pemilik')
        ->get();

@endphp
<div class="mt-3 mb-2 d-flex flex-wrap gap-2">

    @foreach ($pemilik as $d)
        <a href="{{ route($route, ['pemilik' => $d->pemilik]) }}"
            class="btn {{ $d->pemilik == $selectedPemilik ? 'btn-primary' : 'btn-outline-primary' }} btn-sm"
            type="button">{{ ucwords($d->pemilik) }}
            {{ !$d->total_invoice || $cekBukanHistory ? '' : "($d->total_invoice)" }}</a>
    @endforeach
</div>
