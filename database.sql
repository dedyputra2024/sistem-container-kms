CREATE DATABASE IF NOT EXISTS db_container_kms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_container_kms;

DROP TABLE IF EXISTS audit_logs;
DROP TABLE IF EXISTS containers;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','staf_gudang','pimpinan') NOT NULL DEFAULT 'staf_gudang',
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NULL,
    updated_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE containers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nomor_container VARCHAR(30) NOT NULL UNIQUE,
    jenis_ukuran VARCHAR(50) NOT NULL,
    isi_muatan VARCHAR(150) NULL,
    kondisi_fisik VARCHAR(100) NULL,
    tanggal_masuk DATE NOT NULL,
    tanggal_keluar DATE NULL,
    tujuan_pengiriman VARCHAR(150) NULL,
    status ENUM('di_gudang','keluar') NOT NULL DEFAULT 'di_gudang',
    keterangan TEXT NULL,
    created_by INT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    CONSTRAINT fk_containers_user FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    action VARCHAR(80) NOT NULL,
    description VARCHAR(255) NOT NULL,
    created_at DATETIME NULL,
    CONSTRAINT fk_logs_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO users (name, username, password, role, is_active, created_at, updated_at) VALUES
('Administrator', 'admin', '$2y$12$D/jJus6yx.dz16SlGE096u3NTN.JeYF9obd2eEDD.J.y9uWYlixla', 'admin', 1, NOW(), NOW()),
('Staf Gudang', 'staf', '$2y$12$anI891Qn/6glzgbmkuIzg.ZHUVsponadxaoBYfKdkgf03jZjzEbXm', 'staf_gudang', 1, NOW(), NOW()),
('Pimpinan', 'pimpinan', '$2y$12$h1xCJWUCBPVc/2WHNRA5xeah3mmDo0zN4biUFpJL/AtEGvs0gfgD.', 'pimpinan', 1, NOW(), NOW());

INSERT INTO containers (nomor_container, jenis_ukuran, isi_muatan, kondisi_fisik, tanggal_masuk, tanggal_keluar, tujuan_pengiriman, status, keterangan, created_by, created_at, updated_at) VALUES
('KMSU1234567', '20 Feet', 'Barang elektronik', 'Baik', CURDATE(), NULL, NULL, 'di_gudang', 'Contoh data container masuk', 1, NOW(), NOW()),
('KMSU7654321', '40 Feet', 'Suku cadang industri', 'Baik', DATE_SUB(CURDATE(), INTERVAL 3 DAY), CURDATE(), 'Pelabuhan Batu Ampar', 'keluar', 'Contoh data container keluar', 1, NOW(), NOW()),
('KMSU2468135', '40 Feet HC', 'Material proyek', 'Rusak Ringan', DATE_SUB(CURDATE(), INTERVAL 1 DAY), NULL, NULL, 'di_gudang', 'Perlu pemeriksaan ulang pada pintu container', 2, NOW(), NOW());
