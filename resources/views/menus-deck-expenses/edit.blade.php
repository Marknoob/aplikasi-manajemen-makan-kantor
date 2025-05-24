<x-app-layout>
    <div class="m-3">
        <div class="h2 mb-4">Menus Deck Expenses</div>

        <div class="card p-3">
            <form action="{{ route('menus-deck-expenses.update', $menusDeckExpense->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label" for="deskripsi_biaya">Deskripsi Biaya</label>
                    <input type="text" class="form-control" name="deskripsi_biaya" id="deskripsi_biaya" value="{{ $menusDeckExpense->deskripsi_biaya }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="jumlah_biaya">Jumlah Biaya</label>
                    <input type="number" class="form-control" name="jumlah_biaya" id="jumlah_biaya" value="{{ (int) $menusDeckExpense->jumlah_biaya  }}" required>
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
