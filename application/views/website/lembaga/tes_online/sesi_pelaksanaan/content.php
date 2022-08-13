 <!-- MAIN CONTENT-->
 <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Sesi Pelaksanaan</h2>
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
                            <table id="table_sesi" class="display text-center">
                                <thead>
                                    <tr>
                                        <th width="15px">No</th>
                                        <th>Aksi</th>
                                        <th>Waktu</th>
                                        <th>Materi Ujian</th>
                                        <th>Kelompok</th>
                                        <th>Total Peserta</th>
                                        <th>Status Sesi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no = 1;
                                $now = date('Y-m-d H:i:s');
                                    foreach($sesi_pelaksanaan as $value){
                                ?>
                                    <tr>
                                        <td><?=$no++?></td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Pilih
                                                </button>
                                                <div class="dropdown-menu">
                                                    <?php if($value->status_sesi_pelakasanaan == 'Sesi Berlangsung'){ echo ''; } else { ?>
                                                        <a class="dropdown-item" href="<?=base_url()?>admin/edit-sesi-pelaksana/<?=urlencode(base64_encode($value->sesi_pelaksanaan_id))?>" >Edit Sesi</a>
                                                    <?php } ?>
                                                    <?php if($value->user_total > 0){ ?>
                                                        <a class="dropdown-item" href="<?=base_url()?>admin/list-peserta-sesi-pelaksana/<?=urlencode(base64_encode($value->sesi_pelaksanaan_id))?>">List Peserta</a>
                                                    <?php } else { echo ''; } ?>
                                                    <a class="dropdown-item" href="<?=base_url()?>admin/detail-sesi-pelaksana/<?=urlencode(base64_encode($value->sesi_pelaksanaan_id))?>">Detail Sesi Pelaksanaan</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="<?=base_url()?>admin/delete-sesi-pelaksana/<?=urlencode(base64_encode($value->sesi_pelaksanaan_id))?>">Hapus Sesi Pelaksanaan</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?=format_indo($value->waktu_mulai)?></td>
                                        <td><h6>
                                                <?=$value->materi_name?><br />
                                                <?php if($value->fleksible_name != ''){?>
                                                    <small><?=$value->fleksible_name?>, Batas <?=format_indo($value->batas_pengerjaan)?></small></h6>
                                                <?php } else { ?>
                                                    <small>Batas <?=format_indo($value->batas_pengerjaan)?></small>
                                                <?php } ?>
                                            </h6>
                                        </td>
                                        <td>
                                            <?php if($value->mode_peserta_id == 1){
                                                echo $value->group_peserta_name;
                                            } else { ?>
                                                Manual input total <?=$value->user_total?> peserta
                                            <?php } ?>
                                        </td>
                                        <td><?=$value->user_total?></td>
                                        <td><?=$value->status_sesi_pelakasanaan?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- END DATA TABLE -->
                    </div>
                </div>