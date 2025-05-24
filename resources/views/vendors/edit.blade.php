<x-app-layout>
    <div class="m-3">
        <div class="h2 mb-4">Vendors</div>

        <div class="card p-3">
            <form action="{{ route('vendors.update', $vendor->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Vendor</label>
                    <input type="text" class="form-control" name="nama" value="{{ $vendor->nama }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kontak</label>
                    <input type="text" class="form-control" name="kontak" value="{{ $vendor->kontak }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <input type="text" class="form-control" name="alamat" value="{{ $vendor->alamat }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ $vendor->email }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Penilaian</label>
                    <input type="text" class="form-control" name="penilaian" value="{{ $vendor->penilaian }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea class="form-control" name="keterangan">{{ $vendor->keterangan }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="is_active" class="form-label">Status Aktif</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ isset($vendor) && $vendor->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Aktif
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('vendors.index') }}" class="btn btn-secondary">Batal</a>
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
