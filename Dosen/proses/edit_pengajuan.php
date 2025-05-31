<?php
include '../../koneksi.php';

function clean_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pengajuan     = clean_input($_POST['id_pengajuan'] ?? '');
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

    // Ambil nilai kompetensi dan lainnya dari form
    $kompetensi_post       = intval($_POST['kompetensi'] ?? 0);
    $laporan_pelatihan_post = intval($_POST['laporan_pelatihan'] ?? 0);
    $anggaran_dipa_post    = intval($_POST['anggaran_dipa'] ?? 0);
    $ketersediaan_sd_post  = intval($_POST['ketersediaan_sd'] ?? 0);
    $tujuan_sasaran_post   = intval($_POST['tujuan_sasaran'] ?? 0);

    $upload_dir = '../../Dokumen/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $dokumen_db = null;
    $dokumen_uploaded = false;

    if (!empty($_FILES['dokumen']) && count(array_filter($_FILES['dokumen']['name'])) > 0) {
        $files = $_FILES['dokumen'];
        $uploaded_files = [];

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
                    $dokumen_uploaded = true;
                } else {
                    echo json_encode(['status' => false, 'message' => "Gagal upload file $original_name"]);
                    exit;
                }
            } else {
                echo json_encode(['status' => false, 'message' => "Error upload file $original_name"]);
                exit;
            }
        }

        $dokumen_db = implode(',', $uploaded_files);
    }

    if ($dokumen_uploaded) {
        $sql = "UPDATE tbl_pengajuan SET 
                    nama_kegiatan = ?, jenis_kegiatan = ?, nama_lembaga = ?, jenis_kompetensi = ?, 
                    target_pelatihan = ?, alamat = ?, tanggal_mulai = ?, tanggal_selesai = ?, 
                    jurusan = ?, program_studi = ?, kode_akun = ?, dokumen = ?
                WHERE id_pengajuan = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("ssssssssssssi",
            $nama_kegiatan, $jenis_kegiatan, $nama_lembaga, $jenis_kompetensi, $target_pelatihan,
            $alamat, $tanggal_mulai, $tanggal_selesai, $jurusan, $program_studi,
            $kode_akun, $dokumen_db, $id_pengajuan
        );
    } else {
        $sql = "UPDATE tbl_pengajuan SET 
                    nama_kegiatan = ?, jenis_kegiatan = ?, nama_lembaga = ?, jenis_kompetensi = ?, 
                    target_pelatihan = ?, alamat = ?, tanggal_mulai = ?, tanggal_selesai = ?, 
                    jurusan = ?, program_studi = ?, kode_akun = ?
                WHERE id_pengajuan = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("sssssssssssi",
            $nama_kegiatan, $jenis_kegiatan, $nama_lembaga, $jenis_kompetensi, $target_pelatihan,
            $alamat, $tanggal_mulai, $tanggal_selesai, $jurusan, $program_studi,
            $kode_akun, $id_pengajuan
        );
    }

    if ($stmt->execute()) {
        // ✅ Lanjut update tbl_approval
        $query_old = "SELECT kompetensi, laporan_pelatihan, anggaran_dipa, ketersediaan_sd, tujuan_sasaran 
                      FROM tbl_approval WHERE id_pengajuan = ?";
        $stmt_old = $koneksi->prepare($query_old);
        $stmt_old->bind_param("i", $id_pengajuan);
        $stmt_old->execute();
        $result_old = $stmt_old->get_result();

        if ($result_old->num_rows > 0) {
            $row_old = $result_old->fetch_assoc();

            $kompetensi        = ($row_old['kompetensi'] == 1)        ? 1 : $kompetensi_post;
            $laporan_pelatihan = ($row_old['laporan_pelatihan'] == 1) ? 1 : $laporan_pelatihan_post;
            $anggaran_dipa     = ($row_old['anggaran_dipa'] == 1)     ? 1 : $anggaran_dipa_post;
            $ketersediaan_sd   = ($row_old['ketersediaan_sd'] == 1)   ? 1 : $ketersediaan_sd_post;
            $tujuan_sasaran    = ($row_old['tujuan_sasaran'] == 1)    ? 1 : $tujuan_sasaran_post;

            $stmt_old->close();

            $update_approval = "UPDATE tbl_approval SET 
                                    kompetensi = ?, laporan_pelatihan = ?, anggaran_dipa = ?, 
                                    ketersediaan_sd = ?, tujuan_sasaran = ?, 
                                    approval_kepegawaian = 0, approval_kpj = 0, approval_kunit = 0, komentar_kepegawaian = NULL, nama_kepegawaian = NULL 
                                WHERE id_pengajuan = ?";
            $stmt_upd = $koneksi->prepare($update_approval);
            $stmt_upd->bind_param("iiiiii", 
                $kompetensi, $laporan_pelatihan, $anggaran_dipa, 
                $ketersediaan_sd, $tujuan_sasaran, $id_pengajuan
            );
            $stmt_upd->execute();
            $stmt_upd->close();
        }

        echo json_encode(['status' => true, 'message' => 'Data berhasil diupdate']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Gagal update data pengajuan: ' . $stmt->error]);
    }

    $stmt->close();
    $koneksi->close();
} else {
    echo json_encode(['status' => false, 'message' => 'Metode request tidak valid']);
}
?>
