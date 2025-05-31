<?php
// Aktifkan pelaporan kesalahan hanya untuk pengembangan
// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Aktifkan hanya saat development

$configPath = __DIR__ . '/config.php';

// Cek file config
if (!file_exists($configPath)) {
    error_log("Configuration file not found at: " . $configPath);
    die("Configuration error. Please contact the administrator.");
}

$config = require $configPath;

// Pastikan konfigurasi lengkap
$requiredKeys = ['host', 'user', 'pass', 'db'];
foreach ($requiredKeys as $key) {
    if (!array_key_exists($key, $config)) {
        error_log("Missing configuration key: $key");
        die("Configuration error. Please contact the administrator.");
    }
}

try {
    $koneksi = new mysqli(
        $config['host'],
        $config['user'],
        $config['pass'],
        $config['db']
    );

    if ($koneksi->connect_error) {
        throw new Exception("Database connection failed: " . $koneksi->connect_error);
    }

    // Set charset ke UTF-8
    $koneksi->set_charset("utf8mb4");

} catch (Exception $e) {
    error_log($e->getMessage());
    die("Unable to connect to the database. Please contact the administrator.");
}
?>
