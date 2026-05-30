-- ============================================================
-- File     : database.sql
-- Deskripsi: database sistem pendaftaran beasiswa kampus
-- Author   : Yzerhaf
-- Versi    : 1.0
-- Tanggal  : 2024-01-01
-- ============================================================

CREATE DATABASE IF NOT EXISTS beasiswa CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE beasiswa;

-- Tabel jenis beasiswa
CREATE TABLE IF NOT EXISTS jenis_beasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    syarat_ipk DECIMAL(3,2) NOT NULL DEFAULT 3.00,
    syarat_lain TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel pendaftaran beasiswa
CREATE TABLE IF NOT EXISTS pendaftaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    no_hp VARCHAR(20) NOT NULL,
    semester TINYINT NOT NULL CHECK (semester BETWEEN 1 AND 8),
    ipk DECIMAL(3,2) NOT NULL,
    jenis_beasiswa_id INT NOT NULL,
    file_berkas VARCHAR(255),
    status_ajuan ENUM('belum di verifikasi', 'dalam proses', 'diterima', 'ditolak') DEFAULT 'belum di verifikasi',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (jenis_beasiswa_id) REFERENCES jenis_beasiswa(id)
);

-- Data awal jenis beasiswa
INSERT INTO jenis_beasiswa (kode, nama, deskripsi, syarat_ipk, syarat_lain) VALUES
('BSW-AKD', 'Beasiswa Akademik', 'Beasiswa prestasi akademik untuk mahasiswa berprestasi tinggi', 3.00, 'IPK minimal 3.00, Transkrip Nilai, Surat Rekomendasi Jurusan'),
('BSW-NON', 'Beasiswa Non-Akademik', 'Beasiswa untuk mahasiswa berprestasi di bidang non-akademik (seni, olahraga, dll)', 3.00, 'IPK minimal 3.00, Sertifikat Prestasi Non-Akademik, Surat Rekomendasi Jurusan'),
('BSW-EKN', 'Beasiswa Ekonomi', 'Beasiswa untuk mahasiswa kurang mampu secara ekonomi', 3.00, 'IPK minimal 3.00, Surat Keterangan Tidak Mampu, Slip Gaji Orang Tua'),
('BSW-RIS', 'Beasiswa Riset', 'Beasiswa untuk mahasiswa yang aktif dalam kegiatan riset/penelitian', 3.00, 'IPK minimal 3.00, Proposal Riset, Surat Rekomendasi Pembimbing');
