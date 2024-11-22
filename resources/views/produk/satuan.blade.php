<select name="satuan" class="select2" id="selectSatuan">
    <option value="">- Pilih Satuan -</option>
    <option value="tambah">Tambah Satuan</option>
    @foreach ($satuan as $r)
        <option value="{{ $r->id }}">{{ $r->satuan }}</option>
    @endforeach
</select>