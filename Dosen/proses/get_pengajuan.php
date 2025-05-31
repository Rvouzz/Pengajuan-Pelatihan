<?php
session_start();
include '../../koneksi.php';

if (!isset($_SESSION['nama'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$nama_pengaju = $_SESSION['nama'];

function mapApprovalStatus($status)
{
    switch ($status) {
        case '1':
            return ['text' => 'Disetujui', 'class' => 'success'];
        case '2':
            return ['text' => 'Ditolak', 'class' => 'danger'];
        default:
            return ['text' => 'Menunggu Persetujuan', 'class' => 'warning'];
    }
}

$query = "
    SELECT 
        p.id_pengajuan, 
        p.nama_pengaju, 
        p.jenis_kegiatan, 
        p.tanggal_mulai, 
        p.tanggal_selesai, 
        a.kompetensi,
        a.laporan_pelatihan,
        a.anggaran_dipa,
        a.ketersediaan_sd,
        a.tujuan_sasaran,
        a.approval_kepegawaian,
        a.komentar_kepegawaian,
        a.nama_kepegawaian,
        a.approval_kpj,
        a.komentar_kpj,
        a.nama_kpj,
        a.approval_kunit,
        a.komentar_kunit,
        a.nama_kunit
    FROM tbl_pengajuan p
    LEFT JOIN tbl_approval a ON p.id_pengajuan = a.id_pengajuan
    WHERE p.nama_pengaju = ?
    ORDER BY p.id_pengajuan DESC
";


$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, 's', $nama_pengaju);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $kpjStatus = mapApprovalStatus($row['approval_kpj']);
    $kunitStatus = mapApprovalStatus($row['approval_kunit']);

    $data[] = [
        'id' => $row['id_pengajuan'],
        'nama_pengaju' => $row['nama_pengaju'],
        'jenis_kegiatan' => $row['jenis_kegiatan'],
        'tanggal_mulai' => date('d M Y', strtotime($row['tanggal_mulai'])),
        'tanggal_selesai' => date('d M Y', strtotime($row['tanggal_selesai'])),
        'approval_kpj_text' => $kpjStatus['text'],
        'approval_kpj_class' => $kpjStatus['class'],
        'approval_kunit_text' => $kunitStatus['text'],
        'approval_kunit_class' => $kunitStatus['class'],
        'approval_kepegawaian' => $row['approval_kepegawaian'],  // tambahkan ini
    ];
}

header('Content-Type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT);
