<x-app-layout>
    <div class="m-3">
        <div class="h2 mb-4">Vendors</div>

        <div class="card p-3">
            <form action="{{ route('vendors.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Vendor</label>
                    <input type="text" class="form-control" name="nama" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kontak</label>
                    <input type="text" class="form-control" name="kontak" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <input type="text" class="form-control" name="alamat" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Penilaian</label>
                    <input type="text" class="form-control" name="penilaian" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea class="form-control" name="keterangan"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('vendors.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</x-app-layout>
