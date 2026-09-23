// ===== anggota.js - Render Daftar Anggota dari data/anggota.json =====

async function muatDaftarAnggota() {
    const tbody = document.getElementById("anggota-tbody");
    const loading = document.getElementById("loading");
    if (!tbody) return;

    if (loading) loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        await new Promise(function (resolve) { setTimeout(resolve, 600); });

        const res = await fetch("../data/anggota.json");
        if (!res.ok) {
            throw new Error("Gagal mengambil data (status " + res.status + ")");
        }

        const daftarAnggota = await res.json();

        daftarAnggota.forEach(function (anggota) {
            const tr = document.createElement("tr");
            tr.innerHTML =
                "<td>" + anggota.no_anggota + "</td>" +
                "<td>" + anggota.nama + "</td>" +
                "<td>" + anggota.alamat + "</td>" +
                "<td>" + anggota.no_hp + "</td>" +
                "<td>" + anggota.email + "</td>" +
                "<td>" +
                "<button type=\"button\">Edit</button>" +
                "<button type=\"button\" class=\"btn-hapus\">Hapus</button>" +
                "</td>";
            tbody.appendChild(tr);
        });
    } catch (err) {
        tbody.innerHTML = "<tr><td colspan='6'>Gagal memuat data: " + err.message + "</td></tr>";
    } finally {
        if (loading) loading.style.display = "none";
    }
}

document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btn-hapus");
    if (!btn) return;

    const row = btn.closest("tr");
    const nama = row ? row.querySelectorAll("td")[1]?.textContent : "anggota ini";
    const yakin = confirm('Yakin ingin menghapus "' + nama + '"?');
    if (yakin && row) row.remove();
});

document.addEventListener("DOMContentLoaded", muatDaftarAnggota);
