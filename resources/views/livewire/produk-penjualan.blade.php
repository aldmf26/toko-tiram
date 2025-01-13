<div>

    <x-alert pesan="{{ session()->get('error') }}" />
    <div class="row mt-4">
        <div class="col-lg-8">
            <input wire:model.live.debounce.500ms="search" type="text" class="form-control"
                placeholder="cari nama produk" autofocus>

            {{-- kategori tags --}}
            <div class="mt-3 d-flex flex-wrap gap-2">
                <button wire:click="$set('selectedTag', 'all')"
                    class="btn {{ is_null($selectedTag) || $selectedTag == 'all' ? 'btn-primary' : 'btn-outline-primary' }} btn-sm"
                    type="button">All</button>

                @foreach ($tags as $d)
                    <button wire:click="$set('selectedTag', '{{ $d->pemilik }}')"
                        class="btn {{ $selectedTag == $d->pemilik ? 'btn-primary' : 'btn-outline-primary' }} btn-sm"
                        type="button">{{ ucwords($d->pemilik) }}</button>
                @endforeach
            </div>

            {{-- produk view --}}
            <div wire:loading wire:target="search,selectedTag">
                <div class="spinner-border text-primary mt-1" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div class="row mt-4">
                @if (empty($produk))
                    <span>Produk Tidak Ditemukan.</span>
                @endif

                @foreach ($this->produk as $d)
                    <div class="col-lg-4">
                        <div class="card {{ $d->stok == 0 ? 'opacity-50' : '' }}" bis_skin_checked="1">
                            <div x-data="{ produkId: null, stokCukup: true }" class="card-content" bis_skin_checked="1">
                                
                                <div class="p-2 pointer hovercard" @click="console.log('Clicked: {{ $d->id }}'); $wire.addToCart({{ $d->id }})">
                                    <div class="card-text">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="pointer" >({{ $d->kd_produk }}) {{ ucwords($d->nama_produk) }}
                                            </h6>
                                            <span class=""><b>({{ number_format($d->stok, 0) }})</b></span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>{{ number_format($d->harga, 0) }}</span>
                                            <div>
                                                @if ($d->stok != 0)
                                                    <span  class="badge bg-primary pointer"><i
                                                            class="fas fa-plus"></i></span>
                                                @else
                                                    <span class="badge bg-danger">Habis</span>
                                                @endif
                                            </div>
                                        </div>
                                        <p class="mt-2 text-primary text-sm">{{ '#' . $d->tags }}</p>
                                        <p class="mt-2  text-sm">pemilik : {{ $d->pemilik->pemilik }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>

        <!-- Order Details -->
        <div class="col-lg-4">
            <form x-data="{
                isDisabled: false,
            
            }" action="{{ route('transaksi.save_pembayaran') }}" method="post">
                @csrf
                <h6>Order Details</h6>
                <div wire:loading wire:target="addToCart">
                    <div class="spinner-border text-primary mt-1" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                @if (!empty($orderDetails))
                    @foreach ($orderDetails as $order)
                    <input type="hidden" name="id_produk[]" value="{{ $order['id'] }}">
                    <input type="hidden" name="qty[]" value="{{ $order['quantity'] }}">
                    <input type="hidden" name="price[]" value="{{ $order['price'] }}">
                    
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                @if (file_exists(public_path('uploads/' . $order['image'])))
                                
                                    <img style="width: 90px; height: 90px"
                                        src="{{ strpos($order['image'], 'http') !== false ? $order['image'] : asset('/uploads/' . $order['image']) }}"
                                        alt="">
                            @endif
                            </div>
                            <div class="col-lg-8">
                                <b>{{ $order['name'] }}</b>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex gap-1 align-items-center">
                                        <span>Qty</span>
                                        <input type="number" name="orderDetails[{{ $order['id'] }}][quantity]"
                                            style="width: 60px" class="form-control"
                                            wire:model.live="orderDetails.{{ $order['id'] }}.quantity" min="1"
                                            max="{{ $order['stok'] }}">
                                    </div>
                                    <span>{{ number_format($order['price'] * $order['quantity'], 0) }}</span>
                                    <span wire:click="removeFromOrder({{ $order['id'] }})"
                                        class="text-danger pointer">X</span>
                                    <span wire:loading wire:target="removeFromOrder({{ $order['id'] }})">...</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span><b>Grand Total</b></span>
                        <h6>{{ number_format($totalPrice, 0) }}</h6>
                    </div>
                    <div class="mt-2">
                        <span>Dijual Ke</span>
                        <br>
                        <div wire:ignore x-data x-init="() => {
                            $('.select2dijual').select2();
                            
                        }">
                            <select class="select2dijual" name="dijual_ke">
                                <option value="">Dijual ke</option>
                                @foreach ($pemilik as $d)
                                    <option value="{{ $d->pemilik }}">{{ $d->pemilik }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="mt-2">
                        <span>keterangan</span>
                        <input required type="text" placeholder="untuk apa ?" class="form-control" name="keterangan">
                    </div>


                    <input type="hidden" name="totalPrice" value="{{ $totalPrice }}">
                    <button x-show="!isDisabled" @click="isDisabled = true" type="submit"
                        class="mt-3 btn btn-primary btn-block"><i class="fa fa-save"></i> Pembayaran</button>

                    <button x-show="isDisabled" class="mt-3 btn btn-primary btn-block" type="button" disabled="">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                @else
                    <p>No items in cart.</p>
                @endif
                
            </form>
        </div>

    </div>
    
  
</div>
