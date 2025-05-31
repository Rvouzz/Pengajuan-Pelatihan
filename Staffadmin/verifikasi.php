<?php
session_start();
$judul = 'Verifikasi Berkas Pengajuan';
include '../header.php';
include 'sidebar_staffadmin.php';
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
    $data_approval['approval_kepegawaian'] == 1
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

$isDisabled = in_array($data_approval['approval_kepegawaian'], [1, 2]) ? 'disabled' : '';
?>

<body>
    <div class="main-panel">
        <div class="container">
            <div class="panel-header bg-primary-gradient">
                <div class="page-inner py-5">
                    <div class="page-header text-white">
                        <!-- judul halaman -->
                        <h4 class="page-title text-white"><i class="fas fa-clipboard-check mr-2"></i>Verifikasi Berkas
                        </h4>
                        <!-- breadcrumbs -->
                        <ul class="breadcrumbs">
                            <li class="nav-home"><a href="dashboard.php"><i class="flaticon-home text-white"></i></a>
                            </li>
                            <li class="separator"><i class="flaticon-right-arrow"></i></li>
                            <li class="nav-item"><a href="data_verifikasi.php" class="text-white">Verifikasi Berkas</a>
                            </li>
                            <li class="separator"><i class="flaticon-right-arrow"></i></li>
                            <li class="nav-item"><a href="data_verifikasi.php" class="text-white">Data Pengajuan</a>
                            </li>
                            <li class="separator"><i class="flaticon-right-arrow"></i></li>
                            <li class="nav-item"><a>Detail Pemeriksaan</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="page-inner mt--5">
                    <div class="row">
                        <!-- Card Persetujuan (KIRI) -->
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-header text-white">
                                    <h4 class="card-title mb-0">Detail Pengajuan</h4>
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
                                <div class="card-body">
                                    <h5 class="card-title">Dokumen yang Diupload:</h5>
                                    <br>
                                    <div class="form-group row">
                                        <div class="col-lg-5 col-md-9 col-sm-8">
                                            <p><a href="../Dokumen/<?php echo htmlspecialchars($data['dokumen']); ?>"
                                                    target="_blank"><?php echo $nama_singkat; ?></a></p>
                                        </div>
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
                                    <h4 class="card-title mb-0">Checklist Kelengkapan Berkas</h4>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex flex-column">
                                        <div class="custom-control custom-checkbox mb-2">
                                            <input type="checkbox" class="custom-control-input" id="kompetensi"
                                                name="kompetensi" <?php echo ($data_approval['kompetensi'] == 1 ? 'checked' : '') . ' ' . $isDisabled; ?>>
                                            <label class="custom-control-label" for="kompetensi">Kompetensi</label>
                                        </div>

                                        <div class="custom-control custom-checkbox mb-2">
                                            <input type="checkbox" class="custom-control-input" id="laporan_pelatihan"
                                                name="laporan_pelatihan" <?php echo ($data_approval['laporan_pelatihan'] == 1 ? 'checked' : '') . ' ' . $isDisabled; ?>>
                                            <label class="custom-control-label" for="laporan_pelatihan">Laporan
                                                pelatihan/pengembangan sebelumnya</label>
                                        </div>

                                        <div class="custom-control custom-checkbox mb-2">
                                            <input type="checkbox" class="custom-control-input" id="anggaran_dipa"
                                                name="anggaran_dipa" <?php echo ($data_approval['anggaran_dipa'] == 1 ? 'checked' : '') . ' ' . $isDisabled; ?>>
                                            <label class="custom-control-label"
                                                for="anggaran_dipa">Anggaran/DIPA</label>
                                        </div>

                                        <div class="custom-control custom-checkbox mb-2">
                                            <input type="checkbox" class="custom-control-input" id="ketersediaan_sd"
                                                name="ketersediaan_sd" <?php echo ($data_approval['ketersediaan_sd'] == 1 ? 'checked' : '') . ' ' . $isDisabled; ?>>
                                            <label class="custom-control-label" for="ketersediaan_sd">Ketersediaan
                                                sumber daya</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="tujuan_sasaran"
                                                name="tujuan_sasaran" <?php echo ($data_approval['tujuan_sasaran'] == 1 ? 'checked' : '') . ' ' . $isDisabled; ?>>
                                            <label class="custom-control-label"
                                                for="tujuan_sasaran">Tujuan/sasaran</label>
                                        </div>
                                    </div>
                                    <br>
                                    <textarea class="form-control" rows="4" placeholder="Tambahkan komentar..."
                                        name="komentar_kepegawaian" <?php echo $isDisabled; ?>><?php echo htmlspecialchars($data_approval['komentar_kepegawaian']); ?></textarea>
                                </div>

                            </div>

                            <!-- status -->
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-0">Status</h4>
                                    <span id="status-indicator" class="rounded-circle"
                                        style="width: 14px; height: 14px; background-color: #1572E8;"></span>
                                </div>
                                <div class="card-body">
                                    <select id="status-select" name="status" class="form-control">
                                        <option value="0" <?php echo ($data_approval['approval_kepegawaian'] == 0) ? 'selected' : ''; ?>>-- Pilih Status --</option>
                                        <option value="1" <?php echo ($data_approval['approval_kepegawaian'] == 1) ? 'selected' : ''; ?>>Disetujui</option>
                                        <option value="2" <?php echo ($data_approval['approval_kepegawaian'] == 2) ? 'selected' : ''; ?>>Ditolak</option>
                                    </select>
                                    <small class="text-muted d-block mt-2">Tetapkan status pengajuan.</small>
                                    <br>
                                    <?php if (!in_array($data_approval['approval_kepegawaian'], [1, 2])): ?>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-success mt-2" onclick="kirim()">Kirim</button>
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
                const kompetensi = $('#kompetensi').is(':checked') ? 1 : 0;
                const laporanPelatihan = $('#laporan_pelatihan').is(':checked') ? 1 : 0;
                const anggaranDipa = $('#anggaran_dipa').is(':checked') ? 1 : 0;
                const ketersediaanSd = $('#ketersediaan_sd').is(':checked') ? 1 : 0;
                const tujuanSasaran = $('#tujuan_sasaran').is(':checked') ? 1 : 0;
                const id_pengajuan = <?php echo $id; ?>;
                const komentarKepegawaian = $('textarea[name="komentar_kepegawaian"]').val();
                const status = $('#status-select').val();

                $.ajax({
                    url: './proses/simpan_approval.php',
                    method: 'POST',
                    data: {
                        kompetensi: kompetensi,
                        laporan_pelatihan: laporanPelatihan,
                        anggaran_dipa: anggaranDipa,
                        ketersediaan_sd: ketersediaanSd,
                        tujuan_sasaran: tujuanSasaran,
                        komentar_kepegawaian: komentarKepegawaian,
                        status: status,
                        id_pengajuan: id_pengajuan
                    },
                    success: function (res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Data berhasil disimpan.'
                        }).then(() => {
                            window.location.href = 'data_verifikasi.php';
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