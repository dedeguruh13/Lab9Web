<?php
// Halaman 1 yang memakai helpers/functions.php (formatRupiah, hitungDiskon, ringkasTeks)
require_once __DIR__ . '/helpers/functions.php';
require_once __DIR__ . '/header.php';

$produk = [
    ['nama' => 'Kopi Arabika Gayo 250g', 'harga' => 85000,  'diskon' => 10,
     'deskripsi' => 'Kopi arabika dari dataran tinggi Gayo dengan aroma rempah dan rasa asam buah yang segar.'],
    ['nama' => 'Kopi Robusta Lampung 250g', 'harga' => 60000, 'diskon' => 15,
     'deskripsi' => 'Robusta pilihan dengan body tebal dan rasa cokelat pahit, cocok untuk espresso dan kopi susu.'],
    ['nama' => 'V60 Dripper', 'harga' => 120000, 'diskon' => 5,
     'deskripsi' => 'Alat seduh manual berbentuk kerucut untuk menghasilkan kopi yang bersih dan jernih.'],
];
?>

<section class="content">
    <h2>Daftar Produk</h2>
    <table class="tabel">
        <tr><th>Produk</th><th>Deskripsi</th><th>Harga</th><th>Diskon</th><th>Harga Akhir</th></tr>
        <?php foreach ($produk as $p): ?>
            <tr>
                <td><?= e($p['nama']) ?></td>
                <td><?= e(ringkasTeks($p['deskripsi'], 40)) ?></td>
                <td><?= formatRupiah($p['harga']) ?></td>
                <td><?= $p['diskon'] ?>%</td>
                <td><?= formatRupiah(hitungDiskon($p['harga'], $p['diskon'])) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>

<?php require_once __DIR__ . '/footer.php'; ?>
