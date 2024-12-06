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
            <div class="col-lg-12">
                <table class="table table-stripped table-bordered" id="tableUser">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach ($user->roles as $role)
                                        {{ $role->name }}
                                    @endforeach
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @section('scripts')
        <script>
            new DataTable('#tableUser');
        </script>
    @endsection
</x-app-layout>
