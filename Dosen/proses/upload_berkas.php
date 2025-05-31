<?php
include '../../koneksi.php';
session_start();

if (!isset($_SESSION['nama'])) {
    echo json_encode(['success' => false, 'message' => 'Session tidak ditemukan.']);
    exit;
}

$maxFileSize = 1 * 1024 * 1024; // 1MB
$uploadDir = '../../Upload/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

$id_pengajuan = $_POST['id_pengajuan'] ?? '';
if (empty($id_pengajuan)) {
    echo json_encode(['success' => false, 'message' => 'ID pengajuan tidak ditemukan.']);
    exit;
}

function uploadFile($fieldName, $allowedExts, $customName) {
    global $uploadDir, $maxFileSize;

    if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] === UPLOAD_ERR_NO_FILE) {
        // File tidak diupload, return null agar tidak overwrite
        return null;
    }

    if ($_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'message' => "Error upload file {$fieldName}."]);
        exit;
    }

    $file = $_FILES[$fieldName];
    if ($file['size'] > $maxFileSize) {
        echo json_encode(['success' => false, 'message' => "Ukuran file {$fieldName} melebihi 1MB."]);
        exit;
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExts)) {
        echo json_encode(['success' => false, 'message' => "Tipe file {$fieldName} tidak diperbolehkan."]);
        exit;
    }

    $filename = "{$customName}.{$ext}";
    $destination = $uploadDir . $filename;

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return $filename;  // Kembalikan hanya nama file, tanpa path
    } else {
        echo json_encode(['success' => false, 'message' => "Gagal mengupload file {$fieldName}."]);
        exit;
    }
}

$year = date('Y');
$formattedId = str_pad($id_pengajuan, 3, '0', STR_PAD_LEFT);

$laporan_kegiatan = uploadFile('laporan_kegiatan', ['pdf', 'docx'], "LK-{$formattedId}_{$year}");
$lpj = uploadFile('lpj', ['pdf', 'xlsx'], "LPJ-{$formattedId}_{$year}");
$sertifikat_pelatihan = uploadFile('sertifikat_pelatihan', ['pdf', 'jpg', 'png'], "SP-{$formattedId}_{$year}");
$sertifikat_kompetensi = uploadFile('sertifikat_kompetensi', ['pdf', 'jpg', 'png'], "SK-{$formattedId}_{$year}");

// Cek apakah data sudah ada di tbl_berkas berdasarkan id_pengajuan
$stmt_check = $koneksi->prepare("SELECT id_pengajuan FROM tbl_berkas WHERE id_pengajuan = ?");
$stmt_check->bind_param("s", $id_pengajuan);
$stmt_check->execute();
$stmt_check->store_result();

if ($stmt_check->num_rows > 0) {
    // Update data jika sudah ada
    $sql_update = "UPDATE tbl_berkas SET 
        laporan_kegiatan = COALESCE(?, laporan_kegiatan),
        lpj = COALESCE(?, lpj),
        sertifikat_pelatihan = COALESCE(?, sertifikat_pelatihan),
        sertifikat_kompetensi = COALESCE(?, sertifikat_kompetensi)
        WHERE id_pengajuan = ?";
    $stmt_update = $koneksi->prepare($sql_update);
    $stmt_update->bind_param(
        "sssss",
        $laporan_kegiatan,
        $lpj,
        $sertifikat_pelatihan,
        $sertifikat_kompetensi,
        $id_pengajuan
    );
    if ($stmt_update->execute()) {
        echo json_encode(['success' => true, 'message' => 'Dokumen berhasil diperbarui.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal memperbarui data: ' . $stmt_update->error]);
    }
    $stmt_update->close();
} else {
    // Insert data baru
    $stmt_insert = $koneksi->prepare("INSERT INTO tbl_berkas (id_pengajuan, laporan_kegiatan, lpj, sertifikat_pelatihan, sertifikat_kompetensi) VALUES (?, ?, ?, ?, ?)");
    $stmt_insert->bind_param(
        "sssss",
        $id_pengajuan,
        $laporan_kegiatan,
        $lpj,
        $sertifikat_pelatihan,
        $sertifikat_kompetensi
    );
    if ($stmt_insert->execute()) {
        echo json_encode(['success' => true, 'message' => 'Dokumen berhasil diunggah.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menyimpan ke database: ' . $stmt_insert->error]);
    }
    $stmt_insert->close();
}

$stmt_check->close();
$koneksi->close();
?>
