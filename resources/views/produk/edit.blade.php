<div class="row p-2">
    <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-3 p-3">
        <div class="position-relative">
            <!-- Pratinjau Gambar -->
            <img id="bookCoverPreviewedit"
                src="{{ @getimagesize(public_path('/uploads/' . $produk->foto))
                    ? asset('/uploads/' . $produk->foto)
                    : asset('/uploads/default.jpg') }}"
                alt="Pratinjau Gambar" height="300" class="img-fluid z-1">
            <img id="imageLoad" src="" class="img-fluid d-none" height="300">
        </div>
    </div>
    
    <div class="col-12">
        <label for="imageEdit" class="form-label">Gambar</label>
        <div class="d-flex align-items-center gap-2">
            <input class="form-control" type="file" id="imageEdit" name="image" accept="image/*">
        </div>
    </div>



    <div class="col-2">
        <div class="mb-1">
            <label for="ind" class="form-label">Kode Produk</label>
            <input type="text" class="form-control" name="kd_produk" value="{{ $produk->kd_produk }}" required>
            <input type="hidden" class="form-control" name="id_produk" value="{{ $produk->id }}" required>
        </div>
    </div>
    <div class="col-4">
        <div class="mb-1">
            <label for="ind" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" name="nm_produk" value="{{ $produk->nama_produk }}" required>
        </div>
    </div>
    <div class="col-6 d-none">
        <div x-data="tagsInput()" class="mb-1">
            <label for="ind" class="form-label">Tags</label>
            <div class="input-group">
                <input x-model="input" @keydown.enter.prevent="addTag" @keydown.comma.prevent="addTag" type="text"
                    class="form-control" placeholder="pisahkan tags dengan koma (,)" autocomplete="off">
                <span class="input-group-text">#</span>
            </div>
            <div class="tags-container mt-2">
                <template x-for="(tag, index) in tags" :key="index">
                    <span class="badge bg-primary text-white d-inline-block m-1 p-2" x-text="tag + ' x'"
                        @click="removeTag(index)" style="cursor: pointer; display: inline-block;">
                        <span class="ms-2">&times;</span>
                    </span>
                </template>
                <input type="hidden" name="tags" :value="tags.join(',')" />
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="mb-1">
            <label for="ind" class="form-label">Deskripsi</label>
            <input placeholder="deskripsi" type="text" class="form-control" name="deskripsi"
                value="{{ $produk->deskripsi }}" required>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label for="">Harga Beli</label>
            <input type="text" name="hrg_beli" class="form-control" value="{{ $produk->hrg_beli }}">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label for="">Harga Jual</label>
            <input type="text" name="hrg_jual" class="form-control" value="{{ $produk->harga }}">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label for="">Stok</label>
            <input readonly type="text" name="stok" class="form-control" value="{{ $produk->stok }}">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label for="">Satuan</label>
            <select name="satuan_id" id="" class="select2">
                @foreach ($satuan as $s)
                    <option value="{{ $s->id }}" @selected($produk->satuan_id == $s->id)>{{ $s->satuan }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label for="">Rak</label>
            <select name="rak_id" id="" class="select2">
                @foreach ($rak as $s)
                    <option value="{{ $s->id }}" @selected($produk->rak_id == $s->id)>{{ $s->rak }}</option>
                @endforeach
            </select>

        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label for="">Pemilik</label>
            <select name="pemilik_id" id="" class="select2">
                @foreach ($pemilik as $s)
                    <option value="{{ $s->id }}" @selected($produk->pemilik_id == $s->id)>{{ $s->pemilik }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
