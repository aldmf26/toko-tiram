<x-app-layout :title="$title">
    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h3>{{ $title }}</h3>
            {{-- <button type="button" data-bs-toggle="modal" data-bs-target="#tambah" class="btn btn-primary"><i
                    class="fa fa-plus"></i> Tambah</button> --}}
        </div>

    </x-slot>

    <form action="{{route('transaksi.save_stok_masuk')}}" method="post">
        @csrf
        <div class="section mb-5">
            @include('transaksi_stok.nav')
            <x-alert pesan="{{ session()->get('error') }}" />
            <x-pemilik_nav route="transaksi.stok_masuk" />

            <div class="row" x-data="{
                rows: ['1'],
                initSelect2: function() {
                    $('.selectGrade').select2({ width: 'element' });
                },
            
            }">
                <div class="col-lg-8">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tgl</th>
                                <th>No Invoice</th>
                                <th>Pemilik</th>
                                <th>Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="date" name="tgl" value="{{ date('Y-m-d') }}"
                                        class="form-control">
                                </td>
                                <td>
                                    <input type="text" readonly value="{{ $no_invoice }}" class="form-control">
                                    <input type="hidden" value="{{ $no_invoice }}" name="no_invoice">
                                </td>
                                <td>
                                    <input name="pemilik" type="text" readonly value="{{ $pemilik }}"
                                        class="form-control">
                                </td>
                                <td><input type="text" readonly value="{{ $admin }}" class="form-control">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Produk</th>
                                <th>Qty</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(row, index) in rows" :key="index">
                                <tr>
                                    <td x-text="index + 1"></td>
                                    <td>
                                        <select x-init="initSelect2" required name="id_produk[]"
                                            class="selectGrade grade" :urutan="index + 1" id="">
                                            <option value="">Pilih Produk</option>
                                            @foreach ($produk as $g)
                                                <option value="{{ $g->id }}">#{{ $g->kd_produk }} {{ ucwords($g->nama_produk) }}
                                                    ({{ $g->stok }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" autocomplete="off" class="text-end form-control"
                                            name="qty[]">
                                    </td>
                                    <td>
                                        <span @click="rows.splice(index, 1)" class="badge bg-danger pointer"><i
                                                class="fas fa-trash"></i></span>
                                    </td>
                                </tr>

                            </template>
                            <tr>
                                <td colspan="6"><button type="button" @click="rows.push({ value: '' })"
                                        class="btn btn-sm btn-primary btn-block"><i class="fas fa-plus"></i>
                                        Tambah</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <button class="btn btn-sm btn-primary float-end" type="submit"><i class="fas fa-save"></i> Simpan</button>
        </div>
    </form>
</x-app-layout>
