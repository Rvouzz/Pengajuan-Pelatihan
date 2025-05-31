<?php $judul = 'Data Verifikasi';
include '../header.php';
include 'sidebar_staffadmin.php' ?>

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
                            <li class="nav-item"><a>Data Pengajuan</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="page-inner mt--5">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Daftar Pengajuan</h4>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <table id="table_verifikasi" class="display table table-bordered table-hover">
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
                                <tbody id="tbody-verifikasi">

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
        });

        function loadPengajuan() {
            $.ajax({
                url: './proses/get_pengajuan.php',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    var tbody = $('#tbody-verifikasi');
                    tbody.empty();

                    if ($.fn.DataTable.isDataTable('#table_verifikasi')) {
                        $('#table_verifikasi').DataTable().destroy();
                    }

                    if (response.length > 0) {
                        $.each(response, function (index, item) {
                            const showUploadButton = (item.approval_kpj == 1 && item.approval_kunit == 1 && !item.nomor_surat);

                            var row = `
                            <tr>
                                <td class="text-center">${index + 1}</td>
                                <td class="text-center">${item.nama_pengaju}</td>
                                <td class="text-center">${item.jenis_kegiatan}</td>
                                <td class="text-center">${item.tanggal_mulai}</td>
                                <td class="text-center">${item.tanggal_selesai}</td>
                                <td class="text-center">
                                    <button class="btn btn-${item.approval_kepegawaian_class} btn-xs">
                                        ${item.approval_kepegawaian_text}
                                    </button>
                                </td>
                                <td class="text-center">
                                    ${showUploadButton
                                    ? `<button onclick="upload_surat(${item.id})" class="btn btn-warning btn-sm">
                                                <i class="fas fa-upload mr-2"></i> Upload Surat Tugas
                                        </button>`
                                    : `<a href="verifikasi.php?id=${item.id}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-info-circle mr-2"></i> Detail
                                        </a>`
                                }
                                </td>
                            </tr>
                            `;
                            tbody.append(row);
                        });
                    }

                    $('#table_verifikasi').DataTable({
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

        function upload_surat(id_pengajuan) {
            Swal.fire({
                title: '<strong>📄 Upload Surat Tugas</strong>',
                html: `
      <div style="display: flex; flex-direction: column; gap: 15px;">
        <input type="file" id="fileUpload" accept="application/pdf"
          style="padding: 10px; border: 1px solid #ddd; border-radius: 6px; width: 100%;">
        <small style="color: gray;">* Hanya file PDF yang diizinkan</small>
        <div style="display: flex; justify-content: center; gap: 15px; margin-top: 20px;">
          <button id="cancelBtn" class="btn btn-secondary">Batal</button>
          <button id="uploadBtn" class="btn btn-success">Upload</button>
        </div>
      </div>
    `,
                showConfirmButton: false,
                showCancelButton: false,
                icon: 'info',
                didOpen: () => {
                    $('#uploadBtn').on('click', function () {
                        const file = $('#fileUpload')[0].files[0];
                        if (!file) {
                            Swal.showValidationMessage('Silakan pilih file terlebih dahulu');
                            return;
                        }
                        if (file.type !== 'application/pdf') {
                            Swal.showValidationMessage('Hanya file PDF yang diizinkan');
                            return;
                        }

                        const formData = new FormData();
                        formData.append('file', file);
                        formData.append('id_pengajuan', id_pengajuan);

                        $.ajax({
                            url: './proses/upload_surat.php',
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function () {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Surat berhasil diupload.',
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function () {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan saat mengupload surat.',
                                });
                            }
                        });
                    });

                    $('#cancelBtn').on('click', function () {
                        Swal.close();
                    });
                }
            });
        }



    </script>