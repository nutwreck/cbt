 <!-- MAIN CONTENT-->
 <div class="main-content">
     <div class="section__content section__content--p30">
         <div class="container-fluid">
             <div class="row">
                 <div class="col-md-12">
                     <div class="overview-wrap">
                         <h2 class="title-1">List Peserta <?= $name_sesi_pelaksana ?></h2>
                     </div>
                 </div>
             </div>
             <div class="row mt-3">
                 <div class="col-md-12">
                     <!-- DATA TABLE -->
                     <div class="table-data__tool">
                         <div class="table-data__tool-right">
                             <a href="<?= base_url() ?>admin/peserta-sesi-pelaksana/<?= $id_sesi_pelaksana ?>" class="btn btn-md btn-primary m-1"><i class="fa fa-plus"></i> Tambah Peserta</a>
                             <button class="btn btn-md btn-success m-1" onclick="export_excel()">
                                 <i class="fa fa-download"></i> Export Excel
                             </button>
                             <a href="<?= base_url() ?>admin/disable-all-list-peserta-sesi/<?= $id_sesi_pelaksana ?>" class="btn btn-md btn-danger m-1" onclick="return confirm('Apakah anda yakin menghapus semua data peserta dalam sesi ini?')"><i class="fa fa-trash"></i> Hapus Semua</a>
                             <a href="<?= base_url() ?>admin/sesi-pelaksana" class="btn btn-md btn-outline-secondary">Kembali</a>
                         </div>
                     </div>
                     <div class="table-responsive table-responsive-data2">
                         <table id="table_list" class="display text-center">
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
                                     <th>Status</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php
                                    $no = 1;
                                    foreach ($list_peserta_sesi as $value) {
                                    ?>
                                     <tr>
                                         <td><?= $no++ ?></td>
                                         <td><input type="checkbox" class="delete_checkbox" value="<?= $value->id_sesi_pelaksanaan_user ?>" /></td>
                                         <td>
                                             <div class="btn-group">
                                                 <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                     Pilih
                                                 </button>
                                                 <div class="dropdown-menu">
                                                     <?php if ($status_sesi_pelakasanaan == "Sesi Berlangsung") { ?>
                                                         <a class="dropdown-item" href="#" data-toggle="modal" data-target="#tambah_waktu_modal" data-userid="<?= $value->user_id ?>">Tambah Waktu Pengerjaan</a>
                                                     <?php } ?>
                                                     <?php if (!empty($value->ujian_id)) { ?>
                                                         <a class="dropdown-item" href="JavaScript:void(0);" onclick="hitung_ulang_ujian('<?= $this->encryption->encrypt($value->ujian_id) ?>');">Hitung Ulang Jawaban</a>
                                                     <?php } ?>
                                                     <div class="dropdown-divider"></div>
                                                     <?php if ($status_sesi_pelakasanaan == "Sesi Berlangsung" && !empty($value->ujian_id)) { ?>
                                                         <a class="dropdown-item text-warning" href="<?= base_url() ?>admin/reset-peserta-sesi/<?= $id_sesi_pelaksana ?>/<?= urlencode(base64_encode($paket_soal_id)) ?>/<?= urlencode(base64_encode($value->user_id)) ?>" onclick="return confirm('Data ujian peserta akan direset serta waktu mulai dan selesai akan dikembalikan seperti belum membuka ujian selama sesi pelaksanaan belum berakhir')">Reset Ujian Peserta</a>
                                                     <?php } ?>
                                                     <a class="dropdown-item text-danger" href="<?= base_url() ?>admin/disable-peserta-sesi/<?= urlencode(base64_encode($value->id_sesi_pelaksanaan_user)) ?>/<?= urlencode(base64_encode($paket_soal_id)) ?>/<?= urlencode(base64_encode($value->sesi_pelaksanaan_id)) ?>" onclick="return confirm('Apakah anda yakin menghapus sesi dan data ujian peserta ini?')">Hapus Peserta</a>
                                                 </div>
                                             </div>
                                         </td>
                                         <td><?= $value->no_peserta ?></td>
                                         <td><?= $value->peserta_name ?></td>
                                         <td><?= $value->group_peserta_name ?></td>
                                         <td><?= $value->username ?></td>
                                         <td><?= $this->encryption->decrypt($value->password) ?></td>
                                         <td><span class="<?= $value->ujian_id > 0 ? 'fa fa-check text-success' : 'fa fa-times text-danger' ?>" title="<?= $value->ujian_id > 0 ? 'Sudah Mengerjakan Ujian' : 'Belum Mengerjakan Ujian' ?>"></span></td>
                                     </tr>
                                 <?php } ?>
                             </tbody>
                         </table>
                     </div>
                     <!-- END DATA TABLE -->
                 </div>
             </div>

             <!-- Modal Tambah Waktu Pengerjaan -->
             <div class="modal fade" id="tambah_waktu_modal" tabindex="-1" role="dialog" aria-labelledby="tambah_waktu_modal_Label" aria-hidden="true" data-backdrop="false">
                 <div class="modal-dialog" role="document">
                     <div class="modal-content">
                         <div class="modal-header">
                             <h5 class="modal-title" id="tambah_waktu_modal_Label">Tambah Waktu Peserta</h5>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                             </button>
                         </div>
                         <div class="modal-body">
                             <div class="container-fluid">
                                 <div class="card">
                                     <div class="card-body">
                                         <div class="row">
                                             <div class="col-sm-12">
                                                 <div class="form-group">
                                                     <h6 class="label-text-left">Dibawah ini menggunakan format Jam dan Menit</h6>
                                                 </div>
                                             </div>
                                             <div class="col-sm-12">
                                                 <div class="form-group">
                                                     <input type="hidden" id="sesi_id" value="<?= $sesi_pelaksana_id ?>">
                                                     <input type="hidden" id="paket_soal_id" value="<?= $paket_soal_id ?>">
                                                     <input type="hidden" id="user_id" value="">
                                                     <input type="text" class="form-control datetimepicker-input" id="datetimepicker10" data-toggle="datetimepicker" data-target="#datetimepicker10" name="waktu_mulai" placeholder="Pilih tanggal dan waktu" required />
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="modal-footer">
                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                             <button type="button" id="submit_waktu_peserta" class="btn btn-primary" onclick="proses_waktu_tambahan_peserta()">Simpan</button>
                         </div>
                     </div>
                 </div>
             </div>