-- database.sql - jalankan di phpMyAdmin / MySQL sebelum membuka aplikasi
CREATE DATABASE IF NOT EXISTS db_latihan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_latihan;

CREATE TABLE IF NOT EXISTS users (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nama       VARCHAR(100) NOT NULL,
    email      VARCHAR(100) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Akun awal untuk login. Email: admin@example.com | Password: admin123
INSERT INTO users (nama, email, password) VALUES
('Administrator', 'admin@example.com', '$2y$10$8uEtUtsIkOI.WG0/7a2Du.jC0YhdoNKp7tiFK3enRlH/1YgSX2k12');
