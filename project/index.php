<?php
// index.php - titik masuk aplikasi (router)
session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/helpers/functions.php';

// Whitelist rute: hanya halaman di daftar ini yang boleh dimuat
$routes = [
    'dashboard'   => __DIR__ . '/views/dashboard.php',
    'user/list'   => __DIR__ . '/modules/user/list.php',
    'user/add'    => __DIR__ . '/modules/user/add.php',
    'user/edit'   => __DIR__ . '/modules/user/edit.php',
    'user/delete' => __DIR__ . '/modules/user/delete.php',
    'auth/login'  => __DIR__ . '/modules/auth/login.php',
    'auth/logout' => __DIR__ . '/modules/auth/logout.php',
];

// Rute yang hanya boleh diakses setelah login
$protectedRoutes = ['user/list', 'user/add', 'user/edit', 'user/delete'];

$page = $_GET['page'] ?? 'dashboard';
if ($page === '') {
    $page = 'dashboard';
}

if (!is_string($page) || !array_key_exists($page, $routes)) {
    http_response_code(404);
    $page = '404';
    $contentFile = __DIR__ . '/views/404.php';
} else {
    if (in_array($page, $protectedRoutes, true) && !sudahLogin()) {
        setFlash('error', 'Silakan login terlebih dahulu.');
        redirect('auth/login');
    }
    $contentFile = $routes[$page];
}

// Modul dijalankan lebih dulu dan keluarannya ditampung,
// sehingga modul tetap dapat melakukan redirect setelah memproses POST.
ob_start();
require $contentFile;
$content = ob_get_clean();

require_once __DIR__ . '/views/header.php';
echo $content;
require_once __DIR__ . '/views/footer.php';