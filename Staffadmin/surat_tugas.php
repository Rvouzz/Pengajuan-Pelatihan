<?php $judul = 'Persetujuan Pengajuan';
include '../header.php';
include 'sidebar_staffadmin.php' ?>

<body>
    <div class="main-panel">
        <div class="container">
            <div class="panel-header bg-primary-gradient">
                <div class="page-inner py-5">
                    <div class="page-header text-white">
                        <!-- judul halaman -->
                        <h4 class="page-title text-white"><i class="far fa-envelope mr-2"></i>Penerbitan Surat Tugas
                        </h4>
                        <!-- breadcrumbs -->
                        <ul class="breadcrumbs">
                            <li class="nav-home"><a href="dashboard.php"><i class="flaticon-home text-white"></i></a>
                            </li>
                            <li class="separator"><i class="flaticon-right-arrow"></i></li>
                            <li class="nav-item"><a href="surat_tugas.php" class="text-white">Penerbitan Surat Tugas</a>
                            </li>
                            <li class="separator"><i class="flaticon-right-arrow"></i></li>
                            <li class="nav-item"><a>Data</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="page-inner mt--5">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Surat Tugas</h4>
                    </div>
                    <div class="card-body">
                        <table id="table_surat" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama Pengaju</th>
                                    <th class="text-center">Jenis Pelatihan</th>
                                    <th>Nomor Surat</th>
                                    <th>Tanggal Surat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_surat">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php include '../footer.php' ?>
    </div>

    <script>
        $(document).ready(function () {
            loadPengajuan();
        });

        function loadPengajuan() {
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
                                ? '../Dokumen/Surat_Tugas/' + item.file_surat
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



    </script>