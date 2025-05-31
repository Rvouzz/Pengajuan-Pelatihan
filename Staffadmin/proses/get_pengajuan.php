<?php
session_start();
include '../../koneksi.php';

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
        a.nama_kunit,
        b.nomor_surat
    FROM tbl_pengajuan p
    LEFT JOIN tbl_approval a ON p.id_pengajuan = a.id_pengajuan
    LEFT JOIN tbl_surat b ON b.id_pengajuan = p.id_pengajuan
    ORDER BY p.id_pengajuan DESC
";


$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $kepegawaianStatus = mapApprovalStatus($row['approval_kepegawaian']);

    $data[] = [
        'id' => $row['id_pengajuan'],
        'nama_pengaju' => $row['nama_pengaju'],
        'jenis_kegiatan' => $row['jenis_kegiatan'],
        'tanggal_mulai' => date('d M Y', strtotime($row['tanggal_mulai'])),
        'tanggal_selesai' => date('d M Y', strtotime($row['tanggal_selesai'])),
        'approval_kepegawaian_text' => $kepegawaianStatus['text'],
        'approval_kepegawaian_class' => $kepegawaianStatus['class'],
        'approval_kpj' => $row['approval_kpj'],
        'approval_kunit' => $row['approval_kunit'],
        'nomor_surat' => $row['nomor_surat'],
    ];
}

header('Content-Type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT);
