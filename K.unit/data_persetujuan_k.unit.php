<?php
session_start();
$judul = 'Data Persetujuan';
include '../header.php';
include 'sidebar_k.unit.php';
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
                        </ul>
                    </div>
                </div>
            </div>
            <div class="page-inner mt--5">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Daftar Persetujuan Pengajuan</h4>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <table id="table_persetujuan" class="display table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama Pengaju</th>
                                        <th class="text-center">Jenis Pelatihan</th>
                                        <th class="text-center">Tanggal Mulai</th>
                                        <th class="text-center">Tanggal Selesai</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-persetujuan">

                                </tbody>
                            </table>

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

            function loadPengajuan() {
                $.ajax({
                    url: './proses/get_pengajuan.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        var tbody = $('#tbody-persetujuan');
                        tbody.empty();

                        if ($.fn.DataTable.isDataTable('#table_persetujuan')) {
                            $('#table_persetujuan').DataTable().destroy();
                        }

                        if (response.length > 0) {
                            $.each(response, function (index, item) {
                                var row = `
                        <tr>
                            <td class="text-center">${index + 1}</td>
                            <td class="text-center">${item.nama_pengaju}</td>
                            <td class="text-center">${item.jenis_kegiatan}</td>
                            <td class="text-center">${item.tanggal_mulai}</td>
                            <td class="text-center">${item.tanggal_selesai}</td>
                            <td class="text-center">
                                <button class="btn btn-${item.approval_kunit_class} btn-xs">${item.approval_kunit_text}</button>
                            </td>
                            <td class="text-center">
                            <a href="persetujuan_k.unit.php?id=${item.id}" class="btn btn-primary btn-sm">
                                <i class="fas fa-info-circle mr-2"></i> Detail
                            </a>
                        </td>
                        </tr>
                    `;
                                tbody.append(row);
                            });
                        }

                        $('#table_persetujuan').DataTable({
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
        });

    </script>