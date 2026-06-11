<?php
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function show_flash(): void
{
    if (!empty($_SESSION['flash'])) {
        $type = e($_SESSION['flash']['type']);
        $message = e($_SESSION['flash']['message']);
        echo "<div class='alert alert-{$type}'>{$message}</div>";
        unset($_SESSION['flash']);
    }
}

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function is_role(string|array $roles): bool
{
    $user = current_user();
    if (!$user) return false;
    $roles = (array) $roles;
    return in_array($user['role'], $roles, true);
}

function role_label(string $role): string
{
    return [
        'admin' => 'Admin',
        'staf_gudang' => 'Staf Gudang',
        'pimpinan' => 'Pimpinan',
    ][$role] ?? $role;
}

function status_badge(string $status): string
{
    $class = $status === 'keluar' ? 'badge-out' : 'badge-in';
    $label = $status === 'keluar' ? 'Keluar' : 'Di Gudang';
    return "<span class='badge {$class}'>{$label}</span>";
}

function redirect(string $path): never
{
    header('Location: ' . url($path));
    exit;
}

function log_activity(PDO $pdo, string $action, string $description): void
{
    if (empty($_SESSION['user'])) return;
    $stmt = $pdo->prepare('INSERT INTO audit_logs (user_id, action, description, created_at) VALUES (?, ?, ?, NOW())');
    $stmt->execute([$_SESSION['user']['id'], $action, $description]);
}

function format_date(?string $date): string
{
    if (!$date) return '-';
    $ts = strtotime($date);
    return $ts ? date('d-m-Y', $ts) : e($date);
}

function container_status_from_dates(?string $tanggalKeluar): string
{
    return $tanggalKeluar ? 'keluar' : 'di_gudang';
}
