<x-app-layout>
    <div class="m-3">
        <div class="h2 mb-4">Menus Category</div>

        <div class="card p-3">
            <form action="{{ route('menus-category.update', $menusCategory->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label" for="kategori_bahan_utama">Kategori Bahan Utama</label>
                    <input type="text" class="form-control" name="kategori_bahan_utama" id="kategori_bahan_utama" value="{{ $menusCategory->kategori_bahan_utama }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="keterangan">Keterangan</label>
                    <input type="text" class="form-control" name="keterangan" id="keterangan" value="{{ $menusCategory->keterangan }}">
                </div>

                <div class="mb-3">
                    <label for="is_active" class="form-label">Status Aktif</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ isset($menusCategory) && $menusCategory->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Aktif
                        </label>
                    </div>
                </div>

                <div class="d-flex flex-row justify-content-between">
                    <!-- Save edit button -->
                    <div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
                    </div>
                </div>
            </form>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
</x-app-layout>
