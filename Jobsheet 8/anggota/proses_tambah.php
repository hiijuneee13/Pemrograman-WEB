<?php
session_start();
require __DIR__ . "/../includes/koneksi.php";

$nama       = trim($_POST["nama"] ?? "");
$no_anggota = trim($_POST["no_anggota"] ?? "");
$alamat     = trim($_POST["alamat"] ?? "");
$no_hp      = trim($_POST["no_hp"] ?? "");
$email      = trim($_POST["email"] ?? "");

// ----- Validasi di server (tidak berubah dari jobsheet-07) -----
$errors = [];

if ($nama === "") {
    $errors[] = "Nama wajib diisi.";
}
if ($no_anggota === "") {
    $errors[] = "No. Anggota wajib diisi.";
}
if ($email !== "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Format email tidak valid.";
}

if (!empty($errors)) {
    $_SESSION["flash"] = ["type" => "error", "pesan" => implode(" ", $errors)];
    header("Location: tambah.php");
    exit;
}

// ----- Jobsheet 8: simpan ke PostgreSQL -----
// Latihan 1: execute() dibungkus try/catch. Kolom no_anggota bersifat UNIQUE, jadi
// nomor yang sudah dipakai ditolak database dengan SQLSTATE 23505 (unique_violation).
// Error itu ditangkap dan diubah jadi pesan flash yang rapi, bukan halaman error mentah.
try {
    $stmt = $pdo->prepare(
        "INSERT INTO anggota (nama, no_anggota, alamat, no_hp, email)
         VALUES (:nama, :no_anggota, :alamat, :no_hp, :email)
         RETURNING id"
    );
    $stmt->execute([
        "nama"       => $nama,
        "no_anggota" => $no_anggota,
        "alamat"     => $alamat,
        "no_hp"      => $no_hp,
        "email"      => $email === "" ? null : $email,
    ]);
} catch (PDOException $e) {
    if ($e->getCode() === "23505") {
        $pesan = "No. Anggota \"$no_anggota\" sudah dipakai, gunakan nomor lain.";
    } else {
        $pesan = "Data anggota gagal disimpan. Silakan coba lagi.";
    }
    $_SESSION["flash"] = ["type" => "error", "pesan" => $pesan];
    header("Location: tambah.php");
    exit;
}

$_SESSION["flash"] = ["type" => "success", "pesan" => "Anggota berhasil ditambahkan."];
header("Location: list.php");
exit;
