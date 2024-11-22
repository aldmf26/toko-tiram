<x-app-layout :title="$title">
    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h3>{{ $title }}</h3>
            {{-- <button type="button" data-bs-toggle="modal" data-bs-target="#tambah" class="btn btn-primary"><i
                    class="fa fa-plus"></i> Tambah</button> --}}
        </div>

    </x-slot>


    <div class="section">
        <x-alert pesan="{{ session()->get('error') }}" />
        <div class="row">
            <div class="col-6">
                <table class="table table-bordered" id="example">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Rak</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rak as $r)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $r->rak }}</td>
                                <td>
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>
