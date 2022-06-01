 <!-- MAIN CONTENT-->
 <div class="main-content">
 	<div class="section__content section__content--p30">
 		<div class="container-fluid">
 			<div class="row">
 				<div class="col-md-12">
 					<div class="overview-wrap">
 						<h2 class="title-1">Report Ujian</h2>
 					</div>
 				</div>
 			</div>
 			<div id="panel-toogle-search" class="row mt-3 mb-4">
 				<div class="col-sm-12">
 					<form id="formsearch" name="formsearch" action="<?php echo base_url(); ?>admin/report-ujian" method="POST" enctype="multipart/form-data">
 						<input type="hidden" id="search_active" name="search_active" value="1" style="display: none" required>
 						<div class="box-search">
 							<table class="table table-borderless text-left">
 								<tr>
 									<td colspan="3" style="font-size:25px">Filter Data</td>
 								</tr>
 								<tr>
 									<td width="20%">
 										<p>Kelompok</p>
 									</td>
 									<td width="2%">
 										<p>:</p>
 									</td>
 									<td>
 										<select class="form-control selectpicker dropup" data-live-search="true" data-width="auto" id="group_kelompok_namex" name="group_kelompok_name">
 											<option data-tokens="PILIH KELOMPOK" value="" disabled>PILIH KELOMPOK PESERTA</option>
 											<option data-tokens="ALL" value="all_group" <?= $group_kelompok_peserta == 'all_group' ? "selected" : "" ?>>SEMUA</option>
 											<option data-tokens="Manual Input" value="manual_input" <?= $group_kelompok_peserta == 'manual_input' ? "selected" : "" ?>>MANUAL INPUT</option>
 											<?php foreach ($group_peserta as $vGP) { ?>
 												<option data-tokens="<?= $vGP->group_peserta_name . ' (' . $vGP->jumlah_peserta . ')' ?>" value="<?= $vGP->group_peserta_name ?>" <?= $group_kelompok_peserta == $vGP->group_peserta_name ? "selected" : "" ?>><?= $vGP->group_peserta_name . ' (' . $vGP->jumlah_peserta . ')' ?></option>
 											<?php } ?>
 										</select>
 									</td>
 								</tr>
 								<tr>
 									<td width="20%">
 										<p>Sesi Pelaksanaan</p>
 									</td>
 									<td width="2%">
 										<p>:</p>
 									</td>
 									<td><input class="form-control" type="text" placeholder="Masukkan Kata Kunci Sesi Pelaksanaan" id="kata_kunci_sesix" name="kata_kunci_sesi" value="<?= @$sesi_pelaksanaan ?>"></td>
 								</tr>
 								<tr>
 									<td width="20%">
 										<p>Paket Soal</p>
 									</td>
 									<td width="2%">
 										<p>:</p>
 									</td>
 									<td><input class="form-control" type="text" placeholder="Masukkan kata kunci Paket Soal" id="kata_kunci_paket_soalx" name="kata_kunci_paket_soal" value="<?= @$paket_soal ?>"></td>
 								</tr>
 								<tr>
 									<td colspan="3">
 										<div class="col-sm-12 text-right">
 											<button type="submit" class="btn btn-md btn-info btn-small">
 												<i class="fa fa-check fa-md"></i>&nbsp;
 												<span>Tampilkan</span>
 											</button>
 										</div>
 									</td>
 								</tr>
 							</table>
 						</div>
 					</form>
 				</div>
 			</div>
 			<div class="row mt-3">
 				<div class="col-md-12">
 					<!-- DATA TABLE -->
 					<div class="table-responsive table-responsive-data2">
 						<table id="table_report" class="display text-center">
 							<thead>
 								<tr>
 									<th rowspan="2">No</th>
 									<th rowspan="2">Aksi</th>
 									<th rowspan="2">Sesi</th>
 									<th rowspan="2">Kelompok</th>
 									<th colspan="2">Nilai</th>
 									<th colspan="2">Peserta</th>
 								</tr>
 								<tr>
 									<th>Tertinggi</th>
 									<th>Terendah</th>
 									<th>Terdaftar</th>
 									<th>Mengerjakan</th>
 								</tr>
 							</thead>
 							<tbody>
 								<?php
									if (count($list_ujian) > 0)
										$no = 1;
									foreach ($list_ujian as $value) {
									?>
 									<tr>
 										<td><?= $no++ ?></td>
 										<td>
 											<a href="<?= base_url() ?>admin/detail-report-ujian/<?= urlencode(base64_encode($value->sesi_pelaksanaan_id)) ?>/<?= urlencode(base64_encode($value->paket_soal_id)) ?>" class="btn btn-sm btn-primary">
 												<i class="fa fa-eye"></i>
 											</a>
 										</td>
 										<td>
 											<h6><?= $value->sesi_pelaksanaan_name ?><br /><small><?= $value->paket_soal_name ?> <?= $value->materi_name ?></small></h6>
 										</td>
 										<td><?= empty($value->group_peserta_name) ? 'Manual Input ' . $value->total_user_sesi . ' Peserta' : $value->group_peserta_name ?></td>
 										<td><?= $value->nilai_tertinggi ?></td>
 										<td><?= $value->nilai_terendah ?></td>
 										<td><?= $value->total_user_sesi ?></td>
 										<td><?= $value->total_user_ujian ?></td>
 									</tr>
 								<?php } ?>
 							</tbody>
 						</table>
 					</div>
 					<!-- END DATA TABLE -->
 				</div>
 			</div>
