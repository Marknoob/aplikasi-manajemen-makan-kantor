<x-app-layout>
    <div class="m-3">
        <div class="h2 mb-4 d-flex justify-content-between">
            <a href="{{ route('menus-deck.index') }}" class="text-decoration-none text-dark">Menus Deck</a>
            <!-- Tombol Trigger Modal -->
            <button type="button" class="btn text-white" style="background-color: #203454;" id="openModalBtn">
                Gunakan Rekomendasi Menu
                <i class="fa-solid fa-wand-magic-sparkles ms-3" style="color: #FFD43B;"></i>
            </button>
        </div>

        <div class="card p-3">
            <form action="{{ route('menus-deck.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="menu_id" class="form-label">Menu</label>
                    <select class="form-control" id="menu_id" name="menu_id" required>
                        <option value="">-- Pilih Menu --</option>
                        @foreach($menus as $menu)
                            <option value="{{ $menu->id }}" {{ (isset($selectedMenu) && $selectedMenu->id == $menu->id) ? 'selected' : '' }}>
                                {{ $menu->nama_menu }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="total_serve" class="form-label">Total Serve</label>
                    <input type="number" class="form-control" id="total_serve" name="total_serve">
                </div>

                <div class="mb-3">
                    <label for="harga_menu" class="form-label">Harga Menu</label>
                    <input type="number" id="harga_menu" name="harga_menu" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="jumlah_vote" class="form-label">Jumlah Vote</label>
                    <input type="number" class="form-control" id="jumlah_vote" name="jumlah_vote">
                </div>

                <div class="mb-3">
                    <label for="tanggal_pelaksanaan" class="form-label">Tanggal Pelaksanaan</label>
                    <input type="date" class="form-control" id="tanggal_pelaksanaan" name="tanggal_pelaksanaan"
                        value="{{ old('tanggal_pelaksanaan', $tanggal_pelaksanaan ?? '') }}" required readonly>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('menus-deck.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modalRekomendasi" tabindex="-1" aria-labelledby="modalRekomendasiLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h3>Menus Recommender</h3>
                        <p>Menu direkomendasikan berdasarkan kemiripan komponen menu target</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="menu_target" class="form-label">Pilih Menu Target</label>
                        <select class="form-select" id="menu_target" onchange="filterRekomendasi(this.value)">
                            <option value="">-- Pilih Menu --</option>
                            @foreach($menus as $menu)
                                <option value="{{ $menu->id }}">{{ $menu->nama_menu }}</option>
                            @endforeach
                        </select>
                    </div>

                    <table class="table table-striped mt-3" id="tabelRekomendasi">
                        <thead>
                            <tr>
                                <th>Aksi</th>
                                <th>Nama Menu</th>
                                <th>Kategori</th>
                                <th>Vendor</th>
                                <th>Kemiripan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($menus as $menu)
                                <tr>
                                    <td>
                                        <button class="btn btn-sm btn-success"
                                            onclick="pilihMenu('{{ $menu->id }}', '{{ $menu->nama_menu }}')" title="Pilih">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </td>
                                    <td>{{ $menu->nama_menu }}</td>
                                    <td>{{ $menu->category->kategori_bahan_utama }}</td>
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
        </div>
    </div>



    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/jquery.js"></script>

    <script>
        // Menus Recommender Algorithm
        const menus = @json($menus);
        // console.log(menus);

        function pilihMenu(menuId, menuNama) {
            const menuSelect = document.getElementById('menu_id');
            menuSelect.value = menuId;

            // Kalau pakai Select2 atau select custom lain, trigger event-nya:
            if (typeof $(menuSelect).trigger === 'function') {
                $(menuSelect).trigger('change');
            }

            // Tutup modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalRekomendasi'));
            modal.hide();
        }

        // function getSimilarityScores(menuTarget, menu) {
        //     // console.log(menuTarget, menu);
        //     const componentList = [];

        //     const addUniqueComponent = (details) => {
        //         details.forEach(item => {
        //             const componentId = item.component.id;
        //             if (!componentList.includes(componentId)) {
        //                 componentList.push(componentId);
        //             }
        //         });
        //     };

        //     // Kumpulkan semua komponen unik dari kedua menu
        //     addUniqueComponent(menuTarget.details);
        //     addUniqueComponent(menu.details);

        //     // Buat vektor biner untuk kedua menu
        //     const buildVector = (details) => {
        //         return componentList.map(componentId =>
        //             details.some(item => item.component.id === componentId) ? 1 : 0
        //         );
        //     };

        //     const componentMenu1 = buildVector(menuTarget.details);
        //     const componentMenu2 = buildVector(menu.details);

        //     // Hitung cosine similarity
        //     const dotProduct = componentMenu1.reduce((acc, val, i) => acc + val * componentMenu2[i], 0);
        //     const magnitude1 = Math.sqrt(componentMenu1.reduce((acc, val) => acc + val * val, 0));
        //     const magnitude2 = Math.sqrt(componentMenu2.reduce((acc, val) => acc + val * val, 0));
        //     // console.log(dotProduct, magnitude1, magnitude2);

        //     const similarity = magnitude1 && magnitude2 ? dotProduct / (magnitude1 * magnitude2) : 0;

        //     // console.log(menuTarget.nama_menu, menu.nama_menu, similarity);
        //     return similarity;
        // }

        function getSimilarityScores(menuTarget, menuAvailable) {
            // const setA = new Set(menuTarget.details.map(item => item.component.id));
            // const setB = new Set(menuAvailable.details.map(item => item.component.id));

            var tempSetA = menuTarget.details.map(item => item.component.id);
            tempSetA.push(menuTarget.category.kategori_bahan_utama);

            var tempSetB = menuAvailable.details.map(item => item.component.id);
            tempSetB.push(menuAvailable.category.kategori_bahan_utama);

            const setA = new Set(tempSetA);
            const setB = new Set(tempSetB);
            console.log(setA, setB);

            const intersection = new Set([...setA].filter(id => setB.has(id)));
            console.log(intersection);

            const union = new Set([...setA, ...setB]);
            console.log(union);

            // Mencegah pembagian dengan nol jika kedua menu tidak memiliki komponen sama sekali.
            if (union.size === 0) {
                return 0;
            }

            const similarity = intersection.size / union.size;
            console.log(intersection.size, union.size, similarity);
            return similarity;
        }

        function generateSimilarityResults(menuTargetId) {
            const menuTarget = menus.find(menu => menu.id == menuTargetId);
            if (!menuTarget) {
                console.error('Menu target tidak ditemukan');
                return;
            }
            // console.log(menus);

            const results = [];
            // Bandingkan dengan semua menu
            menus.forEach(menu => {
                const similarity = getSimilarityScores(menuTarget, menu);
                results.push({
                    id: menu.id,
                    nama_menu: menu.nama_menu,
                    kategori_bahan_utama: menu.category.kategori_bahan_utama,
                    vendor_id: menu.vendor_id,
                    similarity: similarity,
                });
            });

            // Urutkan dari similarity tertinggi ke terendah
            results.sort((a, b) => b.similarity - a.similarity);

            return results;
        }


        // Menampilkan list hasil rekomendasi berdasarkan menu target
        function filterRekomendasi(selectedTargetId) {
            const tableBody = document.querySelector('#tabelRekomendasi tbody');
            tableBody.innerHTML = '';

            const results = generateSimilarityResults(selectedTargetId);

            results.forEach(menu => {
                const row = document.createElement('tr');
                row.innerHTML = `
                            <td>
                                <button class="btn btn-sm btn-success" onclick="pilihMenu('${menu.id}', '${menu.nama_menu}')">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </td>
                            <td>${menu.nama_menu}</td>
                            <td>${menu.kategori_bahan_utama}</td>
                            <td>${menu.vendor_id}</td>
                            <td>${(menu.similarity * 100).toFixed(2)}%</td>
                        `;
                if (menu.id != selectedTargetId) {
                    tableBody.appendChild(row);
                }
            });
        }

        // Open modal rekomendasi
        document.getElementById('openModalBtn').addEventListener('click', function () {
            const modal = new bootstrap.Modal(document.getElementById('modalRekomendasi'));
            modal.show();
        });

    </script>
</x-app-layout>
