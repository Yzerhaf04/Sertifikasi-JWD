<?php
/**
 * File    : function.php
 * Deskripsi: Kumpulan fungsi helper untuk sistem beasiswa
 * Author  : Yzerhaf
 * Versi   : 1.0
 */

require_once __DIR__ . '/../config.php'; // Sesuaikan path dengan lokasi config.php Anda

// ============================================================
// FUNGSI KONEKSI DATABASE (PDO)
// ============================================================

/**
 * getDB() - Membuat koneksi PDO menggunakan konstanta dari config.php
 * Menggunakan pola Singleton agar tidak membuka koneksi berulang kali.
 * * @return PDO
 */
function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Mengembalikan data dalam bentuk array asosiatif
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            die("Koneksi database PDO gagal: " . $e->getMessage());
        }
    }
    return $pdo;
}

// ============================================================
// FUNGSI VALIDASI
// ============================================================

function validateEmail(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validatePhone(string $phone): bool {
    return preg_match('/^[0-9]{8,15}$/', $phone) === 1;
}

function sanitize(string $input): string {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// ============================================================
// FUNGSI DATABASE - BEASISWA
// ============================================================

function getSemuaJenisBeasiswa(): array {
    $db = getDB();
    $stmt = $db->query("SELECT * FROM jenis_beasiswa ORDER BY nama ASC");
    return $stmt->fetchAll();
}

function getDetailBeasiswa(int $id): ?array {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM jenis_beasiswa WHERE id = ?");
    $stmt->execute([$id]);
    $result = $stmt->fetch();
    return $result ?: null;
}

function getSemuaPendaftaran(): array {
    $db = getDB();
    $sql = "SELECT p.*, j.nama AS nama_beasiswa, j.kode AS kode_beasiswa
            FROM pendaftaran p
            JOIN jenis_beasiswa j ON p.jenis_beasiswa_id = j.id
            ORDER BY p.created_at DESC";
    $stmt = $db->query($sql);
    return $stmt->fetchAll();
}

function simpanPendaftaran(array $data): int|false {
    $db = getDB();
    $sql = "INSERT INTO pendaftaran (nama, email, no_hp, semester, ipk, jenis_beasiswa_id, file_berkas, status_ajuan)
            VALUES (:nama, :email, :no_hp, :semester, :ipk, :jenis_beasiswa_id, :file_berkas, 'belum di verifikasi')";
    $stmt = $db->prepare($sql);
    $result = $stmt->execute([
        ':nama'              => $data['nama'],
        ':email'             => $data['email'],
        ':no_hp'             => $data['no_hp'],
        ':semester'          => $data['semester'],
        ':ipk'               => $data['ipk'],
        ':jenis_beasiswa_id' => $data['jenis_beasiswa_id'],
        ':file_berkas'       => $data['file_berkas'] ?? null,
    ]);
    return $result ? (int)$db->lastInsertId() : false;
}

// ============================================================
// FUNGSI UPLOAD FILE & HELPER UI
// ============================================================

function uploadBerkas(array $file): ?string {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    if ($file['size'] > UPLOAD_MAX_SIZE) {
        return null;
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mimeType, UPLOAD_ALLOWED_TYPES)) {
        return null;
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $namaFile = uniqid('berkas_', true) . '.' . $ext;
    $tujuan = UPLOAD_DIR . $namaFile;

    if (!is_dir(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0755, true);
    }

    if (move_uploaded_file($file['tmp_name'], $tujuan)) {
        return $namaFile;
    }

    return null;
}

function getAtributFormBeasiswa(float $ipk_user, float $syarat_ipk = 3.00): array {
    return [
        'disabled'  => ($ipk_user < $syarat_ipk) ? 'disabled' : '',
        'autofocus' => ($ipk_user >= $syarat_ipk) ? 'autofocus' : ''
    ];
}

function formatIPK(float $ipk): string {
    return number_format($ipk, 2);
}

/**
 * Diubah menjadi class Badge dari Bootstrap 5
 */
function badgeStatus(string $status): string {
    return match($status) {
        'belum di verifikasi' => 'badge bg-warning text-dark',
        'dalam proses'        => 'badge bg-info text-dark',
        'diterima'            => 'badge bg-success',
        'ditolak'             => 'badge bg-danger',
        default               => 'badge bg-secondary',
    };
}
?>