 <!-- MAIN CONTENT-->
 <div class="main-content">
 	<div class="section__content section__content--p30">
 		<div class="container-fluid">
 			<div class="row">
 				<div class="col-md-12">
 					<div class="overview-wrap">
 						<h2 class="title-1">Event</h2>
 					</div>
 				</div>
 			</div>
 			<div class="row mt-3">
 				<div class="col-md-12">
 					<!-- DATA TABLE -->
 					<div class="table-data__tool">
 						<div class="table-data__tool-right">
 							<button class="au-btn au-btn-icon au-btn--green au-btn--small" onclick="add_data()">
 								<i class="zmdi zmdi-plus"></i>Tambah
 							</button>
 						</div>
 					</div>
 					<div class="table-responsive table-responsive-data2">
 						<table id="table_event" class="display text-center">
 							<thead>
 								<tr>
 									<th colspan="3"></th>
 									<th colspan="2">Waktu</th>
 									<th colspan="2">Peserta</th>
 									<th></th>
 								</tr>
 								<tr>
 									<th width="15px">No</th>
 									<th>Nama</th>
 									<th>url</th>
 									<th>Mulai</th>
 									<th>Selesai</th>
 									<th>Kuota</th>
 									<th>Kelompok</th>
 									<th>Aksi</th>
 								</tr>
 							</thead>
 							<tbody>
 								<?php
									$no = 1;
									foreach ($event as $value) {
									?>
 									<tr>
 										<td><?= $no++ ?></td>
 										<td><?= $value->event_name ?></td>
 										<td> <a href="<?= config_item('_base_url_event') . $value->prefix_url ?>" target="_blank">Link</a></td>
 										<td><?= $value->start_date ? format_indo($value->start_date) : "Tidak Ada Batasan" ?></td>
 										<td><?= $value->end_date ? format_indo($value->end_date) : "Tidak Ada Batasan" ?></td>
 										<td><?= $value->kuota == 0 ? "<span>&#8734</span>" : $value->kuota ?></td>
 										<td><?= $value->count_group_peserta ?></td>
 										<td>
 											<div class="table-data-feature">
												 <a href="<?php echo base_url(); ?>admin/event-detail/<?php echo urlencode(base64_encode($value->event_id)); ?>" class="item" data-toggle="tooltip" data-placement="top" title="Edit">
													<i class="zmdi zmdi-eye"></i>
												</a>
												<a href="<?php echo base_url(); ?>admin/event-edit/<?php echo urlencode(base64_encode($value->event_id)); ?>" class="item" data-toggle="tooltip" data-placement="top" title="Edit">
													<i class="zmdi zmdi-edit"></i>
												</a>
 												<a href="<?php echo base_url(); ?>admin/event-delete/<?php echo urlencode(base64_encode($value->event_id)); ?>" class="item" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Apakah anda yakin menghapus event ini?')">
 													<i class="zmdi zmdi-delete"></i>
 												</a>
 											</div>
 										</td>
 									</tr>
 								<?php } ?>
 							</tbody>
 						</table>
 					</div>
 					<!-- END DATA TABLE -->
 				</div>
 			</div>
