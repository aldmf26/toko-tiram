<x-maz-sidebar :href="route('transaksi.penjualan')">

    <!-- Add Sidebar Menu Items Here -->

    {{-- <x-maz-sidebar-item name="Dashboard" :link="route('dashboard')" icon="bi bi-grid-fill"></x-maz-sidebar-item> --}}
   
    @role('presiden')
    <x-maz-sidebar-item name="Produk" icon="bi bi-shop-window">
        <x-maz-sidebar-sub-item name="Daftar Produk" :link="route('produk.index')"></x-maz-sidebar-sub-item>
        {{-- <x-maz-sidebar-sub-item name="Daftar Rak / Satuan / Pemilik" :link="route('produk.daftar_rak')"></x-maz-sidebar-sub-item> --}}
    </x-maz-sidebar-item>
    
    @endrole
    
    <x-maz-sidebar-item name="Transaksi" icon="bi bi-shop-window">
        <x-maz-sidebar-sub-item name="Transaksi" :link="route('transaksi.penjualan')"></x-maz-sidebar-sub-item>
        <x-maz-sidebar-sub-item name="History" :link="route('transaksi.history.penjualan')"></x-maz-sidebar-sub-item>
    </x-maz-sidebar-item>
    @role('presiden')

    <x-maz-sidebar-item name="Data Master" icon="bi bi-person-circle">
        <x-maz-sidebar-sub-item name="Daftar User" :link="route('produk.index')"></x-maz-sidebar-sub-item>
        {{-- <x-maz-sidebar-sub-item name="Daftar Rak / Satuan / Pemilik" :link="route('produk.daftar_rak')"></x-maz-sidebar-sub-item> --}}
    </x-maz-sidebar-item>
    @endrole
</x-maz-sidebar>