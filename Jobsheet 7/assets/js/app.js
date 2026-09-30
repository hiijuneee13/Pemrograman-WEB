// ===== app.js - SIMPUS-Mini =====
// Satu file JavaScript dipakai bersama oleh semua halaman.
// Tiap fitur dibungkus fungsinya sendiri, dipanggil setelah DOM siap.

// ----- 1. Menu hamburger -----
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const nav = document.querySelector("header nav");
    if (!toggleBtn || !nav) return;

    toggleBtn.addEventListener("click", function () {
        nav.classList.toggle("nav-open");
    });
}

// ----- 2. Konfirmasi hapus (tabel statis) -----
function initHapusConfirm() {
    document.querySelectorAll(".btn-hapus").forEach(function (btn) {
        btn.addEventListener("click", function () {
            const row = btn.closest("tr");
            const nama = row ? row.querySelector("td")?.textContent : "data ini";
            const yakin = confirm('Yakin ingin menghapus "' + nama + '"?');
            if (yakin && row) row.remove();
        });
    });
}

// ----- 3. Pencarian tabel -----
function initTableFilter() {
    const input = document.getElementById("search-input");
    const table = document.querySelector("table");
    if (!input || !table) return;

    input.addEventListener("keyup", function () {
        const keyword = input.value.toLowerCase();
        table.querySelectorAll("tbody tr").forEach(function (row) {
            const teks = row.textContent.toLowerCase();
            row.style.display = teks.includes(keyword) ? "" : "none";
        });
    });
}

// ----- 4. Validasi form -----
function tampilkanError(input, pesan) {
    hapusError(input);
    const span = document.createElement("span");
    span.className = "error";
    span.textContent = pesan;
    input.insertAdjacentElement("afterend", span);
}

function hapusError(input) {
    const next = input.nextElementSibling;
    if (next && next.classList.contains("error")) {
        next.remove();
    }
}

function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;

        // Field nama utama: "judul" di form Buku, "nama" di form Anggota
        const judulNama = form.querySelector("[name='judul'], [name='nama']");
        if (judulNama && judulNama.value.trim() === "") {
            tampilkanError(judulNama, "Field ini wajib diisi.");
            valid = false;
        } else if (judulNama) {
            hapusError(judulNama);
        }

        // Pengarang (khusus form Buku)
        const pengarang = form.querySelector("[name='pengarang']");
        if (pengarang) {
            if (pengarang.value.trim() === "") {
                tampilkanError(pengarang, "Field ini wajib diisi.");
                valid = false;
            } else {
                hapusError(pengarang);
            }
        }

        // No. Anggota (khusus form Anggota)
        const noAnggota = form.querySelector("[name='no_anggota']");
        if (noAnggota) {
            if (noAnggota.value.trim() === "") {
                tampilkanError(noAnggota, "Field ini wajib diisi.");
                valid = false;
            } else {
                hapusError(noAnggota);
            }
        }

        // Tahun terbit (khusus form Buku): angka, 1900-2026
        const tahun = form.querySelector("[name='tahun']");
        if (tahun) {
            const nilaiTahun = parseInt(tahun.value, 10);
            if (tahun.value.trim() === "" || isNaN(nilaiTahun) || nilaiTahun < 1900 || nilaiTahun > 2026) {
                tampilkanError(tahun, "Masukkan tahun yang valid (1900-2026).");
                valid = false;
            } else {
                hapusError(tahun);
            }
        }

        // Stok (khusus form Buku): angka, minimal 0
        const stok = form.querySelector("[name='stok']");
        if (stok) {
            const nilaiStok = parseInt(stok.value, 10);
            if (stok.value.trim() === "" || isNaN(nilaiStok) || nilaiStok < 0) {
                tampilkanError(stok, "Masukkan angka stok yang valid (minimal 0).");
                valid = false;
            } else {
                hapusError(stok);
            }
        }

        if (!valid) e.preventDefault();
    });
}

// ----- Jalankan semua fungsi setelah DOM siap -----
document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
});
