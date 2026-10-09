<?php
$page_title = "Daftar Anggota";
include __DIR__ . "/../includes/header.php";
require_once __DIR__ . "/../includes/koneksi.php";

try {
    $stmt = $pdo->query("SELECT * FROM anggota ORDER BY id_anggota DESC");
    $daftar_anggota = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Error mengambil data anggota: " . $e->getMessage();
}

$flash = $_SESSION["flash"] ?? null;
unset($_SESSION["flash"]);
?>

<section class="card">
    <div class="card-header flex-between">
        <h2>Daftar Anggota</h2>
        <a href="tambah.php" class="btn btn-primary">+ Tambah Anggota</a>
    </div>

    <?php if ($flash): ?>
        <div class="flash flash-<?= htmlspecialchars($flash["type"]) ?>">
            <?= htmlspecialchars($flash["pesan"]) ?>
        </div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="flash flash-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No. Anggota</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($daftar_anggota)): ?>
                    <?php foreach ($daftar_anggota as $anggota): ?>
                        <tr>
                            <td><code><?= htmlspecialchars($anggota['no_anggota'] ?? '-') ?></code></td>
                            <td><strong><?= htmlspecialchars($anggota['nama'] ?? '') ?></strong></td>
                            <td><?= htmlspecialchars($anggota['email'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($anggota['telepon'] ?? '-') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Belum ada data anggota.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php include __DIR__ . "/../includes/footer.php"; ?>