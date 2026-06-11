<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
$page_title = 'Data Container';
$page_subtitle = 'Pencatatan, pencarian, dan pengelolaan status container';

$q = trim($_GET['q'] ?? '');
$status = $_GET['status'] ?? '';
$start = $_GET['start'] ?? '';
$end = $_GET['end'] ?? '';

$where = [];
$params = [];
if ($q !== '') {
    $where[] = '(nomor_container LIKE ? OR jenis_ukuran LIKE ? OR isi_muatan LIKE ? OR tujuan_pengiriman LIKE ?)';
    $like = '%' . $q . '%';
    array_push($params, $like, $like, $like, $like);
}
if (in_array($status, ['di_gudang','keluar'], true)) {
    $where[] = 'status = ?';
    $params[] = $status;
}
if ($start !== '') { $where[] = 'tanggal_masuk >= ?'; $params[] = $start; }
if ($end !== '') { $where[] = 'tanggal_masuk <= ?'; $params[] = $end; }
$sql = 'SELECT * FROM containers' . ($where ? ' WHERE ' . implode(' AND ', $where) : '') . ' ORDER BY updated_at DESC';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$containers = $stmt->fetchAll();
require_once __DIR__ . '/../includes/header.php';
?>
<div class="card">
    <form class="filter-bar" method="get">
        <div class="form-group"><label>Cari</label><input class="form-control" type="text" name="q" value="<?= e($q) ?>" placeholder="Nomor, muatan, tujuan..."></div>
        <div class="form-group"><label>Status</label><select name="status"><option value="">Semua</option><option value="di_gudang" <?= $status==='di_gudang'?'selected':'' ?>>Di Gudang</option><option value="keluar" <?= $status==='keluar'?'selected':'' ?>>Keluar</option></select></div>
        <div class="form-group"><label>Dari Tanggal Masuk</label><input class="form-control" type="date" name="start" value="<?= e($start) ?>"></div>
        <div class="form-group"><label>Sampai</label><input class="form-control" type="date" name="end" value="<?= e($end) ?>"></div>
        <button class="btn btn-primary" type="submit">Filter</button>
    </form>
</div>
<div class="section-title">
    <h3>Daftar Container</h3>
    <?php if (is_role(['admin','staf_gudang'])): ?><a class="btn btn-primary" href="<?= url('containers/create.php') ?>">Tambah Data</a><?php endif; ?>
</div>
<div class="table-wrap">
<table>
    <thead><tr><th>No</th><th>Nomor Container</th><th>Jenis/Ukuran</th><th>Isi Muatan</th><th>Kondisi</th><th>Masuk</th><th>Keluar</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php if (!$containers): ?><tr><td colspan="9" class="empty">Data tidak ditemukan.</td></tr><?php endif; ?>
    <?php foreach ($containers as $i => $c): ?>
        <tr>
            <td><?= $i+1 ?></td>
            <td><b><?= e($c['nomor_container']) ?></b></td>
            <td><?= e($c['jenis_ukuran']) ?></td>
            <td><?= e($c['isi_muatan']) ?></td>
            <td><?= e($c['kondisi_fisik']) ?></td>
            <td><?= format_date($c['tanggal_masuk']) ?></td>
            <td><?= format_date($c['tanggal_keluar']) ?></td>
            <td><?= status_badge($c['status']) ?></td>
            <td>
                <div class="action-row">
                    <a class="btn btn-outline" href="<?= url('containers/detail.php?id=' . $c['id']) ?>">Detail</a>
                    <?php if (is_role(['admin','staf_gudang'])): ?>
                        <a class="btn btn-secondary" href="<?= url('containers/edit.php?id=' . $c['id']) ?>">Edit</a>
                        <?php if ($c['status'] === 'di_gudang'): ?><a class="btn btn-success" href="<?= url('containers/keluar.php?id=' . $c['id']) ?>">Catat Keluar</a><?php endif; ?>
                    <?php endif; ?>
                    <?php if (is_role('admin')): ?><a data-confirm="Hapus data container ini?" class="btn btn-danger" href="<?= url('containers/delete.php?id=' . $c['id']) ?>">Hapus</a><?php endif; ?>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
