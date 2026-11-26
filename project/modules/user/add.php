<?php
// modules/user/add.php - menambah pengguna (Create)
$errors = [];
$nama = '';
$email = '';

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
    if (strlen($password) < 6) {
        $errors[] = 'Password minimal 6 karakter.';
    }

    if (!$errors) {
        $cek = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
        $cek->execute([$email]);
        if ($cek->fetchColumn() > 0) {
            $errors[] = 'Email sudah terdaftar.';
        }
    }

    if (!$errors) {
        $stmt = $pdo->prepare('INSERT INTO users (nama, email, password) VALUES (?, ?, ?)');
        $stmt->execute([$nama, $email, password_hash($password, PASSWORD_DEFAULT)]);
        setFlash('success', 'Pengguna "' . $nama . '" berhasil ditambahkan.');
        redirect('user/list');
    }
}
?>
<section>
    <h2>Tambah Pengguna</h2>
    <?php foreach ($errors as $err): ?>
        <div class="alert alert-error"><?= e($err) ?></div>
    <?php endforeach; ?>

    <form method="post" action="<?= e(url('user/add')) ?>">
        <?= csrfField() ?>
        <label>Nama</label>
        <input type="text" name="nama" value="<?= e($nama) ?>" required>
        <label>Email</label>
        <input type="email" name="email" value="<?= e($email) ?>" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <div>
            <button type="submit">Simpan</button>
            <a href="<?= e(url('user/list')) ?>">Batal</a>
        </div>
    </form>
</section>
