<?php
session_start();

// Menghitung prefix path relatif ($base) berdasarkan kedalaman folder
// file yang sedang berjalan, bukan ditulis manual per halaman.
$__jobsheetRoot = dirname(__DIR__);
$__scriptDir = dirname($_SERVER["SCRIPT_FILENAME"]);
$__rel = ltrim(str_replace("\\", "/", substr($__scriptDir, strlen($__jobsheetRoot))), "/");
$base = $__rel === "" ? "" : str_repeat("../", substr_count($__rel, "/") + 1);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIMPUS-Mini | <?php echo htmlspecialchars($page_title ?? "Beranda"); ?></title>
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">
</head>
<body>
    <header>
        <h1>SIMPUS-Mini</h1>
        <button type="button" id="nav-toggle-btn" aria-label="Menu">&#9776;</button>
        <nav>
            <ul>
                <li><a href="<?php echo $base; ?>index.php">Beranda</a></li>
                <li><a href="<?php echo $base; ?>buku/list.php">Daftar Buku</a></li>
                <li><a href="<?php echo $base; ?>buku/tambah.php">Tambah Buku</a></li>
                <li><a href="<?php echo $base; ?>anggota/list.php">Daftar Anggota</a></li>
                <li><a href="<?php echo $base; ?>anggota/tambah.php">Tambah Anggota</a></li>
            </ul>
        </nav>
    </header>

    <main>
