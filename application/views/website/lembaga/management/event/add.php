<!-- MAIN CONTENT-->
<div class="main-content">
	<div class="section__content section__content--p30">
		<div class="container-fluid">
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col">Tambah Event</div>
						<div class="col text-right">
							<a href="<?= base_url() ?>admin/event" class="btn btn-sm btn-outline-secondary">Kembali</a>
						</div>
					</div>
				</div>
				<form id="formadd" name="formadd" action="<?php echo base_url(); ?>website/lembaga/Management/submit_add_event" class="form-paket-soal" method="POST" enctype="multipart/form-data">
					<input type="hidden" id="csrf-hash-form" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
					<input type="hidden" id="lembaga_id" name="lembaga_id" value="<?= $lembaga_id ?>" style="display: none" required>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-12 col-lg-3" style="margin-top:1%">
								<h5 class="label-text">Nama Event <span class="text-danger">*</span></h5>
							</div>
							<div class="col-sm-12 col-lg-9">
								<div class="form-group">
									<input id="name" name="name" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Ex: Tes Online SMA XXX" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12 col-lg-3" style="margin-top:1%">
								<h5 class="label-text">Prefix URL Event <span class="text-danger">*</span></h5>
							</div>
							<div class="col-sm-12 col-lg-9">
								<div class="form-group">
									<input id="prefix_url" name="prefix_url" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Ex: tesonlinesmaxxx (input tanpa spasi)" required oninput="this.value = this.value.replace(/[^a-z]/g, '').replace(/(\..*?)\..*/g, '$1');" onchange="check_validasi_prefix()">
									<small for="prefix_url" id="prefix_url_er" class="bg-danger text-white"></small>
									<small for="prefix_url" id="prefix_url_scs" class="bg-success text-white"></small>
									<div class="alert alert-info mt-2">
										<p>
											Prefix url untuk mengisi akhiran url yang akan dijadikan akses pendaftaran/login oleh peserta event, misal <i><?= config_item('_base_url_event') ?></i><b>tesonlinesmaxxx</b>, huruf yang ditebali hasil inputan diatas (prefix url)
										</p>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12 col-lg-3" style="margin-top:1%">
								<h5 class="label-text">Waktu Mulai</h5>
							</div>
							<div class="col-sm-12 col-lg-9">
								<div class="form-group">
									<input type="text" class="form-control datetimepicker-input" id="datetimepicker5" data-toggle="datetimepicker" data-target="#datetimepicker5" name="start_date" placeholder="Pilih tanggal dan waktu" />
									<div class="alert alert-info mt-2">
										<p>
											Kosongi <b>Waktu Mulai</b> jika tidak ada batasan akses link url
										</p>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12 col-lg-3" style="margin-top:1%">
								<h5 class="label-text">Waktu Selesai</h5>
							</div>
							<div class="col-sm-12 col-lg-9">
								<div class="form-group">
									<input type="text" class="form-control datetimepicker-input" id="datetimepicker6" data-toggle="datetimepicker" data-target="#datetimepicker6" name="end_date" placeholder="Pilih tanggal dan waktu" />
									<div class="alert alert-info mt-2">
										<p>
											Kosongi <b>Waktu Selesai</b> jika tidak ada batasan akses link url
										</p>
									</div>
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
										<input type="radio" class="custom-control-input" id="mode_kuota_kelompok" name="mode_kuota" required value="1" checked onchange="unlimited_function()">
										<label class="custom-control-label" for="mode_kuota_kelompok">Tak Terbatas</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline">
										<input type="radio" class="custom-control-input" id="mode_kuota_manual" name="mode_kuota" required value="2" onchange="limited_function()">
										<label class="custom-control-label" for="mode_kuota_manual">Dibatasi</label>
									</div>
									<div class="alert alert-info mt-2">
										<ul class="m-3">
											<li>Jika tak terbatas. Maka tidak ada batasan pendaftaran event. Akan dibuatkan <b>1 kelompok Peserta</b></li>
											<li>Jika dibatasi. Maka pendaftaran tidak bisa dilakukkan jika sudah memenuhi kuota</li>
										</ul>
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
										<input id="kuota" name="kuota" type="number" class="form-control" aria-required="true" aria-invalid="false" onchange="sisa_kuota_kelompok()" placeholder="Masukkan Maksimal Kuota Peserta">
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
											<input type="radio" class="custom-control-input" id="mode_peserta_kelompok" name="mode_kelompok" required value="1" checked onchange="otomatis_function()">
											<label class="custom-control-label" for="mode_peserta_kelompok">Otomatis</label>
										</div>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" class="custom-control-input" id="mode_peserta_manual" name="mode_kelompok" required value="2" onchange="manual_function()">
											<label class="custom-control-label" for="mode_peserta_manual">Buat Manual</label>
										</div>
										<div class="alert alert-info mt-2">
											<ul class="m-3">
												<li>Jika memilih <b>otomatis</b>,sistem maka akan dibuatkan kelompok peserta dengan rumus penentuan jumlah (jika kuota < <?= $max_kuota_split ?> maka dibuatkan 1 kelompok, jika kuota > <?= $max_kuota_split ?> maka jumlah kelompok = kuota dibagi <?= $max_kuota_split ?>).</li>
												<li>Jika buat <b>manual</b> anda bisa membuat </b>lebih dari 1 kelompok peserta beserta kuota</b> masing-masing kelompok.</li>
											</ul>
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
													<th></th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>
														<input id="multi_kelompok_peserta" name="multi_kelompok_peserta[]" type="text" class="form-control text-center" aria-required="true" aria-invalid="false">
													</td>
													<td>
														<input id="multi_kuota_kelompok" name="multi_kuota_kelompok[]" type="number" class="form-control text-center" aria-required="true" aria-invalid="false" onchange="refresh_sisa_kuota()">
													</td>
													<td>
														<button type="button" class="btn btn-sm btn-success" onclick="add_form_kelompok()">
															<i class="zmdi zmdi-plus"></i>
														</button>
													</td>
												</tr>
											</tbody>
										</table>
										<div id="tbody-form-kelompok"></div>
										<table class="table">
											<tr>
												<td class="text-left">
													<p>
													<h5>Total Kuota Sisa : <b id="sisa-kuota-kelompok"></b></h5>
													</p>
												</td>
											</tr>
											</tbody>
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
									<input id="banner_image" name="banner_image[]" type="file" class="form-control" onchange="preview_image();" placeholder="Masukkan Maksimal Kuota Peserta" multiple required>
									<div class="alert alert-info mt-2">
										<p>
											Banner akan ditampilkan dihalaman <b>pendaftaran/login</b>. Gunakan <b>ctrl + klik</b> gambar untuk upload <b>multiple</b>.
										</p>
									</div>
									<div id="banner_image_preview" class="container wrapper"></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6 offset-sm-3">
								<button type="submit" class="btn btn-md btn-info btn-block">
									<i class="fa fa-check fa-md"></i>&nbsp;
									<span>Submit</span>
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
