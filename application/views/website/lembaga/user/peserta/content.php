 <!-- MAIN CONTENT-->
 <div class="main-content">
 	<div class="section__content section__content--p30">
 		<div class="container-fluid">
 			<div class="row">
 				<div class="col-md-12">
 					<div class="overview-wrap">
 						<h2 class="title-1">Data Peserta</h2>
 					</div>
 				</div>
 			</div>
 			<div class="row mt-3">
 				<div class="col-md-12">
 					<!-- DATA TABLE -->
 					<div class="table-data__tool">
 						<div class="table-data__tool-right">
 							<button class="btn btn-md btn-primary m-1" onclick="add_data()">
 								<i class="zmdi zmdi-plus"></i> Tambah
 							</button>
 							<button class="btn btn-md btn-success m-1" onclick="import_excel()">
 								<i class="fa fa-upload"></i> Import Excel
 							</button>
 							<button class="btn btn-md btn-success m-1" onclick="export_excel()">
 								<i class="fa fa-download"></i> Export Excel
 							</button>
 							<a href="<?= base_url() ?>admin/disable-all-participants" class="btn btn-md btn-danger m-1" onclick="return confirm('Apakah anda yakin menghapus semua data peserta?')"><i class="fa fa-trash"></i> Hapus Semua</a>
 						</div>
 					</div>
 					<div id="panel-toogle-search" class="row mt-3 mb-4">
 						<div class="col-sm-12">
 							<form id="formsearch" name="formsearch" action="<?php echo base_url(); ?>admin/participants" method="POST" enctype="multipart/form-data">
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
 												<select class="form-control selectpicker" data-live-search="true" data-width="auto" id="group_kelompok_idx" name="group_kelompok_id">
 													<option data-tokens="PILIH KELOMPOK" value="" disabled>PILIH KELOMPOK PESERTA</option>
 													<option data-tokens="ALL" value="all_group" <?=$group_kelompok_peserta == 'all_group' ? "selected" : ""?>>SEMUA</option>
 													<?php foreach ($group_peserta as $vGP) { ?>
 														<option data-tokens="<?= $vGP->group_peserta_name. ' ('.$vGP->jumlah_peserta.')' ?>" value="<?= $vGP->group_peserta_id ?>" <?=$group_kelompok_peserta == $vGP->group_peserta_id ? "selected" : ""?>><?= $vGP->group_peserta_name. ' ('.$vGP->jumlah_peserta.')' ?></option>
 													<?php } ?>
 												</select>
 											</td>
 										</tr>
 										<tr>
 											<td width="20%">
 												<p>Nomor</p>
 											</td>
 											<td width="2%">
 												<p>:</p>
 											</td>
 											<td><input class="form-control" type="text" placeholder="Masukkan Nomor Peserta" id="kata_kunci_nomorx" name="kata_kunci_nomor" value="<?=@$nomor_peserta?>"></td>
 										</tr>
 										<tr>
 											<td width="20%">
 												<p>Nama</p>
 											</td>
 											<td width="2%">
 												<p>:</p>
 											</td>
 											<td><input class="form-control" type="text" placeholder="Masukkan kata kunci Nama" id="kata_kunci_namax" name="kata_kunci_nama" value="<?=@$nama_peserta?>"></td>
 										</tr>
 										<tr>
 											<td width="20%">
 												<p>Username</p>
 											</td>
 											<td width="2%">
 												<p>:</p>
 											</td>
 											<td><input class="form-control" type="text" placeholder="Masukkan kata kunci Username" id="kata_kunci_usernamex" name="kata_kunci_username" value="<?=@$username_peserta?>"></td>
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
 					<div class="table-responsive table-responsive-data2">
 						<table id="table_participants" class="display text-center">
 							<thead>
 								<tr>
 									<th width="15px">No</th>
 									<th width="2%"><button type="button" name="delete_all" id="delete_all" class="btn btn-sm btn-danger btn-xs"><i class="fa fa-trash"></i></button></th>
 									<th>Aksi</th>
 									<th>Nomor</th>
 									<th>Nama</th>
 									<th>Kelompok</th>
 									<th>Username</th>
 									<th>Password</th>
 								</tr>
 							</thead>
 							<tbody>
 								<?php
									if (count($participants) > 0)
										$no = 1;
									foreach ($participants as $value) {
									?>
 									<tr>
 										<td><?= $no++ ?></td>
 										<td><input type="checkbox" class="delete_checkbox" value="<?= $value->peserta_id ?>|<?= $value->user_id ?>" /></td>
 										<td>
 											<div class="btn-group">
 												<a href="<?= base_url() ?>admin/edit-participants/<?= urlencode(base64_encode($value->peserta_id)) ?>/<?= urlencode(base64_encode($value->user_id)) ?>" class="btn btn-sm btn-primary mr-1"><i class="fa fa-pencil"></i></a>
 												<a href="<?= base_url() ?>admin/disable-participants/<?= urlencode(base64_encode($value->peserta_id)) ?>/<?= urlencode(base64_encode($value->user_id)) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin menghapus peserta ini?')"><i class="fa fa-trash"></i></a>
 											</div>
 										</td>
 										<td><?= $value->no_peserta ?></td>
 										<td><?= $value->peserta_name ?></td>
 										<td><?= $value->group_peserta_name ?></td>
 										<td><?= $value->username ?></td>
 										<td><?= $this->encryption->decrypt($value->password) ?></td>
 									</tr>
 								<?php } ?>
 							</tbody>
 						</table>
 					</div>
 					<!-- END DATA TABLE -->
 				</div>
 			</div>
