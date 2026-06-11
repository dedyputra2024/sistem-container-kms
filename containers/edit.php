<?php
require_once __DIR__ . '/../includes/auth.php';
require_role(['admin','staf_gudang']);
$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM containers WHERE id = ?');
$stmt->execute([$id]);
$c = $stmt->fetch();
if (!$c) { flash('danger', 'Data container tidak ditemukan.'); redirect('containers/index.php'); }
$page_title = 'Edit Container';
$page_subtitle = 'Perbarui data container sesuai kondisi lapangan';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomor = strtoupper(trim($_POST['nomor_container'] ?? ''));
    $jenis = trim($_POST['jenis_ukuran'] ?? '');
    $muatan = trim($_POST['isi_muatan'] ?? '');
    $kondisi = trim($_POST['kondisi_fisik'] ?? '');
    $masuk = $_POST['tanggal_masuk'] ?? '';
    $keluar = $_POST['tanggal_keluar'] ?: null;
    $tujuan = trim($_POST['tujuan_pengiriman'] ?? '');
    $ket = trim($_POST['keterangan'] ?? '');
    $status = container_status_from_dates($keluar);

    if ($nomor === '' || $jenis === '' || $masuk === '') {
        flash('danger', 'Nomor container, jenis/ukuran, dan tanggal masuk wajib diisi.');
    } else {
        try {
            $stmt = $pdo->prepare('UPDATE containers SET nomor_container=?, jenis_ukuran=?, isi_muatan=?, kondisi_fisik=?, tanggal_masuk=?, tanggal_keluar=?, tujuan_pengiriman=?, status=?, keterangan=?, updated_at=NOW() WHERE id=?');
            $stmt->execute([$nomor, $jenis, $muatan, $kondisi, $masuk, $keluar, $tujuan, $status, $ket, $id]);
            log_activity($pdo, 'update_container', 'Mengubah data container ' . $nomor);
            flash('success', 'Data container berhasil diperbarui.');
            redirect('containers/index.php');
        } catch (PDOException $e) {
            flash('danger', 'Gagal memperbarui data. Pastikan nomor container tidak sama dengan data lain.');
        }
    }
}
require_once __DIR__ . '/../includes/header.php';
?>
<div class="card">
<form method="post">
    <div class="form-grid">
        <div class="form-group"><label>Nomor Container *</label><input class="form-control" name="nomor_container" required value="<?= e($c['nomor_container']) ?>"></div>
        <div class="form-group"><label>Jenis/Ukuran *</label><input class="form-control" name="jenis_ukuran" required value="<?= e($c['jenis_ukuran']) ?>"></div>
        <div class="form-group"><label>Isi Muatan</label><input class="form-control" name="isi_muatan" value="<?= e($c['isi_muatan']) ?>"></div>
        <div class="form-group"><label>Kondisi Fisik</label><input class="form-control" name="kondisi_fisik" value="<?= e($c['kondisi_fisik']) ?>"></div>
        <div class="form-group"><label>Tanggal Masuk *</label><input class="form-control" type="date" name="tanggal_masuk" value="<?= e($c['tanggal_masuk']) ?>" required></div>
        <div class="form-group"><label>Tanggal Keluar</label><input class="form-control" type="date" name="tanggal_keluar" value="<?= e($c['tanggal_keluar']) ?>"></div>
        <div class="form-group"><label>Tujuan Pengiriman</label><input class="form-control" name="tujuan_pengiriman" value="<?= e($c['tujuan_pengiriman']) ?>"></div>
        <div class="form-group"><label>Keterangan</label><textarea name="keterangan"><?= e($c['keterangan']) ?></textarea></div>
    </div>
    <div class="form-actions"><button class="btn btn-primary" type="submit">Update</button><a class="btn btn-outline" href="<?= url('containers/index.php') ?>">Kembali</a></div>
</form>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
