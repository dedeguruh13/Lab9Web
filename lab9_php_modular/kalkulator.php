<?php
// Halaman kedua yang memanggil function dari helpers.php (input dari form)
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/header.php';

$suhu   = $_POST['suhu']   ?? '';
$nilai  = $_POST['nilai']  ?? '';
$harga  = $_POST['harga']  ?? '';
$jumlah = $_POST['jumlah'] ?? '';
?>

<section class="content">
    <h2>Kalkulator (memakai helpers.php)</h2>
    <form method="post" action="">
        <label>Suhu (&deg;C)</label>
        <input type="number" step="any" name="suhu" value="<?= e((string) $suhu) ?>" required>
        <label>Nilai (0-100)</label>
        <input type="number" name="nilai" value="<?= e((string) $nilai) ?>" required>
        <label>Harga barang</label>
        <input type="number" name="harga" value="<?= e((string) $harga) ?>" required>
        <label>Jumlah</label>
        <input type="number" name="jumlah" value="<?= e((string) $jumlah) ?>" required>
        <button type="submit">Hitung</button>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <h3>Hasil</h3>
        <ul>
            <li><?= e((string) (float) $suhu) ?> &deg;C = <?= konversiCelciusKeFahrenheit((float) $suhu) ?> &deg;F</li>
            <li>Nilai <?= (int) $nilai ?> = <?= tentukanStatusNilai((int) $nilai) ?></li>
            <li>Total belanja = <?= formatRupiah(hitungTotal((float) $harga, (int) $jumlah)) ?></li>
        </ul>
    <?php endif; ?>
</section>

<?php require_once __DIR__ . '/footer.php'; ?>
