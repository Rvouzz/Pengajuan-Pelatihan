<?php
include '../../koneksi.php';

// Fungsi untuk membersihkan input agar aman dari SQL Injection
function clean_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari POST dan bersihkan
    $nama_pengaju     = clean_input($_POST['nama_pengaju'] ?? '');
    $nama_kegiatan    = clean_input($_POST['nama_kegiatan'] ?? '');
    $jenis_kegiatan   = clean_input($_POST['jenis_kegiatan'] ?? '');
    $nama_lembaga     = clean_input($_POST['nama_lembaga'] ?? '');
    $jenis_kompetensi = clean_input($_POST['jenis_kompetensi'] ?? '');
    $target_pelatihan = clean_input($_POST['target_pelatihan'] ?? '');
    $alamat           = clean_input($_POST['alamat'] ?? '');
    $tanggal_mulai    = clean_input($_POST['tanggal_mulai'] ?? '');
    $tanggal_selesai  = clean_input($_POST['tanggal_selesai'] ?? '');
    $jurusan          = clean_input($_POST['jurusan'] ?? '');
    $program_studi    = clean_input($_POST['program_studi'] ?? '');
    $kode_akun        = clean_input($_POST['kode_akun'] ?? '');

    // Folder penyimpanan dokumen
    $upload_dir = '../../Upload/Pendukung/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $uploaded_files = [];

    // Proses multiple file upload
    if (!empty($_FILES['dokumen'])) {
        $files = $_FILES['dokumen'];

        for ($i = 0; $i < count($files['name']); $i++) {
            $original_name = $files['name'][$i];
            $tmp_name = $files['tmp_name'][$i];
            $error = $files['error'][$i];

            if ($error === UPLOAD_ERR_OK) {
                $ext = pathinfo($original_name, PATHINFO_EXTENSION);
                $datetime = date('YmdHis');
                $new_filename = "RAB-" . $datetime . "-" . uniqid() . "." . $ext;
                $destination = $upload_dir . $new_filename;

                if (move_uploaded_file($tmp_name, $destination)) {
                    $uploaded_files[] = $new_filename;
                } else {
                    echo json_encode(['status' => false, 'message' => "Gagal upload file $original_name"]);
                    exit;
                }
            } else {
                echo json_encode(['status' => false, 'message' => "Error upload file $original_name"]);
                exit;
            }
        }
    } else {
        echo json_encode(['status' => false, 'message' => "Tidak ada file yang diupload"]);
        exit;
    }

    // Simpan nama file ke database (dipisah dengan koma)
    $dokumen_db = implode(',', $uploaded_files);

    // Query insert ke tbl_pengajuan
    $sql = "INSERT INTO tbl_pengajuan 
            (nama_pengaju, nama_kegiatan, jenis_kegiatan, nama_lembaga, jenis_kompetensi, target_pelatihan, alamat, tanggal_mulai, tanggal_selesai, jurusan, program_studi, kode_akun, dokumen) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param(
        "sssssssssssss",
        $nama_pengaju,
        $nama_kegiatan,
        $jenis_kegiatan,
        $nama_lembaga,
        $jenis_kompetensi,
        $target_pelatihan,
        $alamat,
        $tanggal_mulai,
        $tanggal_selesai,
        $jurusan,
        $program_studi,
        $kode_akun,
        $dokumen_db
    );

    if ($stmt->execute()) {
        $id_pengajuan = $stmt->insert_id;

        // ✅ Tambahkan data ke tbl_approval
        $query_insert_approval = "INSERT INTO tbl_approval (id_pengajuan) VALUES (?)";
        $stmt_approval = $koneksi->prepare($query_insert_approval);
        $stmt_approval->bind_param("i", $id_pengajuan);

        if (!$stmt_approval->execute()) {
            echo json_encode(['status' => false, 'message' => 'Gagal insert ke tbl_approval: ' . $stmt_approval->error]);
            exit;
        }

        $stmt_approval->close();

        // Ambil data dari temp_peserta
        $query_temp = "SELECT nama_peserta, nik_peserta FROM temp_peserta WHERE nama_pengaju = ?";
        $stmt_temp = $koneksi->prepare($query_temp);
        $stmt_temp->bind_param("s", $nama_pengaju);
        $stmt_temp->execute();
        $result_temp = $stmt_temp->get_result();

        if ($result_temp->num_rows === 0) {
            echo json_encode(['status' => false, 'message' => 'Tidak ada data peserta di temp_peserta untuk nama_pengaju tersebut']);
            exit;
        }

        // Insert data peserta ke tbl_peserta
        $query_insert_peserta = "INSERT INTO tbl_peserta (id_pengajuan, nama_peserta, nik_peserta) VALUES (?, ?, ?)";
        $stmt_insert = $koneksi->prepare($query_insert_peserta);

        while ($row = $result_temp->fetch_assoc()) {
            if (empty($row['nama_peserta']) || empty($row['nik_peserta'])) {
                echo json_encode(['status' => false, 'message' => 'Data peserta kosong']);
                exit;
            }

            $stmt_insert->bind_param("iss", $id_pengajuan, $row['nama_peserta'], $row['nik_peserta']);
            if (!$stmt_insert->execute()) {
                echo json_encode(['status' => false, 'message' => 'Gagal insert peserta: ' . $stmt_insert->error]);
                exit;
            }
        }

        $stmt_insert->close();
        $stmt_temp->close();

        // Hapus data dari temp_peserta
        $query_delete_temp = "DELETE FROM temp_peserta WHERE nama_pengaju = ?";
        $stmt_delete = $koneksi->prepare($query_delete_temp);
        $stmt_delete->bind_param("s", $nama_pengaju);
        $stmt_delete->execute();
        $stmt_delete->close();

        echo json_encode(['status' => true, 'message' => 'Data berhasil disimpan dan peserta dipindahkan']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Gagal menyimpan data pengajuan: ' . $stmt->error]);
    }

    $stmt->close();
    $koneksi->close();
} else {
    echo json_encode(['status' => false, 'message' => 'Metode request tidak valid']);
}
?>
