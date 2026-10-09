<?php
$page_title = "Daftar Buku";
include __DIR__ . "/../includes/header.php";
require_once __DIR__ . "/../includes/koneksi.php";

$search = $_GET["q"] ?? "";

try {
    if (!empty($search)) {
        $pola = "%" . addcslashes($search, "%_\\") . "%";
        $stmt = $pdo->prepare("SELECT * FROM buku WHERE judul ILIKE :q OR penulis ILIKE :q ORDER BY id_buku DESC");
        $stmt->execute([":q" => $pola]);
    } else {
        $stmt = $pdo->query("SELECT * FROM buku ORDER BY id_buku DESC");
    }
    $daftar_buku = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Error mengambil data buku: " . $e->getMessage();
}

$flash = $_SESSION["flash"] ?? null;
unset($_SESSION["flash"]);
?>

<section class="card">
    <div class="card-header flex-between">
        <h2>Daftar Buku</h2>
        <a href="tambah.php" class="btn btn-primary">+ Tambah Buku</a>
    </div>

    <?php if ($flash): ?>
        <div class="flash flash-<?= htmlspecialchars($flash["type"]) ?>">
            <?= htmlspecialchars($flash["pesan"]) ?>
        </div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="flash flash-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="get" action="" class="search-form">
        <input type="text" name="q" placeholder="Cari judul atau penulis..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn btn-secondary">Cari</button>
        <?php if (!empty($search)): ?>
            <a href="list.php" class="btn btn-outline">Reset</a>
        <?php endif; ?>
    </form>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Tahun</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Ditambahkan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($daftar_buku)): ?>
                    <?php foreach ($daftar_buku as $buku): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($buku['judul'] ?? '') ?></strong></td>
                            <td><?= htmlspecialchars($buku['penulis'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($buku['tahun_terbit'] ?? '-') ?></td>
                            <td><span class="badge"><?= htmlspecialchars($buku['kategori'] ?? 'Umum') ?></span></td>
                            <td><?= htmlspecialchars($buku['stok'] ?? 0) ?></td>
                            <td>
                                <?= !empty($buku['tanggal_ditambahkan']) 
                                    ? date('d-m-Y H:i', strtotime($buku['tanggal_ditambahkan'])) 
                                    : '-' ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data buku.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php include __DIR__ . "/../includes/footer.php"; ?>