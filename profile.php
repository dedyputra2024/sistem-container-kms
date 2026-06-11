<?php
require_once __DIR__ . '/includes/auth.php';
require_login();
$page_title = 'Profil Perusahaan';
$page_subtitle = 'Informasi objek penelitian dan ruang lingkup sistem';
require_once __DIR__ . '/includes/header.php';
?>
<div class="grid grid-2">
    <div class="card">
        <h3>PT Karya Mandiri Sejahtera</h3>
        <p>Sistem ini dirancang untuk membantu proses pencatatan container di area gudang, mulai dari container masuk, pemantauan status selama berada di gudang, sampai pencatatan container keluar dan tujuan pengiriman.</p>
        <div class="detail-list">
            <div>Nama Sistem</div><div><?= e(APP_NAME) ?></div>
            <div>Objek</div><div><?= e(COMPANY_NAME) ?></div>
            <div>Platform</div><div>Web</div>
            <div>Metode Pengembangan</div><div>RAD (Rapid Application Development)</div>
        </div>
    </div>
    <div class="card">
        <h3>Ruang Lingkup Fitur</h3>
        <p>Fitur dibuat sesuai batasan penelitian: nomor container, jenis/ukuran, isi muatan, kondisi fisik, tanggal masuk, tanggal keluar, tujuan pengiriman, status container, pencarian, dan laporan.</p>
        <div class="help-box">
            <b>Role pengguna:</b><br>
            Admin: kelola seluruh data dan akun pengguna.<br>
            Staf Gudang: input dan ubah data container.<br>
            Pimpinan: melihat dashboard dan laporan.
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
