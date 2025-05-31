<?php
session_start();
$judul = 'Pengajuan Pelatihan';
include '../header.php';
include 'sidebar_dosen.php';

$nama = isset($_SESSION['nama']) ? $_SESSION['nama'] : '';

// Include koneksi database
include '../koneksi.php';

// Hapus data peserta sementara sesuai user yang login
if ($nama !== '') {
	$stmt = $koneksi->prepare("DELETE FROM temp_peserta WHERE nama_pengaju = ?");
	$stmt->bind_param("s", $nama);
	$stmt->execute();
	$stmt->close();
}
?>



<body?>
	<div class="main-panel">
		<div class="container">
			<div class="panel-header bg-primary-gradient">
				<div class="page-inner py-5">
					<div class="page-header text-white">
						<!-- judul halaman -->
						<h4 class="page-title text-white"><i class="fas fa-pen-square mr-2"></i>Ajukan Pelatihan</h4>
						<!-- breadcrumbs -->
						<ul class="breadcrumbs">
							<li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
							<li class="separator"><i class="flaticon-right-arrow"></i></li>
							<li class="nav-item"><a href="?module=barang_masuk" class="text-white">Ajukan Pelatihan</a></li>
							<li class="separator"><i class="flaticon-right-arrow"></i></li>
							<li class="nav-item"><a>Form</a></li>
						</ul>
					</div>
				</div>
			</div>

			<div class="page-inner mt--5">
				<div class="card">
					<div class="card-header">
						<div class="card-title">Borang Pengajuan Pelatihan</div>
					</div>
					<div class="card-body">
						<div class="form-group form-show-validation row">
							<label for="nama_pengaju" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">Nama Pengaju Pelatihan
								<span class="required-label">*</span></label>
							<div class="col-lg-5 col-md-9 col-sm-8">
								<input type="text" class="form-control" id="nama_pengaju" name="nama_pengaju"
									value="<?= htmlspecialchars($nama) ?>" placeholder="Masukkan Nama Pengaju" required readonly>
							</div>
						</div>
						<div class="form-group form-show-validation row">
							<label for="nama_kegiatan" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">Nama Kegiatan <span
									class="required-label">*</span></label>
							<div class="col-lg-5 col-md-9 col-sm-8">
								<input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan"
									placeholder="Masukkan Nama Kegiatan" required>
							</div>
						</div>
						<div class="form-group form-show-validation row">
							<label for="jenis_kegiatan" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">Jenis
								Pelatihan/Pengembangan <span class="required-label">*</span></label>
							<div class="col-lg-5 col-md-9 col-sm-8">
								<select id="jenis_kegiatan" class="form-control" required>
									<option value="">-- Pilih Kategori --</option>
									<option value="Pelatihan">Pelatihan</option>
									<option value="Workshop">Workshop</option>
									<option value="Seminar">Seminar</option>
									<option value="Magang Kerja">Magang Kerja</option>
								</select>
							</div>
						</div>
						<div class="form-group form-show-validation row">
							<label for="nama_lembaga" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">Lembaga/Institusi <span
									class="required-label">*</span></label>
							<div class="col-lg-5 col-md-9 col-sm-8">
								<input class="form-control" type="text" id="nama_lembaga" placeholder="Masukkan Nama Lembaga" required>
							</div>
						</div>
						<div class="form-group form-show-validation row">
							<label for="jenis_kompetensi" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">Kompetensi <span
									class="required-label">*</span></label>
							<div class="col-lg-5 col-md-9 col-sm-8">
								<textarea class="form-control" id="jenis_kompetensi" name="jenis_kompetensi"
									placeholder="Masukkan Jenis Kompetensi" rows="3"></textarea>
							</div>
						</div>
						<div class="form-group form-show-validation row">
							<label for="target_pelatihan" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">Target yang ingin
								dicapai
								<span class="required-label">*</span></label>
							<div class="col-lg-5 col-md-9 col-sm-8">
								<textarea class="form-control" id="target_pelatihan" name="target_pelatihan" rows="3"></textarea>
							</div>
						</div>
						<div class="separator-solid"></div>
						<div class="form-group form-show-validation row">
							<label for="alamat" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">Tempat/Alamat Kegiatan <span
									class="required-label">*</span></label>
							<div class="col-lg-5 col-md-9 col-sm-8">
								<textarea class="form-control" id="alamat" name="alamat" placeholder="Masukkan Tempat/Alamat"
									rows="3"></textarea>
							</div>
						</div>
						<div class="form-group form-show-validation row">
							<label for="tanggal_mulai" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
								Tanggal Mulai <span class="required-label">*</span>
							</label>
							<div class="col-lg-5 col-md-9 col-sm-8">
								<div class="input-group">
									<input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
										placeholder="Pilih Tanggal Mulai">
									<div class="input-group-append">
										<!-- <span class="input-group-text">
											<i class="fa fa-calendar"></i>
										</span> -->
									</div>
								</div>
							</div>
						</div>
						<div class="form-group form-show-validation row">
							<label for="tanggal_selesai" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
								Tanggal Selesai <span class="required-label">*</span>
							</label>
							<div class="col-lg-5 col-md-9 col-sm-8">
								<div class="input-group">
									<input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
										placeholder="Pilih Tanggal Selesai">
									<div class="input-group-append">
										<!-- <span class="input-group-text">
											<i class="fa fa-calendar"></i>
										</span> -->
									</div>
								</div>
							</div>
						</div>
						<div class="form-group form-show-validation row">
							<label for="jurusan" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">Jurusan <span
									class="required-label">*</span></label></label>
							<div class="col-lg-5 col-md-9 col-sm-8">
								<select id="jurusan" class="form-control" multiple required>
									<option>Manajemen dan Bisnis</option>
									<option>Teknik Informatika</option>
									<option>Teknik Elektro</option>
									<option>Teknik Mesin</option>
								</select>
							</div>
						</div>
						<div class="form-group form-show-validation row">
							<label for="program_studi" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">Prodi <span
									class="required-label">*</span></label></label>
							<div class="col-lg-5 col-md-9 col-sm-8">
								<select id="program_studi" class="form-control" multiple required>
									<option>Teknik Informatika</option>
									<option>Teknologi Rekayasa Multimedia</option>
									<option>Teknologi Geomatika</option>
									<option>Animasi</option>
									<option>Rekayasa Keamanan Siber</option>
									<option>Teknologi Rekayasa Perangkat Lunak</option>
									<option>Teknologi Permainan</option>
								</select>
							</div>
						</div>
						<div class="form-group form-show-validation row">
							<label for="kode_akun" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">Sumber Dana <i>(Code
									Account)</i>
								<span class="required-label">*</span>
							</label>
							<div class="col-lg-5 col-md-9 col-sm-8">
								<input class="form-control" type="text" id="kode_akun" placeholder="Masukkan Code Account" required>
							</div>
						</div>
						<div class="separator-solid"></div>

						<div class="form-group form-show-validation row">
							<label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right"> Nama Peserta Pelatihan
								<span class="required-label">*</span>
							</label>
							<button type="button" class="btn btn-primary btn-sm mt-2" onclick="addRow()">Tambah Peserta</button>
							<div class="table-responsive">
								<center>
									<table class="table table-sm table-bordered mt-3" id="pesertaTable" style="width:50%;">
										<thead>
											<tr>
												<th class="text-center">No</th>
												<th class="text-center">Nama Peserta <span class="required-label">*</span></th>
												<th class="text-center">NIK <span class="required-label">*</span></th>
												<th class="text-center">Action</th>
											</tr>
										</thead>
										<tbody>

										</tbody>
									</table>
								</center>
							</div>
						</div>

						<div class="form-group form-show-validation row">
							<label class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right font-weight-bold">
								Upload Dokumen Pelatihan
								<span class="text-danger">*</span>
							</label>

							<div class="col-lg-5 col-md-5 col-sm-8">
								<div class="bg-light rounded p-3 mb-4 border-left border-primary">
									<h6 class="font-weight-bold text-right">
										Quotation/Penawaran dari Lembaga
										<span class="text-danger ml-1">*</span>
									</h6>
									<p class="text-muted small mb-2">Format: PDF, JPG, PNG (Maks. 1MB)</p>
									<div class="border rounded p-4 text-center" id="quotationDropZone"
										style="border-style: dashed; cursor: pointer;">
										<i class="fas fa-file-alt fa-3x mb-2 text-primary"></i>
										<p class="text-muted mb-0">Seret file ke sini atau klik untuk memilih</p>
										<input type="file" id="dokumen" class="d-none" accept=".pdf,.jpg,.jpeg,.png" required>
									</div>
									<div id="quotationPreview" class="mt-2 small"></div>
								</div>
							</div>
						</div>

						<div class="card-action d-flex justify-content-end">
							<button class="btn btn-success" onclick="kirim()">Kirim</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal Tambah Peserta -->
		<div class="modal fade" id="modalPeserta" tabindex="-1" role="dialog" aria-labelledby="modalPesertaLabel"
			aria-hidden="true">
			<div class="modal-dialog  modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Tambah Peserta </h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form id="formPeserta">
							<div class="form-group">
								<label for="namaPeserta">Nama Peserta <span class="text-danger ml-1">*</span></label>
								<input type="text" class="form-control" id="nama_peserta" required>
							</div>
							<div class="form-group">
								<label for="nikPeserta">NIK Peserta <span class="text-danger ml-1">*</span></label>
								<input type="text" class="form-control" id="nik_peserta" required>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Batal</button>
						<button type="button" class="btn btn-primary btn-sm" onclick="simpanPeserta()">Simpan</button>
					</div>
				</div>
			</div>
		</div>


		<?php include '../footer.php'; ?>
	</div>
	</div>

	<script>
		function addRow() {
			$('#modalPeserta').modal('show');
		}

		$(document).ready(function () {
			$('#jurusan').select2({
				placeholder: "-- Pilih Jurusan --",
				allowClear: true,
				width: '100%'   // Ini supaya select2 full width
			});
		});

		$(document).ready(function () {
			$('#program_studi').select2({
				placeholder: "-- Pilih Prodi --",
				allowClear: true,
				width: '100%'   // Ini supaya select2 full width
			});
		});

		function kirim() {
			const nama = $('#nama_pengaju').val();
			const nama_kegiatan = $('#nama_kegiatan').val();
			const jenis_kegiatan = $('#jenis_kegiatan').val();
			const nama_lembaga = $('#nama_lembaga').val();
			const jenis_kompetensi = $('#jenis_kompetensi').val();
			const target_pelatihan = $('#target_pelatihan').val();
			const alamat = $('#alamat').val();
			const tanggal_mulai = $('#tanggal_mulai').val();
			const tanggal_selesai = $('#tanggal_selesai').val();

			const jurusan = $('#jurusan').val(); // array
			const program_studi = $('#program_studi').val(); // array
			const jurusanStr = jurusan ? jurusan.join(', ') : '';
			const programStudiStr = program_studi ? program_studi.join(', ') : '';

			const kode_akun = $('#kode_akun').val();
			const files = $('#dokumen')[0].files;

			// 🔍 Validasi semua field wajib
			if (!nama || !nama_kegiatan || !jenis_kegiatan || !nama_lembaga || !jenis_kompetensi || !target_pelatihan || !alamat || !tanggal_mulai || !tanggal_selesai || !kode_akun) {
				Swal.fire({
					icon: 'warning',
					title: 'Data Tidak Lengkap',
					text: 'Mohon lengkapi semua isian wajib.'
				});
				return;
			}

			// 🔍 Validasi tanggal
			if (new Date(tanggal_mulai) > new Date(tanggal_selesai)) {
				Swal.fire({
					icon: 'warning',
					title: 'Tanggal Tidak Valid',
					text: 'Tanggal mulai tidak boleh setelah tanggal selesai.'
				});
				return;
			}

			// 🔍 Validasi file upload
			if (files.length === 0) {
				Swal.fire({
					icon: 'warning',
					title: 'File Belum Diupload',
					text: 'Silakan upload file terlebih dahulu.'
				});
				return;
			}

			// 🔍 Validasi ukuran file maksimal 5MB
			for (let i = 0; i < files.length; i++) {
				if (files[i].size > 1 * 1024 * 1024) {
					Swal.fire({
						icon: 'warning',
						title: 'File Terlalu Besar',
						text: 'Ukuran file maksimal 1MB per file.'
					});
					return;
				}
			}

			// 🔍 Validasi data peserta sebelum submit
			$.ajax({
				url: './proses/get_peserta.php',
				type: 'GET',
				dataType: 'json',
				success: function (data) {
					if (!data || data.length === 0) {
						Swal.fire({
							icon: 'warning',
							title: 'Peserta Kosong',
							text: 'Silakan tambahkan data peserta terlebih dahulu.'
						});
						return;
					}

					// Semua validasi lolos, lanjut submit
					const formData = new FormData();
					formData.append('nama_pengaju', nama);
					formData.append('nama_kegiatan', nama_kegiatan);
					formData.append('jenis_kegiatan', jenis_kegiatan);
					formData.append('nama_lembaga', nama_lembaga);
					formData.append('jenis_kompetensi', jenis_kompetensi);
					formData.append('target_pelatihan', target_pelatihan);
					formData.append('alamat', alamat);
					formData.append('tanggal_mulai', tanggal_mulai);
					formData.append('tanggal_selesai', tanggal_selesai);
					formData.append('jurusan', jurusanStr);
					formData.append('program_studi', programStudiStr);
					formData.append('kode_akun', kode_akun);

					for (let i = 0; i < files.length; i++) {
						formData.append('dokumen[]', files[i]);
					}

					Swal.fire({
						title: 'Mengirim...',
						text: 'Mohon tunggu sebentar.',
						allowOutsideClick: false,
						didOpen: () => {
							Swal.showLoading();
						}
					});

					$.ajax({
						url: './proses/upload_pengajuan.php',
						type: 'POST',
						data: formData,
						contentType: false,
						processData: false,
						success: function (response) {
							try {
								const res = JSON.parse(response);
								if (res.status) {
									Swal.fire({
										icon: 'success',
										title: 'Berhasil!',
										text: 'Data dan file berhasil dikirim!',
										timer: 1500,
										showConfirmButton: false
									}).then(() => {
										window.location.href = 'riwayat-pengajuan.php';
									});
								} else {
									Swal.fire({
										icon: 'error',
										title: 'Gagal',
										text: res.message || 'Terjadi kesalahan saat menyimpan data.'
									});
								}
							} catch (e) {
								Swal.fire({
									icon: 'error',
									title: 'Gagal',
									text: 'Respons tidak valid dari server.'
								});
								console.log('Raw response:', response);
							}
						},
						error: function (xhr, status, error) {
							Swal.fire({
								icon: 'error',
								title: 'Gagal',
								text: 'Gagal mengirim data: ' + error
							});
						}
					});
				},
				error: function () {
					Swal.fire({
						icon: 'error',
						title: 'Gagal Ambil Data Peserta',
						text: 'Coba refresh halaman.'
					});
				}
			});
		}



		function simpanPeserta() {
			var namaPeserta = $('#nama_peserta').val().trim();
			var nikPeserta = $('#nik_peserta').val().trim();

			if (namaPeserta === "" || nikPeserta === "") {
				Swal.fire({
					icon: 'warning',
					title: 'Data belum lengkap',
					text: 'Nama dan NIK wajib diisi.'
				});
				return;
			}

			$.ajax({
				url: './proses/simpan_peserta.php',
				type: 'POST',
				dataType: 'json',
				data: {
					nama_peserta: namaPeserta,
					nik_peserta: nikPeserta
				},
				success: function (response) {
					if (response.status === 'success') {
						Swal.fire({
							icon: 'success',
							title: 'Berhasil',
							text: 'Data peserta berhasil disimpan.',
							timer: 1000,
							showConfirmButton: false
						});

						$('#formPeserta')[0].reset();
						$('#modalPeserta').modal('hide');
						tampilkanPeserta();
					} else {
						Swal.fire({
							icon: 'error',
							title: 'Gagal',
							text: response.message
						});
					}
				},
				error: function (xhr, status, error) {
					Swal.fire({
						icon: 'error',
						title: 'Terjadi kesalahan',
						text: error
					});
				}
			});
		}

		function tampilkanPeserta() {
			$.ajax({
				url: './proses/get_peserta.php',
				type: 'GET',
				dataType: 'json',
				success: function (data) {
					var tbody = $('#pesertaTable tbody');
					tbody.empty(); // bersihkan isi lama

					if (data.length === 0) {
						tbody.append('<tr><td colspan="4" class="text-center">Belum ada peserta</td></tr>');
						return;
					}

					data.forEach((peserta, index) => {
						var row = `
										<tr>
												<td class="text-center">${index + 1}</td>
												<td class="text-center">${peserta.nama_peserta}</td>
												<td class="text-center">${peserta.nik_peserta}</td>
												<td class="text-center">
														<button class="btn btn-danger btn-sm" onclick="hapusPeserta(${peserta.id_peserta})">Hapus</button>
												</td>
										</tr>
								`;
						tbody.append(row);
					});
				},
				error: function (xhr, status, error) {
					Swal.fire({
						icon: 'error',
						title: 'Gagal ambil data peserta',
						text: error
					});
				}
			});
		}


		function hapusPeserta(id) {
			Swal.fire({
				title: 'Konfirmasi',
				text: "Apakah Anda yakin ingin menghapus peserta ini?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Ya, hapus!',
				cancelButtonText: 'Batal'
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url: './proses/hapus_peserta.php',
						type: 'POST',
						dataType: 'json',
						data: { id_peserta: id },
						success: function (response) {
							if (response.status === 'success') {
								Swal.fire('Terhapus!', response.message, 'success');
								tampilkanPeserta(); // refresh tabel setelah hapus
							} else {
								Swal.fire('Gagal!', response.message, 'error');
							}
						},
						error: function (xhr, status, error) {
							Swal.fire('Error!', 'Terjadi kesalahan: ' + error, 'error');
						}
					});
				}
			});
		}


		document.querySelectorAll('[id$="DropZone"]').forEach(dropZone => {
			const input = dropZone.querySelector('input');
			const preview = document.getElementById(dropZone.id.replace('DropZone', 'Preview'));

			// Enable multiple file selection
			input.setAttribute('multiple', 'multiple');

			dropZone.addEventListener('click', () => input.click());

			input.addEventListener('change', () => {
				if (input.files.length > 0) {
					preview.innerHTML = '';

					Array.from(input.files).forEach((file, index) => {
						const fileId = `file-${Date.now()}-${index}`;
						preview.innerHTML += `
											<div class="alert alert-light d-flex justify-content-between align-items-center p-2 mb-2" id="${fileId}">
												<span>
													<i class="fas fa-file mr-2"></i>
													${file.name}
												</span>
												<button class="btn btn-sm btn-outline-danger p-1" onclick="removeFile('${fileId}', '${input.id}')">
													<i class="fas fa-times"></i>
												</button>
											</div>
										`;
					});

					dropZone.style.borderColor = '#28a745';
				}
			});

			['dragenter', 'dragover'].forEach(eventName => {
				dropZone.addEventListener(eventName, (e) => {
					e.preventDefault();
					dropZone.style.borderColor = '#007bff';
					dropZone.style.backgroundColor = '#e1f0ff';
				});
			});

			['dragleave', 'drop'].forEach(eventName => {
				dropZone.addEventListener(eventName, (e) => {
					e.preventDefault();
					dropZone.style.borderColor = '#adb5bd';
					dropZone.style.backgroundColor = '#f8f9fa';
				});
			});

			dropZone.addEventListener('drop', (e) => {
				e.preventDefault();
				input.files = e.dataTransfer.files;
				const event = new Event('change');
				input.dispatchEvent(event);
			});
		});

		function removeFile(fileId, inputId) {
			const fileElement = document.getElementById(fileId);
			const input = document.getElementById(inputId);

			// Remove the file from display
			fileElement.remove();

			// Create new DataTransfer object to update files
			const dataTransfer = new DataTransfer();

			// Add all files except the one being removed
			Array.from(input.files).forEach((file, index) => {
				if (fileId !== `file-${Date.now()}-${index}`) {
					dataTransfer.items.add(file);
				}
			});

			// Update files in input
			input.files = dataTransfer.files;

			// If no files left, reset dropzone style
			if (input.files.length === 0) {
				const dropZone = document.querySelector(`[id$="DropZone"] input[id="${inputId}"]`).parentElement;
				dropZone.style.borderColor = '#adb5bd';
			}
		}
	</script>