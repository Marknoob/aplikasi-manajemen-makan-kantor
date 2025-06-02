<x-app-layout>
    <div class="m-3">
        <h3 class="mb-5">Cosine Similarity</h3>

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

        <h5 class="mt-5 mb-2">Visualisasi Vektor</h5>
        <div class="overflow-x-auto">
            <table id="vectorTable" class="table-auto border border-collapse border-gray-400 w-full text-center">
                <thead class="bg-gray-200">
                    <tr id="headerRow">
                        <th class="border p-2">Menu</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="rowMenu1">
                        <td class="border p-2">{{ $menu1->nama_menu }}</td>
                    </tr>
                    <tr id="rowMenu2">
                        <td class="border p-2">{{ $menu2->nama_menu }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <h5 class="mt-5 mb-2">Formula Cosine Similarity</h5>
        <div class="p-4 border rounded shadow bg-gray-50">
            <code>
                Cosine Similarity = (A · B) / (||A|| × ||B||)
            </code>
        </div>

        <h5 class="mt-5 mb-2">Perhitungan Cosine Similarity</h5>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-2">
            <div class="p-4 border rounded shadow">
                <strong>Dot Product:</strong>
                <div id="dotProductSteps" class="text-sm text-gray-600 mt-2 mb-1"></div>
                <div id="dotProduct" class="text-xl font-bold text-blue-600"></div>
            </div>
            <div class="p-4 border rounded shadow">
                <strong>Magnitude Menu 1:</strong>
                <div id="magnitudeSteps1" class="text-sm text-gray-600 mt-2 mb-1"></div>
                <div id="magnitude1" class="text-xl font-bold text-green-600"></div>
            </div>
            <div class="p-4 border rounded shadow">
                <strong>Magnitude Menu 2:</strong>
                <div id="magnitudeSteps2" class="text-sm text-gray-600 mt-2 mb-1"></div>
                <div id="magnitude2" class="text-xl font-bold text-purple-600"></div>
            </div>
            <div class="p-4 border rounded shadow md:col-span-3">
                <strong>Hasil Cosine Similarity:</strong>
                <div id="cosineSimilaritySteps" class="text-sm text-gray-600 mt-2 mb-1"></div>
                <div id="cosineSimilarity" class="text-xl font-bold text-red-600 mt-2"></div>
            </div>
        </div>
    </div>

    <script>
        const menu1Details = @json($menu1Details);
        const menu2Details = @json($menu2Details);

        const componentList = [];
        const addUniqueComponent = (details) => {
            details.forEach(item => {
                const componentId = item.component.id;
                if (!componentList.includes(componentId)) {
                    componentList.push(componentId);
                }
            });
        };

        addUniqueComponent(menu1Details);
        addUniqueComponent(menu2Details);

        const buildVector = (details) => {
            return componentList.map(componentId =>
                details.some(item => item.component.id === componentId) ? 1 : 0
            );
        };

        const componentMenu1 = buildVector(menu1Details);
        const componentMenu2 = buildVector(menu2Details);

        const dotProductParts = componentMenu1.map((val, i) => `(${val}×${componentMenu2[i]})`);
        const dotProduct = componentMenu1.reduce((acc, val, i) => acc + val * componentMenu2[i], 0);

        const magnitude1Parts = componentMenu1.map(val => `(${val}²)`);
        const magnitude1 = Math.sqrt(componentMenu1.reduce((acc, val) => acc + val * val, 0));

        const magnitude2Parts = componentMenu2.map(val => `(${val}²)`);
        const magnitude2 = Math.sqrt(componentMenu2.reduce((acc, val) => acc + val * val, 0));

        const similarity = magnitude1 && magnitude2 ? dotProduct / (magnitude1 * magnitude2) : 0;

        document.getElementById('dotProductSteps').innerText = dotProductParts.join(' + ');
        document.getElementById('dotProduct').innerText = `= ${dotProduct}`;

        document.getElementById('magnitudeSteps1').innerText = `√(${magnitude1Parts.join(' + ')})`;
        document.getElementById('magnitude1').innerText = `= ${magnitude1.toFixed(4)}`;

        document.getElementById('magnitudeSteps2').innerText = `√(${magnitude2Parts.join(' + ')})`;
        document.getElementById('magnitude2').innerText = `= ${magnitude2.toFixed(4)}`;

        document.getElementById('cosineSimilaritySteps').innerText = `= ${dotProduct} / (${magnitude1.toFixed(4)} × ${magnitude2.toFixed(4) }) `;
        document.getElementById('cosineSimilarity').innerText = `= ${similarity.toFixed(2)}`;

        // Ambil nama komponen unik
        const getComponentNames = () => {
            const idToName = {};
            [...menu1Details, ...menu2Details].forEach(item => {
                idToName[item.component.id] = item.component.nama_komponen;
            });
            return componentList.map(id => idToName[id]);
        };

        const componentNames = getComponentNames();
        const headerRow = document.getElementById('headerRow');
        componentNames.forEach(name => {
            const th = document.createElement('th');
            th.className = 'border p-2';
            th.textContent = name;
            headerRow.appendChild(th);
        });

        const row1 = document.getElementById('rowMenu1');
        componentMenu1.forEach(val => {
            const td = document.createElement('td');
            td.className = 'border p-2';
            td.textContent = val;
            row1.appendChild(td);
        });

        const row2 = document.getElementById('rowMenu2');
        componentMenu2.forEach(val => {
            const td = document.createElement('td');
            td.className = 'border p-2';
            td.textContent = val;
            row2.appendChild(td);
        });
    </script>
</x-app-layout>
