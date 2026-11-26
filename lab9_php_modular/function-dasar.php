<?php
// function-dasar.php - contoh Bagian E nomor 1 s.d. 4

// 1. Function tanpa parameter
function tampilkanSalam() {
    echo "Selamat belajar PHP modular!";
}

// 2. Function dengan parameter
function sapaPengguna($nama) {
    echo "Halo, " . htmlspecialchars($nama, ENT_QUOTES, 'UTF-8');
}

// 3. Function dengan return
function hitungLuasPersegiPanjang($panjang, $lebar) {
    return $panjang * $lebar;
}

// 4. Type declaration dan nilai default
function hitungDiskon(float $harga, float $persen = 10): float {
    return $harga * ($persen / 100);
}

echo "<h3>1. Function tanpa parameter</h3>";
tampilkanSalam();

echo "<h3>2. Function dengan parameter</h3>";
sapaPengguna("Rina");

echo "<h3>3. Function dengan return</h3>";
$luas = hitungLuasPersegiPanjang(8, 5);
echo "Luas: " . $luas;

echo "<h3>4. Type declaration dan nilai default</h3>";
echo hitungDiskon(200000);     // diskon 10%
echo "<br>";
echo hitungDiskon(200000, 15); // diskon 15%
?>
