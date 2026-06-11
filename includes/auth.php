<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/functions.php';

function require_login(): void
{
    if (empty($_SESSION['user'])) {
        flash('danger', 'Silakan login terlebih dahulu.');
        redirect('index.php');
    }
}

function require_role(string|array $roles): void
{
    require_login();
    if (!is_role($roles)) {
        http_response_code(403);
        echo '<div style="font-family:Arial;margin:40px"><h2>Akses ditolak</h2><p>Role Anda tidak memiliki izin untuk membuka halaman ini.</p><a href="' . url('dashboard.php') . '">Kembali ke dashboard</a></div>';
        exit;
    }
}
