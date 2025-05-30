<x-app-layout>
    <div class="m-3">
        <div class="h2 mb-4">Menus</div>
        <div class="d-flex justify-content-between mb-2 mt-2">
            <a href="{{ route('menus.create') }}" class="btn btn-primary">+ Tambah Menu</a>
            <form method="GET" action="{{ route('menus.index') }}" class="d-flex" role="search">
                <input type="text" name="search" class="form-control me-2" style="width: 250px;"placeholder="Cari nama menu / kategori..."
                    value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>

        <div class="card p-3">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col" style="width: 70px;">Aksi</th>
                        <th scope="col">Nama Menu</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Vendor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($menus as $menu)
                        <tr>
                            <td style="width: 70px;">
                                <a class="text-decoration-none text-reset" href="{{ route('menus.edit', $menu->id)}}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a class="text-decoration-none text-reset" href="{{ route('menus.show', $menu->id)}}">
                                    <i class="fa-brands fa-readme"></i>
                                </a>
                            </td>
                            <td>{{$menu->nama_menu}}</td>
                            <td>{{$menu->kategori_bahan_utama}}</td>
                            <td>{{$menu->vendor_id}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $menus->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
