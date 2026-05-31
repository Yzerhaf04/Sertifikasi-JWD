# MyBeasiswa - Sistem Pendaftaran Beasiswa

Aplikasi MyBeasiswa adalah sistem berbasis web untuk memfasilitasi pendaftaran beasiswa mahasiswa. Sistem ini dilengkapi dengan fitur pemilihan jenis beasiswa, validasi IPK untuk syarat pendaftaran, upload berkas persyaratan, dan melihat hasil status ajuan.

---

## 2.1 Struktur & Hirarki Folder

Aplikasi ini menggunakan pola struktur folder modular untuk memisahkan antara bagian konfigurasi, logika program, dan tampilan visual. Berikut adalah penjelasan struktur foldernya:

* **`/` (Root Directory)**
    * `index.php` : Merupakan *entry point* atau file utama yang bertindak sebagai *router* untuk memuat tata letak (navbar dan footer) dan menavigasi pengguna ke halaman yang tepat menggunakan parameter `$_GET['page']`.
    
* **`config/`** *(Folder Konfigurasi)*
    * `config.php` : File yang menyimpan seluruh pengaturan sistem, termasuk detail kredensial untuk koneksi database (host, user, password, dbname), konstanta nama/versi aplikasi, batas ukuran upload, serta penentuan variabel nilai IPK mahasiswa.
    * `database.sql` : Skrip SQL yang berisi instruksi untuk membuat struktur database (`beasiswa`), membuat tabel-tabel (`jenis_beasiswa` dan `pendaftaran`), serta melakukan insert data untuk jenis beasiswa.

* **`includes/`** *(Folder Logika dan Fungsi)*
    * `function.php` : File kumpulan fungsi (*helper*) utama. Berisi logika untuk koneksi menggunakan PDO (Pola *Singleton*), fungsi validasi (email, nomor telepon), instruksi interaksi ke database (mengambil dan menyimpan data), serta fungsi penanganan unggah/upload file dokumen PDF.

* **`pages/`** *(Folder Tampilan/Views)*
    * `home.php` : Halaman awal yang menampilkan daftar pilihan beasiswa yang tersedia.
    * `daftar.php` : Halaman yang berisi form pendaftaran beasiswa, termasuk logika pengecekan apabila nilai IPK berada di bawah 3.00 dan proses penerimaan input data dari user.
    * `hasil.php` : Halaman laporan yang mencetak informasi detail dari para pendaftar dalam format tabel beserta status ajuannya.
    * `navbar.php` : Komponen antarmuka bilah navigasi atas (*header*).
    * `footer.php` : Komponen antarmuka bagian kaki halaman (*footer*).
    * `test.php` : File utilitas/skrip pengecekan untuk memvalidasi apakah koneksi database berfungsi dengan baik dan dapat membaca tabel `jenis_beasiswa`.

* **`uploads/`** *(Direktori Hasil Upload)*
    * Direktori dinamis ini akan dihasilkan secara otomatis oleh sistem untuk menyimpan lampiran file berekstensi PDF (maksimal 10 MB) yang diunggah oleh mahasiswa saat mendaftar.

---

## 2.2 Sumber Daya Pemrograman

Aplikasi ini dibangun dengan mengandalkan beberapa teknologi dan pustaka berikut:

1. **Bahasa Pemrograman: PHP (versi 8.0+)**
   Aplikasi dirancang menggunakan logika PHP prosedural (*Native*) dengan fungsionalitas modern. Sistem ini menggunakan syntax PHP modern seperti `match` expression dan *union types* (contoh: `int|false`), yang menjadikannya butuh spesifikasi minimum PHP versi 8.0 ke atas.

2. **Manajemen Database: MySQL & PDO**
   Aplikasi menggunakan database sistem manajemen relasional MySQL (atau MariaDB). Komunikasi antara aplikasi dan database ditangani menggunakan antarmuka modern **PDO (PHP Data Objects)**. Metode ini digunakan karena lebih aman, stabil, serta mencegah ancaman serangan *SQL Injection* melalui pemanfaatan *Prepared Statements* (`$stmt->prepare()` dan `execute()`).

3. **Front-End Framework: Bootstrap 5.3.0**
   Untuk mempercepat dan memberikan tampilan antarmuka yang rapi, responsif, serta modern, proyek ini menggunakan *framework CSS* **Bootstrap versi 5.3.0**. Framework ini dipanggil melalui CDN (*Content Delivery Network*) JSDelivr tanpa harus mengunduh library-nya secara lokal. Hal ini diaplikasikan dalam bentuk penggunaan *Cards*, *Buttons*, *Badges*, dan *Tables* di berbagai halaman.

4. **Web Server Lingkungan Pengembangan**
   Untuk menjalankan aplikasi ini secara lokal di PC/Laptop, diperlukan web server  Apache yang terintegrasi di dalam XAMPP.
