<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Pendaftaran Beasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php 
    // Memanggil file navbar dari dalam folder pages
    include 'pages/navbar.php'; 
    ?>
    <?php
    // Memanggil file function.php untuk menggunakan fungsi-fungsi yang sudah didefinisikan
    require_once 'includes/function.php';
    ?>

    <div class="container">
        <?php
        // Struktur kontrol percabangan untuk navigasi halaman
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';
        
        if($page == 'home') include 'pages/home.php';
        else if($page == 'daftar') include 'pages/daftar.php';
        else if($page == 'hasil') include 'pages/hasil.php';
        else if($page == 'test') include 'pages/test.php';
        else echo "Halaman tidak ditemukan.";
        ?>
    </div>

    <?php 
    // Memanggil file footer dari dalam folder pages
    include 'pages/footer.php'; 
    ?>
</body>
</html>