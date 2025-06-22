<x-app-layout>
    <div class="m-3">
        <div class="h2 mb-4">Menus Category</div>

        <div class="card p-3">
            <form action="{{ route('menus-component.update', $menusComponent->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label" for="nama_komponen">Nama Komponen</label>
                    <input type="text" class="form-control" name="nama_komponen" id="nama_komponen" value="{{ $menusComponent->nama_komponen }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="jenis_komponen">Jenis Komponen</label>
                    <input type="text" class="form-control" name="jenis_komponen" id="jenis_komponen" value="{{ $menusComponent->jenis_komponen }}">
                </div>

                <div class="mb-3">
                    <label for="is_active" class="form-label">Status Aktif</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ isset($menusComponent) && $menusComponent->is_active ? 'checked' : '' }}>
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
