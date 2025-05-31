<?php
session_start();
include '../../koneksi.php'; // sesuaikan path file koneksi

// Ambil data POST dengan sanitasi
$id_pengajuan = isset($_POST['id_pengajuan']) ? intval($_POST['id_pengajuan']) : 0;
$kompetensi = isset($_POST['kompetensi']) ? intval($_POST['kompetensi']) : 0;
$laporan_pelatihan = isset($_POST['laporan_pelatihan']) ? intval($_POST['laporan_pelatihan']) : 0;
$anggaran_dipa = isset($_POST['anggaran_dipa']) ? intval($_POST['anggaran_dipa']) : 0;
$ketersediaan_sd = isset($_POST['ketersediaan_sd']) ? intval($_POST['ketersediaan_sd']) : 0;
$tujuan_sasaran = isset($_POST['tujuan_sasaran']) ? intval($_POST['tujuan_sasaran']) : 0;
$approval_kepegawaian = isset($_POST['status']) ? intval($_POST['status']) : 0;
$komentar_kepegawaian = isset($_POST['komentar_kepegawaian']) ? $_POST['komentar_kepegawaian'] : '';

$nama_kepegawaian = isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Unknown';

if ($id_pengajuan == 0) {
    http_response_code(400);
    echo json_encode(['error' => 'ID Pengajuan tidak valid']);
    exit;
}

// Cek apakah data approval sudah ada
$queryCek = $koneksi->prepare("SELECT id_approval FROM tbl_approval WHERE id_pengajuan = ?");
$queryCek->bind_param("i", $id_pengajuan);
$queryCek->execute();
$resultCek = $queryCek->get_result();

if ($resultCek === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Query gagal: ' . $koneksi->error]);
    exit;
}

if ($resultCek->num_rows > 0) {
    // UPDATE
    if ($approval_kepegawaian === 2) {
        $sql = "UPDATE tbl_approval SET 
                kompetensi = ?, laporan_pelatihan = ?, anggaran_dipa = ?, 
                ketersediaan_sd = ?, tujuan_sasaran = ?, approval_kepegawaian = ?, 
                komentar_kepegawaian = ?, nama_kepegawaian = ?, 
                approval_kpj = 2, approval_kunit = 2
                WHERE id_pengajuan = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("iiiiisssi", 
            $kompetensi, $laporan_pelatihan, $anggaran_dipa, 
            $ketersediaan_sd, $tujuan_sasaran, $approval_kepegawaian, 
            $komentar_kepegawaian, $nama_kepegawaian, $id_pengajuan
        );
    } else {
        $sql = "UPDATE tbl_approval SET 
                kompetensi = ?, laporan_pelatihan = ?, anggaran_dipa = ?, 
                ketersediaan_sd = ?, tujuan_sasaran = ?, approval_kepegawaian = ?, 
                komentar_kepegawaian = ?, nama_kepegawaian = ?
                WHERE id_pengajuan = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("iiiiisssi", 
            $kompetensi, $laporan_pelatihan, $anggaran_dipa, 
            $ketersediaan_sd, $tujuan_sasaran, $approval_kepegawaian, 
            $komentar_kepegawaian, $nama_kepegawaian, $id_pengajuan
        );
    }
} else {
    // INSERT
    $sql = "INSERT INTO tbl_approval 
        (id_pengajuan, kompetensi, laporan_pelatihan, anggaran_dipa, ketersediaan_sd, tujuan_sasaran, approval_kepegawaian, komentar_kepegawaian, nama_kepegawaian)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("iiiiissss", 
        $id_pengajuan, $kompetensi, $laporan_pelatihan, $anggaran_dipa, $ketersediaan_sd, $tujuan_sasaran, $approval_kepegawaian, $komentar_kepegawaian, $nama_kepegawaian
    );
}

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal menyimpan data: ' . $stmt->error]);
}

$stmt->close();
$koneksi->close();
