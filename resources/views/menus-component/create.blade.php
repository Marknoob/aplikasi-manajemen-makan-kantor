<x-app-layout>
    <div class="m-3">
        <div class="h2 mb-4">Menus Category</div>

        <div class="card p-3">
            <form action="{{ route('menus-component.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="nama_komponen">Nama Komponen</label>
                    <input type="text" class="form-control" name="nama_komponen" id="nama_komponen" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="jenis_komponen">Jenis Komponen</label>
                    <input type="text" class="form-control" name="jenis_komponen" id="jenis_komponen">
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</x-app-layout>
