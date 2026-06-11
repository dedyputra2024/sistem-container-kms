<?php
require_once __DIR__ . '/../includes/auth.php';
require_role('admin');
$page_title = 'Tambah Pengguna';
$page_subtitle = 'Buat akun baru sesuai hak akses';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $role = $_POST['role'] ?? '';
    $password = $_POST['password'] ?? '';
    $active = isset($_POST['is_active']) ? 1 : 0;
    if ($name === '' || $username === '' || $password === '' || !in_array($role, ['admin','staf_gudang','pimpinan'], true)) {
        flash('danger', 'Semua field wajib diisi dengan benar.');
    } else {
        try {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (name, username, password, role, is_active, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())');
            $stmt->execute([$name, $username, $hash, $role, $active]);
            log_activity($pdo, 'create_user', 'Menambah pengguna ' . $username);
            flash('success', 'Pengguna berhasil ditambahkan.');
            redirect('users/index.php');
        } catch (PDOException $e) { flash('danger', 'Username sudah digunakan.'); }
    }
}
require_once __DIR__ . '/../includes/header.php';
?>
<div class="card"><form method="post"><div class="form-grid">
    <div class="form-group"><label>Nama Lengkap</label><input class="form-control" name="name" required></div>
    <div class="form-group"><label>Username</label><input class="form-control" name="username" required></div>
    <div class="form-group"><label>Password</label><input class="form-control" type="password" name="password" required></div>
    <div class="form-group"><label>Role</label><select name="role" required><option value="admin">Admin</option><option value="staf_gudang">Staf Gudang</option><option value="pimpinan">Pimpinan</option></select></div>
    <div class="form-group"><label><input type="checkbox" name="is_active" checked> Aktif</label></div>
</div><div class="form-actions"><button class="btn btn-primary" type="submit">Simpan</button><a class="btn btn-outline" href="<?= url('users/index.php') ?>">Batal</a></div></form></div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
