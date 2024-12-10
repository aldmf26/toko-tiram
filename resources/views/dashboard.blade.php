<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Dashboard</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>


    <section class="section">
        <div class="card ">
            <div class="card-header">
                <h4 class="card-title">Menu</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3" bis_skin_checked="1">
                        <a href="{{route('transaksi.penjualan')}}">
                            <div 
                                class="card border card-hover  bg-info" bis_skin_checked="1">
                                <div class="card-front" bis_skin_checked="1">
                                    <div class="card-body" bis_skin_checked="1">
                                        <h4 class="card-title text-white text-center"><img
                                                src="https://sarang.ptagafood.com/img/kelas.png" width="100"
                                                alt=""><br><br>
                                            Transaksi Penjualan
                                        </h4>
                                    </div>
                                </div>

                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
