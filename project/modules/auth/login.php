<?php
// modules/auth/login.php
if (sudahLogin()) {
    redirect('dashboard');
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!cekCsrf()) {
        $error = 'Token keamanan tidak valid, silakan ulangi.';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $akun = $stmt->fetch();

        if ($akun && password_verify($password, $akun['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id']   = $akun['id'];
            $_SESSION['user_nama'] = $akun['nama'];
            setFlash('success', 'Login berhasil. Selamat datang, ' . $akun['nama'] . '.');
            redirect('dashboard');
        }
        $error = 'Email atau password salah.';
    }
}
?>
<section>
    <h2>Login</h2>
    <?php if ($error): ?>
        <div class="alert alert-error"><?= e($error) ?></div>
    <?php endif; ?>
    <form method="post" action="<?= e(url('auth/login')) ?>">
        <?= csrfField() ?>
        <label>Email</label>
        <input type="email" name="email" value="<?= e($email) ?>" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <button type="submit">Login</button>
    </form>
    <p><small>Akun awal: admin@example.com / admin123</small></p>
</section>
