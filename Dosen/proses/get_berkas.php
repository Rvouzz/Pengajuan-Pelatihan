<?php
include '../../koneksi.php';

header('Content-Type: application/json');

session_start();

if (!$koneksi) {
  http_response_code(500);
  echo json_encode(['error' => 'Koneksi database gagal']);
  exit;
}

// Pastikan session 'nama_pengaju' sudah terisi
if (!isset($_SESSION['nama'])) {
  http_response_code(400);
  echo json_encode(['error' => 'Session nama_pengaju tidak ditemukan']);
  exit;
}

$nama_pengaju = $koneksi->real_escape_string($_SESSION['nama']); // untuk keamanan SQL Injection

$query = "
    SELECT 
         p.id_pengajuan,
        p.nama_pengaju, 
        p.jenis_kegiatan, 
        p.tanggal_mulai, 
        p.tanggal_selesai, 
        b.nomor_surat,
        b.file_surat,
        b.tanggal_surat,
        c.id_berkas,
        d.approval_kepegawaian,
        d.approval_kpj,
        d.approval_kunit
    FROM tbl_pengajuan p
    LEFT JOIN tbl_surat b ON b.id_pengajuan = p.id_pengajuan
    LEFT JOIN tbl_berkas c ON c.id_pengajuan = p.id_pengajuan
    LEFT JOIN tbl_approval d ON d.id_pengajuan = p.id_pengajuan
    WHERE p.nama_pengaju = '$nama_pengaju' 
    ORDER BY p.id_pengajuan DESC
";


// AND (b.nomor_surat IS NULL OR b.nomor_surat = '')

$result = $koneksi->query($query);

$data = [];

if ($result) {
  while ($row = $result->fetch_assoc()) {
    if (empty($row['file_surat'])) {
      $row['file_surat'] = '#';
    }
    if (!empty($row['tanggal_surat'])) {
      $row['tanggal_surat'] = date('d-m-Y', strtotime($row['tanggal_surat']));
    } else {
      $row['tanggal_surat'] = '-';
    }
    $data[] = $row;
  }
  echo json_encode($data);
} else {
  http_response_code(500);
  echo json_encode(['error' => 'Gagal mengambil data: ' . $koneksi->error]);
}
