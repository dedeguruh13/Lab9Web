<?php
// modules/user/delete.php - menghapus pengguna (Delete)
// GET  : hanya menampilkan konfirmasi (tidak menghapus apa pun)
// POST : menghapus data setelah token CSRF valid
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$id ?: 0]);
$data = $stmt->fetch();

if (!$data) {
    setFlash('error', 'Data pengguna tidak ditemukan.');
    redirect('user/list');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!cekCsrf()) {
        setFlash('error', 'Token keamanan tidak valid. Data tidak dihapus.');
    } elseif ((int) $data['id'] === (int) $_SESSION['user_id']) {
        setFlash('error', 'Akun yang sedang login tidak dapat dihapus.');
    } else {
        $pdo->prepare('DELETE FROM users WHERE id = ?')->execute([$id]);
        setFlash('success', 'Pengguna "' . $data['nama'] . '" berhasil dihapus.');
    }
    redirect('user/list');
}
?>
<section>
    <h2>Hapus Pengguna</h2>
    <p>Yakin ingin menghapus pengguna berikut?</p>
    <table class="tabel">
        <tr><th>Nama</th><td><?= e($data['nama']) ?></td></tr>
        <tr><th>Email</th><td><?= e($data['email']) ?></td></tr>
    </table>
    <form method="post" action="<?= e(url('user/delete', ['id' => $id])) ?>" class="form-hapus">
        <?= csrfField() ?>
        <div>
            <button type="submit" class="btn-danger">Ya, Hapus</button>
            <a href="<?= e(url('user/list')) ?>">Batal</a>
        </div>
    </form>
</section>
