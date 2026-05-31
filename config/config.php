<?php
/**
 * File     : config.php
 * Deskripsi: Konfigurasi koneksi database MySQL dan konstanta aplikasi
 * Author   : Yzerhaf04
 * Versi    : 1.0
 * Tanggal  : 30-05-2026
 * Initial state: Belum terhubung ke database
 * Final state  : Terhubung ke database, konstanta terdefinisi
 */

// ============================================================
// KONFIGURASI DATABASE
// ============================================================ 
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'beasiswa');
define('DB_USER', 'root');       
define('DB_PASS', '');           

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
// define('IPK_MAHASISWA', 2.90);   // ← ubah ke 2.90 untuk menguji kondisi IPK < 3
define('IPK_MAHASISWA', 3.40);   // ← ubah ke 3.40 untuk menguji kondisi IPK >= 3

// ============================================================
// KONFIGURASI UPLOAD BERKAS
// ============================================================ 
define('UPLOAD_DIR', __DIR__ . '/../uploads/');
define('UPLOAD_MAX_SIZE', 10 * 1024 * 1024); // 10 MB
define('UPLOAD_ALLOWED_TYPES', ['application/pdf']);