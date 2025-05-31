<?php
session_start();
include '../../koneksi.php'; // Sesuaikan path koneksi

// Cek session user (misalnya nama KPJ disimpan di session)
if (!isset($_SESSION['nama'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$nama_kunit = $_SESSION['nama'];

// Ambil data dari POST
$id_pengajuan = $_POST['id_pengajuan'] ?? '';
$komentar_kunit = $_POST['komentar_kunit'] ?? '';
$approval_kunit = $_POST['approval_kunit'] ?? '';

if (empty($id_pengajuan)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'ID pengajuan tidak valid']);
    exit;
}

// Query untuk update tbl_approval
$query = "
    UPDATE tbl_approval 
    SET 
        approval_kunit = ?, 
        komentar_kunit = ?, 
        nama_kunit = ?
    WHERE id_pengajuan = ?
";

$stmt = mysqli_prepare($koneksi, $query);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'sssi', $approval_kunit, $komentar_kunit, $nama_kunit, $id_pengajuan);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Approval KPJ berhasil disimpan']);
    } else {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data']);
    }

    mysqli_stmt_close($stmt);
} else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Query tidak bisa disiapkan']);
}

mysqli_close($koneksi);
