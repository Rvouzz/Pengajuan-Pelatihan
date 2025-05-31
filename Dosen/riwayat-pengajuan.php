<?php $judul = 'Pengajuan Saya';
include '../header.php';
include 'sidebar_dosen.php' ?>

<body>
    <div class="main-panel">
        <div class="container">
            <div class="panel-header bg-primary-gradient">
                <div class="page-inner py-5">
                    <div class="page-header text-white">
                        <!-- judul halaman -->
                        <h4 class="page-title text-white"><i class="fas fa-tasks mr-2"></i>Pengajuan Saya</h4>
                        <!-- breadcrumbs -->
                        <ul class="breadcrumbs">
                            <li class="nav-home"><a href="dashboard.php"><i class="flaticon-home text-white"></i></a>
                            </li>
                            <li class="separator"><i class="flaticon-right-arrow"></i></li>
                            <li class="nav-item"><a href="riwayat-pengajuan.php" class="text-white">Pengajuan Saya</a>
                            </li>
                            <li class="separator"><i class="flaticon-right-arrow"></i></li>
                            <li class="nav-item"><a>Data Pengajuan</a></li>
                        </ul>
                        <div class="ml-md-auto py-2 py-md-0">
                            <a href="pengajuan.php" class="btn btn-primary btn-round">
                                <span class="btn-label">
                                    <i class="fa fa-plus"></i>
                                </span>
                                Tambah Pengajuan
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page-inner mt--5">
                <div class="card card-with-nav">
                    <div class="card-header">
                        <div class="row row-nav-line">
                            <ul class="nav nav-tabs nav-line nav-color-primary w-100 pl-4" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#daftar" role="tab"
                                        aria-selected="true">
                                        <i class="fas fa-list-ul mr-2"></i> Riwayat Pengajuan
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#surat" role="tab"
                                        aria-selected="false">
                                        <i class="fas fa-envelope mr-2"></i> Surat Tugas
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="tab-content">
                            <!-- Tab Riwayat Pengajuan -->
                            <div class="tab-pane fade show active" id="daftar">
                                <div class="box-body table-responsive">

                                    <table id="add-row" class="display table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Nama pengaju</th>
                                                <th class="text-center">Jenis Pelatihan</th>
                                                <th class="text-center">Tanggal Mulai</th>
                                                <th class="text-center">Tanggal Selesai</th>
                                                <th class="text-center">Disetujui KPJ</th>
                                                <th class="text-center">Disetujui Kepala Unit</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-pengajuan">
                                            <!-- Data akan dimuat secara dinamis -->
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                            <!-- Tab surat tugas -->
                            <div class="tab-pane fade" id="surat">
                                <div class="box-body table-responsive">
                                    <table id="table_surat" class="display table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Nama Pengaju</th>
                                                <th class="text-center">Jenis Pelatihan</th>
                                                <th class="text-center">Nomor Surat</th>
                                                <th class="text-center">Tanggal Surat</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody_surat">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include '../footer.php' ?>
    </div>

    <script>
        $(document).ready(function () {
            loadPengajuan();
            loadSurat();

            function loadPengajuan() {
                $.ajax({
                    url: './proses/get_pengajuan.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        var tbody = $('#tbody-pengajuan');
                        tbody.empty();

                        if ($.fn.DataTable.isDataTable('#add-row')) {
                            $('#add-row').DataTable().destroy();
                        }

                        if (response.length > 0) {
                            $.each(response, function (index, item) {
                                var editButton = '';
                                if (item.approval_kepegawaian !== 1) {
                                    // Tampilkan tombol Edit hanya jika approval_kepegawaian bukan 1
                                    editButton = `
                            <a class="dropdown-item text-warning" href="edit_pengajuan.php?id=${item.id}">
                                <i class="fas fa-edit mr-2"></i> Edit
                            </a>
                        `;
                                }

                                var row = `
                        <tr>
                            <td class="text-center">${index + 1}</td>
                            <td class="text-center">${item.nama_pengaju}</td>
                            <td class="text-center">${item.jenis_kegiatan}</td>
                            <td class="text-center">${item.tanggal_mulai}</td>
                            <td class="text-center">${item.tanggal_selesai}</td>
                            <td class="text-center">
                                <button class="btn btn-${item.approval_kpj_class} btn-xs">${item.approval_kpj_text}</button>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-${item.approval_kunit_class} btn-xs">${item.approval_kunit_text}</button>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button class="btn btn-secondary btn-xs dropdown-toggle" type="button" data-toggle="dropdown">
                                        Aksi
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a class="dropdown-item text-info" href="detail_pengajuan.php?id=${item.id}">
                                                <i class="fas fa-info-circle mr-2"></i> Detail
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            ${editButton}
                                            <a class="dropdown-item text-danger" href="#" onclick="hapusPengajuan(${item.id})">
                                                <i class="fas fa-trash-alt mr-2"></i> Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    `;
                                tbody.append(row);
                            });
                        }

                        $('#add-row').DataTable({
                            "lengthMenu": [10, 25, 50, 100],
                            "language": {
                                "search": "Cari:",
                                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                                "zeroRecords": "Belum ada data pengajuan",
                                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                                "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                                "paginate": {
                                    "next": "Berikutnya",
                                    "previous": "Sebelumnya"
                                }
                            }
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error('Gagal ambil data:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal ambil data',
                            text: error
                        });
                    }
                });
            }

            function loadSurat() {
                $.ajax({
                    url: './proses/get_surat.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if ($.fn.DataTable.isDataTable('#table_surat')) {
                            $('#table_surat').DataTable().clear().destroy();
                        }

                        var tbody = $('#tbody_surat');
                        tbody.empty();

                        if (Array.isArray(response) && response.length > 0) {
                            $.each(response, function (index, item) {
                                var fileLink = (item.file_surat && item.file_surat !== '#')
                                    ? '../Upload/Surat_Tugas/' + item.file_surat
                                    : '#';

                                var row = `
                        <tr>
                            <td class="text-center">${index + 1}</td>
                            <td class="text-center">${item.nama_pengaju}</td>
                            <td class="text-center">${item.jenis_kegiatan}</td>
                            <td class="text-center">${item.nomor_surat}</td>
                            <td class="text-center">${item.tanggal_surat}</td>
                            <td class="text-center">
                                ${fileLink !== '#' ? `<a href="${fileLink}" download class="btn btn-sm btn-primary">Download</a>` : '-'}
                            </td>
                        </tr>
                    `;
                                tbody.append(row);
                            });
                        }

                        $('#table_surat').DataTable({
                            "lengthMenu": [10, 25, 50, 100],
                            "language": {
                                "search": "Cari:",
                                "lengthMenu": "Tampilkan _MENU_ data ",
                                "zeroRecords": "Belum ada data Penerbitan Surat Tugas",
                                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                                "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                                "paginate": {
                                    "next": "Berikutnya",
                                    "previous": "Sebelumnya"
                                }
                            }
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error('Gagal ambil data:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal ambil data',
                            text: error
                        });
                    }
                });
            }


            window.hapusPengajuan = function (id) {
                Swal.fire({
                    title: 'Yakin ingin hapus?',
                    text: 'Data akan dihapus secara permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: './proses/hapus_pengajuan.php',
                            type: 'POST',
                            data: { id: id },
                            success: function (response) {
                                Swal.fire('Dihapus!', 'Data berhasil dihapus.', 'success');
                                window.location.reload();
                            },
                            error: function (err) {
                                Swal.fire('Gagal', 'Gagal menghapus data', 'error');
                            }
                        });
                    }
                });
            };
        });

    </script>