<div>

    <a href="#" data-bs-toggle="modal" data-bs-target="#tambahSaldo" class="btn btn-primary btn-sm">
        Sisa Saldo : Rp. {{ number_format($sisaSaldo, 0) }}

    </a>

    <form wire:submit.prevent='update'>
        <x-modal idModal="tambahSaldo" size="modal-lg" title="Tambah Produk">
            <div class="form-group">
                <label for="">Saldo Awal</label>
                <input type="number" wire:model='saldo' class="form-control">
            </div>
        </x-modal>
    </form>

    @section('scripts')
        <script>
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('close-modal', () => {
                    $('#tambahSaldo').modal('hide');
                });
            });
        </script>
    @endsection

</div>
