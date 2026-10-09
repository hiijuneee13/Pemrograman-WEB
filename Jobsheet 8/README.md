# SIMPUS-Mini - Jobsheet 8: Koneksi PostgreSQL

Melanjutkan jobsheet-07. Data buku dan anggota tidak lagi disimpan di `$_SESSION`,
tetapi di database PostgreSQL sehingga tetap ada walau browser ditutup.

## Yang baru di jobsheet ini

1. `sql/01_buku_anggota.sql` - skema tabel `buku` dan `anggota`.
2. `includes/koneksi.php` - koneksi PDO ke PostgreSQL.
3. `buku/proses_tambah.php`, `anggota/proses_tambah.php` - `$_SESSION[...][] = ...`
   diganti `INSERT ... RETURNING id` lewat prepared statement.
4. `buku/list.php`, `anggota/list.php` - sumber data diganti `SELECT * FROM ... ORDER BY id DESC`.
5. `index.php` - kartu Total Buku / Total Anggota memakai `SELECT COUNT(*)`.

`docs/wireframe.md` identik dengan jobsheet-07 (tidak ada rancangan UI/UX baru).

## Struktur folder

```
jobsheet-08/
├── index.php
├── includes/
│   ├── header.php, footer.php      # tidak berubah dari jobsheet-07
│   └── koneksi.php                 # BARU
├── sql/
│   ├── 01_buku_anggota.sql         # BARU, skema tabel
│   └── 02_latihan_tanggal_ditambahkan.sql   # latihan 2
├── buku/    (list.php, tambah.php, proses_tambah.php)
├── anggota/ (list.php, tambah.php, proses_tambah.php)
├── assets/  (css/style.css, js/app.js)
├── data/buku.json                  # sumber data migrasi (latihan 4)
├── migrasi_buku.php                # latihan 4
└── docs/wireframe.md
```

## Persiapan (urutan jangan dibalik)

1. Pastikan PostgreSQL berjalan dan ekstensi `pdo_pgsql` aktif:
   `php -m | findstr pgsql` (Windows) atau `php -m | grep pgsql` (Linux/Mac).
2. Buat database: `createdb -U postgres simpus_mini`
3. Jalankan skema: `psql -U postgres -d simpus_mini -f sql/01_buku_anggota.sql`
4. Sesuaikan `$user` dan `$pass` di `includes/koneksi.php` dengan instalasi lokal.

Panduan Laragon (Quick Add PostgreSQL, aktifkan `pdo_pgsql`, atur password) ada di bab 8
dokumentasi jobsheet-08.

## Menjalankan

```
php -S localhost:8000
```

Buka `http://localhost:8000/index.php`. Jangan dibuka lewat klik dua kali (`file://`),
file `.php` harus diproses server dulu.

## Latihan (7.4)

| No | Latihan | Lokasi |
|----|---------|--------|
| 1 | Error UNIQUE `no_anggota` jadi flash message rapi | `anggota/proses_tambah.php` |
| 2 | Kolom `tanggal_ditambahkan TIMESTAMP DEFAULT NOW()` tampil di list buku | `sql/02_...sql`, `buku/list.php` |
| 3 | Pencarian server-side `WHERE judul ILIKE :keyword` | `buku/list.php` |
| 4 | Migrasi `data/buku.json` ke tabel `buku` | `migrasi_buku.php` |
| + | Validasi format ISBN dengan `preg_match()` (tugas mandiri di slide) | `buku/proses_tambah.php` |

Untuk latihan 2 jalankan dulu: `psql -U postgres -d simpus_mini -f sql/02_latihan_tanggal_ditambahkan.sql`
