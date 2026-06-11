<?php
require_once __DIR__ . '/../includes/auth.php';
require_role('admin');
$page_title = 'Manajemen Pengguna';
$page_subtitle = 'Kelola akun dan hak akses pengguna sistem';
$users = $pdo->query('SELECT * FROM users ORDER BY role, name')->fetchAll();
require_once __DIR__ . '/../includes/header.php';
?>
<div class="section-title"><h3>Daftar Pengguna</h3><a class="btn btn-primary" href="<?= url('users/create.php') ?>">Tambah Pengguna</a></div>
<div class="table-wrap">
<table>
<thead><tr><th>No</th><th>Nama</th><th>Username</th><th>Role</th><th>Status</th><th>Dibuat</th><th>Aksi</th></tr></thead>
<tbody>
<?php foreach ($users as $i => $u): ?>
<tr>
    <td><?= $i+1 ?></td><td><b><?= e($u['name']) ?></b></td><td><?= e($u['username']) ?></td><td><?= e(role_label($u['role'])) ?></td><td><?= $u['is_active'] ? 'Aktif' : 'Nonaktif' ?></td><td><?= e($u['created_at']) ?></td>
    <td><div class="action-row"><a class="btn btn-secondary" href="<?= url('users/edit.php?id=' . $u['id']) ?>">Edit</a><?php if ($u['id'] != ($_SESSION['user']['id'] ?? 0)): ?><a data-confirm="Hapus pengguna ini?" class="btn btn-danger" href="<?= url('users/delete.php?id=' . $u['id']) ?>">Hapus</a><?php endif; ?></div></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
