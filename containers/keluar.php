<?php
require_once __DIR__ . '/../includes/auth.php';
require_role(['admin','staf_gudang']);
$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM containers WHERE id = ?');
$stmt->execute([$id]);
$c = $stmt->fetch();
if (!$c) { flash('danger', 'Data container tidak ditemukan.'); redirect('containers/index.php'); }
$page_title = 'Catat Container Keluar';
$page_subtitle = 'Lengkapi tanggal keluar dan tujuan pengiriman container';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keluar = $_POST['tanggal_keluar'] ?? date('Y-m-d');
    $tujuan = trim($_POST['tujuan_pengiriman'] ?? '');
    if ($tujuan === '') {
        flash('danger', 'Tujuan pengiriman wajib diisi saat container keluar.');
    } else {
        $stmt = $pdo->prepare("UPDATE containers SET tanggal_keluar=?, tujuan_pengiriman=?, status='keluar', updated_at=NOW() WHERE id=?");
        $stmt->execute([$keluar, $tujuan, $id]);
        log_activity($pdo, 'container_keluar', 'Mencatat container keluar ' . $c['nomor_container']);
        flash('success', 'Status container berhasil dicatat keluar.');
        redirect('containers/index.php');
    }
}
require_once __DIR__ . '/../includes/header.php';
?>
<div class="card">
    <div class="detail-list" style="margin-bottom:18px">
        <div>Nomor Container</div><div><b><?= e($c['nomor_container']) ?></b></div>
        <div>Jenis/Ukuran</div><div><?= e($c['jenis_ukuran']) ?></div>
        <div>Tanggal Masuk</div><div><?= format_date($c['tanggal_masuk']) ?></div>
        <div>Status Saat Ini</div><div><?= status_badge($c['status']) ?></div>
    </div>
    <form method="post">
        <div class="form-grid">
            <div class="form-group"><label>Tanggal Keluar</label><input class="form-control" type="date" name="tanggal_keluar" value="<?= date('Y-m-d') ?>" required></div>
            <div class="form-group"><label>Tujuan Pengiriman</label><input class="form-control" name="tujuan_pengiriman" value="<?= e($c['tujuan_pengiriman']) ?>" required></div>
        </div>
        <div class="form-actions"><button class="btn btn-success" type="submit">Simpan Status Keluar</button><a class="btn btn-outline" href="<?= url('containers/index.php') ?>">Batal</a></div>
    </form>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
