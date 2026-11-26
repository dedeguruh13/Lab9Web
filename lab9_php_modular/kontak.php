<?php
// Halaman 2 yang memakai helpers/functions.php (validasiEmail, ringkasTeks)
require_once __DIR__ . '/helpers/functions.php';
require_once __DIR__ . '/header.php';

$nama  = trim($_POST['nama']  ?? '');
$email = trim($_POST['email'] ?? '');
$pesan = trim($_POST['pesan'] ?? '');
$error = '';
$sukses = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($nama === '' || $pesan === '') {
        $error = 'Nama dan pesan wajib diisi.';
    } elseif (!validasiEmail($email)) {
        $error = 'Format email tidak valid.';
    } else {
        $sukses = true;
    }
}
?>

<section class="content">
    <h2>Halaman Kontak</h2>

    <?php if ($error): ?>
        <div class="alert alert-error"><?= e($error) ?></div>
    <?php elseif ($sukses): ?>
        <div class="alert alert-success">
            Terima kasih <?= e($nama) ?> (<?= e($email) ?>). Pesan Anda:
            "<?= e(ringkasTeks($pesan, 60)) ?>"
        </div>
    <?php endif; ?>

    <form method="post" action="">
        <label>Nama</label>
        <input type="text" name="nama" value="<?= e($nama) ?>">
        <label>Email</label>
        <input type="text" name="email" value="<?= e($email) ?>">
        <label>Pesan</label>
        <textarea name="pesan" rows="4"><?= e($pesan) ?></textarea>
        <button type="submit">Kirim</button>
    </form>
</section>

<?php require_once __DIR__ . '/footer.php'; ?>
