<?php
$judul = 'Detail Pengajuan';
include '../header.php';
include 'sidebar_dosen.php';
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
    $data_approval['approval_kepegawaian'] == 1 &&
    $data_approval['approval_kpj'] == 1 &&
    $data_approval['approval_kunit'] == 1
) {
    $status = 'Disetujui';
    $btn_class = 'btn-success';
} elseif (
    $data_approval['approval_kepegawaian'] == 2 ||
    $data_approval['approval_kpj'] == 2 ||
    $data_approval['approval_kunit'] == 2
) {
    $status = 'Ditolak';
    $btn_class = 'btn-danger';
} else {
    $status = 'Menunggu Persetujuan';
    $btn_class = 'btn-warning';
}
$nama_file = htmlspecialchars($data['dokumen']);
$parts = explode('-', $nama_file);
$nama_singkat = isset($parts[0]) && isset($parts[1]) ? $parts[0] . '-' . $parts[1] : $nama_file;
?>

<body>
    <div class="main-panel">
        <div class="container">
            <div class="panel-header bg-primary-gradient">
                <div class="page-inner py-5">
                    <div class="page-header text-white">
                        <h4 class="page-title text-white"><i class="fas fa-info-circle mr-2"></i>Detail Pengajuan</h4>
                        <ul class="breadcrumbs">
                            <li class="nav-home"><a href="dashboard.php"><i class="flaticon-home text-white"></i></a>
                            </li>
                            <li class="separator"><i class="flaticon-right-arrow"></i></li>
                            <li class="nav-item"><a href="riwayat-pengajuan.php" class="text-white">Pengajuan Saya</a>
                            </li>
                            <li class="separator"><i class="flaticon-right-arrow"></i></li>
                            <li class="nav-item"><a href="#" class="text-white">Detail</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="page-inner mt--5">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Detail Pengajuan Pelatihan</div>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-bordered">
                            <tbody>
                                <tr>
                                    <th class="bg-light" style="width: 35%;">Status Pengajuan</th>
                                    <td>
                                        <button class="btn btn-sm <?php echo $btn_class; ?>">
                                            <?php echo $status; ?>
                                        </button>
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

                    <div class="card-header">
                        <div class="card-title">Status Kelengkapan Berkas</div>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-bordered">
                            <tbody>
                                <tr>
                                    <th class="bg-light" style="width: 40%;">Kompetensi</th>
                                    <td>
                                        <?php
                                        if ($data_approval['kompetensi'] == 0) {
                                            echo '<button class="btn btn-warning btn-sm">Menunggu</button>';
                                        } else {
                                            echo '<button class="btn btn-success btn-sm">Disetujui</button>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light" style="width: 40%;">Laporan pelatihan/pengembangan sebelumnya
                                    </th>
                                    <td>
                                        <?php
                                        if ($data_approval['laporan_pelatihan'] == 0) {
                                            echo '<button class="btn btn-warning btn-sm">Menunggu</button>';
                                        } else {
                                            echo '<button class="btn btn-success btn-sm">Disetujui</button>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light" style="width: 40%;">Anggaran/DIPA</th>
                                    <td>
                                        <?php
                                        if ($data_approval['anggaran_dipa'] == 0) {
                                            echo '<button class="btn btn-warning btn-sm">Menunggu</button>';
                                        } else {
                                            echo '<button class="btn btn-success btn-sm">Disetujui</button>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light" style="width: 40%;">Ketersediaan sumber daya</th>
                                    <td>
                                        <?php
                                        if ($data_approval['ketersediaan_sd'] == 0) {
                                            echo '<button class="btn btn-warning btn-sm">Menunggu</button>';
                                        } else {
                                            echo '<button class="btn btn-success btn-sm">Disetujui</button>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light" style="width: 40%;">Tujuan/sasaran</th>
                                    <td>
                                        <?php
                                        if ($data_approval['tujuan_sasaran'] == 0) {
                                            echo '<button class="btn btn-warning btn-sm">Menunggu</button>';
                                        } else {
                                            echo '<button class="btn btn-success btn-sm">Disetujui</button>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light" style="width: 40%;">Komentar Kepegawaian</th>
                                    <td><?= htmlspecialchars($data_approval['komentar_kepegawaian'] ?? '-') ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-header">
                        <div class="card-title">Status Approval</div>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-bordered">
                            <tbody>
                                <tr>
                                    <th class="bg-light">Kepala Jurusan</th>
                                    <td>
                                        <small><strong>Nama:</strong>
                                            <?= htmlspecialchars($data_approval['nama_kpj'] ?? '-') ?></small>
                                        <br> <small><strong>Komentar:</strong>
                                            <?= htmlspecialchars($data_approval['komentar_kpj'] ?? '-') ?></small>
                                    </td>
                                    <td>
                                        <?php
                                        if ($data_approval['approval_kpj'] == 1) {
                                            echo '<button class="btn btn-success btn-sm">Disetujui</button>';
                                        } elseif ($data_approval['approval_kpj'] == 0) {
                                            echo '<button class="btn btn-warning btn-sm">Menunggu</button>';
                                        } else {
                                            echo '<button class="btn btn-danger btn-sm">Ditolak</button>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Kepala Unit</th>
                                    <td>
                                        <small><strong>Nama:</strong>
                                            <?= htmlspecialchars($data_approval['nama_kunit'] ?? '-') ?></small>
                                        <br> <small><strong>Komentar:</strong>
                                            <?= htmlspecialchars($data_approval['komentar_kunit'] ?? '-') ?></small>
                                    </td>
                                    <td>
                                        <?php
                                        if ($data_approval['approval_kunit'] == 1) {
                                            echo '<button class="btn btn-success btn-sm">Disetujui</button>';
                                        } elseif ($data_approval['approval_kunit'] == 0) {
                                            echo '<button class="btn btn-warning btn-sm">Menunggu</button>';
                                        } else {
                                            echo '<button class="btn btn-danger btn-sm">Ditolak</button>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Tabel Peserta Pelatihan -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card-header">
                                <div class="card-title">Nama Peserta Pelatihan</div>
                            </div>
                            <div class="card-body">
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
                        </div>

                        <!-- Dokumen Pendukung -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">
                                        <i class="text-primary"></i>Dokumen Pendukung
                                    </h4>
                                </div>
                                <div class="card-body p-0">
                                    <div class="list-group list-group-flush">
                                        <?php if (!empty($data['dokumen'])): ?>
                                            <div
                                                class="list-group-item d-flex justify-content-between align-items-center py-3 px-4">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-file-pdf text-danger mr-3"
                                                        style="font-size: 1.5rem;"></i>
                                                    <div>
                                                        <h6 class="mb-0"><?php echo $nama_singkat; ?>
                                                        </h6>
                                                        <small class="text-muted">PDF</small>
                                                    </div>
                                                </div>
                                                <div class="btn-group">
                                                    <a href="../dokumen/<?php echo htmlspecialchars($data['dokumen']); ?>"
                                                        class="btn btn-sm btn-outline-primary" target="_blank"
                                                        rel="noopener noreferrer">
                                                        <i class="fas fa-eye mr-1"></i> Lihat
                                                    </a>
                                                    <a href="../dokumen/<?php echo htmlspecialchars($data['dokumen']); ?>"
                                                        download class="btn btn-sm btn-outline-success">
                                                        <i class="fas fa-download mr-1"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="list-group-item px-4 py-3">
                                                <em class="text-muted">Tidak ada dokumen terlampir.</em>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->
                </div>
            </div>
            <?php include '../footer.php' ?>
        </div>
    </div>
</body>

<script>
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