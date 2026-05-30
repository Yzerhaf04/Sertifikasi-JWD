<?php
// Panggil file konfigurasi
require_once 'config.php';

try {
    // Dapatkan instance PDO
    $db = getDB();
    echo "✅ Koneksi database berhasil!<br><br>";

    // Coba ambil data jenis beasiswa
    $stmt = $db->query("SELECT kode, nama FROM jenis_beasiswa");
    $beasiswa = $stmt->fetchAll();

    echo "<strong>Daftar Beasiswa yang Tersedia:</strong><ul>";
    foreach ($beasiswa as $b) {
        echo "<li>{$b['kode']} - {$b['nama']}</li>";
    }
    echo "</ul>";

} catch (PDOException $e) {
    echo "❌ Terjadi kesalahan: " . $e->getMessage();
}
?>