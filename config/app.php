<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('APP_NAME', 'Sistem Informasi Pencatatan Container');
define('COMPANY_NAME', 'PT Karya Mandiri Sejahtera');

$docRoot = isset($_SERVER['DOCUMENT_ROOT']) ? realpath($_SERVER['DOCUMENT_ROOT']) : '';
$appRoot = realpath(__DIR__ . '/..');
$docRoot = $docRoot ? rtrim(str_replace('\\', '/', $docRoot), '/') : '';
$appRoot = $appRoot ? rtrim(str_replace('\\', '/', $appRoot), '/') : '';
$basePath = '';
if ($docRoot && $appRoot && substr($appRoot, 0, strlen($docRoot)) === $docRoot) {
    $basePath = substr($appRoot, strlen($docRoot));
}
define('BASE_URL', $basePath ?: '');

function url(string $path = ''): string
{
    $base = rtrim(BASE_URL, '/');
    $path = ltrim($path, '/');
    return ($base === '' ? '' : $base) . '/' . $path;
}
