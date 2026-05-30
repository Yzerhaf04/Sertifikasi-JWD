<?php 
/**
 * File     : hasil.php
 * Deskripsi: Menampilkan data hasil pendaftaran beasiswa
 * Author   : Yzerhaf04
 * Versi    : 1.0
 * Tanggal  : 30-05-2026
 * 
 * Initial state: data kosong, 
 * Final state  : data terisi, ditampilkan di tabel
 */
require 'config/database.php'; 
/** @var mysqli $conn */
?>

<h2 class="mb-4">Data Hasil Pendaftaran Beasiswa</h2>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>No HP</th>
            <th>Semester</th>
            <th>IPK</th>
            <th>Beasiswa</th>
            <th>Berkas</th>
            <th>Status Ajuan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Query membaca data untuk ditampilkan
        // Menampilkan semua elemen yg form ditambah elemen status_ajuan
        $result = mysqli_query($conn, "SELECT * FROM pendaftaran");
        
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>{$row['nama']}</td>
                <td>{$row['email']}</td>
                <td>{$row['no_hp']}</td>
                <td>{$row['semester']}</td>
                <td>{$row['ipk']}</td>
                <td>{$row['jenis_beasiswa']}</td>
                <td>{$row['berkas']}</td>
                <td><span class='badge bg-warning text-dark'>{$row['status_ajuan']}</span></td>
            </tr>";
        }
        ?>
    </tbody>
</table>