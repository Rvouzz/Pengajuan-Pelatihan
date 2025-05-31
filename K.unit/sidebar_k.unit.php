<?php
session_start();
include '../header.php';

// Cek session nik dan level
if (!isset($_SESSION['nik']) || !isset($_SESSION['level']) || $_SESSION['level'] !== 'kunit') {
	// Jika nik tidak ada di session (session abis) atau level bukan dosen, redirect ke index.php
	session_unset();
	session_destroy();
	header("Location: ../index.php");
	exit();
}

$nama = isset($_SESSION['nama']) ? $_SESSION['nama'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$get_level = isset($_SESSION['level']) ? $_SESSION['level'] : '';

$level_map = [
	'dosen' => 'Dosen',
	'kunit' => 'Kepala Unit',
	'kpj' => 'Kepala Jurusan',
	'staff' => 'Kepegawaian',
];

$level = isset($level_map[$get_level]) ? $level_map[$get_level] : 'Unknown';
?>

<body>
	<div class="wrapper">
		<div class="main-header">
			<!-- Logo Header -->
			<div class="logo-header" data-background-color="blue">

				<a href="index.html" class="logo">
					<img src="../assets/img/logo.svg" alt="navbar brand" class="navbar-brand">
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
					data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="icon-menu"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
				<div class="nav-toggle">
					<button class="btn btn-toggle toggle-sidebar">
						<i class="icon-menu"></i>
					</button>
				</div>
			</div>
			<!-- Navbar Header -->
			<nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
				<div class="container-fluid">
					<div class="collapse" id="search-nav">
						<ul class="navbar-nav navbar-left topbar-nav nav-search mr-md-3 align-items-center">
							<!-- tanggal -->
							<li class="nav-item dropdown hidden-caret">
								<a aria-label="Current Date and Calender" class="nav-link dropdown-toggle" data-toggle="dropdown"
									href="#" aria-expanded="false">
									<span id="date"></span>
								</a>
								<ul class="float-right dropdown-menu dropdown-calender dropdown-user animated fadeIn">
									<div class="dropdown-user-scroll scrollbar-outer">
										<div class="card-body text-center text-accent-1">
											<h3>Thu, 13 Feb 2025</h3>
										</div>
									</div>
								</ul>
							</li>
							<!-- jam -->
							<li class="nav-item dropdown hidden-caret">
								<a aria-label="Current Time" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
									aria-expanded="false">
									<span id="clock"></span>
								</a>
								<ul class="float-right dropdown-menu dropdown-calender dropdown-user animated fadeIn">
									<div class="dropdown-user-scroll scrollbar-outer">
										<div class="card-body text-center text-accent-1">
											<h3>Jakarta, Indonesia</h3>
											<h1>
												<span id="clock2"></span>
											</h1>
										</div>
									</div>
								</ul>
							</li>
						</ul>
					</div>
				</div>
				<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
					
					<li class="nav-item dropdown hidden-caret">
						<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
							<div class="avatar-sm">
								<img src="../assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
							</div>
						</a>
						<ul class="dropdown-menu dropdown-user animated fadeIn">
							<div class="dropdown-user-scroll scrollbar-outer">
								<li>
									<div class="user-box">
										<div class="avatar-lg"><img src="../assets/img/profile.jpg" alt="image profile"
												class="avatar-img rounded"></div>
										<div class="u-text">
											<h4><?= htmlspecialchars(string: $nama) ?></h4>
											<p class="text-muted"><?= htmlspecialchars($email) ?></p>
											<!-- <a href="profile.html"
												class="btn btn-xs btn-secondary btn-sm">View Profile</a> -->
										</div>
									</div>
								</li>
								<li>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="#">Account Setting</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="./proses/logout.php">Logout</a>
								</li>
							</div>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
		<!-- End Navbar -->

		<!-- Sidebar -->
		<div class="sidebar sidebar-style-2">
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
				<div class="sidebar-content">
					<div class="user">
						<div class="avatar-sm float-left mr-2">
							<img src="../assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
						</div>
						<div class="info">
							<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<span>
									<?= htmlspecialchars($nama) ?>
									<span class="user-level"><?= htmlspecialchars($level) ?></span>
								</span>
							</a>
							
						</div>
					</div>
					<ul class="nav nav-primary" id="sidebarMenu">
						<li class="nav-item <?= in_array($current_file, ['dashboard_k.unit.php']) ? 'active' : ''; ?>">
							<a href="dashboard_k.unit.php">
								<i class="fas fa-home"></i>
								<p>Dashboard</p>
							</a>
						</li>
						<li class="nav-section">
							<h4 class="text-section">Laporan</h4>
						</li>
						<li
							class="nav-item <?= in_array($current_file, ['data_persetujuan_k.unit.php', 'persetujuan_k.unit.php']) ? 'active' : ''; ?>">
							<a href="data_persetujuan_k.unit.php">
								<i class="fas fa-file-signature"></i>
								<p>Persetujuan Pengajuan</p>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- End Sidebar -->