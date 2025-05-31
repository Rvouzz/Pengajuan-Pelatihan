<?php
include '../../koneksi.php';
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_peserta'] ?? '';
    $nik = $_POST['nik_peserta'] ?? '';
    $id_pengajuan = $_POST['id_pengajuan'] ?? '';

    if ($nama !== '' && $nik !== '' && $id_pengajuan !== '') {
        $stmt = $koneksi->prepare("INSERT INTO tbl_peserta (nama_peserta, nik_peserta, id_pengajuan) VALUES (?, ?, ?)");
        if (!$stmt) {
            echo json_encode(['status' => 'error', 'message' => 'Prepare statement gagal: ' . $koneksi->error]);
            exit;
        }
        $stmt->bind_param("sss", $nama, $nik, $id_pengajuan);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Peserta berhasil disimpan']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan ke database: ' . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
