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
                        <h4 class="page-title text-white"><i class="fas fa-upload mr-2"></i>Upload Berkas Pelatihan</h4>
                        <!-- breadcrumbs -->
                        <ul class="breadcrumbs">
                            <li class="nav-home"><a href="dashboard.php"><i class="flaticon-home text-white"></i></a>
                            </li>
                            <li class="separator"><i class="flaticon-right-arrow"></i></li>
                            <li class="nav-item"><a href="upload.php" class="text-white">Upload Berkas</a></li>
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
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Upload Berkas Pelatihan</h4>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <table id="table_berkas" class="display table table-bordered table-hover">
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
                                <tbody id="tbody_berkas">

                                </tbody>
                            </table>

                            <!-- Modal Upload Laporan -->
                            <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog"
                                aria-labelledby="uploadModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold" id="uploadModalLabel">Upload Laporan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Upload Laporan Kegiatan -->
                                            <input type="text" id="id_pengajuan" hidden>
                                            <div class="form-group">
                                                <label for="laporan_kegiatan">Upload Laporan Kegiatan (.pdf,
                                                    .docx)</label>
                                                <input type="file" class="form-control-file" id="laporan_kegiatan"
                                                    accept=".pdf,.docx" required>
                                                <small class="text-muted">Laporan lengkap kegiatan pelatihan yang
                                                    telah dilaksanakan.</small>
                                            </div>

                                            <!-- Upload LPJ (Laporan Pertanggungjawaban) -->
                                            <div class="form-group mt-3">
                                                <label for="lpj">Upload LPJ (.pdf, .xlsx)</label>
                                                <input type="file" class="form-control-file" id="lpj"
                                                    accept=".pdf,.xlsx" required>
                                                <small class="text-muted">Laporan Pertanggungjawaban keuangan dan
                                                    administrasi.</small>
                                            </div>

                                            <!-- Upload Sertifikat Pelatihan -->
                                            <div class="form-group mt-3">
                                                <label for="sertifikat_pelatihan">Upload Sertifikat Pelatihan (.pdf,
                                                    .jpg, .png)</label>
                                                <input type="file" class="form-control-file" id="sertifikat_pelatihan"
                                                    accept=".pdf,.jpg,.png" required>
                                                <small class="text-muted">Sertifikat sebagai bukti keikutsertaan
                                                    pelatihan.</small>
                                            </div>

                                            <!-- Upload Sertifikat Kompetensi/Sertifikasi -->
                                            <div class="form-group mt-3">
                                                <label for="sertifikat_kompetensi">Upload Sertifikat Kompetensi
                                                    (.pdf, .jpg, .png)</label>
                                                <input type="file" class="form-control-file" id="sertifikat_kompetensi"
                                                    accept=".pdf,.jpg,.png">
                                                <small class="text-muted">Sertifikat kompetensi (jika ada,
                                                    opsional).</small>
                                            </div>

                                            <!-- Tombol Submit -->
                                            <div class="d-flex justify-content-end mt-4">
                                                <button type="submit" class="btn btn-success" onclick="submit()">Kirim
                                                    Dokumen</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailModalLabel">Detail Berkas</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <ul id="fileList" class="list-group">
                                                <!-- File list akan di-inject di sini -->
                                            </ul>
                                        </div>
                                    </div>
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
        });

        function loadPengajuan() {
            $.ajax({
                url: './proses/get_berkas.php',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    var tbody = $('#tbody_berkas');
                    tbody.empty();

                    if ($.fn.DataTable.isDataTable('#table_berkas')) {
                        $('#table_berkas').DataTable().destroy();
                    }

                    if (response.length > 0) {
                        $.each(response, function (index, item) {
                            // Tombol Upload muncul jika approval kpj & kunit = 1 dan nomor_surat masih kosong atau null
                            // const showUploadButton = (
                            //     item.approval_kpj == 1 &&
                            //     item.approval_kunit == 1 &&
                            //     (!item.nomor_surat || item.nomor_surat === '') &&
                            //     !item.id_berkas // tambahkan kondisi ini
                            // );
                            var row = `
                            <tr>
                                <td class="text-center">${index + 1}</td>
                                <td class="text-center">${item.nama_pengaju}</td>
                                <td class="text-center">${item.jenis_kegiatan}</td>
                                <td class="text-center">${item.tanggal_mulai}</td>
                                <td class="text-center">${item.tanggal_selesai}</td>
                                <td class="text-center">
                                    <button class="btn btn-success btn-xs" disabled>
                                        Disetujui
                                    </button>
                                </td>
                                <td class="text-center">
                                ${(item.id_berkas == null &&
                                                                item.approval_kpj == 1 &&
                                                                item.approval_kunit == 1 &&
                                                                item.nomor_surat && item.nomor_surat.trim() !== '')
                                                                ? `<button onclick="upload_berkas(${item.id_pengajuan})" class="btn btn-warning btn-sm">
                                        <i class="fas fa-upload mr-2"></i> Upload Laporan
                                </button>`
                                                                : `<button onclick="showFiles(${item.id_pengajuan})" class="btn btn-primary btn-sm">
                                        <i class="fas fa-info-circle mr-2"></i> Detail
                                </button>`
                                                            }
                                </td>
                            </tr>
                            `;

                            tbody.append(row);
                        });
                    }

                    $('#table_berkas').DataTable({
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

        function upload_berkas(id_pengajuan) {
            $('#id_pengajuan').val(id_pengajuan); // Set nilai ke input
            $('#uploadModal').modal('show');      // Tampilkan modal
        }

        function showFiles(id_pengajuan) {
            // Contoh: ambil data file via AJAX dari server (buat endpoint sesuai backend-mu)
            $.ajax({
                url: './proses/get_files.php',
                method: 'POST',
                dataType: 'json', // Tambahkan ini!
                data: { id_pengajuan: id_pengajuan },
                success: function (data) {
                    if (data.success) {
                        const files = data.files;
                        const fileList = $('#fileList');
                        fileList.empty();

                        for (const [key, filename] of Object.entries(files)) {
                            if (filename) {
                                let label = '';
                                switch (key) {
                                    case 'laporan_kegiatan': label = 'Laporan Kegiatan'; break;
                                    case 'lpj': label = 'LPJ'; break;
                                    case 'sertifikat_pelatihan': label = 'Sertifikat Pelatihan'; break;
                                    case 'sertifikat_kompetensi': label = 'Sertifikat Kompetensi'; break;
                                    default: label = key;
                                }

                                const fileUrl = `../Upload/Berkas/${filename}`;
                                const item = `<li class="list-group-item">
                        <strong>${label}: &nbsp</strong> 
                        <a href="${fileUrl}" target="_blank" rel="noopener noreferrer">${filename}</a>
                    </li>`;
                                fileList.append(item);
                            }
                        }

                        const modal = new bootstrap.Modal(document.getElementById('detailModal'));
                        modal.show();

                    } else {
                        alert('Gagal mengambil data file: ' + data.message);
                    }
                },
                error: function () {
                    alert('Gagal menghubungi server');
                }
            });

        }

        function submit() {
            const id_pengajuan = $('#id_pengajuan').val();
            const laporan_kegiatan = $('#laporan_kegiatan')[0].files[0];
            const lpj = $('#lpj')[0].files[0];
            const sertifikat_pelatihan = $('#sertifikat_pelatihan')[0].files[0];
            const sertifikat_kompetensi = $('#sertifikat_kompetensi')[0].files[0];

            if (!laporan_kegiatan || !lpj || !sertifikat_pelatihan) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap',
                    text: 'Silakan unggah semua dokumen wajib.'
                });
                return;
            }

            const maxSize = 1 * 1024 * 1024; // 1 MB
            const filesToCheck = [
                { name: 'Laporan Kegiatan', file: laporan_kegiatan },
                { name: 'LPJ', file: lpj },
                { name: 'Sertifikat Pelatihan', file: sertifikat_pelatihan },
                { name: 'Sertifikat Kompetensi', file: sertifikat_kompetensi }
            ];

            for (let f of filesToCheck) {
                if (f.file && f.file.size > maxSize) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Terlalu Besar',
                        text: `${f.name} tidak boleh lebih dari 1 MB.`
                    });
                    return;
                }
            }

            const formData = new FormData();
            formData.append('id_pengajuan', id_pengajuan);
            formData.append('laporan_kegiatan', laporan_kegiatan);
            formData.append('lpj', lpj);
            formData.append('sertifikat_pelatihan', sertifikat_pelatihan);
            if (sertifikat_kompetensi) {
                formData.append('sertifikat_kompetensi', sertifikat_kompetensi);
            }

            Swal.fire({
                title: 'Memproses...',
                text: 'Mohon tunggu, dokumen sedang diunggah',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: './proses/upload_berkas.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    Swal.close();
                    try {
                        const res = JSON.parse(response);
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: res.message
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: res.message
                            });
                        }
                    } catch (e) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat memproses data dari server.'
                        });
                    }
                },
                error: function () {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Upload Gagal',
                        text: 'Gagal menghubungi server.'
                    });
                }
            });
        }


    </script>