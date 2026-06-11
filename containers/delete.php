<?php
require_once __DIR__ . '/../includes/auth.php';
require_role('admin');
$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT nomor_container FROM containers WHERE id = ?');
$stmt->execute([$id]);
$c = $stmt->fetch();
if ($c) {
    $pdo->prepare('DELETE FROM containers WHERE id = ?')->execute([$id]);
    log_activity($pdo, 'delete_container', 'Menghapus data container ' . $c['nomor_container']);
    flash('success', 'Data container berhasil dihapus.');
} else {
    flash('danger', 'Data container tidak ditemukan.');
}
redirect('containers/index.php');
