<x-app-layout>
    <div class="m-3">
        <div class="h2 mb-4">Vendors</div>

        <a href="{{ route('vendors.create') }}" class="btn btn-primary mb-2 mt-2">+ Tambah Vendor</a>

        <div class="card p-3">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col" style="width: 70px;">Aksi</th>
                        <th scope="col">Nama Vendor</th>
                        <th scope="col">Kontak</th>
                        <th scope="col">Penilaian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vendors as $vendor)
                        <tr>
                            <td style="width: 70px;">
                                <a class="text-decoration-none text-reset" href="{{ route('vendors.edit', $vendor->id)}}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a class="text-decoration-none text-reset" href="{{ route('vendors.show', $vendor->id)}}">
                                    <i class="fa-brands fa-readme"></i>
                                </a>
                            </td>
                            <td>{{$vendor->nama}}</td>
                            <td>{{$vendor->kontak}}</td>
                            <td>{{$vendor->penilaian}}</td>
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

</x-app-layout>
