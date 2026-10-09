<?php
require __DIR__ . "/includes/koneksi.php";

$json_file = __DIR__ . "/data_buku.json";

// 1. Cek keberadaan file JSON
if (!file_exists($json_file)) {
    die("Error: File data_buku.json tidak ditemukan!");
}

// 2. Baca dan decode isi file JSON
$json_data = file_get_contents($json_file);
$data_buku = json_decode($json_data, true);

if ($data_buku === null) {
    die("Error: Format JSON tidak valid atau file kosong!");
}

$berhasil = 0;
$gagal = 0;

echo "<h2>Proses Migrasi Data JSON ke PostgreSQL</h2>";
echo "<ul>";

// 3. Prepare statement sesuai kolom tabel database kamu
$stmt = $pdo->prepare(
    "INSERT INTO buku (judul, penulis, tahun_terbit, stok)
     VALUES (:judul, :penulis, :tahun_terbit, :stok)"
);

foreach ($data_buku as $buku) {
    try {
        $stmt->execute([
            "judul"        => $buku["judul"] ?? "",
            "penulis"      => $buku["penulis"] ?? ($buku["pengarang"] ?? ""),
            "tahun_terbit" => (int) ($buku["tahun_terbit"] ?? ($buku["tahun"] ?? 0)),
            "stok"         => (int) ($buku["stok"] ?? 0)
        ]);
        
        echo "<li style='color: green;'>[BERHASIL] Buku \"{$buku['judul']}\" berhasil diimport.</li>";
        $berhasil++;
    } catch (PDOException $e) {
        echo "<li style='color: red;'>[GAGAL] Buku \"{$buku['judul']}\" gagal diimport: " . htmlspecialchars($e->getMessage()) . "</li>";
        $gagal++;
    }
}

echo "</ul>";
echo "<p><strong>Migrasi Selesai!</strong> Total Berhasil: $berhasil | Total Gagal: $gagal</p>";
echo "<a href='buku/list.php'>Lihat Daftar Buku</a>";