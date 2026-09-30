<?php
$page_title = "Daftar Anggota";
include __DIR__ . "/../includes/header.php";

$flash = $_SESSION["flash"] ?? null;
unset($_SESSION["flash"]);

$daftarAnggota = $_SESSION["anggota"] ?? [];
?>
        <section>
            <h2>Daftar Anggota</h2>

            <?php if ($flash): ?>
            <div class="flash flash-<?php echo $flash["type"]; ?>">
                <?php echo htmlspecialchars($flash["pesan"]); ?>
            </div>
            <?php endif; ?>

            <div class="search-box">
                <input type="text" id="search-input" placeholder="Cari nama anggota...">
            </div>
            <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No. Anggota</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No. HP</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($daftarAnggota)): ?>
                    <tr>
                        <td colspan="6">Belum ada data. Tambahkan lewat menu "Tambah Anggota".</td>
                    </tr>
                    <?php endif; ?>
                    <?php foreach ($daftarAnggota as $anggota): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($anggota["no_anggota"]); ?></td>
                        <td><?php echo htmlspecialchars($anggota["nama"]); ?></td>
                        <td><?php echo htmlspecialchars($anggota["alamat"]); ?></td>
                        <td><?php echo htmlspecialchars($anggota["no_hp"]); ?></td>
                        <td><?php echo htmlspecialchars($anggota["email"]); ?></td>
                        <td>
                            <button type="button">Edit</button>
                            <button type="button" class="btn-hapus">Hapus</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        </section>
<?php include __DIR__ . "/../includes/footer.php"; ?>
