<!-- MENU SIDEBAR-->
<aside class="menu-sidebar d-none d-lg-block">
	<div class="logo">
		<a class="logo" href="<?php echo base_url(); ?>admin">
			<img src="https://see.fontimg.com/api/renderfont4/BW768/eyJyIjoiZnMiLCJoIjo2NCwidyI6MTAwMCwiZnMiOjY0LCJmZ2MiOiIjMUVBREZGIiwiYmdjIjoiI0ZGRkZGRiIsInQiOjF9/dWppYW4gb25saW5l/gv-time-regular.png" width="100%" alt="logo-ujian-online">
		</a>
	</div>
	<div class="menu-sidebar__content js-scrollbar1">
		<nav class="navbar-sidebar">
			<ul class="list-unstyled navbar__list">
				<li class="active">
					<a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-tachometer"></i>Dashboard</a>
				</li>
				<li class="has-sub">
					<a class="js-arrow" href="#"><i class="fa fa-book"></i>Tes Online</a>
					<ul class="list-unstyled navbar__sub-list js-sub-list">
						<li>
							<a href="<?php echo base_url(); ?>admin/materi">Materi</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>admin/paket-soal">Paket Soal</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>admin/sesi-pelaksana">Sesi Pelaksana</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>admin/report-ujian">Report Ujian</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>admin/report-buku">Report Tes Buku</a>
						</li>
					</ul>
				</li>
				<li class="has-sub">
					<a class="js-arrow" href="#"><i class="fa fa-users"></i>User Management</a>
					<ul class="list-unstyled navbar__sub-list js-sub-list">
						<li>
							<a href="<?php echo base_url(); ?>admin/user-lembaga">User Admin</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>admin/group-participants">Group Peserta</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>admin/participants">Peserta</a>
						</li>
					</ul>
				</li>
				<li class="has-sub">
					<a class="js-arrow" href="#"><i class="fa fa-folder-open"></i>Lembaga Management</a>
					<ul class="list-unstyled navbar__sub-list js-sub-list">
						<li>
							<a href="<?php echo base_url(); ?>admin/event">Event</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>admin/data-lembaga">Data Lembaga</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>admin/konversi-skor">Konversi Skor</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>admin/buku-setting">Buku Setting</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>admin/pembayaran-master">Master Pembayaran</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>admin/voucher">Kode Voucher</a>
						</li>
					</ul>
				</li>
				<li class="has-sub">
					<a class="js-arrow" href="#"><i class="fa fa-money"></i>Keuangan</a>
					<ul class="list-unstyled navbar__sub-list js-sub-list">
						<li>
							<a href="<?php echo base_url(); ?>admin/invoice">All Invoice</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>admin/invoice-confirm">Konfirmasi Pembayaran</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>admin/invoice-expired">Invoice Expired</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>admin/invoice-success">Pembayaran Sukses</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="<?php echo base_url(); ?>admin/logout"><i class="zmdi zmdi-power"></i>Logout</a>
				</li>
			</ul>
		</nav>
	</div>
</aside>
<!-- END MENU SIDEBAR-->

<!-- PAGE CONTAINER-->
<div class="page-container">
