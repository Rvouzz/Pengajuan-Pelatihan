<?php
session_start();
include '../../koneksi.php';

$nama_pengaju = $_SESSION['nama'] ?? '';

$result = $koneksi->prepare("SELECT id_peserta, nama_peserta, nik_peserta FROM temp_peserta WHERE nama_pengaju = ?");
$result->bind_param("s", $nama_pengaju);
$result->execute();
$data = $result->get_result();

$peserta = [];
while ($row = $data->fetch_assoc()) {
    $peserta[] = $row;
}

echo json_encode($peserta);
?>
