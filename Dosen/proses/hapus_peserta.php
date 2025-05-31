<?php
session_start();
include '../../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_peserta = $_POST['id_peserta'] ?? '';
    $nama_pengaju = $_SESSION['nama'] ?? '';

    if ($id_peserta !== '' && $nama_pengaju !== '') {
        // Hapus peserta hanya jika sesuai dengan pengaju yang sedang login
        $stmt = $koneksi->prepare("DELETE FROM temp_peserta WHERE id_peserta = ? AND nama_pengaju = ?");
        $stmt->bind_param("is", $id_peserta, $nama_pengaju);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(['status' => 'success', 'message' => 'Peserta berhasil dihapus']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Peserta tidak ditemukan atau bukan milik Anda']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus peserta']);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
