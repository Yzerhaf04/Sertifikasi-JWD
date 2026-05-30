<?php
/**
 * File     : pages/daftar.php
 * Deskripsi: Halaman registrasi beasiswa
 * * Initial state: form kosong, 
 * Final state  : form terisi, data tersimpan di database menggunakan helper, file terupload.
 */

// Memanggil file fungsi (pastikan path ini sesuai dengan struktur direktori Anda)
// config.php tidak perlu dipanggil lagi jika di dalam function.php sudah di-require.
require_once __DIR__ . '/../function.php'; 

// Menggunakan konstanta IPK dari config.php (bukan IPK_USER lagi)
$ipk_user = IPK_MAHASISWA;

// Aturan logika form: Jika IPK < 3, seluruh form dinonaktifkan
$disableAttr = ($ipk_user < 3) ? 'disabled' : '';
$autofocusAttr = ($ipk_user >= 3) ? 'autofocus' : '';

// Tangkap parameter 'jenis' dari URL (berasal dari tombol di home.php)
$selected_jenis = isset($_GET['jenis']) ? (int)$_GET['jenis'] : 0;

// Ambil daftar beasiswa untuk pilihan dropdown secara dinamis dari database
$daftar_beasiswa = getSemuaJenisBeasiswa();

// Penanganan aksi submit form
if (isset($_POST['submit'])) {
    // Ambil dan sanitasi input dari form
    $nama = sanitize($_POST['nama']);
    $email = sanitize($_POST['email']);
    $hp = sanitize($_POST['hp']);
    $semester = (int)$_POST['semester'];
    $jenis_beasiswa_id = (int)$_POST['jenis_beasiswa'];
    
    // Validasi format email dan nomor HP menggunakan helper
    if (!validateEmail($email)) {
        echo "<div class='alert alert-danger'>Format email tidak valid!</div>";
    } elseif (!validatePhone($hp)) {
        echo "<div class='alert alert-danger'>Format nomor HP tidak valid (harus 8-15 digit angka)!</div>";
    } else {
        // Proses upload berkas syarat menggunakan fungsi dari function.php
        $file_berkas = uploadBerkas($_FILES['berkas']);

        if ($file_berkas) {
            // Jika upload sukses, susun array data untuk disimpan ke database
            $dataPendaftaran = [
                'nama'              => $nama,
                'email'             => $email,
                'no_hp'             => $hp,
                'semester'          => $semester,
                'ipk'               => $ipk_user,
                'jenis_beasiswa_id' => $jenis_beasiswa_id,
                'file_berkas'       => $file_berkas
            ];
            
            // Simpan pendaftaran ke database
            $insertId = simpanPendaftaran($dataPendaftaran);
            
            if ($insertId) {
                echo "<div class='alert alert-success'>Pendaftaran berhasil! <a href='index.php?page=hasil'>Lihat Hasil</a></div>";
            } else {
                echo "<div class='alert alert-danger'>Terjadi kesalahan saat menyimpan data ke database.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Gagal mengupload berkas! Pastikan format file sesuai (hanya PDF) dan ukuran tidak melebihi 10MB.</div>";
        }
    }
}
?>

<h2 class="mb-4">Registrasi Beasiswa</h2>

<?php if($ipk_user < 3): ?>
    <div class="alert alert-warning">
        Mohon maaf, IPK Anda saat ini (<strong><?= formatIPK($ipk_user) ?></strong>) tidak memenuhi syarat minimal (3.00) untuk mendaftar beasiswa.
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Masukkan Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" required <?= $disableAttr ?>>
            </div>
            
            <div class="mb-3">
                <label>Masukkan Email</label>
                <input type="email" name="email" class="form-control" required <?= $disableAttr ?>>
            </div>
            
            <div class="mb-3">
                <label>Nomor HP</label>
                <input type="text" name="hp" class="form-control" required <?= $disableAttr ?>>
            </div>
            
            <div class="mb-3">
                <label>Semester Saat Ini</label>
                <select name="semester" class="form-control" required <?= $disableAttr ?>>
                    <option value="">Pilih Semester</option>
                    <?php for($i=1; $i<=8; $i++) { echo "<option value='$i'>Semester $i</option>"; } ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label>IPK Terakhir</label>
                <input type="text" value="<?= formatIPK($ipk_user) ?>" class="form-control" readonly>
            </div>
            
            <div class="mb-3">
                <label>Pilihan Beasiswa</label>
                <select name="jenis_beasiswa" class="form-control" required <?= $disableAttr ?> <?= $autofocusAttr ?>>
                    <option value="">Pilih Beasiswa</option>
                    <?php foreach($daftar_beasiswa as $beasiswa): ?>
                        <option value="<?= $beasiswa['id'] ?>" <?= ($selected_jenis == $beasiswa['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($beasiswa['nama']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label>Upload Berkas Syarat</label>
                <input type="file" name="berkas" class="form-control" accept=".pdf" required <?= $disableAttr ?>>
                <small class="text-muted">Format yang diizinkan: <strong>PDF</strong>. Maksimal 10 MB.</small>
            </div>
            
            <button type="submit" name="submit" class="btn btn-primary" <?= $disableAttr ?>>Daftar Beasiswa</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>