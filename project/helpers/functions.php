<?php
// helpers/functions.php - function umum yang dipakai banyak modul

// Escaping output ke HTML
function e(?string $nilai): string {
    return htmlspecialchars((string) $nilai, ENT_QUOTES, 'UTF-8');
}

// Base URL aplikasi (agar path aset & tautan tetap benar walau memakai URL rewrite)
function baseUrl(string $path = ''): string {
    $base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
    return $base . '/' . ltrim($path, '/');
}

// Membuat tautan ke rute: url('user/edit', ['id' => 1]) -> index.php?page=user/edit&id=1
function url(string $page, array $params = []): string {
    $query = http_build_query(array_merge(['page' => $page], $params));
    return baseUrl('index.php') . '?' . $query;
}

function redirect(string $page, array $params = []): void {
    header('Location: ' . url($page, $params));
    exit;
}

// Menu aktif berdasarkan rute yang sedang dibuka
function isActive(string $prefix): string {
    global $page;
    return (isset($page) && str_starts_with($page, $prefix)) ? 'active' : '';
}

// Pesan sukses/gagal setelah operasi CRUD (flash message berbasis session)
function setFlash(string $tipe, string $pesan): void {
    $_SESSION['flash'] = ['tipe' => $tipe, 'pesan' => $pesan];
}

function tampilFlash(): string {
    if (empty($_SESSION['flash'])) {
        return '';
    }
    $f = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return '<div class="alert alert-' . e($f['tipe']) . '">' . e($f['pesan']) . '</div>';
}

// Validasi
function validasiEmail(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function formatTanggal(string $tanggal): string {
    return date('d-m-Y H:i', strtotime($tanggal));
}

// Proteksi CSRF untuk operasi tambah/ubah/hapus
function csrfToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrfField(): string {
    return '<input type="hidden" name="csrf_token" value="' . e(csrfToken()) . '">';
}

function cekCsrf(): bool {
    $token = $_POST['csrf_token'] ?? '';
    return is_string($token) && hash_equals(csrfToken(), $token);
}

// Autentikasi
function sudahLogin(): bool {
    return !empty($_SESSION['user_id']);
}
