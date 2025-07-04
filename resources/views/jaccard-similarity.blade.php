<x-app-layout>
    <div class="m-3">
        <h3 class="mb-5">Jaccard Similarity</h3>

        <h5 class="mt-5 mb-2">Menu Comparison</h5>
        <div class="d-flex justify-content-evenly">
            <div>
                <h5>Menu 1: {{ $menu1->nama_menu }}</h5>
                <ul>
                    @foreach ($menu1Details as $detail)
                        <li>{{ $detail->component->nama_komponen }}</li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h5>Menu 2: {{ $menu2->nama_menu }}</h5>
                <ul>
                    @foreach ($menu2Details as $detail)
                        <li>{{ $detail->component->nama_komponen }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <h5 class="mt-5 mb-2">Formula Jaccard Similarity</h5>
        <div class="p-4 border rounded shadow bg-gray-50">
            <code>
                Jaccard Similarity = |A ∩ B| / |A ∪ B|
            </code>
        </div>

        <h5 class="mt-4">Calculate Jaccard Similarity</h5>
        <div class="p-4 border rounded shadow bg-white mt-2">
            <div><strong>Set A (Menu 1):</strong> <span id="setA" class="text-blue-600"></span></div>
            <div><strong>Set B (Menu 2):</strong> <span id="setB" class="text-green-600"></span></div>

            <div class="mt-3"><strong>Intersection:</strong> <span id="intersection" class="text-purple-600"></span></div>
            <div><strong>Union:</strong> <span id="union" class="text-orange-600"></span></div>

            <div class="mt-3"><strong>Calculation: (intersection / union)</strong></div>
            <div><strong>= <span id="calculate" class="text-gray-600"></span></strong></div>

            <div class="mt-3"><strong>Hasil Jaccard Similarity:</strong> <span id="jaccardResult"
                    class="text-red-600 text-xl font-bold"></span></div>
        </div>


        {{-- Jaccard Similarity Accuracy Vizualization --}}
        <h5 class="mt-5">Jaccard Similarity Accuracy</h5>
        {{-- @php
            $trueCount = 0;
            $falseCount = 0;
            $threshold = 0; // batas minimal similarity untuk dianggap relevan
        @endphp
        <div class="p-4 border rounded shadow bg-gray-50">
            <div class="mb-4">
                <h5>Target Menu: <strong>{{ $menu1->nama_menu }}</strong></h5>
                <p><strong>Kategori Bahan Utama:</strong> {{ $menu1->category->kategori_bahan_utama }}</p>
            </div>

            <div class="mb-4">
                <h5>Expected Menus (Kategori Sama):</h5>
                <ul>
                    @foreach($expectedMenus as $expected)
                        <li>{{ $expected->nama_menu }}</li>
                    @endforeach
                </ul>
            </div>

            <h5>Perhitungan Jaccard Similarity Semua Menu</h5>
            <table class="table table-bordered">
                <thead class="bg-light">
                    <tr>
                        <th>Nama Menu</th>
                        <th>Kategori</th>
                        <th>Similarity (%)</th>
                        <th>Expected?</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allMenus as $menu)
                        @php
                            $setA = collect($menu1->details)->pluck('component.id')->unique()->toArray();
                            $setB = collect($menu->details)->pluck('component.id')->unique()->toArray();

                            $intersection = array_intersect($setA, $setB);
                            $union = array_unique(array_merge($setA, $setB));
                            $similarity = count($union) > 0 ? count($intersection) / count($union) : 0;

                            $isExpected = $expectedMenus->contains('id', $menu->id);

                            // Hitung untuk evaluasi
                            if ($similarity >= $threshold) {
                                if ($isExpected) {
                                    $trueCount++; // True Positive
                                } else {
                                    $falseCount++; // False Positive
                                }
                            }
                        @endphp
                        <tr>
                            <td>{{ $menu->nama_menu }}</td>
                            <td>{{ $menu->category->kategori_bahan_utama }}</td>
                            <td>{{ number_format($similarity * 100, 2) }}%</td>
                            <td>
                                @if($isExpected)
                                    <span class="badge bg-success">True</span>
                                @else
                                    <span class="badge bg-danger">False</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Summary Accuracy
            @php
                $total = $trueCount + $falseCount;
                $accuracy = $total > 0 ? ($trueCount / $total) * 100 : 0;
            @endphp

            <div class="mt-4 p-3 border rounded bg-light">
                <h5>Hasil Evaluasi Akurasi</h5>
                <ul>
                    <li><strong>Total True Positif (Expected & Similarity >= {{ $threshold * 100 }}%):</strong> {{ $trueCount }}</li>
                    <li><strong>Total False Positif (Tidak Expected & Similarity >= {{ $threshold * 100 }}%):</strong> {{ $falseCount }}</li>
                    <li><strong>Accuracy:</strong> {{ number_format($accuracy, 2) }}%</li>
                </ul>
            </div>
        </div> --}}

        <div id="accuracy-section" class="p-4 border rounded shadow bg-gray-50"></div>
    </div>

    <script>
        const menu1 = {
            category: { kategori_bahan_utama: "{{ $menu1->category->kategori_bahan_utama }}" },
            details: @json($menu1Details)
        };

        const menu2 = {
            category: { kategori_bahan_utama: "{{ $menu2->category->kategori_bahan_utama }}" },
            details: @json($menu2Details)
        };

        const idToName = {};
        [...menu1.details, ...menu2.details].forEach(item => {
            idToName[item.component.id] = item.component.nama_komponen;
        });
        idToName[menu1.category.kategori_bahan_utama] = menu1.category.kategori_bahan_utama;
        idToName[menu2.category.kategori_bahan_utama] = menu2.category.kategori_bahan_utama;

        function getSimilarityScores(menuTarget, menuAvailable) {
            // const setA = new Set(menuTarget.details.map(item => item.component.id));
            // const setB = new Set(menuAvailable.details.map(item => item.component.id));

            const tempSetA = menuTarget.details.map(item => item.component.id);
            tempSetA.push(menuTarget.category.kategori_bahan_utama);

            const tempSetB = menuAvailable.details.map(item => item.component.id);
            tempSetB.push(menuAvailable.category.kategori_bahan_utama);

            const setA = new Set(tempSetA);
            const setB = new Set(tempSetB);

            const intersection = [...setA].filter(id => setB.has(id));
            const union = [...new Set([...setA, ...setB])];

            const similarity = union.length > 0 ? intersection.length / union.length : 0;

            return {
                setA: [...setA],
                setB: [...setB],
                intersection,
                union,
                similarity
            };
        }

        const result = getSimilarityScores(menu1, menu2);

        document.getElementById('setA').innerText = result.setA.map(id => idToName[id]).join(', ');
        document.getElementById('setB').innerText = result.setB.map(id => idToName[id]).join(', ');
        document.getElementById('intersection').innerText = result.intersection.map(id => idToName[id]).join(', ');
        document.getElementById('union').innerText = result.union.map(id => idToName[id]).join(', ');
        document.getElementById('calculate').innerText = `${result.intersection.length} / ${result.union.length}`;
        document.getElementById('jaccardResult').innerText = result.similarity.toFixed(2);

        const allMenus = @json($allMenus);
        const expectedMenus = @json($expectedMenus);
        const menuTarget = @json($menu1);
        const threshold = 0;

        function renderAccuracyTable() {
            let trueCount = 0;
            // let falseCount = 0;
            let falseCount = expectedMenus.length; // Metode Recall

            // let tableRows = '';
            const rows = [];
            let index = 0;

            allMenus.forEach(menu => {
                const simResult = getSimilarityScores(menuTarget, menu);
                const similarity = simResult.similarity;
                const similarityPercent = (similarity * 100).toFixed(2);

                const isExpected = expectedMenus.find(m => m.id === menu.id) !== undefined;
                const status = isExpected ? 'True' : 'False';
                const badge = isExpected ? 'success' : 'danger';

                // Hitung akurasi
                // if (similarity >= threshold) {
                //     if (isExpected) trueCount++;
                //     else falseCount++;
                // } else {
                //     falseCount++;
                // }



                // Ambil

                // tableRows += `
                //     <tr>
                //         <td>${menu.nama_menu}</td>
                //         <td>${menu.category.kategori_bahan_utama}</td>
                //         <td>${similarityPercent}%</td>
                //         <td><span class="badge bg-${badge}">${status}</span></td>
                //     </tr>
                // `;
                rows.push({
                    id: menu.id,
                    nama_menu: menu.nama_menu,
                    kategori: menu.category.kategori_bahan_utama,
                    similarity,
                    similarityPercent,
                    status,
                    badge,
                    isExpected
                });
            });

            // Urutkan dari similarity tertinggi ke terendah
            rows.sort((a, b) => b.similarity - a.similarity);
            let tableRows = '';
            rows.forEach(row => {
                tableRows += `
                    <tr>
                        <td>${row.nama_menu}</td>
                        <td>${row.kategori}</td>
                        <td>${row.similarityPercent}%</td>
                        <td><span class="badge bg-${row.badge}">${row.status}</span></td>
                    </tr>
                `;

                // Metode perhitungan recall setelah diurutkan dari similarity tertinggi ke terendah
                // if dilakukan Dibatasi sampai sejumlah expectedMenus
                const isExpected = expectedMenus.find(m => m.id === row.id) !== undefined;
                if (isExpected && index <= expectedMenus.length) {
                    trueCount++;
                }
                index++;
            });


            const total = trueCount + falseCount;
            // const accuracy = total > 0 ? ((trueCount / total) * 100).toFixed(2) : 0;
            // Metode Recall
            const accuracy = total > 0 ? ((trueCount / falseCount) * 100).toFixed(2) : 0;

            document.getElementById('accuracy-section').innerHTML = `
                <div class="mb-4">
                    <h5>Target Menu: <strong>${menuTarget.nama_menu ?? 'Target Menu'}</strong></h5>
                    <p><strong>Kategori Bahan Utama:</strong> ${menuTarget.category.kategori_bahan_utama}</p>
                </div>

                <div class="mb-4">
                    <h5>Expected Menus (Kategori Sama):</h5>
                    <ul>
                        ${expectedMenus.map(m => `<li>${m.id} - ${m.nama_menu}</li>`).join('')}
                    </ul>
                </div>

                <h5>Perhitungan Jaccard Similarity Semua Menu</h5>
                <table class="table table-bordered">
                    <thead class="bg-light">
                        <tr>
                            <th>Nama Menu</th>
                            <th>Kategori</th>
                            <th>Similarity (%)</th>
                            <th>Expected?</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${tableRows}
                    </tbody>
                </table>

                <div class="mt-4 p-3 border rounded bg-light">
                    <h5>Hasil Evaluasi Akurasi</h5>
                    <ul>
                        <li><strong>Total True Positif:</strong> ${trueCount}</li>
                        <li><strong>Total False Positif:</strong> ${falseCount}</li>
                        <li><strong>Accuracy:</strong> ${accuracy}%</li>
                    </ul>
                </div>
            `;
        }

        // Jalankan saat halaman selesai render
        document.addEventListener('DOMContentLoaded', renderAccuracyTable);
    </script>
</x-app-layout>
