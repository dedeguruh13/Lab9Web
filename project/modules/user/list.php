<?php
// modules/user/list.php - menampilkan data pengguna (Read)
$cari = trim($_GET['cari'] ?? '');

if ($cari !== '') {
    $stmt = $pdo->prepare('SELECT * FROM users WHERE nama LIKE ? OR email LIKE ? ORDER BY id');
    $stmt->execute(["%$cari%", "%$cari%"]);
} else {
    $stmt = $pdo->query('SELECT * FROM users ORDER BY id');
}
$users = $stmt->fetchAll();
?>
<section>
    <h2>Data Pengguna</h2>
    <div class="toolbar">
        <a class="btn" href="<?= e(url('user/add')) ?>">+ Tambah Pengguna</a>
        <form method="get" action="<?= e(baseUrl('index.php')) ?>" class="form-cari">
            <input type="hidden" name="page" value="user/list">
            <input type="text" name="cari" placeholder="Cari nama / email" value="<?= e($cari) ?>">
            <button type="submit">Cari</button>
        </form>
    </div>

    <table class="tabel">
        <tr><th>No</th><th>Nama</th><th>Email</th><th>Dibuat</th><th>Aksi</th></tr>
        <?php if (!$users): ?>
            <tr><td colspan="5">Data tidak ditemukan.</td></tr>
        <?php endif; ?>
        <?php foreach ($users as $i => $u): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= e($u['nama']) ?></td>
                <td><?= e($u['email']) ?></td>
                <td><?= e(formatTanggal($u['created_at'])) ?></td>
                <td>
                    <a href="<?= e(url('user/edit', ['id' => $u['id']])) ?>">Ubah</a> |
                    <a href="<?= e(url('user/delete', ['id' => $u['id']])) ?>" class="link-hapus">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>
