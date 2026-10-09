-- Jobsheet 8, Latihan 2: kolom baru tanggal_ditambahkan di tabel buku.
-- TIMESTAMP  = tipe data tanggal + jam.
-- NOW()      = fungsi PostgreSQL yang mengembalikan waktu saat ini, dipakai
--              sebagai nilai DEFAULT sehingga terisi otomatis saat INSERT.
-- Jalankan: psql -d simpus_mini -f sql/02_latihan_tanggal_ditambahkan.sql

ALTER TABLE buku
    ADD COLUMN IF NOT EXISTS tanggal_ditambahkan TIMESTAMP DEFAULT NOW();
