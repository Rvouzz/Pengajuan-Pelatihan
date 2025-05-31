<footer class="footer">
	<div class="container-fluid">
		<nav class="pull-left">
			<ul class="nav">
				<li class="nav-item">
					<a class="nav-link" href="http://www.themekita.com">
						ThemeKita
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">
						Help
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">
						Licenses
					</a>
				</li>
			</ul>
		</nav>
		<div class="copyright ml-auto">
			2018, made with <i class="fa fa-heart heart text-danger"></i> by <a href="http://www.themekita.com">ThemeKita</a>
		</div>
	</div>
</footer>

<!--   Core JS Files   -->
<script src="../assets/js/core/jquery.3.2.1.min.js"></script>
<script src="../assets/js/core/popper.min.js"></script>
<script src="../assets/js/core/bootstrap.min.js"></script>

<!-- jQuery UI -->
<script src="../assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="../assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

<!-- jQuery Scrollbar -->
<script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

<!-- Moment JS -->
<script src="../assets/js/plugin/moment/moment.min.js"></script>

<!-- Chart JS -->
<script src="../assets/js/plugin/chart.js/chart.min.js"></script>

<!-- jQuery Sparkline -->
<script src="../assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

<!-- Chart Circle -->
<!--<script src="../assets/js/plugin/chart-circle/circles.min.js"></script>-->

<!-- Datatables -->
<script src="../assets/js/plugin/datatables/datatables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- Bootstrap Notify -->
<script src="../assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

<!-- Bootstrap Toggle -->
<script src="../assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>

<!-- jQuery Vector Maps -->
<script src="../assets/js/plugin/jqvmap/jquery.vmap.min.js"></script>
<script src="../assets/js/plugin/jqvmap/maps/jquery.vmap.world.js"></script>

<!-- Google Maps Plugin -->
<script src="../assets/js/plugin/gmaps/gmaps.js"></script>

<!-- Dropzone -->
<script src="../assets/js/plugin/dropzone/dropzone.min.js"></script>

<!-- Fullcalendar -->
<script src="../assets/js/plugin/fullcalendar/fullcalendar.min.js"></script>

<!-- DateTimePicker -->
<script src="../assets/js/plugin/datepicker/bootstrap-datetimepicker.min.js"></script>

<!-- Bootstrap Tagsinput -->
<script src="../assets/js/plugin/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>

<!-- Bootstrap Wizard -->
<script src="../assets/js/plugin/bootstrap-wizard/bootstrapwizard.js"></script>

<!-- jQuery Validation -->
<script src="../assets/js/plugin/jquery.validate/jquery.validate.min.js"></script>

<!-- Summernote -->
<script src="../assets/js/plugin/summernote/summernote-bs4.min.js"></script>

<!-- Select2 -->
<script src="../assets/js/plugin/select2/select2.full.min.js"></script>
<!-- CSS Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- JS Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<!-- Sweet Alert -->
<script src="../assets/js/plugin/sweetalert/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Owl Carousel -->
<script src="../assets/js/plugin/owl-carousel/owl.carousel.min.js"></script>

<!-- Magnific Popup -->
<script src="../assets/js/plugin/jquery.magnific-popup/jquery.magnific-popup.min.js"></script>

<!-- jQuery Validation -->
<script src="../assets/js/plugin/jquery.validate/jquery.validate.min.js"></script>

<!-- Atlantis JS -->
<script src="../assets/js/atlantis.min.js"></script>

<!-- Atlantis DEMO methods, don't include it in your project! -->
<script src="../assets/js/setting-demo.js"></script>
<script src="../assets/js/demo.js"></script>

<script>
    document.getElementById("status-select").addEventListener("change", function () {
        let indicator = document.getElementById("status-indicator");
        let status = this.value;
          
        if (status === "Pending") {
            indicator.style.backgroundColor = "#ffa534"; // Kuning (Warning)
        } else if (status === "Approved") {
            indicator.style.backgroundColor = "#35cd3a"; // Hijau (Success)
        } else if (status === "Rejected") {
            indicator.style.backgroundColor = "#f3545d"; // Merah (Danger)
        } else {
            indicator.style.backgroundColor = "#36a3f7"; // Biru (Primary) - Default untuk Scheduled
        }
    });
</script>

<script>
	$(document).ready(function() {
		clock_run();
		show_calendar();
	});

	function show_calendar() {
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		var className = Array('fc-primary', 'fc-danger', 'fc-black', 'fc-success', 'fc-info', 'fc-warning', 'fc-danger-solid', 'fc-warning-solid', 'fc-success-solid', 'fc-black-solid', 'fc-success-solid', 'fc-primary-solid');
		$calendar = $('#calendar');
		$calendar.fullCalendar({
			fixedWeekCount: false,
		});
	}

	function clock_run() {
		'use strict';
		let d = new Date();
		let en_day = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
		let en_month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
		let day = en_day[d.getDay()];
		let date = d.getDate();
		let month = en_month[d.getMonth()];
		let year = (d.getYear() + 1900);
		let curr_date = day + ', ' + date + ' ' + month + ' ' + year;
		localStorage.setItem('curr_date', curr_date);
		let old_date = localStorage.getItem('curr_date');

		if ($("#date").text() != curr_date) {
			localStorage.setItem('curr_date', curr_date);
			$("#date").text(curr_date);
		}
		setInterval(function() {
			let d = new Date();
			let day = en_day[d.getDay()];
			let date = d.getDate();
			let month = en_month[d.getMonth()];
			let year = (d.getYear() + 1900);
			let date_day = day + ', ' + date + ' ' + month + ' ' + year;
			if (date_day != old_date) {
				localStorage.setItem('curr_date', date_day);
				$("#date").text(date_day);
			}
			let hours = d.getHours();
			let minutes = d.getMinutes();
			let seconds = d.getSeconds();
			let time = ((hours < 10 ? "0" : "") + hours) + ' : ' + ((minutes < 10 ? "0" : "") + minutes) + ' : ' + ((seconds < 10 ? "0" : "") + seconds);
			$("#clock").text(time);
			$("#clock2").text(time);
		}, 1000);
	}
</script>

<script>
	$(document).ready(function() {
		// $('#add-row').DataTable({
		// 	"LengthMenu": [10, 25, 50, 100],
		// 	"language": {
		// 		"search": "Cari:", // Ubah teks pencarian
		// 		"lengthMenu": "Tampilkan _MENU_ data per halaman",
		// 		"zeroRecords": "Tidak ada data yang ditemukan",
		// 		"info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
		// 		"infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
		// 		"paginate": {
		// 			"next": "Berikutnya",
		// 			"previous": "Sebelumnya"
		// 		}
		// 	}
		// });

		var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

		$('#addRowButton').click(function() {
			$('#add-row').dataTable().fnAddData([
				$("#addName").val(),
				$("#addPosition").val(),
				$("#addOffice").val(),
				action
			]);
			$('#addRowModal').modal('hide');

		});
	});
</script>

<script>
	$(document).ready(function() {
		$('#dataTable').DataTable({
			"lengthMenu": [10, 25, 50, 100], // Pilihan jumlah data per halaman
			"language": {
				"search": "Cari:", // Ubah teks pencarian
				"lengthMenu": "Tampilkan _MENU_ data per halaman",
				"zeroRecords": "Tidak ada data yang ditemukan",
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

<script>
	// // Tanggal Mulai
	// $('#tanggal_mulai').datetimepicker({
	// 	format: 'DD/MM/YYYY'
	// });

	$('#state').select2({
		theme: "bootstrap"
	});

	// // Tanggal Selesai
	// $('#tanggal_selesai').datetimepicker({
	// 	format: 'DD/MM/YYYY'
	// });

	$('#state').select2({
		theme: "bootstrap"
	});
</script>
</body>