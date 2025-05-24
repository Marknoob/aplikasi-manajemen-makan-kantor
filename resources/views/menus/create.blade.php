<x-app-layout>
    <div class="m-3">
        <div class="h2 mb-4">Menus</div>

        <div class="card p-3">
            <form action="{{ route('menus.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nama_menu" class="form-label">Nama Menu</label>
                    <input type="text" class="form-control" id="nama_menu" name="nama_menu" required>
                </div>

                <div class="mb-3">
                    <label for="karbohidrat" class="form-label">Karbohidrat</label>
                    <input type="text" class="form-control" id="karbohidrat" name="karbohidrat" required>
                </div>

                <div class="mb-3">
                    <label for="protein" class="form-label">Protein</label>
                    <input type="text" class="form-control" id="protein" name="protein" required>
                </div>

                <div class="mb-3">
                    <label for="sayur" class="form-label">Sayur</label>
                    <input type="text" class="form-control" id="sayur" name="sayur" required>
                </div>

                <div class="mb-3">
                    <label for="buah" class="form-label">Buah</label>
                    <input type="text" class="form-control" id="buah" name="buah" required>
                </div>

                <div class="mb-3">
                    <label for="kategori_bahan_utama" class="form-label">Kategori Bahan Utama</label>
                    <input type="text" class="form-control" id="kategori_bahan_utama" name="kategori_bahan_utama" required>
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label">Harga (Rp)</label>
                    <input type="number" class="form-control" id="harga" name="harga" min="0" value="0" required>
                </div>

                <div class="mb-3">
                    <label for="vendor_id" class="form-label">Pilih Vendor</label>
                    <select class="form-control" id="vendor_id" name="vendor_id" required>
                        <option value="" disabled selected>-- Pilih Vendor --</option>
                        @foreach ($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ isset($menu) && $menu->vendor_id == $vendor->id ? 'selected' : '' }}>
                                {{ $vendor->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('menus.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</x-app-layout>
