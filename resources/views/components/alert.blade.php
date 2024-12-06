@props([
    'pesan' => '',
])
@if (session()->has('error'))
    <div class="col-lg-12">
        <div class="alert alert-danger">
            <i class="bi bi-file-excel"></i> {{ ucwords($pesan) }}.
        </div>
    </div>
@endif
@if (session()->has('sukses'))
    <div class="col-lg-12">
        <div class="alert alert-success">
            <i class="bi bi-file-excel"></i> {{ ucwords($pesan) }}.
        </div>
    </div>
@endif
