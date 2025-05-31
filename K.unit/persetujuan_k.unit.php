<?php
session_start();
$judul = 'Persetujuan Pengajuan Kepala Unit';
include '../header.php';
include 'sidebar_k.unit.php';
include '../koneksi.php'; // pastikan ini menghubungkan ke database

// Ambil ID pengajuan dari parameter URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data pengajuan
$query_pengajuan = mysqli_query($koneksi, "SELECT * FROM tbl_pengajuan WHERE id_pengajuan = $id");
$data = mysqli_fetch_assoc($query_pengajuan);

// Ambil data peserta pelatihan
$query_peserta = mysqli_query($koneksi, "SELECT * FROM tbl_peserta WHERE id_pengajuan = $id");

$query_approval = mysqli_query($koneksi, "SELECT * FROM tbl_approval WHERE id_pengajuan = $id");
$data_approval = mysqli_fetch_assoc($query_approval);

if (
    $data_approval['approval_kunit'] == 1
) {
    $status = 'Disetujui';
    $btn_class = 'btn-success';
} else {
    $status = 'Menunggu Persetujuan';
    $btn_class = 'btn-warning';
}
$nama_file = htmlspecialchars($data['dokumen']);
$parts = explode('-', $nama_file);
$nama_singkat = isset($parts[0]) && isset($parts[1]) ? $parts[0] . '-' . $parts[1] : $nama_file;

$isDisabled = in_array($data_approval['approval_kunit'], [1, 2]) ? 'disabled' : '';
?>

<body>
    <div class="main-panel">
        <div class="container">
            <div class="panel-header bg-primary-gradient">
                <div class="page-inner py-5">
                    <div class="page-header text-white">
                        <!-- judul halaman -->
                        <h4 class="page-title text-white"><i class="fas fa-file-signature mr-2"></i>Persetujuan
                            Pengajuan</h4>
                        <!-- breadcrumbs -->
                        <ul class="breadcrumbs">
                            <li class="nav-home"><a href="dashboard.php"><i class="flaticon-home text-white"></i></a>
                            </li>
                            <li class="separator"><i class="flaticon-right-arrow"></i></li>
                            <li class="nav-item"><a href="data_persetujuan_k.unit.php" class="text-white">Persetujuan
                                    Pengajuan</a></li>
                            <li class="separator"><i class="flaticon-right-arrow"></i></li>
                            <li class="nav-item"><a href="data_persetujuan_k.unit.php" class="text-white">Data
                                    Persetujuan</a></li>
                            <li class="separator"><i class="flaticon-right-arrow"></i></li>
                            <li class="nav-item"><a>Detail Persetujuan</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="page-inner mt--5">
                <div class="row">
                    <!-- Card Persetujuan (KIRI) -->
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header text-white">
                                <h4 class="card-title mb-0">Daftar Persetujuan Pengajuan</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-bordered">
                                    <tbody>
                                        <tr>
                                            <th class="bg-light" style="width: 35%;">Status Pengajuan</th>
                                            <td><button
                                                    class="btn btn-sm <?php echo $btn_class; ?>"><?php echo $status; ?></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Nama Pengaju Pelatihan</th>
                                            <td><?php echo htmlspecialchars($data['nama_pengaju']); ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Nama Kegiatan</th>
                                            <td><?php echo htmlspecialchars($data['nama_kegiatan']); ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Jenis Pelatihan/Pengembangan</th>
                                            <td><?php echo htmlspecialchars($data['jenis_kegiatan']); ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Lembaga/Institusi</th>
                                            <td><?php echo htmlspecialchars($data['nama_lembaga']); ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Kompetensi</th>
                                            <td><?php echo htmlspecialchars($data['jenis_kompetensi']); ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Target yang ingin dicapai</th>
                                            <td><?php echo htmlspecialchars($data['target_pelatihan']); ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Tempat</th>
                                            <td><?php echo htmlspecialchars($data['alamat']); ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Tanggal Mulai & Selesai Kegiatan</th>
                                            <td><?php echo date('d M Y', strtotime($data['tanggal_mulai'])) . " - " . date('d M Y', strtotime($data['tanggal_selesai'])); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Sumber Dana (Kode Account)</th>
                                            <td><?php echo htmlspecialchars($data['kode_akun']); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Nama Peserta Pelatihan -->
                            <div class="card-body">
                                <h5 class="card-title">Nama Peserta Pelatihan</h5>
                                <br>
                                <div class="table-responsive">
                                    <table id="datatable-peserta" class="table table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th style="width: 10%;">No</th>
                                                <th>Nama Peserta</th>
                                                <th>NIK</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            while ($peserta = mysqli_fetch_assoc($query_peserta)) {
                                                echo "<tr>";
                                                echo "<td>{$no}</td>";
                                                echo "<td>" . htmlspecialchars($peserta['nama_peserta']) . "</td>";
                                                echo "<td>" . htmlspecialchars($peserta['nik_peserta']) . "</td>";
                                                echo "</tr>";
                                                $no++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Dokumen Pendukung -->
                            <!-- Dokumen Pendukung -->
                            <div class="form-group row align-items-center">
                                <label class="col-lg-3 col-md-3 col-sm-4 text-sm-right font-weight-bold">
                                    Dokumen yang Diupload:
                                </label>
                                <div class="col-lg-5 col-md-9 col-sm-8">
                                    <p class="mb-0" style="margin-top: -13px;">
                                        <a href="../Upload/Pendukung/<?php echo htmlspecialchars($data['dokumen']); ?>"
                                            target="_blank" class="text-primary d-inline-flex align-items-center"
                                            title="Download Proposal Pelatihan">
                                            <i class="bi bi-file-earmark-pdf-fill mr-2" style="font-size: 1.25rem;"></i>
                                            <?php echo $nama_singkat; ?>
                                        </a>
                                    </p>
                                </div>
                            </div>
                            <div class="card-action">
                                <button class="btn btn-primary" onclick="window.history.back();">Kembali</button>
                            </div>
                        </div>
                    </div>
                    <!-- Card Status (KANAN) -->
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0">Status</h4>
                                <span id="status-indicator" class="rounded-circle"
                                    style="width: 14px; height: 14px; background-color: #1572E8;"></span>
                            </div>
                            <div class="card-body">
                                <select id="approval_kunit" class="form-control">
                                    <option value="0" <?php echo ($data_approval['approval_kunit'] == 0) ? 'selected' : ''; ?>>Menunggu</option>
                                    <option value="1" <?php echo ($data_approval['approval_kunit'] == 1) ? 'selected' : ''; ?>>Disetujui</option>
                                    <option value="2" <?php echo ($data_approval['approval_kunit'] == 2) ? 'selected' : ''; ?>>Ditolak</option>
                                </select>
                                <small class="text-muted d-block mt-2">Tetapkan status pengajuan.</small>
                            </div>
                        </div>
                        <!-- Card Komentar -->
                        <div class="card mt-3">
                            <div class="card-header text-white">
                                <h4 class="card-title mb-0">Komentar</h4>
                            </div>
                            <div class="card-body">
                                <textarea class="form-control" rows="4" placeholder="Tambahkan komentar..."
                                    name="komentar_kunit" <?php echo $isDisabled; ?>><?php echo htmlspecialchars($data_approval['komentar_kunit']); ?></textarea>
                                <br>
                                <?php if ($data_approval['approval_kepegawaian'] == 1): ?>
                                    <?php if (!in_array($data_approval['approval_kunit'], [1])): ?>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-success mt-2" onclick="kirim()">Kirim</button>
                                        </div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <div class="alert alert-warning mt-3 text-center" role="alert">
                                        <strong>Perhatian:</strong> Kepegawaian belum selesai melakukan pengecekan
                                        kelengkapan berkas.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include '../footer.php' ?>
    </div>

    <script>
        function kirim() {
            const id_pengajuan = <?php echo $id; ?>;
            const komentar_kunit = $('textarea[name="komentar_kunit"]').val();
            const approval_kunit = $('#approval_kunit').val();

            $.ajax({
                url: './proses/simpan_approval.php',
                method: 'POST',
                data: {
                    komentar_kunit: komentar_kunit,
                    approval_kunit: approval_kunit,
                    id_pengajuan: id_pengajuan
                },
                success: function (res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Data berhasil disimpan.'
                    }).then(() => {
                        window.location.href = 'data_persetujuan_k.unit.php';
                    });
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan: ' + error
                    });
                }
            });
        }

        $(document).ready(function () {
            $('#datatable-peserta').DataTable({
                "lengthMenu": [10, 25, 50, 100],
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ data ",
                    "zeroRecords": "Belum ada data pengajuan",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                    "paginate": {
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    }
                }
            });
        });
    </script>