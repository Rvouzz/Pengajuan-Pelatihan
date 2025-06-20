<?php $judul = 'Dashboard'; include '../header.php'; include 'sidebar_k.unit.php';?>
<body>
	<div class="main-panel">
		<div class="container">
			<div class="panel-header bg-primary-gradient">
				<div class="page-inner py-5">
					<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
						<div>
							<h2 class="text-white pb-2 fw-bold">Dashboard</h2>
							<h5 class="text-white op-7 mb-2">Premium Bootstrap 4 Admin Dashboard</h5>
						</div>
						<div class="ml-md-auto py-2 py-md-0">
							<a href="#" class="btn btn-white btn-border btn-round mr-2">Manage</a>
							<a href="#" class="btn btn-secondary btn-round">Add Customer</a>
						</div>
					</div>
				</div>
			</div>
			<div class="page-inner mt--5">
				<div class="row mt-3">
					<div class="col-md-6">
						<div class="card text-center" style="background-color: #eef2ff; border-radius: 10px; padding: 20px;">
							<h1 style="color: #4a80f5; font-weight: bold;">8</h1>
							<p style="color: #4a80f5; font-weight: 600;">Total Tickets</p>
						</div>
					</div>
					<div class="col-md-6">
						<div class="card text-center" style="background-color: #fff7e6; border-radius: 10px; padding: 20px;">
							<h1 style="color: #f5a623; font-weight: bold;">2</h1>
							<p style="color: #f5a623; font-weight: 600;">Pending Tickets</p>
						</div>
					</div>
				</div>
				<div class="row mt--2">
					<div class="col-md-6">
						<div class="card full-height">
							<div class="card-body text-center" style="background-color: #eef2ff;">
								<div class="card-title">TOTAL PENGAJUAN</div>
								<div class="card-category">3</div>
								<div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
									<div class="px-2 pb-2 pb-md-0 text-center">
										<div id="circles-1"></div>
										<h6 class="fw-bold mt-3 mb-0">New Users</h6>
									</div>
									<div class="px-2 pb-2 pb-md-0 text-center">
										<div id="circles-2"></div>
										<h6 class="fw-bold mt-3 mb-0">Sales</h6>
									</div>
									<div class="px-2 pb-2 pb-md-0 text-center">
										<div id="circles-3"></div>
										<h6 class="fw-bold mt-3 mb-0">Subscribers</h6>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="card full-height">
							<div class="card-body text-center" style="background-color: #fff7e6;">
								<div class="card-title">PENGAJUAN DISETUJUI</div>
								<div class="card-category">Daily information about statistics in system</div>
								<div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
									<div class="px-2 pb-2 pb-md-0 text-center">
										<div id="circles-1"></div>
										<h6 class="fw-bold mt-3 mb-0">New Users</h6>
									</div>
									<div class="px-2 pb-2 pb-md-0 text-center">
										<div id="circles-2"></div>
										<h6 class="fw-bold mt-3 mb-0">Sales</h6>
									</div>
									<div class="px-2 pb-2 pb-md-0 text-center">
										<div id="circles-3"></div>
										<h6 class="fw-bold mt-3 mb-0">Subscribers</h6>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8">
						<div class="card">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="card full-height">
							<div class="card-header">
								<div class="card-title">Feed Activity</div>
							</div>
							<div class="card-body">
								<ol class="activity-feed">
									<li class="feed-item feed-item-secondary">
										<time class="date" datetime="9-25">Sep 25</time>
										<span class="text">Responded to need <a href="#">"Volunteer opportunity"</a></span>
									</li>
									<li class="feed-item feed-item-success">
										<time class="date" datetime="9-24">Sep 24</time>
										<span class="text">Added an interest <a href="#">"Volunteer Activities"</a></span>
									</li>
									<li class="feed-item feed-item-info">
										<time class="date" datetime="9-23">Sep 23</time>
										<span class="text">Joined the group <a href="single-group.php">"Boardsmanship Forum"</a></span>
									</li>
									<li class="feed-item feed-item-warning">
										<time class="date" datetime="9-21">Sep 21</time>
										<span class="text">Responded to need <a href="#">"In-Kind Opportunity"</a></span>
									</li>
									<li class="feed-item feed-item-danger">
										<time class="date" datetime="9-18">Sep 18</time>
										<span class="text">Created need <a href="#">"Volunteer Opportunity"</a></span>
									</li>
									<li class="feed-item">
										<time class="date" datetime="9-17">Sep 17</time>
										<span class="text">Attending the event <a href="single-event.php">"Some New Event"</a></span>
									</li>
								</ol>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="card full-height">
							<div class="card-header">
								<div class="card-head-row">
									<div class="card-title">Support Tickets</div>
									<div class="card-tools">
										<ul class="nav nav-pills nav-secondary nav-pills-no-bd nav-sm" id="pills-tab" role="tablist">
											<li class="nav-item">
												<a class="nav-link" id="pills-today" data-toggle="pill" href="#pills-today" role="tab" aria-selected="true">Today</a>
											</li>
											<li class="nav-item">
												<a class="nav-link active" id="pills-week" data-toggle="pill" href="#pills-week" role="tab" aria-selected="false">Week</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" id="pills-month" data-toggle="pill" href="#pills-month" role="tab" aria-selected="false">Month</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="d-flex">
									<div class="avatar avatar-online">
										<span class="avatar-title rounded-circle border border-white bg-info">J</span>
									</div>
									<div class="flex-1 ml-3 pt-1">
										<h6 class="text-uppercase fw-bold mb-1">Joko Subianto <span class="text-warning pl-3">pending</span></h6>
										<span class="text-muted">I am facing some trouble with my viewport. When i start my</span>
									</div>
									<div class="float-right pt-1">
										<small class="text-muted">8:40 PM</small>
									</div>
								</div>
								<div class="separator-dashed"></div>
								<div class="d-flex">
									<div class="avatar avatar-offline">
										<span class="avatar-title rounded-circle border border-white bg-secondary">P</span>
									</div>
									<div class="flex-1 ml-3 pt-1">
										<h6 class="text-uppercase fw-bold mb-1">Prabowo Widodo <span class="text-success pl-3">open</span></h6>
										<span class="text-muted">I have some query regarding the license issue.</span>
									</div>
									<div class="float-right pt-1">
										<small class="text-muted">1 Day Ago</small>
									</div>
								</div>
								<div class="separator-dashed"></div>
								<div class="d-flex">
									<div class="avatar avatar-away">
										<span class="avatar-title rounded-circle border border-white bg-danger">L</span>
									</div>
									<div class="flex-1 ml-3 pt-1">
										<h6 class="text-uppercase fw-bold mb-1">Lee Chong Wei <span class="text-muted pl-3">closed</span></h6>
										<span class="text-muted">Is there any update plan for RTL version near future?</span>
									</div>
									<div class="float-right pt-1">
										<small class="text-muted">2 Days Ago</small>
									</div>
								</div>
								<div class="separator-dashed"></div>
								<div class="d-flex">
									<div class="avatar avatar-offline">
										<span class="avatar-title rounded-circle border border-white bg-secondary">P</span>
									</div>
									<div class="flex-1 ml-3 pt-1">
										<h6 class="text-uppercase fw-bold mb-1">Peter Parker <span class="text-success pl-3">open</span></h6>
										<span class="text-muted">I have some query regarding the license issue.</span>
									</div>
									<div class="float-right pt-1">
										<small class="text-muted">2 Day Ago</small>
									</div>
								</div>
								<div class="separator-dashed"></div>
								<div class="d-flex">
									<div class="avatar avatar-away">
										<span class="avatar-title rounded-circle border border-white bg-danger">L</span>
									</div>
									<div class="flex-1 ml-3 pt-1">
										<h6 class="text-uppercase fw-bold mb-1">Logan Paul <span class="text-muted pl-3">closed</span></h6>
										<span class="text-muted">Is there any update plan for RTL version near future?</span>
									</div>
									<div class="float-right pt-1">
										<small class="text-muted">2 Days Ago</small>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include '../footer.php'; ?>
	</div>
	<!-- End Custom template -->
