<x-app-layout>
    <div class="m-3">
        <div class="h2 mb-4">Menus</div>

        <div class="card p-3">
            <div class="mb-3">
                <label for="nama_menu" class="form-label">Nama Menu</label>
                <input type="text" class="form-control" id="nama_menu" name="nama_menu" value="{{ $menu->nama_menu }}"
                    disabled>
            </div>

            <div class="mb-3">
                <label for="karbohidrat" class="form-label">Karbohidrat</label>
                <input type="text" class="form-control" id="karbohidrat" name="karbohidrat" value="{{ $menu->karbohidrat }}"
                    disabled>
            </div>

            <div class="mb-3">
                <label for="protein" class="form-label">Protein</label>
                <input type="text" class="form-control" id="protein" name="protein" value="{{ $menu->protein }}" disabled>
            </div>

            <div class="mb-3">
                <label for="sayur" class="form-label">Sayur</label>
                <input type="text" class="form-control" id="sayur" name="sayur" value="{{ $menu->sayur }}" disabled>
            </div>

            <div class="mb-3">
                <label for="buah" class="form-label">Buah</label>
                <input type="text" class="form-control" id="buah" name="buah" value="{{ $menu->buah }}" disabled>
            </div>

            <div class="mb-3">
                <label for="kategori_bahan_utama" class="form-label">Kategori Bahan Utama</label>
                <input type="text" class="form-control" id="kategori_bahan_utama" name="kategori_bahan_utama"
                    value="{{ $menu->kategori_bahan_utama }}" disabled>
            </div>

            <div class="mb-3">
                <label for="vendor_id" class="form-label">Vendor ID</label>
                <input type="number" class="form-control" id="vendor_id" name="vendor_id" value="{{ $menu->vendor_id }}"
                    disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="text" class="form-control" value="Rp. {{ number_format($menu->harga, 0, ',', '.') }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah Vote</label>
                <input type="text" class="form-control" value="{{ $menu->jumlah_vote }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Terakhir Dipilih</label>
                <input type="text" class="form-control"
                    value="{{ $menu->terakhir_dipilih ? \Carbon\Carbon::parse($menu->terakhir_dipilih)->format('Y-m-d') : '-' }}"
                    disabled>
            </div>

            <div class="mb-3">
                <label for="is_active" class="form-label">Status</label>
                <input type="text" class="form-control" id="is_active" name="is_active"
                    value="{{ $menu->is_active ? 'Aktif' : 'Nonaktif' }}" disabled>
            </div>

            <a href="{{ url()->previous() }}" class="btn btn-secondary mt-2">Kembali</a>
        </div>
    </div>
</x-app-layout>
