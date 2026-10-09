<?php
session_start();
require_once __DIR__ . "/../includes/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $judul    = trim($_POST["judul"] ?? "");
    $penulis  = trim($_POST["pengarang"] ?? $_POST["penulis"] ?? "");
    $tahun    = $_POST["tahun"] ?? $_POST["tahun_terbit"] ?? null;
    $isbn     = trim($_POST["isbn"] ?? "");
    $stok     = (int)($_POST["stok"] ?? 0);
    $kategori = trim($_POST["kategori"] ?? "");

    $errors = [];

    if (empty($judul) || empty($penulis)) {
        $errors[] = "Judul dan Penulis wajib diisi!";
    }

    // Validasi Format ISBN (Regex) untuk Tugas Mandiri
    if ($isbn !== "") {
        $jumlahDigit = strlen(str_replace("-", "", $isbn));
        if (!preg_match('/^[0-9\-]+$/', $isbn) || !in_array($jumlahDigit, [10, 13], true)) {
            $errors[] = "ISBN hanya boleh berisi angka dan tanda hubung, sebanyak 10 atau 13 digit.";
        }
    }

    if (!empty($errors)) {
        $_SESSION["flash"] = [
            "type"  => "error",
            "pesan" => implode(" ", $errors)
        ];
        header("Location: tambah.php");
        exit;
    }

    try {
        $sql = "INSERT INTO buku (judul, penulis, tahun_terbit, isbn, stok, kategori) 
                VALUES (:judul, :penulis, :tahun_terbit, :isbn, :stok, :kategori)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":judul"        => $judul,
            ":penulis"      => $penulis,
            ":tahun_terbit" => $tahun,
            ":isbn"         => $isbn,
            ":stok"         => $stok,
            ":kategori"     => $kategori
        ]);

        $_SESSION["flash"] = [
            "type"  => "success",
            "pesan" => "Buku berhasil ditambahkan!"
        ];
        header("Location: list.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION["flash"] = [
            "type"  => "error",
            "pesan" => "Gagal menambah buku: " . $e->getMessage()
        ];
        header("Location: tambah.php");
        exit;
    }
} else {
    header("Location: list.php");
    exit;
}