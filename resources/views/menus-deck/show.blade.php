<x-app-layout>
    <div class="m-3">
        <div class="h2 mb-4">
            <a href="{{ route('menus-deck.index') }}" class="text-decoration-none text-dark">Menus Deck</a>
        </div>

        <div class="card p-3">
            <div class="mb-3">
                <label for="nama_menu" class="form-label">Nama Menu</label>
                <input type="text" class="form-control" id="nama_menu" name="nama_menu"
                    value="{{ $menusDeck->menu->nama_menu }}" disabled>
            </div>

            <div class="mb-3">
                <label for="total_serve" class="form-label">Total Serve</label>
                <input type="number" class="form-control" id="total_serve" name="total_serve"
                    value="{{ $menusDeck->total_serve }}" disabled>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <input type="text" class="form-control" id="status" name="status" value="{{ $menusDeck->status }}" disabled>
            </div>

            <div class="mb-3">
                <label for="tanggal_pelaksanaan" class="form-label">Tanggal Pelaksanaan</label>
                <input type="text" class="form-control" id="tanggal_pelaksanaan" name="tanggal_pelaksanaan"
                    value="{{ $menusDeck->tanggal_pelaksanaan }}" disabled>
            </div>

            <a href="{{ url()->previous() }}" class="btn btn-secondary mt-2">Kembali</a>
        </div>
    </div>
</x-app-layout>
