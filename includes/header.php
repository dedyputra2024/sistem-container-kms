<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/functions.php';
$user = current_user();
$current = basename($_SERVER['PHP_SELF']);
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(APP_NAME) ?></title>
    <link rel="stylesheet" href="<?= url('assets/css/style.css') ?>">
</head>
<body>
<div class="app-shell">
    <aside class="sidebar">
        <div class="brand">
    <div class="brand-logo" style="
    width: 52px;
    height: 52px;
    min-width: 52px;
    max-width: 52px;
    min-height: 52px;
    max-height: 52px;
    overflow: hidden;
    border-radius: 14px;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
">
    <img src="<?= url('assets/img/logo-kms.png') ?>" alt="Logo KMS" style="
        width: 100%;
        height: 100%;
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
        display: block;
    ">
</div>
    <div>
        <h1>Container KMS</h1>
        <p><?= e(COMPANY_NAME) ?></p>
    </div>
</div>
        <nav class="menu">
            <a class="<?= $current === 'dashboard.php' ? 'active' : '' ?>" href="<?= url('dashboard.php') ?>">Dashboard</a>
            <a class="<?= strpos($_SERVER['REQUEST_URI'], '/containers/') !== false ? 'active' : '' ?>" href="<?= url('containers/index.php') ?>">Data Container</a>
            <a class="<?= strpos($_SERVER['REQUEST_URI'], '/reports/') !== false ? 'active' : '' ?>" href="<?= url('reports/index.php') ?>">Laporan</a>
            <a class="<?= $current === 'profile.php' ? 'active' : '' ?>" href="<?= url('profile.php') ?>">Profil Perusahaan</a>
            <?php if (is_role('admin')): ?>
                <a class="<?= strpos($_SERVER['REQUEST_URI'], '/users/') !== false ? 'active' : '' ?>" href="<?= url('users/index.php') ?>">Pengguna</a>
            <?php endif; ?>
        </nav>
        <div class="sidebar-footer">
            <small>Login sebagai</small>
            <strong><?= e($user['name'] ?? '-') ?></strong>
            <span><?= e(role_label($user['role'] ?? '-')) ?></span>
            <a class="logout" href="<?= url('logout.php') ?>">Keluar</a>
        </div>
    </aside>
    <main class="main-content">
        <header class="topbar">
            <div>
                <h2><?= e($page_title ?? APP_NAME) ?></h2>
                <p><?= e($page_subtitle ?? 'Pengelolaan data container secara terpusat dan terstruktur') ?></p>
            </div>
            <div class="topbar-date"><?= date('d M Y') ?></div>
        </header>
        <?php show_flash(); ?>
