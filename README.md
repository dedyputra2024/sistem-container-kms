# Sistem Informasi Pencatatan Container - PT Kepri Mega Sejahtera

Aplikasi ini dibuat menggunakan PHP Native, MySQL, HTML, CSS, dan sedikit JavaScript. Aplikasi dapat dijalankan di Laragon tanpa framework tambahan.

## Fitur Utama

1. Login multi-user.
2. Hak akses: Admin, Staf Gudang, dan Pimpinan.
3. Dashboard ringkasan container.
4. CRUD data container.
5. Pencatatan container keluar.
6. Pencarian dan filter berdasarkan nomor container, status, dan tanggal.
7. Laporan periode, cetak laporan, dan export CSV.
8. Manajemen pengguna oleh admin.
9. Log aktivitas sederhana.

## Cara Menjalankan di Laragon

1. Extract folder `sistem-container-kms` ke:

   `C:\laragon\www\sistem-container-kms`

2. Buka Laragon, klik **Start All** untuk menjalankan Apache dan MySQL.

3. Buka database manager Laragon, misalnya HeidiSQL/phpMyAdmin.

4. Import file:

   `database.sql`

   File tersebut otomatis membuat database `db_container_kms` beserta tabel dan akun demo.

5. Buka browser:

   `http://localhost/sistem-container-kms/`

## Akun Login Demo

| Role | Username | Password |
|---|---|---|
| Admin | admin | admin123 |
| Staf Gudang | staf | staf123 |
| Pimpinan | pimpinan | pimpinan123 |

## Konfigurasi Database

File konfigurasi berada di:

`config/database.php`

Default Laragon:

- Host: `localhost`
- Database: `db_container_kms`
- Username: `root`
- Password: kosong

Jika MySQL di komputer Anda memakai password, ubah nilai `$password` pada file tersebut.

## Catatan Akademik

Aplikasi ini disesuaikan dengan proposal penelitian berjudul "Perancangan Sistem Informasi Pencatatan Container pada PT Kepri Mega Sejahtera". Ruang lingkup fitur mengikuti batasan: pencatatan nomor container, jenis/ukuran, isi muatan, kondisi fisik, tanggal masuk, tanggal keluar, tujuan pengiriman, status, pencarian, dan laporan.
