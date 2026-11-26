<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aplikasi CRUD Modular</title>
    <link rel="stylesheet" href="<?= e(baseUrl('assets/css/style.css')) ?>">
</head>
<body>
<div class="container">
    <header>
        <h1>Aplikasi CRUD Modular</h1>
        <p>Praktikum 9 - PHP Modular, Function, Template, dan Routing</p>
    </header>
    <nav>
        <a href="<?= e(url('dashboard')) ?>" class="<?= isActive('dashboard') ?>">Dashboard</a>
        <a href="<?= e(url('user/list')) ?>" class="<?= isActive('user/') ?>">Data Pengguna</a>
        <span class="spacer"></span>
        <?php if (sudahLogin()): ?>
            <span class="user-info">Login: <?= e($_SESSION['user_nama']) ?></span>
            <a href="<?= e(url('auth/logout')) ?>">Logout</a>
        <?php else: ?>
            <a href="<?= e(url('auth/login')) ?>" class="<?= isActive('auth/login') ?>">Login</a>
        <?php endif; ?>
    </nav>
    <main>
        <?= tampilFlash() ?>
