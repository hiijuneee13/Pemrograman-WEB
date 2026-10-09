<?php
// Latihan 4: skrip migrasi sekali jalan.
// Membaca data/buku.json (sumber data Jobsheet 6) lalu memasukkan seluruh isinya
// ke tabel buku di PostgreSQL lewat prepared statement.
//
// Cara menjalankan (dari folder jobsheet-08):
//   php migrasi_buku.php
// atau buka http://localhost:8000/migrasi_buku.php lewat browser.
//
// Aman dijalankan berulang: buku yang judul dan pengarangnya sudah ada dilewati,
// jadi data tidak ganda.

if (PHP_SAPI !== "cli") {
    header("Content-Type: text/plain; charset=utf-8");
}

require __DIR__ . "/includes/koneksi.php";

$file = __DIR__ . "/data/buku.json";
if (!is_file($file)) {
    die("File data/buku.json tidak ditemukan.\n");
}

$daftarBuku = json_decode(file_get_contents($file), true);
if (!is_array($daftarBuku)) {
    die("Isi data/buku.json bukan JSON array yang valid.\n");
}

$cek = $pdo->prepare("SELECT 1 FROM buku WHERE judul = :judul AND pengarang = :pengarang");
$simpan = $pdo->prepare(
    "INSERT INTO buku (judul, pengarang, tahun, isbn, stok, kategori)
     VALUES (:judul, :pengarang, :tahun, :isbn, :stok, :kategori)"
);

$masuk = 0;
$lewati = 0;

// Transaksi: kalau satu baris gagal, seluruh migrasi dibatalkan (tidak setengah jadi).
$pdo->beginTransaction();
try {
    foreach ($daftarBuku as $buku) {
        $cek->execute([
            "judul"     => $buku["judul"],
            "pengarang" => $buku["pengarang"],
        ]);
        if ($cek->fetchColumn()) {
            $lewati++;
            continue;
        }

        $simpan->execute([
            "judul"     => $buku["judul"],
            "pengarang" => $buku["pengarang"],
            "tahun"     => (int) $buku["tahun"],
            "isbn"      => $buku["isbn"] ?? null,
            "stok"      => (int) ($buku["stok"] ?? 0),
            "kategori"  => $buku["kategori"] ?? null,
        ]);
        $masuk++;
    }
    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollBack();
    die("Migrasi dibatalkan: " . $e->getMessage() . "\n");
}

echo "Migrasi selesai.\n";
echo "Dimasukkan : $masuk buku\n";
echo "Dilewati   : $lewati buku (sudah ada)\n";
