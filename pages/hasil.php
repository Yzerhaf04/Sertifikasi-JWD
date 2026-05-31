<?php 
/**
 * File     : hasil.php
 * Deskripsi: Menampilkan data hasil pendaftaran beasiswa
 * Author   : Yzerhaf04
 * Versi    : 1.0
 * Tanggal  : 30-05-2026
 * Initial state: data kosong, 
 * Final state  : data terisi, ditampilkan di tabel
 */
$pendaftarans = getSemuaPendaftaran();
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
        <?php if(!empty($pendaftarans)): ?>
            <?php foreach ($pendaftarans as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['no_hp']) ?></td>
                    <td><?= htmlspecialchars($row['semester']) ?></td>
                    <td><?= formatIPK($row['ipk']) ?></td>
                    <td><?= htmlspecialchars($row['nama_beasiswa']) ?></td>
                    <td>
                        <a href="uploads/<?= htmlspecialchars($row['file_berkas']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                            Lihat Berkas
                        </a>
                    </td>
                    <td><span class='<?= badgeStatus($row['status_ajuan']) ?>'><?= htmlspecialchars($row['status_ajuan']) ?></span></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" class="text-center">Belum ada data pendaftaran yang masuk.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>