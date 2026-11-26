<?php
// config/database.php - satu-satunya tempat pengelolaan koneksi database
$host = '127.0.0.1;port=8889';
$db   = 'db_latihan';
$user = 'root';
$pass = 'root';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    // Detail error tidak ditampilkan kepada pengguna aplikasi
    error_log($e->getMessage());
    http_response_code(500);
    exit('Terjadi kesalahan pada koneksi database.');
}
