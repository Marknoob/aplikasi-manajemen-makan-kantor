<x-app-layout>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Dashboard - Pembayaran</h2>
            <form method="GET" action="{{ route('dashboard.pengeluaran') }}">
                <input type="month" name="periode" value="{{ request('periode', now()->format('Y-m')) }}" class="form-control"
                    onchange="this.form.submit()" style="width: 200px;">
            </form>
        </div>

        <div class="card p-3">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col" style="width: 40px;">Aksi</th>
                        <th scope="col">Nama Menu</th>
                        <th scope="col">Tanggal Pelaksanaan</th>
                        <th scope="col">Total Tagihan</th>
                        <th scope="col">Total Pembayaran</th>
                        <th scope="col">Sisa Tagihan</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($menusDeck as $menu)
                        <tr>
                            <td style="width: 40px;">
                                <a href="{{ route('menus-deck.edit', $menu->id) }}" class="text-decoration-none text-dark">
                                    <i class="fa-solid fa-eye" style="color: #74C0FC;"></i>
                                </a>
                            </td>
                            <td>{{ $menu->menu->nama_menu }}</td>
                            <td>{{ $menu->tanggal_pelaksanaan ? \Carbon\Carbon::parse($menu->tanggal_pelaksanaan)->format('d M Y') : '-' }}
                            </td>
                            <td>Rp {{ number_format($menu->total_tagihan ?? 0, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($menu->total_pembayaran ?? 0, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($menu->sisa_tagihan ?? 0, 0, ',', '.') }}</td>
                            <td>
                                <div class="rounded" style="
                                    width: 135px;
                                    background-color:
                                    @if ($menu->status_lunas == "Paid")
                                        #b6f2b6
                                    @elseif ($menu->status_lunas == "Half Paid")
                                        #a5d8ff
                                    @else
                                        #ffd2d2
                                    @endif
                                    ;

                                    border: 1px solid
                                    @if ($menu->status_lunas == "Paid")
                                        #59c459
                                    @elseif ($menu->status_lunas == "Half Paid")
                                        #1971c2
                                    @else
                                        #ff7a7a
                                    @endif
                                    ;
                                    text-align: center;
                                ">
                                    {{ $menu->status_lunas }}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
