# Lab9Web — Praktikum 9: PHP Modular

| | |
|---|---|
| **Nama** | Guruh Khaerullah Kusvhi |
| **NIM** | 312310630 |
| **Kelas** | I251D |
| **Mata Kuliah** | Pemrograman Web |
| **Topik** | Modularisasi Program, Function, Template, dan Routing |

---

## 1. Tujuan Project

1. Memahami pengertian, tujuan, dan manfaat modularisasi program.
2. Membedakan `include`, `require`, `include_once`, dan `require_once`.
3. Membuat template halaman (header/footer) yang dipakai bersama oleh beberapa halaman.
4. Membuat function PHP dengan parameter dan nilai kembalian, lalu memisahkannya ke file helper.
5. Menyusun struktur direktori aplikasi PHP secara modular.
6. Menerapkan routing berdasarkan parameter URL dengan validasi halaman (whitelist + halaman 404).
7. Mengintegrasikan modularisasi dan routing ke aplikasi CRUD database.

## 2. Kebutuhan Perangkat

- Web server Apache (XAMPP / Laragon), dengan `mod_rewrite` aktif untuk bagian `.htaccess`
- PHP 8.0 atau lebih baru (diuji pada PHP 8.3) dengan ekstensi `pdo_mysql`
- MySQL / MariaDB
- Browser dan Visual Studio Code

## 3. Cara Menjalankan Aplikasi

1. Salin folder `lab9_php_modular` dan `project` ke docroot web server (misalnya `C:\xampp\htdocs\`).
2. Jalankan Apache dan MySQL dari XAMPP Control Panel.
3. Buka phpMyAdmin, lalu import file `project/database.sql`. File ini membuat database `db_latihan`, tabel `users`, dan satu akun awal.
4. Jika user/password MySQL berbeda, sesuaikan di `project/config/database.php`.
5. Buka di browser:
   - Latihan template & function: `http://localhost/lab9_php_modular/home.php`
   - Aplikasi CRUD modular (router): `http://localhost/project/index.php`
6. Login memakai akun awal: **admin@example.com** / **admin123**.

> Untuk URL ringkas (`/project/user/list`), pastikan `mod_rewrite` aktif dan `AllowOverride All` pada konfigurasi Apache (`httpd.conf`).

## 4. Struktur Direktori

```
Lab9Web/
├── lab9_php_modular/          # Bagian C, D, E + Latihan 1 & 2
│   ├── helpers/
│   │   └── functions.php      # Latihan 2: formatRupiah, hitungDiskon, validasiEmail, ringkasTeks
│   ├── pesan.php              # file yang dipanggil include/require
│   ├── uji-include.php        # uji include
│   ├── uji-require.php        # uji require
│   ├── header.php             # template: awal HTML + navigasi
│   ├── footer.php             # template: penutup halaman
│   ├── home.php               # halaman Home
│   ├── about.php              # halaman Tentang
│   ├── profil.php             # halaman Profil (Latihan 1)
│   ├── kontak.php             # halaman Kontak (Latihan 1 + pakai helpers/functions.php)
│   ├── function-dasar.php     # contoh function E.1 – E.4
│   ├── helpers.php            # E.5 + latihan function (konversi suhu, status nilai, total)
│   ├── contoh-panggil.php     # memanggil helpers.php
│   ├── latihan-function.php   # halaman 1 pemakai helpers.php
│   ├── kalkulator.php         # halaman 2 pemakai helpers.php
│   ├── produk.php             # halaman pemakai helpers/functions.php
│   └── style.css
├── project/                   # Bagian F, G, H, I + Latihan 3 & 4
│   ├── index.php              # titik masuk aplikasi (router)
│   ├── .htaccess              # URL rewrite (opsional)
│   ├── database.sql           # struktur & data awal database
│   ├── config/
│   │   └── database.php       # satu-satunya file koneksi database (PDO)
│   ├── views/
│   │   ├── header.php
│   │   ├── footer.php
│   │   ├── dashboard.php
│   │   └── 404.php
│   ├── helpers/
│   │   └── functions.php      # e(), url(), redirect(), flash message, CSRF, validasi, isActive()
│   ├── modules/
│   │   ├── user/
│   │   │   ├── list.php       # Read (+ pencarian)
│   │   │   ├── add.php        # Create
│   │   │   ├── edit.php       # Update
│   │   │   └── delete.php     # Delete (konfirmasi GET, hapus via POST + CSRF)
│   │   └── auth/
│   │       ├── login.php
│   │       └── logout.php
│   └── assets/
│       ├── css/style.css
│       └── js/script.js
├── screenshots/
└── README.md
```

![Struktur direktori repository](screenshots/01-struktur-direktori-repo.png)

![Struktur direktori project](screenshots/02-struktur-direktori-project.png)

## 5. Daftar Rute (`project/index.php`)

| Rute (`?page=`) | File | Keterangan | Perlu login |
|---|---|---|---|
| `dashboard` (default) | `views/dashboard.php` | Halaman utama, jumlah pengguna | Tidak |
| `user/list` | `modules/user/list.php` | Daftar & pencarian pengguna | Ya |
| `user/add` | `modules/user/add.php` | Form tambah pengguna | Ya |
| `user/edit&id=…` | `modules/user/edit.php` | Form ubah pengguna | Ya |
| `user/delete&id=…` | `modules/user/delete.php` | Konfirmasi & hapus (POST) | Ya |
| `auth/login` | `modules/auth/login.php` | Form login | Tidak |
| `auth/logout` | `modules/auth/logout.php` | Keluar dari sesi | Tidak |
| *(lainnya)* | `views/404.php` | Status HTTP 404 | – |

Dengan `.htaccess`, setiap rute juga bisa diakses tanpa `index.php?page=`, misalnya `/project/user/list`.

---

## 6. Langkah Praktikum

### 6.1 Bagian C — Menguji `include` dan `require`

1. Membuat folder `lab9_php_modular`, file `pesan.php`, `uji-include.php`, dan `uji-require.php`.

![Kode include & require](screenshots/03-kode-include-require.png)

2. Menjalankan `uji-include.php` saat `pesan.php` tersedia: isi `pesan.php` tampil di antara dua baris.

![Uji include normal](screenshots/04-uji-include-normal.png)

3. Mengganti nama `pesan.php` sementara, lalu menjalankan lagi `uji-include.php`. Muncul **Warning**, tetapi baris **"Sesudah pemanggilan" tetap dijalankan**.

![Include file hilang](screenshots/05-uji-include-file-hilang.png)

4. Mengulangi dengan `uji-require.php`. Muncul **Fatal error** dan baris **"Sesudah pemanggilan" tidak dijalankan**.

![Require file hilang](screenshots/06-uji-require-file-hilang.png)

**Catatan perbedaan:**

| | `include` | `require` |
|---|---|---|
| File tidak ditemukan | Warning | Fatal error |
| Baris berikutnya | Tetap dijalankan | Eksekusi berhenti |
| Cocok untuk | Komponen tidak kritis | File wajib (konfigurasi, koneksi DB) |

### 6.2 Bagian D + Latihan 1 — Template Multi-halaman

`header.php` berisi awal dokumen HTML, judul, dan navigasi. `footer.php` berisi penutup halaman. Halaman Home, Tentang, Profil, dan Kontak hanya berisi kontennya sendiri lalu memanggil template dengan `require_once`.

![Kode template](screenshots/07-kode-template-header-footer.png)

| Home | Tentang |
|---|---|
| ![Home](screenshots/08-template-home.png) | ![About](screenshots/09-template-about.png) |

| Profil | Kontak |
|---|---|
| ![Profil](screenshots/10-template-profil.png) | ![Kontak](screenshots/11-template-kontak.png) |

**Analisis hasil:**
- **Bagian yang digunakan bersama:** header (judul aplikasi), navigasi, dan footer. Semuanya berasal dari `header.php` dan `footer.php`.
- **Jika teks navigasi diubah di `header.php`:** perubahannya langsung terlihat di semua halaman, karena semua halaman memuat file yang sama.
- **Mengapa konten tidak diletakkan di `header.php`:** header hanya bertugas menyediakan bagian yang sama untuk semua halaman. Konten setiap halaman berbeda, jadi harus berada di file halaman masing-masing. Kalau tidak, semua halaman akan menampilkan konten yang sama.
- **Manfaat `require_once` dibanding menyalin header:** kode hanya ditulis sekali, mudah dipelihara, tampilan pasti konsisten, dan file tidak termuat dua kali. Jika header wajib tetapi tidak ada, `require` langsung menghentikan halaman, sehingga kesalahan cepat terlihat.

**Kriteria Latihan 1:** tidak ada salinan kode header/footer pada file halaman ✔, navigasi berfungsi ✔, tampilan konsisten ✔.

### 6.3 Bagian E — Function

Contoh function tanpa parameter, dengan parameter, dengan `return`, serta type declaration dan nilai default (`function-dasar.php`):

![Function dasar](screenshots/12-function-dasar.png)

Memanggil function dari file helper (`contoh-panggil.php`). Fungsi `e()` membuat tag `<script>` ditampilkan sebagai teks dan tidak dijalankan browser:

![Contoh panggil helper](screenshots/13-function-contoh-panggil.png)

**Latihan function:** `konversiCelciusKeFahrenheit()`, `tentukanStatusNilai()` (85–100 = A, 75–84 = B, 65–74 = C, 50–64 = D, < 50 = E), dan `hitungTotal()` dipindahkan ke `helpers.php`.

![Kode helpers.php](screenshots/14-kode-helpers-latihan-function.png)

`helpers.php` dipanggil dari **dua halaman berbeda**: `latihan-function.php` dan `kalkulator.php` (input dari form).

| Halaman 1: latihan-function.php | Halaman 2: kalkulator.php |
|---|---|
| ![Latihan function](screenshots/15-latihan-function-halaman1.png) | ![Kalkulator](screenshots/16-latihan-function-halaman2-kalkulator.png) |

### 6.4 Latihan 2 — Library Function

`lab9_php_modular/helpers/functions.php` berisi empat function: `formatRupiah()`, `hitungDiskon()`, `validasiEmail()`, dan `ringkasTeks()`.

![Kode helpers/functions.php](screenshots/17-kode-helpers-functions-latihan2.png)

Function tersebut dipakai pada dua halaman:
- `produk.php` → `formatRupiah()`, `hitungDiskon()`, `ringkasTeks()`

![Produk](screenshots/18-latihan2-produk.png)

- `kontak.php` → `validasiEmail()` dan `ringkasTeks()`

| Email tidak valid | Email valid (pesan diringkas) |
|---|---|
| ![Email salah](screenshots/19-latihan2-kontak-email-tidak-valid.png) | ![Email benar](screenshots/20-latihan2-kontak-email-valid.png) |

### 6.5 Bagian F, G + Latihan 3 — Struktur Direktori & Router Aman

`index.php` menjadi satu-satunya pintu masuk. Nilai `page` dicocokkan dengan **whitelist** `$routes` dan tidak pernah dipakai langsung sebagai path file. Nilai yang tidak terdaftar atau bukan string menghasilkan `http_response_code(404)`. Keluaran modul ditampung dengan `ob_start()`, sehingga modul tetap bisa melakukan `redirect` setelah memproses POST sebelum header HTML dikirim.

![Kode router](screenshots/21-kode-router-index.png)

![Kode config & .htaccess](screenshots/22-kode-config-database-htaccess.png)

![Kode template project](screenshots/23-kode-template-project.png)

**Pengujian routing:**

| Uji | URL | Hasil |
|---|---|---|
| Dashboard | `index.php` | 200, dashboard tampil |
| Rute tidak terdaftar | `index.php?page=admin/rahasia` | **404** |
| Parameter kosong | `index.php?page=` | 200, kembali ke dashboard |
| Tipe tidak sesuai (array) | `index.php?page[]=x` | **404**, tidak error |
| Percobaan path traversal | `index.php?page=../config/database` | **404**, file tidak dimuat |
| Rute terproteksi tanpa login | `index.php?page=user/list` | Diarahkan ke login |

| Dashboard | 404 |
|---|---|
| ![Dashboard](screenshots/24-router-dashboard.png) | ![404](screenshots/25-router-404-admin-rahasia.png) |

| page kosong | page array | path traversal |
|---|---|---|
| ![kosong](screenshots/26-router-page-kosong.png) | ![array](screenshots/27-router-page-array.png) | ![traversal](screenshots/28-router-path-traversal.png) |

![Redirect ke login](screenshots/29-router-protected-redirect-login.png)

### 6.6 Bagian I + Latihan 4 — Refactoring CRUD

Langkah yang dilakukan:
1. Membuat project baru `project/` dengan direktori `config`, `views`, `helpers`, `modules`, dan `assets`.
2. Memindahkan koneksi database ke `config/database.php` (PDO, dimuat sekali dengan `require_once` di `index.php`).
3. Memindahkan header, navigasi, dan footer ke `views/header.php` dan `views/footer.php`.
4. Memindahkan function umum (escaping, validasi email, format tanggal, flash message, CSRF) ke `helpers/functions.php`.
5. Mengelompokkan halaman CRUD pengguna ke `modules/user/`.
6. Mendaftarkan semua halaman di `index.php` dan mengubah semua tautan menjadi `index.php?page=...` (melalui helper `url()`).
7. Operasi tambah, ubah, dan hapus diproses lewat **POST**, divalidasi di server, dan dilindungi token **CSRF**. Penghapusan tidak terjadi hanya karena URL GET dibuka. GET hanya menampilkan halaman konfirmasi.

**Hasil pengujian CRUD:**

| Login berhasil | Read (daftar pengguna) |
|---|---|
| ![Login](screenshots/30-login-berhasil-dashboard.png) | ![List](screenshots/31-crud-read-list.png) |

| Create: form | Create: validasi gagal | Create: berhasil |
|---|---|---|
| ![Form tambah](screenshots/32-crud-create-form.png) | ![Validasi](screenshots/33-crud-create-validasi-gagal.png) | ![Tambah berhasil](screenshots/34-crud-create-berhasil.png) |

| Update: form | Update: berhasil |
|---|---|
| ![Form ubah](screenshots/35-crud-update-form.png) | ![Ubah berhasil](screenshots/36-crud-update-berhasil.png) |

| Delete: konfirmasi | Delete: berhasil |
|---|---|
| ![Konfirmasi hapus](screenshots/37-crud-delete-konfirmasi.png) | ![Hapus berhasil](screenshots/38-crud-delete-berhasil.png) |

Pencarian data:

![Pencarian](screenshots/39-crud-pencarian.png)

### 6.7 Tantangan Mandiri

| Tantangan | Implementasi |
|---|---|
| Menu aktif | Helper `isActive()` menambahkan class `active` (garis bawah) pada menu sesuai rute yang dibuka |
| Pesan sukses/gagal | Helper `setFlash()` / `tampilFlash()` berbasis session, ditampilkan di `views/header.php` |
| Pembatasan akses | Array `$protectedRoutes` di `index.php`. Rute `user/*` hanya bisa diakses setelah login (`modules/auth`) |
| URL rewrite `.htaccess` | `RewriteCond` meloloskan file/folder fisik (CSS, JS), sedangkan selain itu `RewriteRule` diteruskan ke `index.php?page=$1` |

Konfigurasi `.htaccess` yang diperlukan di XAMPP (`C:\xampp\apache\conf\httpd.conf`):
1. Pastikan baris `LoadModule rewrite_module modules/mod_rewrite.so` tidak diberi tanda `#`.
2. Pada blok `<Directory "C:/xampp/htdocs">`, ubah `AllowOverride None` menjadi `AllowOverride All`.
3. Restart Apache.

| `/project/user/list` | `/project/admin/rahasia` |
|---|---|
| ![Rewrite](screenshots/40-htaccess-rewrite-user-list.png) | ![Rewrite 404](screenshots/41-htaccess-rewrite-404.png) |

Logout:

![Logout](screenshots/42-logout.png)

---

## 7. Kendala dan Cara Mengatasinya

| Kendala | Penyebab | Solusi |
|---|---|---|
| Uji include/require dengan file yang sudah di-rename tetap menampilkan isi `pesan.php` | PHP menyimpan cache path dan opcache, sehingga file lama masih dianggap ada | Menunggu beberapa saat / me-restart Apache. Untuk pengembangan, `opcache` dan `realpath_cache` dimatikan di `php.ini` |
| `Cannot modify header information - headers already sent` saat redirect setelah simpan data | `header.php` sudah mengirim HTML sebelum modul memanggil `header('Location: ...')` | Router menjalankan modul lebih dulu dengan `ob_start()` / `ob_get_clean()`, baru kemudian mencetak header, konten, dan footer |
| CSS tidak tampil saat diakses lewat `/project/user/list` | Path relatif `assets/css/style.css` dibaca menjadi `/project/user/assets/...` | Membuat helper `baseUrl()` sehingga path aset selalu absolut dari folder project |
| `Function already declared` saat `helpers.php` dan `helpers/functions.php` sama-sama berisi `formatRupiah()` dan `e()` | Function dideklarasikan dua kali | Memakai `require_once` dan membungkus deklarasi dengan `if (!function_exists(...))` |
| Login gagal walaupun password benar | Hash password di `database.sql` tidak sesuai | Membuat hash dengan `password_hash('admin123', PASSWORD_DEFAULT)` lalu memasukkannya ke SQL |
| URL rewrite menghasilkan 404 dari Apache | `mod_rewrite` belum aktif / `AllowOverride None` | Mengaktifkan `mod_rewrite` dan mengubah `AllowOverride All`, lalu restart Apache |

---

## 8. Jawaban Pertanyaan Pemahaman

**1. Pengertian modularisasi dan manfaatnya.**
Modularisasi adalah teknik membagi program menjadi bagian-bagian kecil (modul) berdasarkan fungsi atau tanggung jawabnya, misalnya template tampilan, konfigurasi, helper, dan fitur. Manfaatnya: (1) kode dapat digunakan ulang tanpa ditulis berulang, (2) pemeliharaan lebih mudah karena perubahan cukup dilakukan di satu modul, (3) tampilan dan perilaku aplikasi lebih konsisten, (4) kode lebih mudah dibaca, ditelusuri, dan diuji, serta (5) pekerjaan tim bisa dibagi per modul sehingga konflik berkurang.

**2. Perbedaan include dan require ketika file tidak ditemukan.**
`include` hanya menghasilkan *warning* dan baris berikutnya tetap dijalankan. `require` menghasilkan *fatal error* dan eksekusi script langsung berhenti (lihat screenshot 05 dan 06).

**3. Mengapa require_once sesuai untuk konfigurasi database?**
Koneksi database wajib ada. Tanpanya aplikasi tidak bisa bekerja dengan benar, jadi lebih baik dihentikan (`require`) daripada berjalan dalam keadaan error. Akhiran `_once` memastikan file hanya dimuat sekali walaupun dipanggil dari beberapa modul, sehingga tidak terjadi koneksi ganda atau deklarasi ulang.

**4. Parameter, argumen, dan nilai return.**
Parameter adalah variabel yang ditulis pada deklarasi function, misalnya `$harga` pada `function hitungTotal($harga, $jumlah)`. Argumen adalah nilai nyata yang dikirim saat function dipanggil, misalnya `hitungTotal(15000, 3)`. Nilai return adalah hasil yang dikembalikan function kepada pemanggil dengan `return`, sehingga bisa disimpan ke variabel, dihitung lagi, atau dipakai dalam kondisi.

**5. Mengapa header dan footer dipisahkan dari konten?**
Header dan footer sama di semua halaman, sedangkan konten berbeda. Dengan dipisah, keduanya cukup ditulis dan diubah sekali, tampilannya konsisten, file halaman menjadi ringkas, dan setiap file punya tanggung jawab yang jelas.

**6. Fungsi index.php pada pola routing.**
`index.php` adalah titik masuk tunggal (front controller). File ini memuat konfigurasi dan helper, membaca parameter `page`, mencocokkannya dengan daftar rute, memeriksa hak akses, lalu memuat modul yang sesuai di antara template header dan footer.

**7. Mengapa router menggunakan whitelist rute?**
Agar hanya file yang memang ditentukan aplikasi yang bisa dimuat. Input pengguna tidak dipercaya begitu saja. Nilai di luar daftar langsung diarahkan ke halaman 404, sehingga file internal (misalnya konfigurasi) tidak bisa dipanggil secara sembarangan. Daftar rute juga menjadi dokumentasi halaman apa saja yang tersedia.

**8. Risiko jika input page langsung digabung menjadi path file.**
Misalnya `require $_GET['page'] . '.php'`. Penyerang bisa melakukan *path traversal* (`?page=../../config/database`) untuk memuat file yang tidak dimaksudkan, membaca atau menjalankan file sensitif, memicu error yang membocorkan struktur server, dan pada konfigurasi tertentu bahkan melakukan *file inclusion* (LFI/RFI) yang berujung eksekusi kode berbahaya.

**9. Fungsi RewriteCond dan RewriteRule pada .htaccess.**
`RewriteCond` adalah syarat sebelum aturan dijalankan. `%{REQUEST_FILENAME} !-f` dan `!-d` berarti aturan hanya berlaku jika yang diminta *bukan* file atau folder fisik, sehingga CSS, JS, dan gambar tetap dilayani langsung. `RewriteRule ^(.+)$ index.php?page=$1 [QSA,L]` menulis ulang URL, misalnya `/project/user/list` menjadi `index.php?page=user/list`. `QSA` mempertahankan query string lain (misalnya `&id=2`), dan `L` menandakan aturan terakhir.

**10. Bagian aplikasi CRUD yang dipindahkan ke config, views, helpers, dan modules.**
- **config/**: pengaturan koneksi database (`database.php`: host, nama DB, user, password, pembuatan objek PDO).
- **views/**: komponen tampilan bersama, yaitu `header.php` (HTML awal, navigasi, flash message), `footer.php`, `dashboard.php`, dan `404.php`.
- **helpers/**: function umum seperti `e()` untuk escaping, `url()`/`redirect()`, `validasiEmail()`, `formatTanggal()`, flash message, dan token CSRF.
- **modules/**: fitur aplikasi per domain, yaitu `user/` (list, add, edit, delete) dan `auth/` (login, logout).
