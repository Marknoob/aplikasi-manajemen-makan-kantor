<x-app-layout>
    <div class="m-3">
        <div class="h2 mb-4">Menus</div>

        <div class="card p-3">
            <form id="menu-form" action="{{ route('menus.update', $menu->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama_menu" class="form-label">Nama Menu</label>
                    <input type="text" class="form-control" id="nama_menu" name="nama_menu" value="{{ $menu->nama_menu }}" required>
                </div>

                {{-- Komponen Karbohidrat --}}
                <div class="mb-3">
                    <label class="form-label">Karbohidrat</label>
                    <div id="karbohidrat-group">
                        @foreach ($selectedKomponen as $item)
                            @if ($item->component->jenis_komponen == 'Karbohidrat')
                                <div class="border rounded-2 p-1 d-inline-flex align-items-center gap-2 me-1 mb-1">
                                    <span>{{ $item->component->nama_komponen }}</span>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeKomponen({{ $item->component_id }})"
                                        fdprocessedid="yhu3uk">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary mt-1" onclick="openKomponenModal('karbohidrat')">
                        + Tambah Karbohidrat
                    </button>
                </div>

                {{-- Komponen Protein --}}
                <div class="mb-3">
                    <label class="form-label">Protein</label>
                    <div id="protein-group">
                        @foreach ($selectedKomponen as $item)
                            @if ($item->component->jenis_komponen == 'Protein')
                                <div class="border rounded-2 p-1 d-inline-flex align-items-center gap-2 me-1 mb-1">
                                    <span>{{ $item->component->nama_komponen }}</span>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeKomponen({{ $item->component_id }})"
                                        fdprocessedid="yhu3uk">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary mt-1" onclick="openKomponenModal('protein')">
                        + Tambah Protein
                    </button>
                </div>



                {{-- Komponen Sayur --}}
                <div class="mb-3">
                    <label class="form-label">Sayur</label>
                    <div id="sayur-group">
                        @foreach ($selectedKomponen as $item)
                            @if ($item->component->jenis_komponen == 'Sayur')
                                <div class="border rounded-2 p-1 d-inline-flex align-items-center gap-2 me-1 mb-1">
                                    <span>{{ $item->component->nama_komponen }}</span>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeKomponen({{ $item->component_id }})" fdprocessedid="yhu3uk">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary mt-1" onclick="openKomponenModal('sayur')">
                        + Tambah Sayur
                    </button>
                </div>

                {{-- Komponen Buah --}}
                <div class="mb-3">
                    <label class="form-label">Buah</label>
                    <div id="buah-group">
                        @foreach ($selectedKomponen as $item)
                            @if ($item->component->jenis_komponen == 'Buah')
                                <div class="border rounded-2 p-1 d-inline-flex align-items-center gap-2 me-1 mb-1">
                                    <span>{{ $item->component->nama_komponen }}</span>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeKomponen({{ $item->component_id }})"
                                        fdprocessedid="yhu3uk">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary mt-1" onclick="openKomponenModal('buah')">
                        + Tambah Buah
                    </button>
                </div>


                <div class="mb-3">
                    <label for="kategori_bahan_utama" class="form-label">Kategori Bahan Utama</label>
                    <select class="form-control" id="kategori_bahan_utama" name="kategori_bahan_utama" required>
                        <option value="" disabled selected>-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ isset($menu) && $menu->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->kategori_bahan_utama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="vendor_id" class="form-label">Pilih Vendor</label>
                    <select class="form-control" id="vendor_id" name="vendor_id" required>
                        <option value="" disabled selected>Pilih Vendor</option>
                        @foreach ($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ isset($menu) && $menu->vendor_id == $vendor->id ? 'selected' : '' }}>
                                {{ $vendor->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="is_active" class="form-label">Status Aktif</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ isset($menu) && $menu->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Aktif
                        </label>
                    </div>
                </div>

                <button type="button" class="btn btn-primary" onclick="handleSaveClick()">Simpan</button>
                <input type="hidden" name="selected_komponen" id="selectedKomponenInput">
                <a href="{{ route('menus.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>

        <!-- Modal Pilih Komponen -->
        <div class="modal fade" id="modalKomponen" tabindex="-1" aria-labelledby="modalKomponenLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Pilih Komponen <span id="modalKomponenType"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="searchKomponenInput" class="form-control mb-3" placeholder="Cari komponen...">

                        <ul class="list-group" id="komponenResultList"></ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Validasi Komponen -->
        <div class="modal fade" id="validationModal" tabindex="-1" aria-labelledby="validationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="validationModalLabel">Komponen Wajib Diisi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p class="h5">Setidaknya satu komponen dari Karbohidrat, Protein, Sayur, dan Buah harus diisi.</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

    </div>

    {{-- Helper untuk JS mengubah bentuk data selectedKomponen --}}
    @php
        $selectedKomponenFormatted = $selectedKomponen->map(function ($item) {
            return [
                'id' => $item->component->id,
                'nama_komponen' => $item->component->nama_komponen,
                'jenis_komponen' => $item->component->jenis_komponen,
            ];
        });
    @endphp

    <script>
        let currentJenisKomponen = null;
        let selectedKomponen = @json($selectedKomponenFormatted);
        let komponenList = {
            karbohidrat: @json($karbohidratList),
            protein: @json($proteinList),
            sayur: @json($sayurList),
            buah: @json($buahList),
        };

        function getJenisKomponenById(id) {
            for (const [jenis, list] of Object.entries(komponenList)) {
                if (list.some(item => item.id === id)) {
                    return jenis;
                }
            }
            return null;
        }

        // Normalisasi jenis_komponen agar sesuai dengan key di komponenList
        selectedKomponen = selectedKomponen.map(item => {
            const jenis = getJenisKomponenById(item.id);
            return {
                ...item,
                jenis_komponen: jenis ?? item.jenis_komponen  // fallback kalau tidak ketemu
            };
        });

        // Filter komponenList untuk membuang item yang sudah dipilih
        const selectedIds = new Set(selectedKomponen.map(k => k.component_id));
        for (let kategori in komponenList) {
            komponenList[kategori] = komponenList[kategori].filter(item => !selectedIds.has(item.id));
        }

        function openKomponenModal(jenis) {
            currentJenisKomponen = jenis;
            document.getElementById('modalKomponenType').textContent = jenis.charAt(0).toUpperCase() + jenis.slice(1);
            document.getElementById('searchKomponenInput').value = '';
            showKomponenResults('');
            const modal = new bootstrap.Modal(document.getElementById('modalKomponen'));
            modal.show();
        }

        function showKomponenResults(keyword) {
            const available = komponenList[currentJenisKomponen].filter(item => {
                return (
                    item.nama_komponen.toLowerCase().includes(keyword.toLowerCase()) &&
                    !selectedKomponen.find(k => k.id == item.id)
                );
            });

            const resultList = document.getElementById('komponenResultList');
            resultList.innerHTML = '';

            available.forEach(item => {
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex align-items-center';
                li.innerHTML = `
                    <button class="btn btn-sm btn-success me-3" onclick="addKomponen(${item.id})">
                        <i class="fa fa-plus"></i>
                    </button>
                    <span>${item.nama_komponen}</span>
                `;
                resultList.appendChild(li);
            });
        }

        function findKomponenById(id) {
            for (const [jenis, list] of Object.entries(komponenList)) {
                const found = list.find(item => item.id === id);
                if (found) {
                    return { ...found, jenis_komponen: jenis };
                }
            }
            return null;
        }

        function addKomponen(id) {
            const komponen = findKomponenById(id);
            if (!komponen) return;

            // Mencegah data kembar
            const alreadyExists = selectedKomponen.some(item => item.id === id);
            if (alreadyExists) return;

            // Masukkan ke daftar selectedKomponen
            selectedKomponen.push({
                id: komponen.id,
                nama_komponen: komponen.nama_komponen,
                jenis_komponen: komponen.jenis_komponen,
            });

            const group = document.getElementById(`${komponen.jenis_komponen}-group`);
            const wrapper = document.createElement('div');
            wrapper.className = 'border rounded-2 p-1 d-inline-flex align-items-center gap-2 me-1 mb-1';

            wrapper.innerHTML = `
                <span>${komponen.nama_komponen}</span>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeKomponen(${komponen.id})">
                    <i class="fa fa-times"></i>
                </button>
            `;

            group.appendChild(wrapper);

            const modal = bootstrap.Modal.getInstance(document.getElementById('modalKomponen'));
            modal.hide();
        }

        function removeKomponen(id) {
            console.log(selectedKomponen);
            const komponen = selectedKomponen.find(item => item.id == id);
            if (!komponen) return;

            selectedKomponen = selectedKomponen.filter(item => item.id != id);

            let jenisKomponen = null;
            for (const [jenis, list] of Object.entries(komponenList)) {
                if (list.some(item => item.id === id)) {
                    jenisKomponen = jenis;
                    break;
                }
            }

            if (!jenisKomponen) return;

            const group = document.getElementById(`${jenisKomponen}-group`);
            if (!group) return;

            const badges = group.querySelectorAll('.border');
            badges.forEach(el => {
                if (el.querySelector('span')?.textContent === komponen.nama_komponen) {
                    el.remove();
                }
            });

            if (document.getElementById('modalKomponen').classList.contains('show')) {
                showKomponenResults(document.getElementById('searchKomponenInput').value);
            }
        }

        document.getElementById('searchKomponenInput').addEventListener('input', function () {
            showKomponenResults(this.value);
        });

        function handleSaveClick() {
            const requiredTypes = ['karbohidrat', 'protein', 'sayur', 'buah'];
            const selectedTypes = selectedKomponen.map(k => k.jenis_komponen);
            const isValid = requiredTypes.every(type => selectedTypes.includes(type));

            if (!isValid) {
                const validationModal = new bootstrap.Modal(document.getElementById('validationModal'));
                validationModal.show();
                return;
            }

            document.getElementById('selectedKomponenInput').value = JSON.stringify(selectedKomponen);
            document.getElementById('menu-form').requestSubmit();
        }
    </script>
</x-app-layout>
