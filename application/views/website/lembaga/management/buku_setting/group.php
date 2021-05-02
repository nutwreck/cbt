 <!-- MAIN CONTENT-->
 <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Group Modul Buku <b><?=$buku_name?></b></h2>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <!-- DATA TABLE -->
                        <div class="table-data__tool">
                            <div class="table-data__tool-right">
                                <button class="au-btn au-btn-icon au-btn--blue au-btn--small" onclick="add_group_modul()">
                                    <i class="zmdi zmdi-plus"></i>Tambah
                                </button>
                                <a href="<?=base_url()?>admin/buku-setting" class="btn btn-md btn-outline-secondary">Kembali</a>
                            </div>
                        </div>
                        <div class="table-responsive table-responsive-data2">
                            <table id="table_setting_buku" class="display text-center">
                                <thead>
                                    <tr>
                                        <th width="15px">No</th>
                                        <th>Nama Group</th>                          
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no = 1;
                                    foreach($group_buku as $value){
                                ?>
                                    <tr>
                                        <td><?=$no++?></td>
                                        <td><?=$value->name?></td>
                                        <td>
                                            <div class="table-data-feature">
                                                <a href="<?=base_url()?>admin/detail-buku/<?=$id_buku?>/<?=urlencode(base64_encode($value->config_buku_id))?>/<?=urlencode(base64_encode($value->id))?>" class="item" data-toggle="tooltip" data-placement="top" title="Tambah Modul">
                                                    <i class="zmdi zmdi-plus"></i>
                                                </a>
                                                <a href="<?php echo base_url(); ?>admin/edit-group-buku/<?=$id_buku?>/<?php echo urlencode(base64_encode($value->id)); ?>" class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="zmdi zmdi-edit"></i>
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