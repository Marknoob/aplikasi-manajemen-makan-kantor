<x-app-layout>
    <div class="m-3">
        <div class="h2 mb-4">Menus Category</div>

        <div class="card p-3">
            <form action="{{ route('menus-category.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="kategori_bahan_utama">Kategori Bahan Utama</label>
                    <input type="text" class="form-control" name="kategori_bahan_utama" id="kategori_bahan_utama" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="keterangan">Keterangan</label>
                    <input type="text" class="form-control" name="keterangan" id="keterangan">
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</x-app-layout>
