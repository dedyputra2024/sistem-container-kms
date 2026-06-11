<?php
require_once __DIR__ . '/app.php';

$host = 'localhost';
$dbname = 'db_container_kms';
$username = 'root';
$password = ''; // default Laragon biasanya kosong
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host={$host};dbname={$dbname};charset={$charset}", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    die('<div style="font-family:Arial;margin:40px;padding:20px;border:1px solid #f5c2c7;background:#f8d7da;color:#842029;border-radius:10px;max-width:760px">'
        . '<h2>Koneksi database gagal</h2>'
        . '<p>Pastikan Laragon sudah menjalankan MySQL dan file <b>database.sql</b> sudah di-import ke database <b>db_container_kms</b>.</p>'
        . '<p><b>Detail:</b> ' . htmlspecialchars($e->getMessage()) . '</p>'
        . '</div>');
}
