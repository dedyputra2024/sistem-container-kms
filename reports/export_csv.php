<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
$start = $_GET['start'] ?? date('Y-m-01');
$end = $_GET['end'] ?? date('Y-m-d');
$status = $_GET['status'] ?? '';
$where = ['tanggal_masuk BETWEEN ? AND ?'];
$params = [$start, $end];
if (in_array($status, ['di_gudang','keluar'], true)) { $where[] = 'status = ?'; $params[] = $status; }
$stmt = $pdo->prepare('SELECT * FROM containers WHERE ' . implode(' AND ', $where) . ' ORDER BY tanggal_masuk ASC');
$stmt->execute($params);
$rows = $stmt->fetchAll();
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=laporan-container-' . date('Ymd-His') . '.csv');
$out = fopen('php://output', 'w');
fputcsv($out, ['No','Nomor Container','Jenis/Ukuran','Isi Muatan','Kondisi Fisik','Tanggal Masuk','Tanggal Keluar','Tujuan Pengiriman','Status','Keterangan']);
foreach ($rows as $i => $r) {
    fputcsv($out, [$i+1, $r['nomor_container'], $r['jenis_ukuran'], $r['isi_muatan'], $r['kondisi_fisik'], $r['tanggal_masuk'], $r['tanggal_keluar'], $r['tujuan_pengiriman'], $r['status'], $r['keterangan']]);
}
fclose($out);
exit;
