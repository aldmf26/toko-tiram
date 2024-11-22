<select name="rak" class="select2" id="selectRak">
    <option value="">- Pilih Rak -</option>
    <option value="tambah">Tambah Rak</option>
    @foreach ($rak as $r)
        <option value="{{ $r->id }}">{{ $r->rak }}</option>
    @endforeach
</select>