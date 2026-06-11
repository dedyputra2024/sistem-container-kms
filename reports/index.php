<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
$page_title = 'Laporan Container';
$page_subtitle = 'Filter laporan harian, bulanan, dan status container';

$start = $_GET['start'] ?? date('Y-m-01');
$end = $_GET['end'] ?? date('Y-m-d');
$status = $_GET['status'] ?? '';
$where = ['tanggal_masuk BETWEEN ? AND ?'];
$params = [$start, $end];
if (in_array($status, ['di_gudang','keluar'], true)) { $where[] = 'status = ?'; $params[] = $status; }
$sql = 'SELECT * FROM containers WHERE ' . implode(' AND ', $where) . ' ORDER BY tanggal_masuk ASC, nomor_container ASC';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll();
$sumIn = 0; $sumOut = 0;
foreach ($rows as $r) { if ($r['status'] === 'keluar') $sumOut++; else $sumIn++; }
require_once __DIR__ . '/../includes/header.php';
$query = http_build_query(['start'=>$start,'end'=>$end,'status'=>$status]);
?>
<div class="card no-print">
    <form class="filter-bar" method="get" style="grid-template-columns:1fr 1fr 1fr auto auto">
        <div class="form-group"><label>Tanggal Mulai</label><input class="form-control" type="date" name="start" value="<?= e($start) ?>"></div>
        <div class="form-group"><label>Tanggal Akhir</label><input class="form-control" type="date" name="end" value="<?= e($end) ?>"></div>
        <div class="form-group"><label>Status</label><select name="status"><option value="">Semua</option><option value="di_gudang" <?= $status==='di_gudang'?'selected':'' ?>>Di Gudang</option><option value="keluar" <?= $status==='keluar'?'selected':'' ?>>Keluar</option></select></div>
        <button class="btn btn-primary" type="submit">Tampilkan</button>
        <a class="btn btn-secondary" href="<?= url('reports/export_csv.php?' . $query) ?>">Export CSV</a>
    </form>
</div>
<div class="grid grid-3" style="margin-top:18px">
    <div class="card stat"><div><small>Total Data</small><h3><?= count($rows) ?></h3></div><div class="stat-icon">L</div></div>
    <div class="card stat"><div><small>Di Gudang</small><h3><?= $sumIn ?></h3></div><div class="stat-icon">G</div></div>
    <div class="card stat"><div><small>Keluar</small><h3><?= $sumOut ?></h3></div><div class="stat-icon">K</div></div>
</div>
<div class="section-title"><h3>Hasil Laporan</h3><button onclick="window.print()" class="btn btn-outline no-print">Cetak</button></div>
<div class="card">
    <div class="print-header">
        <h2>Laporan Pencatatan Container</h2>
        <p><?= e(COMPANY_NAME) ?></p>
        <p>Periode: <?= format_date($start) ?> s.d. <?= format_date($end) ?></p>
    </div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>No</th><th>Nomor Container</th><th>Jenis/Ukuran</th><th>Isi Muatan</th><th>Kondisi</th><th>Masuk</th><th>Keluar</th><th>Tujuan</th><th>Status</th></tr></thead>
            <tbody>
                <?php if (!$rows): ?><tr><td colspan="9" class="empty">Tidak ada data pada periode ini.</td></tr><?php endif; ?>
                <?php foreach ($rows as $i => $r): ?>
                <tr>
                    <td><?= $i+1 ?></td><td><b><?= e($r['nomor_container']) ?></b></td><td><?= e($r['jenis_ukuran']) ?></td><td><?= e($r['isi_muatan']) ?></td><td><?= e($r['kondisi_fisik']) ?></td><td><?= format_date($r['tanggal_masuk']) ?></td><td><?= format_date($r['tanggal_keluar']) ?></td><td><?= e($r['tujuan_pengiriman']) ?: '-' ?></td><td><?= status_badge($r['status']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
