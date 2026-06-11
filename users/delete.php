<?php
require_once __DIR__ . '/../includes/auth.php';
require_role('admin');
$id = (int) ($_GET['id'] ?? 0);
if ($id === (int) ($_SESSION['user']['id'] ?? 0)) {
    flash('danger', 'Akun yang sedang digunakan tidak dapat dihapus.');
    redirect('users/index.php');
}
$stmt = $pdo->prepare('SELECT username FROM users WHERE id = ?');
$stmt->execute([$id]);
$u = $stmt->fetch();
if ($u) {
    $pdo->prepare('DELETE FROM users WHERE id = ?')->execute([$id]);
    log_activity($pdo, 'delete_user', 'Menghapus pengguna ' . $u['username']);
    flash('success', 'Pengguna berhasil dihapus.');
} else {
    flash('danger', 'Pengguna tidak ditemukan.');
}
redirect('users/index.php');
