<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

if (!empty($_SESSION['user'])) {
    redirect('dashboard.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? AND is_active = 1 LIMIT 1');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'username' => $user['username'],
            'role' => $user['role'],
        ];
        log_activity($pdo, 'login', 'Pengguna login ke sistem');
        redirect('dashboard.php');
    }
    flash('danger', 'Username atau password tidak sesuai.');
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - <?= e(APP_NAME) ?></title>
    <link rel="stylesheet" href="<?= url('assets/css/style.css') ?>">
</head>
<body class="login-page">
    <div class="login-card">
        <div class="login-logo">
    <img src="<?= url('assets/img/logo-kms.png') ?>" alt="Logo KMS">
</div>
        <h1><?= e(APP_NAME) ?></h1>
        <p>Masuk untuk mengelola data pencatatan container <?= e(COMPANY_NAME) ?>.</p>
        <?php show_flash(); ?>
        <form method="post">
            <div class="form-group">
                <label>Username</label>
                <input class="form-control" type="text" name="username" required autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input class="form-control" type="password" name="password" required>
            </div>
            <button class="btn btn-primary btn-block" type="submit">Login</button>
        </form>
    </div>
</body>
</html>
