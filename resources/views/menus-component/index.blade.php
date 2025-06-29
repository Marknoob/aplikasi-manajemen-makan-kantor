<x-app-layout>
    <div class="m-3">
        <div class="h2 mb-4">Menus Component</div>
        <div class="d-flex justify-content-between mb-2 mt-2">
            <a href="{{ route('menus-component.create') }}" class="btn btn-primary">+ Tambah Komponen Menu</a>
            <form method="GET" action="{{ route('menus-component.index') }}" class="d-flex" role="search">
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
                        <th scope="col">Nama Komponen</th>
                        <th scope="col">Jenis Komponen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($menusComponents as $menusComponent)
                        <tr>
                            <td style="width: 70px;">
                                <a class="text-decoration-none text-reset" href="{{ route('menus-component.edit', $menusComponent->id)}}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>
                            <td>{{$menusComponent->nama_komponen}}</td>
                            <td>{{$menusComponent->jenis_komponen}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $menusComponents->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
