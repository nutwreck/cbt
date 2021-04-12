 <!-- MAIN CONTENT-->
 <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Paket Soal</h2>
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
                            <table id="table_paket" class="display text-center">
                                <thead>
                                    <tr>
                                        <th width="15px">No</th>
                                        <th>Aksi</th>
                                        <th>Nama Paket Soal</th>
                                        <th>Dibuat Oleh</th>
                                        <th>Perubahan Oleh</th>
                                        <th>Total Soal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no = 1;
                                    foreach($paket_soal as $value){
                                ?>
                                    <tr>
                                        <td><?=$no++?></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="<?=base_url()?>admin/list-soal/<?=urlencode(base64_encode($value->paket_soal_id))?>" class="btn btn-primary"><i class="fa fa-book" aria-hidden="true" title="List Soal"></i></a>
                                                <button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="<?=base_url()?>admin/bacaan-soal/<?=urlencode(base64_encode($value->paket_soal_id))?>">Bacaan Soal</a>
                                                    <a class="dropdown-item" href="<?=base_url()?>admin/group-soal/<?=urlencode(base64_encode($value->paket_soal_id))?>">Group Soal</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="<?=base_url()?>admin/detail-paket-soal/<?=urlencode(base64_encode($value->paket_soal_id))?>">Detail Paket Soal</a>
                                                    <a class="dropdown-item" href="<?=base_url()?>admin/edit-paket-soal/<?=urlencode(base64_encode($value->paket_soal_id))?>">Edit Paket Soal</a>
                                                    <a class="dropdown-item" href="<?=base_url()?>admin/disable-paket-soal/<?=urlencode(base64_encode($value->paket_soal_id))?>">Hapus Paket Soal</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td><h5><?=$value->nama_paket_soal?><br /><small><?=$value->materi_name?> <?=$value->kelas_name?></small></h5></td>
                                        <td><h6><?=$value->user_created_name?><br /><small><?=$value->created_datetime?></small></h6></td>
                                        <td><h6 class="text-danger"><?=$value->user_edited_name?><br /><small><?=$value->updated_datetime?></small></h6></td>
                                        <td><?=$value->total_soal?></td>
                                        <td>
                                            <?=$value->is_enable == 0 ? '<small>'.$value->status_paket_soal.'</small>'.'<br />'.'<a href="'.base_url().'admin/active-paket-soal/'.urlencode(base64_encode($value->paket_soal_id)).'" data-toggle="tooltip" data-placement="top" title="Aktifkan Paket Soal"> Aktifkan Kembali
                                            </a>' : $value->status_paket_soal?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- END DATA TABLE -->
                    </div>
                </div>