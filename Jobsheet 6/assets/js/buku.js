document.addEventListener("DOMContentLoaded", function () {
    muatDataGenerik({
        tbodyId: "buku-tbody",
        url: "../data/buku.json",
        colSpan: 5,
        delay: 3000,
        renderRow: (buku) => `
            <td>${buku.judul}</td>
            <td>${buku.pengarang}</td>
            <td>${buku.tahun}</td>
            <td>${buku.stok}</td>
            <td>
                <button type="button">Edit</button>
                <button type="button" class="btn-detail">Detail</button>
                <button type="button" class="btn-hapus">Hapus</button>
            </td>`
    });
    initTableFilter(0);
});