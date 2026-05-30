<?php
// Pastikan file functions.php sudah di-include di index.php atau panggil di sini jika belum.
// Memanggil fungsi untuk mengambil semua jenis beasiswa dari database
require_once __DIR__ . '/../functions.php'; // Sesuaikan path ini dengan letak file functions.php Anda

$jenis_beasiswa = getSemuaJenisBeasiswa();
?>

<h2 class="mb-4">Pilihan Beasiswa</h2>
<div class="row">
    <?php if (!empty($jenis_beasiswa)): ?>
        <?php foreach ($jenis_beasiswa as $index => $beasiswa): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= ($index + 1) . '. ' . htmlspecialchars($beasiswa['nama']) ?></h5>
                        
                        <p class="card-text text-muted mb-3">
                            <small>Kode: <?= htmlspecialchars($beasiswa['kode']) ?></small>
                        </p>
                        
                        <p class="card-text mb-3">
                            <?= htmlspecialchars($beasiswa['deskripsi']) ?>
                        </p>

                        <div class="mt-auto">
                            <hr>
                            <p class="mb-2"><strong>Syarat IPK Minimal:</strong> <?= formatIPK($beasiswa['syarat_ipk']) ?></p>
                            <p class="mb-3"><strong>Syarat Lain:</strong> <?= htmlspecialchars($beasiswa['syarat_lain']) ?></p>
                            
                            <a href="index.php?page=daftar&jenis=<?= $beasiswa['id'] ?>" class="btn btn-primary w-100">Daftar Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="alert alert-warning" role="alert">
                Saat ini belum ada informasi jenis beasiswa yang tersedia.
            </div>
        </div>
    <?php endif; ?>
</div>