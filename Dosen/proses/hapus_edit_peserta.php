<?php
session_start();
include '../../koneksi.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_peserta = $_POST['id_peserta'] ?? '';
    $id_pengajuan = $_POST['id_pengajuan'] ?? '';  // ambil dari POST bukan session

    if ($id_peserta !== '' && $id_pengajuan !== '') {
        $stmt = $koneksi->prepare("DELETE FROM tbl_peserta WHERE id_peserta = ? AND id_pengajuan = ?");
        if (!$stmt) {
            echo json_encode(['status' => 'error', 'message' => 'Prepare statement gagal: ' . $koneksi->error]);
            exit;
        }
        $stmt->bind_param("is", $id_peserta, $id_pengajuan);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(['status' => 'success', 'message' => 'Peserta berhasil dihapus']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Peserta tidak ditemukan atau bukan milik Anda']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus peserta: ' . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
