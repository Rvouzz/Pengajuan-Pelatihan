<?php
include '../../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);

    if ($id <= 0) {
        echo json_encode(['status' => false, 'message' => 'ID tidak valid']);
        exit;
    }

    // Ambil dokumen untuk dihapus dari folder
    $query_get_dokumen = "SELECT dokumen FROM tbl_pengajuan WHERE id_pengajuan = ?";
    $stmt_get = $koneksi->prepare($query_get_dokumen);
    $stmt_get->bind_param("i", $id);
    $stmt_get->execute();
    $result_get = $stmt_get->get_result();

    if ($result_get->num_rows === 0) {
        echo json_encode(['status' => false, 'message' => 'Data tidak ditemukan']);
        exit;
    }

    $data = $result_get->fetch_assoc();
    $dokumen_files = explode(',', $data['dokumen']);

    // Hapus dokumen dari folder
    foreach ($dokumen_files as $file) {
        $file_path = '../../Dokumen/' . $file;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    $stmt_get->close();

    // Hapus dari tbl_peserta
    $query_peserta = "DELETE FROM tbl_peserta WHERE id_pengajuan = ?";
    $stmt_peserta = $koneksi->prepare($query_peserta);
    $stmt_peserta->bind_param("i", $id);
    $stmt_peserta->execute();
    $stmt_peserta->close();

    // Hapus dari tbl_approval
    $query_approval = "DELETE FROM tbl_approval WHERE id_pengajuan = ?";
    $stmt_approval = $koneksi->prepare($query_approval);
    $stmt_approval->bind_param("i", $id);
    $stmt_approval->execute();
    $stmt_approval->close();

    // Hapus dari tbl_pengajuan
    $query_delete = "DELETE FROM tbl_pengajuan WHERE id_pengajuan = ?";
    $stmt_delete = $koneksi->prepare($query_delete);
    $stmt_delete->bind_param("i", $id);

    if ($stmt_delete->execute()) {
        echo json_encode(['status' => true, 'message' => 'Data berhasil dihapus']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Gagal menghapus data pengajuan: ' . $stmt_delete->error]);
    }

    $stmt_delete->close();
    $koneksi->close();
} else {
    echo json_encode(['status' => false, 'message' => 'Metode request tidak valid']);
}
