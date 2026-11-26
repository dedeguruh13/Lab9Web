<?php
// views/dashboard.php
$jumlahUser = (int) $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
?>
<section>
    <h2>Dashboard</h2>
    <p>Selamat datang di aplikasi CRUD yang sudah dimodularisasi.</p>
    <div class="card">
        <span class="angka"><?= $jumlahUser ?></span>
        <span>Jumlah pengguna terdaftar</span>
    </div>
    <p><a class="btn" href="<?= e(url('user/list')) ?>">Kelola Data Pengguna</a></p>
</section>
