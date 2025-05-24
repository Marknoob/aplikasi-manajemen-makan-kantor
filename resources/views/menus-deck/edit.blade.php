<x-app-layout>
    <div class="m-3">
        <div class="h2 mb-4">
            <a href="{{ route('menus-deck.index') }}" class="text-decoration-none text-dark">Menus Deck</a>
        </div>

        <div class="card p-3">
            <form id="formEdit" action="{{ route('menus-deck.update', $menusDeck->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Data Details -->
                <p class="fs-5 d-flex justify-content-end" style="font-weight: bold;">Data Details</p>
                <div class="mb-3">
                    <label for="menu_id" class="form-label">Menu</label>
                    <select class="form-control" id="menu_id" name="menu_id" {{ $menusDeck->status == 1 ? 'disabled' : '' }}
                        required>
                        @foreach($menus as $menu)
                            <option value="{{ $menu->id }}" {{ $menusDeck->menu_id == $menu->id ? 'selected' : '' }}>
                                {{ $menu->nama_menu }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="total_serve" class="form-label">Total Serve</label>
                    <input type="number" class="form-control" id="total_serve" name="total_serve"
                        value="{{ $menusDeck->total_serve }}" {{ $menusDeck->status == 1 ? 'disabled' : '' }} required>
                </div>

                <input type="hidden" class="form-control" id="status" name="status" value="{{ $menusDeck->status }}">

                <div class="mb-3">
                    <label for="tanggal_pelaksanaan" class="form-label">Tanggal Pelaksanaan</label>
                    <input type="date" class="form-control" id="tanggal_pelaksanaan" name="tanggal_pelaksanaan"
                        value="{{ $menusDeck->tanggal_pelaksanaan }}" {{ $menusDeck->status == 1 ? 'disabled' : '' }} required
                        disabled>
                </div>

                @if ($menusDeck->status == 0)
                    <div class="d-flex flex-row justify-content-between">
                        <!-- Save edit button -->
                        <div>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="{{ route('menus-deck.index') }}" class="btn btn-secondary">Batal</a>
                        </div>

                        <!-- Confirm menu button -->
                        <button type="button" class="btn" style="background-color: #b6f2b6; border: 1px solid #59c459;"
                            onclick="handleConfirmClick()">
                            Konfirmasi Menu
                        </button>

                    </div>
                @else
                    <!-- Expenses Details -->
                    <p class="mt-5 fs-5 d-flex justify-content-end" style="font-weight: bold;">Expenses Details</p>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('menus-deck-expenses.create', ['menu_deck_id' => $menusDeck->id]) }}"
                            class="btn btn-primary mb-2 mt-2">+ Tambah Biaya</a>

                        <!-- Status -->
                        <div class="d-flex align-items-center">
                            <label for="status" class="form-label">Status: </label>
                            <div class="ms-2 px-2 py-1 rounded" style="
                                        width: 135px;
                                        background-color:
                                        @if ($menusDeck->status_lunas == "Paid")
                                            #b6f2b6
                                        @elseif ($menusDeck->status_lunas == "Half Paid")
                                            #a5d8ff
                                        @else
                                            #ffd2d2
                                        @endif
                                        ;

                                        border: 1px solid
                                        @if ($menusDeck->status_lunas == "Paid")
                                            #59c459
                                        @elseif ($menusDeck->status_lunas == "Half Paid")
                                            #1971c2
                                        @else
                                            #ff7a7a
                                        @endif
                                        ;
                                        text-align: center;
                                    ">
                                {{ $menusDeck->status_lunas }}
                            </div>
                        </div>
                    </div>

                    <!-- Header Total Serve -->
                    <div class="row my-3 align-items-center">
                        <div class="col-auto">
                            <label for="total_serve">Total Serve</label>
                            <input type="number" id="total_serve" name="total_serve" class="form-control"
                                value="{{ $menusDeck->total_serve }}" disabled>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-xmark"></i>
                        </div>
                        <div class="col-auto">
                            <label for="harga_menu">Harga Menu</label>
                            <input type="text" id="harga_menu" name="harga_menu" class="form-control"
                                value="{{ 'Rp. ' . number_format($menusDeck->menu->harga, 0, ',', '.') }}" disabled>
                        </div>
                        @php
                            // Ambil data expense pertama jika ada
                            if ($expenses->isNotEmpty()) {
                                $firstExpense = $expenses->first()->jumlah_biaya;
                            } else {
                                $firstExpense = 0;
                            }
                        @endphp
                        <div class="col-auto">
                            <label for="total_harga">Total Harga</label>
                            <input type="text" id="total_harga" name="total_harga" class="form-control"
                                value="{{ 'Rp. ' . number_format($firstExpense, 0, ',', '.') }}"
                                readonly disabled>
                        </div>
                    </div>

                    <hr>

                    <!-- Deskripsi Biaya -->
                    @foreach ($expenses as $index => $expense)
                        @if ($index != 0) <!-- Biaya Pokok tidak ditampilkan, sudah ada di header -->
                            <div class="row mb-3 align-items-center">
                                <div class="col-auto">
                                    <a class="btn" href="{{ route('menus-deck-expenses.edit', $expense->id) }}">
                                        <i class="fa-solid fa-pen" style="color: #2f5e81;"></i>
                                    </a>
                                </div>
                                <div class="col-5">
                                    <input type="text" name="expenses[{{ $index }}][deskripsi_biaya]"
                                        value="{{ $expense->deskripsi_biaya }}" class="form-control" disabled>
                                </div>
                                <div class="col-5">
                                    <input type="text" name="expenses[{{ $index }}][jumlah_biaya]"
                                        value="{{ 'Rp. ' . number_format($expense->jumlah_biaya, 0, ',', '.') }}" class="form-control"
                                        disabled>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    <hr>

                    <!-- Total Semua -->
                    <div class="row mb-3">
                        <div class="col-auto">
                            <label for="total_semua">Total Semua</label>
                            <input type="text" id="total_semua" name="total_semua" class="form-control" readonly disabled
                                value="{{ 'Rp. ' . number_format($total_biaya, 0, ',', '.') }}">
                        </div>
                    </div>


                    <!-- Expenses Details -->
                    <p class="mt-5 fs-5 d-flex justify-content-end" style="font-weight: bold;">Payment Details</p>

                    @if ($menusDeck->status_lunas != 'Paid')
                        <a href="{{ route('menus-deck-payments.create', ['menu_deck_id' => $menusDeck->id]) }}"
                            class="btn btn-primary mb-2 mt-2">+ Tambah Pembayaran</a>
                    @endif

                    <div class="card p-3 my-3">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 40px;">Aksi</th>
                                    <th scope="col">Deskripsi Pembayaran</th>
                                    <th scope="col">Jumlah Bayar</th>
                                    <th scope="col">Tanggal Pembayaran</th>
                                    <th scope="col">Metode Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $payment)
                                    <tr>
                                        <td style="width: 40px; text-align: center">
                                            <a class="text-decoration-none text-reset"
                                                href="{{ route('menus-deck-payments.edit', $payment->id)}}">
                                                <i class="fa-solid fa-pen" style="color: #2f5e81;"></i>
                                            </a>
                                        </td>
                                        <td>{{$payment->deskripsi_pembayaran}}</td>
                                        <td>{{ 'Rp. ' . number_format($payment->jumlah_bayar, 0, ',', '.') }}</td>
                                        <td>{{$payment->tanggal_bayar}}</td>
                                        <td>{{$payment->metode_pembayaran}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </form>
        </div>

        <!-- Modal Konfirmasi -->
        <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p class="fs-5" style="font-weight: bold;">Apakah anda yakin mengkonfirmasi menu ini?</p>
                        <p>*Note: Pastikan Pesanan Menu ini telah dikonfirmasi oleh pihak penyedia / vendor, karena Anda
                            tidak dapat mengubah menu ini setelah dikonfirmasi</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn" data-bs-dismiss="modal" style="
                                    background-color: #ffd2d2;
                                    border: 1px solid #ff7a7a;">
                            Batal
                        </button>
                        <button type="button" class="btn" onclick="confirmMenu()" style="
                                    background-color: #b6f2b6;
                                    border: 1px solid #59c459;">
                            Ya, Konfirmasi
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <script src="/bootstrap/js/bootstrap.min.js"></script>

    <script>
        function handleConfirmClick() {
            const form = document.getElementById('formEdit');

            // Validasi form field
            if (form.checkValidity()) {
                const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
                modal.show();
            } else {
                // Jika ada field yang belum diisi, tampilkan pesan error
                form.reportValidity();
            }
        }

        function confirmMenu() {
            // Set field status jadi 1 (confirmed)
            document.getElementById('status').value = 1;
            document.getElementById('formEdit').requestSubmit();
        }
    </script>
</x-app-layout>
