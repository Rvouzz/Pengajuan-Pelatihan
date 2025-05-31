<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../../koneksi.php';
session_start();

header('Content-Type: application/json; charset=utf-8');

if ($koneksi->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Koneksi DB gagal: ' . $koneksi->connect_error]);
    exit;
}

$id_pengajuan = $_POST['id_pengajuan'] ?? '';
if (!$id_pengajuan) {
    echo json_encode(['success' => false, 'message' => 'ID pengajuan tidak ditemukan']);
    exit;
}

$stmt = $koneksi->prepare("SELECT laporan_kegiatan, lpj, sertifikat_pelatihan, sertifikat_kompetensi FROM tbl_berkas WHERE id_pengajuan = ?");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Gagal prepare statement: ' . $koneksi->error]);
    exit;
}

$stmt->bind_param("s", $id_pengajuan);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Data berkas tidak ditemukan']);
    exit;
}

$data = $result->fetch_assoc();

foreach ($data as $key => $value) {
    $data[$key] = $value ? basename($value) : null;
}

echo json_encode(['success' => true, 'files' => $data]);

$stmt->close();
$koneksi->close();
exit;
