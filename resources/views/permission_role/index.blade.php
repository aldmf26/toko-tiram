<x-app-layout :title="$title">
    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h3>{{ $title }}</h3>
            <button type="button" data-bs-toggle="modal" data-bs-target="#tambah" class="btn btn-primary"><i
                    class="fa fa-plus"></i> Tambah</button>
        </div>

    </x-slot>


    <div class="section">
        @php
            $pesan = session()->get('error') ? 'error' : 'sukses';
        @endphp
        <x-alert pesan="{{ session()->get($pesan) }}" />
        <div class="row">
            <div class="col-lg-6">
                <table class="table table-stripped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <form action="{{ route('permission.store') }}" method="post">
                            @csrf
                            <tr>
                                <td></td>
                                <td>
                                    <input required type="text" name="role" class="form-control"
                                        placeholder="tambah role baru">
                                </td>

                                <td>
                                    <button class="btn btn-sm btn-primary">Simpan</button>
                                </td>
                            </tr>
                        </form>
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $role->name }}</td>
                                <td class="d-flex gap-1">
                                    <button type="button" data-bs-toggle="modal"
                                        data-bs-target="#edit{{ $role->id }}" class="btn btn-sm btn-primary"><i
                                            class="fa fa-edit"></i></button>
                                    <a onclick="return confirm('Yakin hapus?')"
                                        href="{{ route('permission.destroy', $role->id) }}"
                                        class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @foreach ($roles as $role)
        <form action="{{ route('permission.update') }}" method="post">
            @csrf
            <x-modal idModal="edit{{ $role->id }}" size="modal-lg" title="Tambah Produk" btnSave="Y">
                <input type="hidden" name="role_id" value="{{ $role->id }}">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Nama Role</label>
                            <input type="text" name="role" value="{{ $role->name }}" class="form-control">
                        </div>
                    </div>
                </div>
                <!-- List Permission -->
                <div class="form-group">
                    <label for="">Permission</label>
                    <div class="row">
                        @foreach ($permissions as $permission)
                            <div class="col-lg-4">
                                <div class="form-check">
                                    <input id="{{$permission->name . $role->id}}" type="checkbox" name="permission[]" value="{{ $permission->name }}"
                                        class="form-check-input" @if ($role->permissions->contains('name', $permission->name)) checked @endif>
                                    <label for="{{$permission->name . $role->id}}" class="form-check-label">{{ $permission->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <x-multiple-input label="Tambah Row">
                    <div class="col-lg-9">
                        <div class="form-group">
                            <label for="">Permission</label>
                            <input type="text" name="permission[]" placeholder="contoh : produk.create"
                                class="form-control">
                        </div>
                    </div>
                </x-multiple-input>
            </x-modal>
        </form>
    @endforeach
</x-app-layout>
