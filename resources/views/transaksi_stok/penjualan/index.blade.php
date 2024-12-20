<x-app-layout :title="$title">
    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h3>{{ $title }}</h3>
            {{-- <button type="button" data-bs-toggle="modal" data-bs-target="#tambah" class="btn btn-primary"><i
                    class="fa fa-plus"></i> Tambah</button> --}}
        </div>

    </x-slot>


    <div class="section">
        @include('transaksi_stok.nav')
        <x-alert pesan="{{ session()->get('error') }}" />
        @livewire('produk-penjualan')

    </div>

</x-app-layout>
