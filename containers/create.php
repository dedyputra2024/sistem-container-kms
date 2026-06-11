<?php
require_once __DIR__ . '/../includes/auth.php';
require_role(['admin','staf_gudang']);
$page_title = 'Tambah Container';
$page_subtitle = 'Input data container satu kali saat kegiatan berlangsung';

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
            $stmt = $pdo->prepare('INSERT INTO containers (nomor_container, jenis_ukuran, isi_muatan, kondisi_fisik, tanggal_masuk, tanggal_keluar, tujuan_pengiriman, status, keterangan, created_by, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())');
            $stmt->execute([$nomor, $jenis, $muatan, $kondisi, $masuk, $keluar, $tujuan, $status, $ket, $_SESSION['user']['id']]);
            log_activity($pdo, 'create_container', 'Menambah data container ' . $nomor);
            flash('success', 'Data container berhasil ditambahkan.');
            redirect('containers/index.php');
        } catch (PDOException $e) {
            flash('danger', 'Gagal menyimpan data. Pastikan nomor container belum pernah digunakan.');
        }
    }
}
require_once __DIR__ . '/../includes/header.php';
?>
<div class="card">
<form method="post">
    <div class="form-grid">
        <div class="form-group"><label>Nomor Container *</label><input class="form-control" name="nomor_container" required placeholder="Contoh: KMSU1234567"></div>
        <div class="form-group"><label>Jenis/Ukuran *</label><select name="jenis_ukuran" required><option value="">Pilih</option><option>20 Feet</option><option>40 Feet</option><option>40 Feet HC</option><option>Reefer</option><option>Open Top</option></select></div>
        <div class="form-group"><label>Isi Muatan</label><input class="form-control" name="isi_muatan" placeholder="Contoh: Barang elektronik"></div>
        <div class="form-group"><label>Kondisi Fisik</label><select name="kondisi_fisik"><option>Baik</option><option>Rusak Ringan</option><option>Rusak Berat</option><option>Perlu Pemeriksaan</option></select></div>
        <div class="form-group"><label>Tanggal Masuk *</label><input class="form-control" type="date" name="tanggal_masuk" value="<?= date('Y-m-d') ?>" required></div>
        <div class="form-group"><label>Tanggal Keluar</label><input class="form-control" type="date" name="tanggal_keluar"></div>
        <div class="form-group"><label>Tujuan Pengiriman</label><input class="form-control" name="tujuan_pengiriman" placeholder="Contoh: Batam Center / Pelabuhan"></div>
        <div class="form-group"><label>Keterangan</label><textarea name="keterangan" placeholder="Catatan tambahan"></textarea></div>
    </div>
    <div class="form-actions"><button class="btn btn-primary" type="submit">Simpan</button><a class="btn btn-outline" href="<?= url('containers/index.php') ?>">Batal</a></div>
</form>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
