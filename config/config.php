<?php
/**
 * File     : config.php
 * Deskripsi: Konfigurasi koneksi database MySQL dan konstanta aplikasi
 * Author   : Yzerhaf04
 * Versi    : 1.0
 * Tanggal  : 30-05-2026
 * * Initial state: Belum terhubung ke database
 * Final state  : Terhubung ke database, konstanta terdefinisi
 */

// ============================================================
// KONFIGURASI DATABASE
// Sesuaikan nilai berikut dengan konfigurasi MySQL lokal Anda
// ============================================================ 
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'beasiswa');
define('DB_USER', 'root');       // ganti sesuai username MySQL Anda
define('DB_PASS', '');           // ganti sesuai password MySQL Anda

// ============================================================
// KONSTANTA APLIKASI
// ============================================================
define('APP_NAME', 'MyBeasiswa');
define('APP_VERSION', '1.0');

/**
 * Nilai IPK diasumsikan didapat otomatis dari sistem akademik.
 * Untuk keperluan demonstrasi, gunakan salah satu nilai di bawah:
 * - IPK_MAHASISWA = 3.40  → IPK di atas 3, bisa mendaftar
 * - IPK_MAHASISWA = 2.90  → IPK di bawah 3, tidak bisa mendaftar
 */
define('IPK_MAHASISWA', 2.90);   // ← ubah ke 2.90 untuk menguji kondisi IPK < 3
// define('IPK_MAHASISWA', 3.40);   // ← ubah ke 3.40 untuk menguji kondisi IPK >= 3

define('UPLOAD_DIR', __DIR__ . '/../uploads/');
define('UPLOAD_MAX_SIZE', 10 * 1024 * 1024); // 10 MB
define('UPLOAD_ALLOWED_TYPES', ['application/pdf', 'image/jpeg', 'image/png', 'application/zip']);

// ============================================================
// FUNGSI KONEKSI DATABASE (PDO)
// ============================================================

/**
 * getDB() - Mengembalikan instance PDO untuk koneksi ke MySQL
 * * Initial state : Belum ada koneksi aktif
 * Final state   : Instance PDO siap digunakan
 * * @return PDO
 * @throws PDOException jika koneksi gagal
 */
function getDB(): PDO {
    static $pdo = null; // Gunakan singleton agar koneksi hanya dibuat sekali

    if ($pdo === null) {
        $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // Tampilkan error asli untuk sementara waktu (HANYA UNTUK DEBUGGING)
            die("Detail Error MySQL: " . $e->getMessage());
        }
    }

    return $pdo;
}