<?php
include '../../koneksi.php';
session_start(); // penting: untuk mengakses session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_peserta'] ?? '';
    $nik = $_POST['nik_peserta'] ?? '';
    $nama_pengaju = $_SESSION['nama'] ?? ''; // ambil dari session

    if ($nama !== '' && $nik !== '' && $nama_pengaju !== '') {
        $stmt = $koneksi->prepare("INSERT INTO temp_peserta (nama_peserta, nik_peserta, nama_pengaju) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nama, $nik, $nama_pengaju);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Peserta berhasil disimpan']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan ke database']);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
