<!-- MAIN CONTENT-->
<div class="main-content">
	<div class="section__content section__content--p30">
		<div class="container-fluid">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col">Detail Event</div>
						<div class="col text-right">
							<a href="<?= base_url() ?>admin/event" class="btn btn-sm btn-outline-secondary">Kembali</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-sm-12 col-lg-3" style="margin-top:1%">
							<h5 class="label-text">Nama Event <span class="text-danger">*</span></h5>
						</div>
						<div class="col-sm-12 col-lg-9">
							<div class="form-group">
								<input id="name" name="name" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Ex: Tes Online SMA XXX" value="<?= $event->name ?>" required disabled>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-lg-3" style="margin-top:1%">
							<h5 class="label-text">Prefix URL Event <span class="text-danger">*</span></h5>
						</div>
						<div class="col-sm-12 col-lg-9">
							<div class="form-group">
								<input id="prefix_url" name="prefix_url" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Ex: tesonlinesmaxxx (input tanpa spasi)" required oninput="this.value = this.value.replace(/[^a-z]/g, '').replace(/(\..*?)\..*/g, '$1');" onchange="check_validasi_prefix()" value="<?= $event->prefix_url ?>" disabled>
								<small for="prefix_url" id="prefix_url_er" class="bg-danger text-white"></small>
								<small for="prefix_url" id="prefix_url_scs" class="bg-success text-white"></small>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-lg-3" style="margin-top:1%">
							<h5 class="label-text">Waktu Mulai</h5>
						</div>
						<div class="col-sm-12 col-lg-9">
							<div class="form-group">
								<?php
								$placeMulai = '';
								if ($event->start_date) {
									$placeMulai = format_indo($event->start_date);
								} else {
									$placeMulai = 'Tidak Ada Batasan';
								}
								?>
								<input type="text" class="form-control" id="start_date" name="start_date" value="<?= $placeMulai ?>" disabled />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-lg-3" style="margin-top:1%">
							<h5 class="label-text">Waktu Selesai</h5>
						</div>
						<div class="col-sm-12 col-lg-9">
							<div class="form-group">
								<?php
								$placeSelesai = '';
								if ($event->end_date) {
									$placeSelesai = format_indo($event->end_date);
								} else {
									$placeSelesai = 'Tidak Ada Batasan';
								}
								?>
								<input type="text" class="form-control" id="end_date" name="end_date" value="<?= $placeSelesai ?>" disabled />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
							<h5 class="label-text">Mode Kuota Peserta <span class="text-danger">*</span></h5>
						</div>
						<div class="col-sm-12 col-lg-9">
							<div class="form-group">
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" class="custom-control-input" id="mode_kuota_kelompok" name="mode_kuota" required value="1" <?= $event->mode_kuota_peserta == 1 ? 'checked' : 'disabled' ?> onchange="unlimited_function()">
									<label class="custom-control-label" for="mode_kuota_kelompok">Tak Terbatas</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" class="custom-control-input" id="mode_kuota_manual" name="mode_kuota" required value="2" <?= $event->mode_kuota_peserta == 2 ? 'checked' : 'disabled' ?> onchange="limited_function()">
									<label class="custom-control-label" for="mode_kuota_manual">Dibatasi</label>
								</div>
							</div>
						</div>
					</div>
					<div id="kuota_peserta" style="display: none;">
						<div class="row">
							<div class="col-sm-12 col-lg-3" style="margin-top:1%">
								<h5 class="label-text">Kuota Peserta <span class="text-danger">*</span></h5>
							</div>
							<div class="col-sm-12 col-lg-9">
								<div class="form-group">
									<input id="kuota" name="kuota" type="number" class="form-control" aria-required="true" aria-invalid="false" onchange="sisa_kuota_kelompok()" value="<?= $event->kuota ?>" placeholder="Masukkan Maksimal Kuota Peserta">
								</div>
							</div>
						</div>
					</div>
					<div id="kelompok_peserta" style="display: none;">
						<div class="row">
							<div class="col-sm-12 col-lg-3" style="margin-top:0.3%">
								<h5 class="label-text">Mode Kelompok Peserta <span class="text-danger">*</span></h5>
							</div>
							<div class="col-sm-12 col-lg-9">
								<div class="form-group">
									<div class="custom-control custom-radio custom-control-inline">
										<input type="radio" class="custom-control-input" id="mode_peserta_kelompok" name="mode_kelompok" required value="1" <?= $event->mode_kelompok_peserta == 1 ? 'checked' : 'disabled' ?> onchange="otomatis_function()">
										<label class="custom-control-label" for="mode_peserta_kelompok">Otomatis</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline">
										<input type="radio" class="custom-control-input" id="mode_peserta_manual" name="mode_kelompok" required value="2" <?= $event->mode_kelompok_peserta == 2 ? 'checked' : 'disabled' ?> onchange="manual_function()">
										<label class="custom-control-label" for="mode_peserta_manual">Buat Manual</label>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="tbl_group_peserta_manual" style="display:none;">
						<div class="row">
							<input type="hidden" id="jumlah-form-kelompok" value="1">
							<div class="col-sm-12 col-lg-3">

							</div>
							<div class="col-sm-12 col-lg-9">
								<div class="form-group">
									<table class="table text-center">
										<thead class="thead-light">
											<tr>
												<th>Nama Kelompok Peserta</th>
												<th>Kuota Kelompok</th>
											</tr>
										</thead>
										<tbody>
											<?php if (isset($group_peserta)) { ?>
												<?php foreach ($group_peserta as $keyGP => $valGP) { ?>
													<tr>
														<td>
															<input id="<?= 'multi_kelompok_peserta' . $keyGP ?>" name="<?= 'multi_kelompok_peserta' . $keyGP ?>" type="text" class="form-control text-center" aria-required="true" value="<?= $valGP->name ?>" aria-invalid="false" disabled>
														</td>
														<td>
															<input id="<?= 'multi_kuota_kelompok' . $keyGP ?>" name="<?= 'multi_kuota_kelompok' . $keyGP ?>" type="number" class="form-control text-center" aria-required="true" aria-invalid="false" value="<?= $valGP->max_kuota ?>" disabled>
														</td>
													</tr>
												<?php } ?>
											<?php } ?>
										</tbody>
									</table>
									<div id="tbody-form-kelompok"></div>
									<table class="table">
										<tr>
											<td class="text-left">
												<p>
												<h5>Total Kuota Sisa : <?= $kuota_sisa ?></h5>
												</p>
											</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 col-lg-3" style="margin-top:1%">
							<h5 class="label-text">Banner <span class="text-danger">*</span></h5>
						</div>
						<div class="col-sm-12 col-lg-9">
							<div class="form-group">
								<div id="banner_image_preview" class="container wrapper">
									<?php if (isset($banner)) { ?>
										<?php foreach ($banner as $valB) { ?>
											<div class="mb-2 text-center">
												<img src="<?php echo config_item('_dir_website') . 'lembaga/grandsbmptn/event/' . $valB->image; ?>" class='img-fluid img-rounded' style='width: 50%'>
												<hr class="dashed">
											</div>
										<?php } ?>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
