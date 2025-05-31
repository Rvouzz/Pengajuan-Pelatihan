<?php
session_start();
include '../../koneksi.php';

header('Content-Type: application/json');

$id_pengajuan = isset($_POST['id_pengajuan']) ? $_POST['id_pengajuan'] : '';

if ($id_pengajuan !== '') {
    $stmt = $koneksi->prepare("SELECT id_peserta, nama_peserta, nik_peserta FROM tbl_peserta WHERE id_pengajuan = ?");
    if (!$stmt) {
        die(json_encode(['error' => "Prepare failed: " . $koneksi->error]));
    }
    $stmt->bind_param("s", $id_pengajuan);
    if (!$stmt->execute()) {
        die(json_encode(['error' => "Execute failed: " . $stmt->error]));
    }
    $result = $stmt->get_result();

    $peserta = [];
    while ($row = $result->fetch_assoc()) {
        $peserta[] = $row;
    }
    echo json_encode($peserta);

    $stmt->close();
} else {
    echo json_encode(['error' => 'id_pengajuan kosong']);
}

$koneksi->close();
exit;
?>
