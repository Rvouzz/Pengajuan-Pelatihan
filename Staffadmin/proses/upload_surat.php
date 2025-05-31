<?php
include '../../koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pengajuan = $_POST['id_pengajuan'];
    $file = $_FILES['file'];

    // Ambil ekstensi file
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if ($ext !== 'pdf') {
        http_response_code(400);
        echo json_encode(['error' => 'Hanya file PDF yang diperbolehkan.']);
        exit;
    }

    // Format nomor surat: ST-XXX/YYYY (contoh: ST-007/2025)
    $tahun = date('Y');
    $id_format = str_pad($id_pengajuan, 3, '0', STR_PAD_LEFT);
    $nomor_surat = "ST-$id_format/$tahun";

    // Simpan file: ST-007_2025.pdf
    $file_name = "ST-$id_format" . "_$tahun." . $ext;
    $upload_dir = '../../Upload/Surat_Tugas/';
    $tujuan = $upload_dir . $file_name;

    // Pastikan folder ada
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if (move_uploaded_file($file['tmp_name'], $tujuan)) {
        // Insert ke database
        $query = "INSERT INTO tbl_surat (id_pengajuan, nomor_surat, file_surat, tanggal_surat)
                  VALUES (?, ?, ?, CURDATE())";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("sss", $id_pengajuan, $nomor_surat, $file_name);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Gagal menyimpan ke database.']);
        }

        $stmt->close();
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Gagal mengunggah file.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Metode tidak diizinkan.']);
}
?>
