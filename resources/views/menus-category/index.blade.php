<x-app-layout>
    <div class="m-3">
        <div class="h2 mb-4">Menus Category</div>
        <div class="d-flex justify-content-between mb-2 mt-2">
            <a href="{{ route('menus-category.create') }}" class="btn btn-primary">+ Tambah Kategori Menu</a>
            <form method="GET" action="{{ route('menus-category.index') }}" class="d-flex" role="search">
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
                        <th scope="col">Kategori Bahan Utama</th>
                        <th scope="col">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($menusCategories as $menusCategory)
                        <tr>
                            <td style="width: 70px;">
                                <a class="text-decoration-none text-reset" href="{{ route('menus-category.edit', $menusCategory->id)}}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>
                            <td>{{$menusCategory->kategori_bahan_utama}}</td>
                            <td>{{$menusCategory->keterangan}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $menusCategories->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
