{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Menus Recommender</title>

    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('fontawesome/css/all.min.css')}}">
</head>
<body>

    <div class="m-3">
        <div class="mb-4">
            <p class="h2">Menus Recommender</p>
            <p>Menu direkomendasikan berdasarkan kemiripan komponen menu target</p>
        </div>

        <div class="card p-3 mb-5">
            <p class="h5">Menu Target</p>

            <form method="GET" action="{{ route('menus-recommender.index') }}">
                <select class="form-control mt-2" id="menu_id" name="menu_id" required onchange="this.form.submit()">
                    <option value="">-- Pilih Menu --</option>
                    @foreach($menus as $menu)
                        <option value="{{ $menu->id }}" {{ request('menu_id') == $menu->id ? 'selected' : '' }}>
                            {{ $menu->nama_menu }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="card p-3">
            <p class="h5">Menu Recommended</p>

            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th scope="col" style="width: 50px;">Aksi</th>
                        <th scope="col">Nama Menu</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Vendor</th>
                        <th scope="col">Persentase Kemiripan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($menus as $menu)
                        <tr>
                            <td>
                                <a class="text-decoration-none text-reset" href="{{ route('menus-deck.create', $menu->id) }}">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </td>
                            <td>{{ $menu->nama_menu }}</td>
                            <td>{{ $menu->kategori_bahan_utama }}</td>
                            <td>{{ $menu->vendor_id }}</td>
                            <td>
                                {{ isset($recommendations[$menu->id]) ? number_format($recommendations[$menu->id] * 100, 2) . '%' : '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <script src="/bootstrap/js/bootstrap.min.js"></script>
</body>
</html> --}}
