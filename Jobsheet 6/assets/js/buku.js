// ===== buku.js - Render Daftar Buku dari data/buku.json =====

async function muatDaftarBuku() {
    const tbody = document.getElementById("buku-tbody");
    const loading = document.getElementById("loading");
    if (!tbody) return;

    if (loading) loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        // Simulasi jeda jaringan supaya indikator loading terlihat
        await new Promise(function (resolve) { setTimeout(resolve, 600); });

        const res = await fetch("../data/buku.json");
        if (!res.ok) {
            throw new Error("Gagal mengambil data (status " + res.status + ")");
        }

        const daftarBuku = await res.json();

        daftarBuku.forEach(function (buku) {
            const tr = document.createElement("tr");
            tr.innerHTML =
                "<td>" + buku.judul + "</td>" +
                "<td>" + buku.pengarang + "</td>" +
                "<td>" + buku.tahun + "</td>" +
                "<td>" + buku.stok + "</td>" +
                "<td>" +
                "<button type=\"button\">Edit</button>" +
                "<button type=\"button\" class=\"btn-detail\">Detail</button>" +
                "<button type=\"button\" class=\"btn-hapus\">Hapus</button>" +
                "</td>";
            tbody.appendChild(tr);
        });
    } catch (err) {
        tbody.innerHTML = "<tr><td colspan='5'>Gagal memuat data: " + err.message + "</td></tr>";
    } finally {
        if (loading) loading.style.display = "none";
    }
}

// Event delegation: baris dibuat setelah fetch selesai, jadi listener
// dipasang di document, bukan di tiap tombol satu-satu.
document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btn-hapus");
    if (!btn) return;

    const row = btn.closest("tr");
    const judul = row ? row.querySelector("td")?.textContent : "buku ini";
    const yakin = confirm('Yakin ingin menghapus "' + judul + '"?');
    if (yakin && row) row.remove();
});

document.addEventListener("DOMContentLoaded", muatDaftarBuku);
