<?php
$config = require __DIR__ . '/config.php';

$koneksi = mysqli_connect(
    $config['host'],
    $config['user'],
    $config['pass'],
    $config['db']
);

if (!$koneksi) {
    // Log error ke file, jangan tampilkan ke user
    error_log("Database connection failed: " . mysqli_connect_error());
    die("Database connection failed. Please contact the administrator.");
}
?>