<x-app-layout>
    <div class="m-3">
        <div class="h2 mb-4">Tambah Pembayaran Menu Deck</div>

        <div class="card p-3">
            <form action="{{ route('menus-deck-payments.store') }}" method="POST">
                @csrf

                <input type="hidden" class="form-control" name="menu_deck_id" id="menu_deck_id" value="{{ $menu_deck_id }}">

                <div class="mb-3">
                    <label class="form-label" for="deskripsi_pembayaran">Deskripsi Pembayaran</label>
                    <input type="text" class="form-control" name="deskripsi_pembayaran" id="deskripsi_pembayaran" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="jumlah_bayar">Jumlah Bayar</label>
                    <input type="number" class="form-control" name="jumlah_bayar" id="jumlah_bayar" required>
                </div>

                <div class="mb-3">
                    <label for="tanggal_bayar" class="form-label">Tanggal Bayar</label>
                    <input type="date" class="form-control" name="tanggal_bayar" id="tanggal_bayar" required>
                </div>

                <div class="mb-3">
                    <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                    <select class="form-control" id="metode_pembayaran" name="metode_pembayaran" required>
                        <option value="">-- Pilih Metode --</option>
                        <option value="Transfer">Transfer</option>
                        <option value="Cash">Cash</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</x-app-layout>
