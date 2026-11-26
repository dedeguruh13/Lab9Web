<?php
// helpers/functions.php - Latihan 2: library function

// Escaping teks sebelum ditampilkan ke HTML
if (!function_exists('e')) {
    function e(string $nilai): string {
        return htmlspecialchars($nilai, ENT_QUOTES, 'UTF-8');
    }
}

// 1. Mengubah angka menjadi format mata uang Rupiah
if (!function_exists('formatRupiah')) {
    function formatRupiah(float $angka): string {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
}

// 2. Menghitung harga setelah diskon (persen default 10%)
function hitungDiskon(float $harga, float $persen = 10): float {
    return $harga - ($harga * ($persen / 100));
}

// 3. Memeriksa apakah format email valid
function validasiEmail(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// 4. Meringkas teks panjang menjadi maksimal $batas karakter
function ringkasTeks(string $teks, int $batas = 50): string {
    if (mb_strlen($teks) <= $batas) {
        return $teks;
    }
    return rtrim(mb_substr($teks, 0, $batas)) . '...';
}
?>
