<?php
require_once __DIR__ . '/includes/auth.php';
require_login();
$page_title = 'Dashboard';
$page_subtitle = 'Ringkasan data container masuk, keluar, dan laporan terbaru';

$total = (int) $pdo->query('SELECT COUNT(*) FROM containers')->fetchColumn();
$in = (int) $pdo->query("SELECT COUNT(*) FROM containers WHERE status = 'di_gudang'")->fetchColumn();
$out = (int) $pdo->query("SELECT COUNT(*) FROM containers WHERE status = 'keluar'")->fetchColumn();
$today = (int) $pdo->query('SELECT COUNT(*) FROM containers WHERE DATE(created_at) = CURDATE()')->fetchColumn();
$recent = $pdo->query('SELECT c.*, u.name AS created_by_name FROM containers c LEFT JOIN users u ON u.id = c.created_by ORDER BY c.updated_at DESC LIMIT 8')->fetchAll();
$logs = $pdo->query('SELECT l.*, u.name FROM audit_logs l LEFT JOIN users u ON u.id = l.user_id ORDER BY l.created_at DESC LIMIT 6')->fetchAll();
require_once __DIR__ . '/includes/header.php';
?>
<div class="grid grid-4">
    <div class="card stat"><div><small>Total Container</small><h3><?= $total ?></h3></div><div class="stat-icon">T</div></div>
    <div class="card stat"><div><small>Di Gudang</small><h3><?= $in ?></h3></div><div class="stat-icon">G</div></div>
    <div class="card stat"><div><small>Sudah Keluar</small><h3><?= $out ?></h3></div><div class="stat-icon">K</div></div>
    <div class="card stat"><div><small>Input Hari Ini</small><h3><?= $today ?></h3></div><div class="stat-icon">H</div></div>
</div>

<div class="section-title">
    <h3>Data Container Terbaru</h3>
    <?php if (is_role(['admin','staf_gudang'])): ?><a class="btn btn-primary" href="<?= url('containers/create.php') ?>">Tambah Container</a><?php endif; ?>
</div>
<div class="table-wrap">
    <table>
        <thead><tr><th>No Container</th><th>Jenis/Ukuran</th><th>Muatan</th><th>Tanggal Masuk</th><th>Tanggal Keluar</th><th>Status</th><th>Input Oleh</th></tr></thead>
        <tbody>
        <?php if (!$recent): ?>
            <tr><td class="empty" colspan="7">Belum ada data container.</td></tr>
        <?php endif; ?>
        <?php foreach ($recent as $row): ?>
            <tr>
                <td><b><?= e($row['nomor_container']) ?></b></td>
                <td><?= e($row['jenis_ukuran']) ?></td>
                <td><?= e($row['isi_muatan']) ?></td>
                <td><?= format_date($row['tanggal_masuk']) ?></td>
                <td><?= format_date($row['tanggal_keluar']) ?></td>
                <td><?= status_badge($row['status']) ?></td>
                <td><?= e($row['created_by_name'] ?? '-') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="section-title"><h3>Aktivitas Sistem</h3></div>
<div class="card">
    <?php if (!$logs): ?>
        <p class="empty">Belum ada aktivitas.</p>
    <?php endif; ?>
    <?php foreach ($logs as $log): ?>
        <p><b><?= e($log['name'] ?? 'Sistem') ?></b> — <?= e($log['description']) ?> <small style="color:#6b7280">(<?= e($log['created_at']) ?>)</small></p>
    <?php endforeach; ?>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
