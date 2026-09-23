# Wireframe & User Flow - SIMPUS-Mini (Jobsheet 4)

Dokumen ini berisi rancangan (wireframe) dan alur pengguna (user flow) untuk fitur
Petugas, yang dibuat SEBELUM coding. Tidak ada perubahan HTML/CSS di jobsheet ini -
struktur dan style tetap sama persis dengan jobsheet-03.

## 1. Aktor

| Aktor   | Akses                                                              |
|---------|---------------------------------------------------------------------|
| Tamu    | Hanya melihat katalog: Beranda, Daftar Buku. Tanpa login. (sudah ada sejak jobsheet-01 s.d. 03) |
| Petugas | Login untuk mengakses seluruh CRUD dan transaksi peminjaman. (dirancang di jobsheet ini) |

## 2. Wireframe: Halaman Login Petugas

```
+--------------------------------------+
|              SIMPUS-Mini             |
|--------------------------------------|
|                                      |
|         [ Login Petugas ]            |
|                                      |
|   Username : [______________]        |
|   Password : [______________]        |
|                                      |
|          [   Masuk   ]               |
+--------------------------------------+
```

Keterangan notasi:

| Notasi        | Artinya                                      |
|---------------|----------------------------------------------|
| `+ - \|`      | batas luar halaman/panel                     |
| `[______]`    | kotak input -> `<input type="text">`         |
| `[ Teks ]`    | tombol yang bisa diklik -> `<button>`        |
| Teks polos    | label/keterangan -> `<label>`, `<h1>`, `<p>` |

Catatan: field Password nantinya menggunakan `type="password"`.

## 3. Wireframe: Dashboard Petugas

```
+-------------------------------------------------------------+
| SIMPUS-Mini   Beranda | Buku | Anggota | Peminjaman  Logout |
|-------------------------------------------------------------|
|  [Total Buku]   [Total Anggota]   [Sedang Dipinjam]         |
|                                                             |
|  Aksi Cepat:                                                |
|  [ + Peminjaman Baru ]   [ + Pengembalian ]                 |
|                                                             |
|  Transaksi Terbaru                                          |
|  Anggota | Buku | Tgl Pinjam | Status                       |
+-------------------------------------------------------------+
```

- **Sudah ada**: navbar & kartu statistik (dari jobsheet-02/03).
- **Ditambah**: satu menu baru "Peminjaman" + indikator login di kanan (Logout).
  Karena navbar sudah pakai Flexbox, menambah satu `<li>` menu baru otomatis
  ditata ulang tanpa perlu mengubah CSS.
- **Benar-benar baru**: blok "Aksi Cepat" dan "Transaksi Terbaru".

## 4. User Flow: Peminjaman Buku

```
Petugas Login -> Dashboard -> Pilih "Peminjaman Baru" -> Pilih Anggota
-> Pilih Buku (stok > 0) -> Simpan -> Stok berkurang 1
```

## 5. User Flow: Pengembalian Buku

```
Dashboard -> Menu "Pengembalian" -> Cari transaksi aktif
-> Tandai "Dikembalikan" -> Stok bertambah 1 -> Kembali ke Dashboard
```

Catatan: aturan validasi `stok > 0` sengaja ditulis sejak tahap rancangan ini,
supaya tidak lupa diterapkan nanti saat proses coding (jobsheet berikutnya).

## 6. Fitur yang dirancang di jobsheet ini

Login, Dashboard Petugas, Peminjaman, Pengembalian, Riwayat.

## 7. Wireframe Registrasi Anggota Baru

+--------------------------------------------------+
|                   SIMPUS-Mini                    |
|--------------------------------------------------|
|                                                  |
|           [ Registrasi Anggota Baru ]            |
|                                                  |
|   NIM / NIP     : [__________________________] * |
|   Nama Lengkap  : [__________________________] * |
|   Jenis Kelamin : (o) Laki-laki  ( ) Perempuan   |
|   Program Studi : [-- Pilih Prodi ------- v]     |
|   Email         : [__________________________]   |
|   No. WhatsApp  : [__________________________] * |
|   Alamat        : [__________________________]   |
|                                                  |
|   [ Batal ]                         [ Simpan ]   |
|                                                  |
|--------------------------------------------------|
|          Sudah punya akun? [ Login ]             |
+--------------------------------------------------+

## 8. User Flow: Mencari Anggota Lewat Jatuh Tempo

Petugas Login -> Dashboard -> Pilih Menu "Anggota" -> Filter "Jatuh Tempo" 
-> Ketik Nama / ID -> Tampil Daftar Anggota Menunggak