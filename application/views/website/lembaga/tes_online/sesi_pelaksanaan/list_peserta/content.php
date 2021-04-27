 <!-- MAIN CONTENT-->
 <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">List Peserta <?=$name_sesi_pelaksana?></h2>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <!-- DATA TABLE -->
                        <div class="table-data__tool">
                            <div class="table-data__tool-right">
                                <button class="btn btn-md btn-success m-1" onclick="export_excel()">
                                    <i class="fa fa-download"></i> Export Excel
                                </button>
                                <a href="<?=base_url()?>admin/disable-all-list-peserta-sesi/<?=$id_sesi_pelaksana?>" class="btn btn-md btn-danger m-1" onclick="return confirm('Apakah anda yakin menghapus semua data peserta dalam sesi ini?')"><i class="fa fa-trash"></i> Hapus Semua</a>
                                <a href="<?=base_url()?>admin/sesi-pelaksana" class="btn btn-md btn-outline-secondary">Kembali</a>
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
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no = 1;
                                    foreach($list_peserta_sesi as $value){
                                ?>
                                    <tr>
                                        <td><?=$no++?></td>
                                        <td><input type="checkbox" class="delete_checkbox" value="<?=$value->id_sesi_pelaksanaan_user?>" /></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="<?=base_url()?>admin/disable-peserta-sesi/<?=urlencode(base64_encode($value->id_sesi_pelaksanaan_user))?>/<?=urlencode(base64_encode($value->sesi_pelaksanaan_id))?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin menghapus sesi peserta ini?')"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                        <td><?=$value->no_peserta?></td>
                                        <td><?=$value->peserta_name?></td>
                                        <td><?=$value->group_peserta_name?></td>
                                        <td><?=$value->username?></td>
                                        <td><?=$this->encryption->decrypt($value->password)?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- END DATA TABLE -->
                    </div>
                </div>