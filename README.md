# 📦 Sistem Informasi Pencatatan Container

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)

Sistem informasi berbasis web untuk mengelola pencatatan container di area gudang PT Karya Mandiri Sejahtera — mulai dari container masuk, pemantauan status, hingga pencatatan keluar dan tujuan pengiriman.

---

## ✨ Fitur

- 🔐 Login dengan 3 role: **Admin**, **Staf Gudang**, **Pimpinan**
- 📊 Dashboard ringkasan data container (total, di gudang, keluar, input hari ini)
- 📦 Manajemen data container (tambah, edit, hapus, catat keluar)
- 🔍 Pencarian & filter data berdasarkan status dan tanggal
- 📄 Laporan harian & bulanan dengan filter status
- 📥 Export laporan ke **CSV**
- 🖨️ Cetak laporan langsung dari browser
- 👥 Manajemen pengguna & hak akses
- 🏢 Profil perusahaan & ruang lingkup sistem

---

## 🛠️ Teknologi

- **Backend:** PHP Native
- **Database:** MySQL
- **Frontend:** HTML5, CSS3, JavaScript
- **Server:** Apache (XAMPP / Laragon)
- **Metode:** RAD (Rapid Application Development)

---

## ⚙️ Cara Menjalankan

1. Clone repo ini:
   ```bash
   git clone https://github.com/dedyputra2024/sistem-container-kms.git
   ```
2. Pindahkan folder ke direktori server lokal (`htdocs` / `www`)
3. Import file `database.sql` ke MySQL via phpMyAdmin
4. Sesuaikan konfigurasi database di file `database.php`:
   ```php
   $host = 'localhost';
   $user = 'root';
   $pass = '';
   $db   = 'nama_database';
   ```
5. Buka di browser: `http://localhost/sistem-container-kms`

---

## 👤 Akun Default

| Role | Username | Password |
|------|----------|----------|
| Admin | `admin` | `admin` |
| Staf Gudang | `staf` | `staf` |
| Pimpinan | `pimpinan` | `pimpinan` |

> ⚠️ Segera ganti password setelah instalasi!

---

## 👨‍💻 Developer

**Dedy Saputra** — Project 2026  
[github.com/dedyputra2024](https://github.com/dedyputra2024)
