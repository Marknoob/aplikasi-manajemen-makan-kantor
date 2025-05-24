<x-app-layout>
    <div class="m-3">
        <div class="h2 mb-4">Tambah Biaya Menu Deck</div>

        <div class="card p-3">
            <form action="{{ route('menus-deck-expenses.store') }}" method="POST">
                @csrf

                <input type="hidden" class="form-control" name="menu_deck_id" id="menu_deck_id" value="{{ $menu_deck_id }}">

                <div class="mb-3">
                    <label class="form-label" for="deskripsi_biaya">Deskripsi Biaya</label>
                    <input type="text" class="form-control" name="deskripsi_biaya" id="deskripsi_biaya" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="jumlah_biaya">Jumlah Biaya</label>
                    <input type="number" class="form-control" name="jumlah_biaya" id="jumlah_biaya" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</x-app-layout>
