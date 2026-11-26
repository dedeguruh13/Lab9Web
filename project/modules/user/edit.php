<?php
// modules/user/edit.php - mengubah data pengguna (Update)
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$id ?: 0]);
$data = $stmt->fetch();

if (!$data) {
    setFlash('error', 'Data pengguna tidak ditemukan.');
    redirect('user/list');
}

$errors = [];
$nama  = $data['nama'];
$email = $data['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim($_POST['nama'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!cekCsrf()) {
        $errors[] = 'Token keamanan tidak valid, silakan ulangi.';
    }
    if ($nama === '') {
        $errors[] = 'Nama wajib diisi.';
    }
    if (!validasiEmail($email)) {
        $errors[] = 'Format email tidak valid.';
    }
    if ($password !== '' && strlen($password) < 6) {
        $errors[] = 'Password minimal 6 karakter.';
    }

    if (!$errors) {
        $cek = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = ? AND id <> ?');
        $cek->execute([$email, $id]);
        if ($cek->fetchColumn() > 0) {
            $errors[] = 'Email sudah dipakai pengguna lain.';
        }
    }

    if (!$errors) {
        if ($password !== '') {
            $stmt = $pdo->prepare('UPDATE users SET nama = ?, email = ?, password = ? WHERE id = ?');
            $stmt->execute([$nama, $email, password_hash($password, PASSWORD_DEFAULT), $id]);
        } else {
            $stmt = $pdo->prepare('UPDATE users SET nama = ?, email = ? WHERE id = ?');
            $stmt->execute([$nama, $email, $id]);
        }
        setFlash('success', 'Data pengguna "' . $nama . '" berhasil diubah.');
        redirect('user/list');
    }
}
?>
<section>
    <h2>Ubah Pengguna</h2>
    <?php foreach ($errors as $err): ?>
        <div class="alert alert-error"><?= e($err) ?></div>
    <?php endforeach; ?>

    <form method="post" action="<?= e(url('user/edit', ['id' => $id])) ?>">
        <?= csrfField() ?>
        <label>Nama</label>
        <input type="text" name="nama" value="<?= e($nama) ?>" required>
        <label>Email</label>
        <input type="email" name="email" value="<?= e($email) ?>" required>
        <label>Password baru <small>(kosongkan jika tidak diubah)</small></label>
        <input type="password" name="password">
        <div>
            <button type="submit">Simpan Perubahan</button>
            <a href="<?= e(url('user/list')) ?>">Batal</a>
        </div>
    </form>
</section>
