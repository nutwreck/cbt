<!-- Sidebar  -->
<nav id="sidebar">
	<div class="sidebar-header">
		<div class="row">
			<div class="container">
				<img src="<?= config_item('_assets_general') ?>header_logo/header_logo_menu.png" alt="logo" width="220">
			</div>
		</div>
	</div>

	<ul class="list-unstyled components">
		<!-- <p>Dummy Heading</p> -->
		<li class="active">
			<a href="<?= base_url() ?>dashboard"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
		</li>
		<li>
			<a href="<?= base_url() ?>history"><i class="fa fa-list-alt" aria-hidden="true"></i> History & Pembahasan</a>
		</li>
		<?php if ($this->session->userdata('event') != 1) { //Event ?>
		<li>
			<a href="#simulasimateri" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-book" aria-hidden="true"></i> Buku</a>
			<ul class="collapse list-unstyled" id="simulasimateri">
				<li>
					<a href="#">SBMPTN <small><i>(Coming Soon)</i></small></a>
					<!--<?= base_url() ?>buku/sbmptn/launch-->
				</li>
				<li>
					<a href="<?= base_url() ?>buku/toefl/launch">TOEFL</a>
				</li>
				<li>
					<a href="#">CPNS <small><i>(Coming Soon)</i></small></a>
					<!--<?= base_url() ?>buku/cpns/launch-->
				</li>
			</ul>
		</li>
		<?php } ?>
		<li>
			<a href="<?= base_url() ?>account"><i class="fa fa-user" aria-hidden="true"></i> Akun</a>
		</li>
		<?php if ($this->session->userdata('event') != 1) { //Event ?>
		<li>
			<a href="<?= base_url() ?>purchase"><i class="fas fa-shopping-cart" aria-hidden="true"></i> Status Pembelian</a>
		</li>
		<?php } ?>
		<li>
			<?php if ($this->session->userdata('event') == 1) { //Event ?>
				<a href="<?= base_url() ?>event/logout/<?=$this->session->userdata('event_prefix')?>"><i class="fa fa-power-off" aria-hidden="true"></i> Logout</a>
			<?php } else { //Tidak Event ?>
				<a href="<?= base_url() ?>logout"><i class="fa fa-power-off" aria-hidden="true"></i> Logout</a>
			<?php } ?>
		</li>
	</ul>
</nav>

<div id="content">
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container-fluid">
			<button type="button" id="sidebarCollapse" class="btn btn-info">
				<i class="fas fa-align-left"></i>
				<span>Toggle Sidebar</span>
			</button>

			<div style="margin-top:10px;">
				<h6>Hi, <?= $this->session->userdata('peserta_name') ?></h6>
			</div>
		</div>
	</nav>
