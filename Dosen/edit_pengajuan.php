<?php
$judul = 'Edit Pelatihan';
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

<body?>
	<div class="main-panel">
		<div class="container">
			<div class="panel-header bg-primary-gradient">
				<div class="page-inner py-5">
					<div class="page-header text-white">
						<!-- judul halaman -->
						<h4 class="page-title text-white"><i class="fas fa-edit mr-2"></i>Edit Pengajuan</h4>
						<!-- breadcrumbs -->
						<ul class="breadcrumbs">
							<li class="nav-home"><a href="dashboard.php"><i class="flaticon-home text-white"></i></a></li>
							<li class="separator"><i class="flaticon-right-arrow"></i></li>
							<li class="nav-item"><a href="riwayat-pengajuan.php" class="text-white">Pengajuan Saya</a></li>
							<li class="separator"><i class="flaticon-right-arrow"></i></li>
							<li class="nav-item"><a href="riwayat-pengajuan.php" class="text-white">Data</a></li>
							<li class="separator"><i class="flaticon-right-arrow"></i></li>
							<li class="nav-item"><a href="detail_pengajuan.php" class="text-white">Edit</a></li>
						</ul>
					</div>
				</div>
			</div>

			<div class="page-inner mt--5">
				<div class="card">
					<div class="card-header">
						<div class="d-flex align-items-center">
							<h4 class="card-title">Borang Pengajuan Pelatihan</h4>
						</div>
					</div>
					<div class="card-body">
						<div class="form-group form-show-validation row">
							<label for="nama_kegiatan" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">Nama Kegiatan <span
									class="required-label">*</span></label>
							<div class="col-lg-5 col-md-9 col-sm-8">
								<input type="text" class="form-control" value="<?php echo htmlspecialchars($data['nama_kegiatan']); ?>"
									id="nama_kegiatan" name="nama_kegiatan" placeholder="Masukkan Nama Kegiatan" required>
							</div>
						</div>
						<div class="form-group form-show-validation row">
							<label for="jenis_kegiatan" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">Jenis
								Pelatihan/Pengembangan <span class="required-label">*</span></label>
							<div class="col-lg-5 col-md-9 col-sm-8">
								<select id="jenis_kegiatan" class="form-control" required>
									<option value="" disabled <?php echo (empty($data['jenis_kegiatan'])) ? 'selected' : ''; ?>>
										-- Pilih Kategori --</option>
									<option value="Pelatihan" <?php echo ($data['jenis_kegiatan'] == 'Pelatihan') ? 'selected' : ''; ?>>
										Pelatihan</option>
									<option value="Workshop" <?php echo ($data['jenis_kegiatan'] == 'Workshop') ? 'selected' : ''; ?>>
										Workshop</option>
									<option value="Seminar" <?php echo ($data['jenis_kegiatan'] == 'Seminar') ? 'selected' : ''; ?>>Seminar
									</option>
									<option value="Magang Kerja" <?php echo ($data['jenis_kegiatan'] == 'Magang Kerja') ? 'selected' : ''; ?>>Magang Kerja</option>
								</select>
							</div>
						</div>
						<div class="form-group form-show-validation row">
							<label for="defaultInput" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">Lembaga/Institusi <span
									class="required-label">*</span></label>
							<div class="col-lg-5 col-md-9 col-sm-8">
								<input class="form-control" type="text" id="nama_lembaga"
									value="<?php echo htmlspecialchars($data['nama_lembaga']); ?>" placeholder="Masukkan Nama Lembaga"
									required>
							</div>
						</div>
						<div class="form-group form-show-validation row">
							<label for="jenis_kompetensi" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">Kompetensi <span
									class="required-label">*</span></label>
							<div class="col-lg-5 col-md-9 col-sm-8">
								<textarea class="form-control" id="jenis_kompetensi" name="jenis_kompetensi"
									placeholder="Masukkan Jenis Kompetensi"
									rows="3"><?php echo htmlspecialchars($data['jenis_kompetensi']); ?></textarea>
							</div>
						</div>
						<div class="form-group form-show-validation row">
							<label for="target_pelatihan" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">Target yang ingin
								dicapai
								<span class="required-label">*</span></label>
							<div class="col-lg-5 col-md-9 col-sm-8">
								<textarea class="form-control" id="target_pelatihan" name="target_pelatihan"
									rows="3"><?php echo htmlspecialchars($data['target_pelatihan']); ?></textarea>
							</div>
						</div>
						<div class="separator-solid"></div>
						<div class="form-group form-show-validation row">
							<label for="alamat" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">Tempat/Alamat Kegiatan <span
									class="required-label">*</span></label>
							<div class="col-lg-5 col-md-9 col-sm-8">
								<textarea class="form-control" id="alamat" name="alamat" placeholder="Masukkan Tempat/Alamat"
									rows="3"><?php echo htmlspecialchars($data['alamat']); ?></textarea>
							</div>
						</div>
						<div class="form-group form-show-validation row">
							<label for="tanggal_mulai" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
								Tanggal Mulai <span class="required-label">*</span>
							</label>
							<div class="col-lg-5 col-md-9 col-sm-8">
								<div class="input-group">
									<input type="date" class="form-control"
										value="<?php echo htmlspecialchars($data['tanggal_mulai']); ?>" id="tanggal_mulai"
										name="tanggal_mulai" placeholder="Pilih Tanggal Mulai">
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
									<input type="date" class="form-control"
										value="<?php echo htmlspecialchars($data['tanggal_selesai']); ?>" id="tanggal_selesai"
										name="tanggal_selesai" placeholder="Pilih Tanggal Selesai">
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
								<?php
								$selected_jurusan = $data['jurusan']; // "Teknik Informatika, Teknik Elektro"
								$selected_array = explode(", ", $selected_jurusan);
								?>
								<select id="jurusan" class="form-control" multiple required>
									<option value="Manajemen dan Bisnis" <?php if (in_array("Manajemen dan Bisnis", $selected_array))
										echo "selected"; ?>>Manajemen dan Bisnis</option>
									<option value="Teknik Informatika" <?php if (in_array("Teknik Informatika", $selected_array))
										echo "selected"; ?>>Teknik Informatika</option>
									<option value="Teknik Elektro" <?php if (in_array("Teknik Elektro", $selected_array))
										echo "selected"; ?>>Teknik Elektro</option>
									<option value="Teknik Mesin" <?php if (in_array("Teknik Mesin", $selected_array))
										echo "selected"; ?>>
										Teknik Mesin</option>
								</select>
							</div>
						</div>
						<div class="form-group form-show-validation row">
							<label for="program_studi" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">Prodi <span
									class="required-label">*</span></label></label>
							<div class="col-lg-5 col-md-9 col-sm-8">
								<?php
								$selected_prodi = $data['program_studi']; // contoh: "Teknik Informatika, Teknologi Permainan"
								$selected_array_prodi = explode(", ", $selected_prodi);
								?>
								<select id="program_studi" name="program_studi[]" class="form-control" multiple required>
									<option value="Teknik Informatika" <?php if (in_array("Teknik Informatika", $selected_array_prodi))
										echo "selected"; ?>>Teknik Informatika</option>
									<option value="Teknologi Rekayasa Multimedia" <?php if (in_array("Teknologi Rekayasa Multimedia", $selected_array_prodi))
										echo "selected"; ?>>Teknologi Rekayasa Multimedia</option>
									<option value="Teknologi Geomatika" <?php if (in_array("Teknologi Geomatika", $selected_array_prodi))
										echo "selected"; ?>>Teknologi Geomatika</option>
									<option value="Animasi" <?php if (in_array("Animasi", $selected_array_prodi))
										echo "selected"; ?>>
										Animasi</option>
									<option value="Rekayasa Keamanan Siber" <?php if (in_array("Rekayasa Keamanan Siber", $selected_array_prodi))
										echo "selected"; ?>>Rekayasa Keamanan Siber</option>
									<option value="Teknologi Rekayasa Perangkat Lunak" <?php if (in_array("Teknologi Rekayasa Perangkat Lunak", $selected_array_prodi))
										echo "selected"; ?>>Teknologi Rekayasa Perangkat Lunak</option>
									<option value="Teknologi Permainan" <?php if (in_array("Teknologi Permainan", $selected_array_prodi))
										echo "selected"; ?>>Teknologi Permainan</option>
								</select>

							</div>
						</div>
						<div class="form-group form-show-validation row">
							<label for="kode_akun" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">Sumber Dana <i>(Code
									Account)</i>
								<span class="required-label">*</span>
							</label>
							<div class="col-lg-5 col-md-9 col-sm-8">
								<input class="form-control" type="text" id="kode_akun"
									value="<?php echo htmlspecialchars($data['kode_akun']); ?>" placeholder="Masukkan Code Account"
									required>
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
							<label for="dokumen" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-right">
								Upload Dokumen yang Diperlukan <span class="required-label">*</span>
							</label>
							<div class="col-lg-5 col-md-9 col-sm-8">
								<input type="file" class="form-control" id="dokumen" name="dokumen" accept=".pdf,.jpg,.jpeg,.png"
									required>
								<small class="text-muted">Format: PDF, JPG, PNG. Maksimal 1 MB</small>

								<?php if (!empty($data['dokumen'])): ?>
									<div class="mt-3" id="filePreviewContainer">
										<h5>Dokumen Sebelumnya:</h5>
										<div class="border p-3 rounded bg-light" id="previewArea">
											<a href="<?php echo '../Dokumen' . htmlspecialchars($data['dokumen']); ?>" target="_blank">
												<?php echo htmlspecialchars($data['dokumen']); ?>
											</a>
										</div>
									</div>
								<?php endif; ?>
							</div>
						</div>
						<div class="card-action d-flex justify-content-end">
							<button class="btn btn-success" onclick="kirim()">Simpan</button>
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
			tampilkanPeserta()
		});

		function validateForm() {
			if (!$('#nama_kegiatan').val() || !$('#jenis_kegiatan').val() || !$('#nama_lembaga').val() ||
				!$('#jenis_kompetensi').val() || !$('#target_pelatihan').val() || !$('#alamat').val() ||
				!$('#tanggal_mulai').val() || !$('#tanggal_selesai').val() || !$('#kode_akun').val()) {
				Swal.fire('Data Tidak Lengkap', 'Mohon lengkapi semua isian wajib.', 'warning');
				return false;
			}
			if (new Date($('#tanggal_mulai').val()) > new Date($('#tanggal_selesai').val())) {
				Swal.fire('Tanggal Tidak Valid', 'Tanggal mulai tidak boleh setelah tanggal selesai.', 'warning');
				return false;
			}
			for (const file of $('#dokumen')[0].files) {
				if (file.size > 1 * 1024 * 1024) {
					Swal.fire('File Terlalu Besar', 'Ukuran file maksimal 1MB per file.', 'warning');
					return false;
				}
			}
			return true;
		}

		function kirim() {
			const id_pengajuan = <?php echo json_encode(value: $id); ?>;
			if (!validateForm()) return;

			$.getJSON('./proses/get_edit_peserta.php', { id_pengajuan }, function (data) {
				if (!data || data.length === 0) {
					Swal.fire('Peserta Kosong', 'Silakan tambahkan data peserta terlebih dahulu.', 'warning');
					return;
				}

				const formData = new FormData();
				formData.append('id_pengajuan', id_pengajuan);
				formData.append('nama_kegiatan', $('#nama_kegiatan').val());
				formData.append('jenis_kegiatan', $('#jenis_kegiatan').val());
				formData.append('nama_lembaga', $('#nama_lembaga').val());
				formData.append('jenis_kompetensi', $('#jenis_kompetensi').val());
				formData.append('target_pelatihan', $('#target_pelatihan').val());
				formData.append('alamat', $('#alamat').val());
				formData.append('tanggal_mulai', $('#tanggal_mulai').val());
				formData.append('tanggal_selesai', $('#tanggal_selesai').val());

				// Convert array fields to strings
				formData.append('jurusan', ($('#jurusan').val() || []).join(', '));
				formData.append('program_studi', ($('#program_studi').val() || []).join(', '));
				formData.append('kode_akun', $('#kode_akun').val());

				for (const file of $('#dokumen')[0].files) {
					formData.append('dokumen[]', file);
				}

				Swal.fire({
					title: 'Mengirim...',
					text: 'Mohon tunggu sebentar.',
					allowOutsideClick: false,
					didOpen: () => Swal.showLoading(),
				});

				$.ajax({
					url: './proses/edit_pengajuan.php',
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
									showConfirmButton: false,
								}).then(() => window.location.href = 'riwayat-pengajuan.php');
							} else {
								Swal.fire('Gagal', res.message || 'Terjadi kesalahan saat menyimpan data.', 'error');
							}
						} catch {
							Swal.fire('Gagal', 'Respons tidak valid dari server.', 'error');
							console.log('Raw response:', response);
						}
					},
					error: function (xhr, status, error) {
						Swal.fire('Gagal', 'Gagal mengirim data: ' + error, 'error');
					},
				});
			}).fail(function () {
				Swal.fire('Gagal Ambil Data Peserta', 'Coba refresh halaman.', 'error');
			});
		}


		function simpanPeserta() {
			const id_pengajuan = <?php echo json_encode($id); ?>;
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
				url: './proses/simpan_edit_peserta.php',
				type: 'POST',
				dataType: 'json',
				data: {
					nama_peserta: namaPeserta,
					nik_peserta: nikPeserta,
					id_pengajuan: id_pengajuan,
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
			const id_pengajuan = <?php echo $id; ?>;
			$.ajax({
				url: './proses/get_edit_peserta.php',
				type: 'POST',
				dataType: 'json',
				data: {
					id_pengajuan: id_pengajuan
				},
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
			const id_pengajuan = <?php echo $id; ?>;
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
						url: './proses/hapus_edit_peserta.php',
						type: 'POST',
						dataType: 'json',
						data: {
							id_peserta: id,
							id_pengajuan: id_pengajuan
						},
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
	</script>