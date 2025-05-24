<x-app-layout>
    <div class="container mt-4">
        <h2 class="mb-4">Dashboard</h2>

        <div class="row">
            <!-- Card Pengeluaran -->
            <div class="col-md-6 col-lg-4 mb-4">
                <a href="{{ url('dashboard/pengeluaran') }}" class="text-decoration-none">
                    <div class="card shadow-sm border-0 hover-shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="text-danger">Rp {{ number_format($totalPaymentThisMonth ?? 0, 0, ',', '.') }}</h4>
                                    <p class="text-muted mb-1">Total Biaya Pengeluaran (Bulan {{ $bulan }} 2025)</p>
                                </div>
                                <div>
                                    <i class="fas fa-arrow-circle-down fa-2x text-danger"></i>
                                </div>
                            </div>
                            <div class="mt-3">
                                <span class="badge bg-danger">{{ $expensePercentage }}% increase</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Card Pembayaran -->
            <div class="col-md-6 col-lg-4 mb-4">
                <a href="{{ url('dashboard/pembayaran') }}" class="text-decoration-none">
                    <div class="card shadow-sm border-0 hover-shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    @if ($totalMenusDeckWaitingPayment > 0)
                                        <h4 class="text-primary">{{ $totalMenusDeckWaitingPayment }} Pembayaran Menunggu..</h4>
                                    @else
                                        <h4 class="text-primary">Tidak ada tagihan</h4>
                                    @endif
                                    <p class="text-muted mb-1">Pembayaran (Bulan {{ $bulan }} 2025)</p>
                                </div>
                                <div>
                                    <i class="fas fa-credit-card fa-2x text-primary"></i>
                                </div>
                            </div>
                            <div class="mt-3">
                                <span class="badge bg-primary">{{ $totalMenusDeckLunas }} Tagihan Lunas</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
</x-app-layout>
