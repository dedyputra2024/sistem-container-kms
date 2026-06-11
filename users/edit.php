<?php
require_once __DIR__ . '/../includes/auth.php';
require_role('admin');
$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$id]);
$u = $stmt->fetch();
if (!$u) { flash('danger', 'Pengguna tidak ditemukan.'); redirect('users/index.php'); }
$page_title = 'Edit Pengguna';
$page_subtitle = 'Ubah identitas, role, status, atau password pengguna';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $role = $_POST['role'] ?? '';
    $password = $_POST['password'] ?? '';
    $active = isset($_POST['is_active']) ? 1 : 0;
    if ($name === '' || $username === '' || !in_array($role, ['admin','staf_gudang','pimpinan'], true)) {
        flash('danger', 'Nama, username, dan role wajib diisi.');
    } else {
        try {
            if ($password !== '') {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare('UPDATE users SET name=?, username=?, password=?, role=?, is_active=?, updated_at=NOW() WHERE id=?');
                $stmt->execute([$name, $username, $hash, $role, $active, $id]);
            } else {
                $stmt = $pdo->prepare('UPDATE users SET name=?, username=?, role=?, is_active=?, updated_at=NOW() WHERE id=?');
                $stmt->execute([$name, $username, $role, $active, $id]);
            }
            log_activity($pdo, 'update_user', 'Mengubah pengguna ' . $username);
            flash('success', 'Pengguna berhasil diperbarui.');
            redirect('users/index.php');
        } catch (PDOException $e) { flash('danger', 'Username sudah digunakan.'); }
    }
}
require_once __DIR__ . '/../includes/header.php';
?>
<div class="card"><form method="post"><div class="form-grid">
    <div class="form-group"><label>Nama Lengkap</label><input class="form-control" name="name" value="<?= e($u['name']) ?>" required></div>
    <div class="form-group"><label>Username</label><input class="form-control" name="username" value="<?= e($u['username']) ?>" required></div>
    <div class="form-group"><label>Password Baru</label><input class="form-control" type="password" name="password" placeholder="Kosongkan jika tidak diubah"></div>
    <div class="form-group"><label>Role</label><select name="role" required><option value="admin" <?= $u['role']==='admin'?'selected':'' ?>>Admin</option><option value="staf_gudang" <?= $u['role']==='staf_gudang'?'selected':'' ?>>Staf Gudang</option><option value="pimpinan" <?= $u['role']==='pimpinan'?'selected':'' ?>>Pimpinan</option></select></div>
    <div class="form-group"><label><input type="checkbox" name="is_active" <?= $u['is_active']?'checked':'' ?>> Aktif</label></div>
</div><div class="form-actions"><button class="btn btn-primary" type="submit">Update</button><a class="btn btn-outline" href="<?= url('users/index.php') ?>">Kembali</a></div></form></div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
