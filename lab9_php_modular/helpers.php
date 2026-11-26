<?php
// helpers.php - kumpulan function Bagian E (contoh nomor 5 + Latihan function)

if (!function_exists('formatRupiah')) {
    function formatRupiah(float $angka): string {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
}

if (!function_exists('e')) {
    function e(string $nilai): string {
        return htmlspecialchars($nilai, ENT_QUOTES, 'UTF-8');
    }
}

// Latihan function 1: konversi suhu Celcius ke Fahrenheit
function konversiCelciusKeFahrenheit($c) {
    return ($c * 9 / 5) + 32;
}

// Latihan function 2: predikat nilai berdasarkan rentang
// 85-100 = A, 75-84 = B, 65-74 = C, 50-64 = D, 0-49 = E
function tentukanStatusNilai($nilai) {
    if ($nilai < 0 || $nilai > 100) {
        return 'Nilai tidak valid';
    } elseif ($nilai >= 85) {
        return 'A (Sangat Baik)';
    } elseif ($nilai >= 75) {
        return 'B (Baik)';
    } elseif ($nilai >= 65) {
        return 'C (Cukup)';
    } elseif ($nilai >= 50) {
        return 'D (Kurang)';
    }
    return 'E (Gagal)';
}

// Latihan function 3: total belanja
function hitungTotal($harga, $jumlah) {
    return $harga * $jumlah;
}
?>
