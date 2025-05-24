<x-app-layout>
    <div class="m-3">
        <div class="h2 mb-4">Menus Deck Expenses</div>

        <div class="card p-3">
            <form action="{{ route('menus-deck-payments.update', $menusDeckPayment->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label" for="deskripsi_pembayaran">Deskripsi Pembayaran</label>
                    <input type="text" class="form-control" name="deskripsi_pembayaran" id="deskripsi_pembayaran" value="{{ $menusDeckPayment->deskripsi_pembayaran }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="jumlah_bayar">Jumlah Bayar</label>
                    <input type="number" class="form-control" name="jumlah_bayar" id="jumlah_bayar" value="{{ (int) $menusDeckPayment->jumlah_bayar }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="tanggal_bayar" >Tanggal Bayar</label>
                    <input type="date" class="form-control" name="tanggal_bayar" id="tanggal_bayar" value="{{ $menusDeckPayment->tanggal_bayar }}" required>
                </div>

                <div class="mb-3">
                    <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                    <select class="form-control" id="metode_pembayaran" name="metode_pembayaran" required>
                        <option value="">-- Pilih Metode --</option>
                        <option value="Transfer" {{ $menusDeckPayment->metode_pembayaran == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                        <option value="Cash" {{ $menusDeckPayment->metode_pembayaran == 'Cash' ? 'selected' : '' }}>Cash</option>
                        <option value="Lainnya" {{ $menusDeckPayment->metode_pembayaran == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
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
