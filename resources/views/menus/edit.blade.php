<x-app-layout>
    <div class="m-3">
        <div class="h2 mb-4">Menus</div>

        <div class="card p-3">
            <form action="{{ route('menus.update', $menu->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama_menu" class="form-label">Nama Menu</label>
                    <input type="text" class="form-control" id="nama_menu" name="nama_menu" value="{{ $menu->nama_menu }}" required>
                </div>

                <div class="mb-3">
                    <label for="karbohidrat" class="form-label">Karbohidrat</label>
                    <input type="text" class="form-control" id="karbohidrat" name="karbohidrat" value="{{ $menu->karbohidrat }}"
                        required>
                </div>

                <div class="mb-3">
                    <label for="protein" class="form-label">Protein</label>
                    <input type="text" class="form-control" id="protein" name="protein" value="{{ $menu->protein }}" required>
                </div>

                <div class="mb-3">
                    <label for="sayur" class="form-label">Sayur</label>
                    <input type="text" class="form-control" id="sayur" name="sayur" value="{{ $menu->sayur }}" required>
                </div>

                <div class="mb-3">
                    <label for="buah" class="form-label">Buah</label>
                    <input type="text" class="form-control" id="buah" name="buah" value="{{ $menu->buah }}" required>
                </div>

                <div class="mb-3">
                    <label for="kategori_bahan_utama" class="form-label">Kategori Bahan Utama</label>
                    <input type="text" class="form-control" id="kategori_bahan_utama" name="kategori_bahan_utama"
                        value="{{ $menu->kategori_bahan_utama }}" required>
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="harga" name="harga" value="{{ $menu->harga }}" required>
                </div>

                <div class="mb-3">
                    <label for="jumlah_vote" class="form-label">Jumlah Vote</label>
                    <input type="number" class="form-control" id="jumlah_vote" name="jumlah_vote" value="{{ $menu->jumlah_vote }}"
                        required>
                </div>

                <div class="mb-3">
                    <label for="terakhir_dipilih" class="form-label">Terakhir Dipilih</label>
                    <input type="text" class="form-control" id="terakhir_dipilih" name="terakhir_dipilih"
                        value="{{ $menu->terakhir_dipilih != null ? \Carbon\Carbon::parse($menu->terakhir_dipilih)->format('Y-m-d') : '-' }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="vendor_id" class="form-label">Pilih Vendor</label>
                    <select class="form-control" id="vendor_id" name="vendor_id" required>
                        <option value="" disabled selected>Pilih Vendor</option>
                        @foreach ($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ isset($menu) && $menu->vendor_id == $vendor->id ? 'selected' : '' }}>
                                {{ $vendor->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="is_active" class="form-label">Status Aktif</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ isset($menu) && $menu->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Aktif
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
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
