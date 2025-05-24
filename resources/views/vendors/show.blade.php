<x-app-layout>
    <div class="m-3">
        <div class="h2 mb-4">Vendors</div>

        <div class="card p-3">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Vendor</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ $vendor->nama }}" disabled>
            </div>

            <div class="mb-3">
                <label for="kontak" class="form-label">Kontak</label>
                <input type="text" class="form-control" id="kontak" name="kontak" value="{{ $vendor->kontak }}" disabled>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $vendor->alamat }}" disabled>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $vendor->email }}" disabled>
            </div>

            <div class="mb-3">
                <label for="penilaian" class="form-label">Penilaian</label>
                <input type="text" class="form-control" id="penilaian" name="penilaian" value="{{ $vendor->penilaian }}"
                    disabled>
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan"
                    disabled>{{ $vendor->keterangan }}</textarea>
            </div>

            <div class="mb-3">
                <label for="is_active" class="form-label">Status</label>
                <input type="text" class="form-control" id="is_active" name="is_active"
                    value="{{ $vendor->is_active ? 'Aktif' : 'Nonaktif' }}" disabled>
            </div>

            <a href="{{ route('vendors.index') }}" class="btn btn-secondary mt-2">Kembali</a>
        </div>
    </div>
</x-app-layout>
