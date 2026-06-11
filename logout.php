<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
log_activity($pdo, 'logout', 'Pengguna keluar dari sistem');
$_SESSION = [];
session_destroy();
session_start();
flash('success', 'Anda berhasil keluar.');
redirect('index.php');
