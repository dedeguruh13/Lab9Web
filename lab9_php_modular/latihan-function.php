<?php
// Halaman pertama yang memanggil function dari helpers.php
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/header.php';

$daftarSuhu  = [0, 25, 37, 100];
$daftarNilai = [92, 80, 70, 55, 30];
?>

<section class="content">
    <h2>Latihan Function</h2>

    <h3>1. konversiCelciusKeFahrenheit()</h3>
    <table class="tabel">
        <tr><th>Celcius</th><th>Fahrenheit</th></tr>
        <?php foreach ($daftarSuhu as $c): ?>
            <tr><td><?= $c ?> &deg;C</td><td><?= konversiCelciusKeFahrenheit($c) ?> &deg;F</td></tr>
        <?php endforeach; ?>
    </table>

    <h3>2. tentukanStatusNilai()</h3>
    <table class="tabel">
        <tr><th>Nilai</th><th>Predikat</th></tr>
        <?php foreach ($daftarNilai as $n): ?>
            <tr><td><?= $n ?></td><td><?= tentukanStatusNilai($n) ?></td></tr>
        <?php endforeach; ?>
    </table>

    <h3>3. hitungTotal()</h3>
    <?php $total = hitungTotal(15000, 3); ?>
    <p>Harga Rp 15.000 x 3 item = <strong><?= formatRupiah($total) ?></strong></p>
</section>

<?php require_once __DIR__ . '/footer.php'; ?>
