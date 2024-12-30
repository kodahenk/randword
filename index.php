<?php
// Klasör yolu
$folderPath = "json_dosyalar"; // JSON dosyalarının bulunduğu klasör

// Tüm JSON dosyalarını al
$jsonFiles = glob($folderPath . "/*.json");

// JSON dosyalarının varlığını kontrol et
if (empty($jsonFiles)) {
    die(json_encode(["error" => "Klasörde JSON dosyası bulunamadı."]));
}

// Rastgele bir JSON dosyası seç
$randomFile = $jsonFiles[array_rand($jsonFiles)];

// JSON dosyasını oku
$jsonContent = file_get_contents($randomFile);

// JSON verisini decode et
$words = json_decode($jsonContent, true);

// JSON verisinin geçerli olup olmadığını kontrol et
if (json_last_error() !== JSON_ERROR_NONE) {
    die(json_encode(["error" => "JSON dosyası okunamadı veya hatalı formatta", "message" => json_last_error_msg()]));
}

// JSON'dan rastgele bir kelime seç
$randomWord = $words[array_rand($words)];
$randomWord['link'] = "https://dictionary.cambridge.org/dictionary/english-turkish/" . $randomWord['word'];

// Resim dosyasının yolunu belirle
$imagePath = "images/" . $randomWord['word'] . ".jpeg";

// Resim dosyasını kontrol et ve uygun işlemi yap
if (file_exists($imagePath)) {
    // Resim dosyasını göster
    header('Content-Type: text/html; charset=utf-8');
    echo "<html><head><link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'></head><body class='bg-light'>";
    echo "<div class='container mt-5'><div class='card' style='width: 40rem; margin: auto;'>";
    echo "<img src='" . htmlspecialchars($imagePath) . "' class='card-img-top' alt='" . htmlspecialchars($randomWord['word']) . "'>";
    echo "<div class='card-body'><h5 class='card-title text-center'>" . htmlspecialchars($randomWord['word']) . "</h5></div>";
    echo "</div></div></body></html>";
} else {
    // Belirtilen linke yönlendir
    header('Location: ' . $randomWord['link']);
    exit;
}
