<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel {{$title}}</title>

    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
</head>
<body>
    <h1>{{$title}}</h1>
    <p>Target: {{$targetMenu->nama_menu}}</p>
    <p>Menus: {{$menus}}</p>
    @foreach ($menus as $menu)
        <p>Menu-{{$menu->id}}: {{$menu->nama_menu}}</p>
    @endforeach

    <div>
        <?php
            // Fungsi untuk menghitung panjang vektor (magnitude)
            function calculateMagnitude($vector)
            {
                $sum = 0;
                foreach ($vector as $value) {
                    $sum += $value ** 2;
                }
                return sqrt($sum);
            }
    
            // Fungsi untuk menghitung dot product antara dua vektor
            function calculateDotProduct($vector1, $vector2)
            {
                $dotProduct = 0;
                for ($i = 0; $i < count($vector1); $i++) {
                    $dotProduct += $vector1[$i] * $vector2[$i];
                }
                return $dotProduct;
            }

            // Fungsi untuk menghitung Cosine Similarity
            function cosineSimilarity($vector1, $vector2)
            {
                $dotProduct = calculateDotProduct($vector1, $vector2);
                $magnitude1 = calculateMagnitude($vector1);
                $magnitude2 = calculateMagnitude($vector2);

                // Cegah pembagian dengan nol
                if ($magnitude1 == 0 || $magnitude2 == 0) {
                    return 0;
                }

                return $dotProduct / ($magnitude1 * $magnitude2);
            }

            // Vektor A, B, dan C
            // $input1 = ["Nasi", "Ayam", "Bayam", "Jeruk", "Poultry", 3];
            // $input2 = ["Mie", "Sapi", "Kol", "Pisang", "Meat", 2];
            // $target = ["Nasi", "Sapi", "Sawi", "Pisang", "Meat", 3];

            // Vektor A, B, dan C
            $input1 = ["Nasi", "Ayam", "Bayam", "Jeruk", "Poultry", 3];
            $input2 = ["Mie", "Sapi", "Kol", "Pisang", "Meat", 2];
            $target = [$targetMenu->karbohidrat, $targetMenu->protein, $targetMenu->sayur, $targetMenu->buah, $targetMenu->kategori_bahan_utama, $targetMenu->vendor_id];

            $A = array();
            $B = array();
            $C = array();

            // Konversi input menjadi vektor
            for ($i = 0; $i < count($target); $i++) {
                if (strtolower($target[$i]) == strtolower($input1[$i])) {
                    $A[] = 1;
                } else {
                    $A[] = 0;
                }

                if ($target[$i] == $input2[$i]) {
                    $B[] = 1;
                } else {
                    $B[] = 0;
                }
            }

            $C = [1, 1, 1, 1, 1, 1]; // Karena untuk target vektornya semua pasti 1

            // Hitung Cosine Similarity
            $cosineAC = cosineSimilarity($A, $C);
            $cosineBC = cosineSimilarity($B, $C);

            // Tampilkan hasil
            echo "Cosine Similarity (A, C): " . round($cosineAC, 2);
            echo "Cosine Similarity (B, C): " . round($cosineBC, 2);
        ?>
    </div>

    <script src="/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
