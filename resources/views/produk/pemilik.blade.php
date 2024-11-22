<select name="pemilik" class="select2" id="selectPemilik">
    <option value="">- Pilih Pemilik -</option>
    <option value="tambah">Tambah Pemilik</option>
    @foreach ($pemilik as $p)
        <option value="{{ $p->id }}">{{ $p->pemilik }}</option>
    @endforeach
</select>