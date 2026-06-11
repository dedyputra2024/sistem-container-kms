<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT c.*, u.name AS created_by_name FROM containers c LEFT JOIN users u ON u.id = c.created_by WHERE c.id = ?');
$stmt->execute([$id]);
$c = $stmt->fetch();
if (!$c) { flash('danger', 'Data container tidak ditemukan.'); redirect('containers/index.php'); }
$page_title = 'Detail Container';
$page_subtitle = 'Informasi lengkap pencatatan container';
require_once __DIR__ . '/../includes/header.php';
?>
<div class="card">
    <div class="detail-list">
        <div>Nomor Container</div><div><b><?= e($c['nomor_container']) ?></b></div>
        <div>Jenis/Ukuran</div><div><?= e($c['jenis_ukuran']) ?></div>
        <div>Isi Muatan</div><div><?= e($c['isi_muatan']) ?: '-' ?></div>
        <div>Kondisi Fisik</div><div><?= e($c['kondisi_fisik']) ?: '-' ?></div>
        <div>Tanggal Masuk</div><div><?= format_date($c['tanggal_masuk']) ?></div>
        <div>Tanggal Keluar</div><div><?= format_date($c['tanggal_keluar']) ?></div>
        <div>Tujuan Pengiriman</div><div><?= e($c['tujuan_pengiriman']) ?: '-' ?></div>
        <div>Status</div><div><?= status_badge($c['status']) ?></div>
        <div>Keterangan</div><div><?= nl2br(e($c['keterangan'])) ?: '-' ?></div>
        <div>Dibuat Oleh</div><div><?= e($c['created_by_name'] ?? '-') ?></div>
        <div>Terakhir Diubah</div><div><?= e($c['updated_at']) ?></div>
    </div>
    <div class="form-actions no-print"><a class="btn btn-outline" href="<?= url('containers/index.php') ?>">Kembali</a><button onclick="window.print()" class="btn btn-secondary">Cetak</button></div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
